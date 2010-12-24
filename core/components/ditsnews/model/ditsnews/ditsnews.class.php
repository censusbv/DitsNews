<?php
class Ditsnews {
    /**
     * Constructs the Ditsnews object
     *
     * @param modX &$modx A reference to the modX object
     * @param array $config An array of configuration options
     */

    var $errormsg = array();
    
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $basePath = $this->modx->getOption('ditsnews.core_path',$config,$this->modx->getOption('core_path').'components/ditsnews/');
        $assetsUrl = $this->modx->getOption('ditsnews.assets_url',$config,$this->modx->getOption('assets_url').'components/ditsnews/');
        $this->config = array_merge(array(
            'basePath' => $basePath,
            'corePath' => $basePath,
            'modelPath' => $basePath.'model/',
            'processorsPath' => $basePath.'processors/',
            'chunksPath' => $basePath.'elements/chunks/',
            'jsUrl' => $assetsUrl.'js/',
            'cssUrl' => $assetsUrl.'css/',
            'assetsUrl' => $assetsUrl,
            'connectorUrl' => $assetsUrl.'connector.php'
        ),$config);

        $this->modx->addPackage('ditsnews',$this->config['modelPath']);

        $this->modx->lexicon->load('ditsnews:default');
    }

    /**
     * Initializes the class into the proper context
     *
     * @access public
     * @param string $ctx
     */
    public function initialize($ctx = 'web') {
        switch ($ctx) {
            case 'mgr':
                $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">var siteId = \''.$this->modx->site_id.'\';</script>');

                if (!$this->modx->loadClass('ditsnews.request.ditsnewsControllerRequest',$this->config['modelPath'],true,true)) {
                    return 'Could not load controller request handler.';
                }
                $this->request = new ditsnewsControllerRequest($this);
                return $this->request->handleRequest();
            break;
            case 'connector':
                if (!$this->modx->loadClass('ditsnews.request.ditsnewsConnectorRequest',$this->config['modelPath'],true,true)) {
                    echo 'Could not load connector request handler.'; die();
                }
                $this->request = new ditsnewsConnectorRequest($this);
                return $this->request->handle();
            break;
            default: break;
        }
        return true;
    }

    public function queueMessages($newsletterId, $documentId, $groups) {
        //publish document
        $doc = $this->modx->getObject('modResource', $documentId);
        $doc->set('published', 1);
        $doc->save();
        $this->modx->switchContext($doc->get('context_key'));        
        unset($doc);

        //get settings
        $settings = $this->modx->getObject('dnSettings', 1);

        //get content
        $docUrl = preg_replace('/&amp;/', '&', $this->modx->makeUrl((int)$documentId, '', '&smartytags=1', 'full') );
        $message = file_get_contents( $docUrl );

        //get CSS
        $cssStyles = '';
        preg_match_all('|<style(.*)>(.*)</style>|isU', $message, $css);
        if( !empty($css[2]) )
        {
            foreach( $css[2] as $cssblock )
            {
                $cssStyles .= $cssblock;
            }
        }

        $sentTo = array(); //used to check if not already sent to an email address (same user in other group)

        foreach( $groups as $group )
        {
            $c = $this->modx->newQuery('dnSubscriber');
            $c->leftJoin('dnGroupSubscribers', 'dn', 'dnSubscriber.id = dn.subscriber');
            $c->where( array( 'dn.group' => $group, 'dnSubscriber.active' => 1 ) );
            $subscribers = $this->modx->getCollection('dnSubscriber', $c);

            foreach($subscribers as $subscriber)
            {
                if( !in_array($subscriber->get('email'), $sentTo) )
                {
                    $myMessage = $message;

                    //replace local links and images; add domain
                    $myMessage = preg_replace_callback('|<a(?:.+?)href\=\"(\S+)\"|',array( $this, 'parseUrls' ),$myMessage);
                    $myMessage = preg_replace_callback('|<img(?:.+?)src\=\"(\S+)\"|',array( $this, 'parseUrls' ),$myMessage);

                    //parse smarty 'placeholders'
                    $this->modx->smarty->left_delimiter = '{{';
                    $this->modx->smarty->right_delimiter = '}}';
                    $this->modx->smarty->assign('firstname',  $subscriber->get('firstname'));
                    $this->modx->smarty->assign('lastname',  $subscriber->get('lastname'));
                    $this->modx->smarty->assign('fullname',  trim($subscriber->get('firstname').' '.$subscriber->get('lastname')));
                    $this->modx->smarty->assign('company',  $subscriber->get('company'));
                    $this->modx->smarty->assign('email',  $subscriber->get('email'));
                    $this->modx->smarty->assign('unsubscribe',  $this->modx->makeUrl($settings->get('unsubscribepage'), '', '?subscriber='.$subscriber->get('id').'&code='.$subscriber->get('code')));
                    $myMessage = $this->modx->smarty->fetch('string: '.$myMessage);

                    // CSS inline
                    $Emogrifier = new Emogrifier($myMessage, $cssStyles);
                    $myMessage = $Emogrifier->emogrify();

                    $queueItem = $this->modx->newObject('dnQueue');
                    $queueItem->set('newsletter',   $newsletterId);
                    $queueItem->set('to', 		    $subscriber->get('email'));
                    $queueItem->set('message', 	    $myMessage);
                    $queueItem->set('sent',		    0);
                    $queueItem->save();

                    $sentTo[] = $subscriber->get('email');
                }
            }
        }
        return count($sentTo).' emails added to queue.';
	}
    
    private function parseUrls($match)
	{
	    //echo 'Complete match: '.$match[0].PHP_EOL;
	    //echo 'Matched URL: '.$match[1].PHP_EOL;

        $siteurl = $this->modx->config['site_url'];

        //skip ubsubscribe and external links
	    if( stripos($match[1], '{{$unsubscribe}}') !== false || stripos($match[1], 'http://') !== false || stripos($match[1], 'https://') !==false || stripos($match[1], 'mailto:') !== false )
	    {
	        return $match[0];
	    }
	    else
	    {
	        $replace = $match[1]; //text to replace
	        $replaced = $siteurl.( substr($match[1], 0, 1) == '/' ? '' : '/' ).$match[1]; //replaced url
	        return str_replace($replace, $replaced, $match[0]);
	    }
	}

    public function signup($fields)
    {
        if( !$this->checkUniqueEmail($fields['email']) ) {
            $this->errormsg[] = $this->modx->lexicon('ditsnews.subscribers.signup.err.emailunique');
            return false;
        }

		$subscriber = $this->modx->newObject('dnSubscriber');
		$subscriber->fromArray($fields);
		$subscriber->set('code', md5( time().$fields['firstname'].$fields['lastname'] ));
		$subscriber->set('active', 0);
        $subscriber->save();

        //add subscriber to selected groups
        if( is_array($fields['groups']) )
		{
            foreach($fields['groups'] as $group)
		    {
                //only allow public groups
                if( $this->modx->getCount('dnGroup', array('id' => $group, 'public' => 1)) == 1 )
                {
                    $dnGroupSubscribers = $this->modx->newObject('dnGroupSubscribers');
                    $dnGroupSubscribers->set('group', $group);
                    $dnGroupSubscribers->set('subscriber', $subscriber->get('id'));
                    $dnGroupSubscribers->save();
                }
            }
            unset($dnGroupSubscribers);
        }

        //get settings
        $settings = $this->modx->getObject('dnSettings', 1);

        //sent confirm message
        $confirmUrl =  $this->modx->makeUrl($settings->get('confirmpage'), '', '?subscriber='.$subscriber->get('id').'&amp;code='.$subscriber->get('code'), 'full');

        $message = $this->modx->getChunk('ditsnewssignupmail', array('confirmUrl' => $confirmUrl, 'firstname' => $subscriber->get('firstname'), 'lastname' => $subscriber->get('lastname')));

        $this->modx->getService('mail', 'mail.modPHPMailer');
        $this->modx->mail->set(modMail::MAIL_BODY, $message);
        $this->modx->mail->set(modMail::MAIL_FROM, $settings->get('email') );
        $this->modx->mail->set(modMail::MAIL_FROM_NAME, $settings->get('name') );
        $this->modx->mail->set(modMail::MAIL_SENDER, $settings->get('name') );
        $this->modx->mail->set(modMail::MAIL_SUBJECT, $this->modx->lexicon('ditsnews.subscribers.confirm.subject'));
        $this->modx->mail->address('to', $subscriber->get('email') );
        $this->modx->mail->address('reply-to', $settings->get('email') );
        $this->modx->mail->setHTML(true);
        if (!$this->modx->mail->send()) {
             $this->modx->log(modX::LOG_LEVEL_ERROR,'An error occurred while trying to send the confirmation email to '.$subscriber->get('email'));
        }
        $this->modx->mail->reset();

        return true;
	}

    /**
     * Checks if an email address is unique
     *
     * @access private
     * @param string $email The email address to check
     * @return boolean False if address already in use, true if address is not in use
     */
	private function checkUniqueEmail($email)
    {
		$c = $this->modx->newQuery('dnSubscriber');
		$c->where( array('email' => $email) );

		if( $this->modx->getCount('dnSubscriber', $c ) > 0)
			return false;
		else
			return true;
	}

    /**
     * Checks code and activates subscriber
     * @access public
     * @return boolean true on activated, false on not found
     */
    public function confirmSignup()
	{
		$subscriber = $this->modx->getObject('dnSubscriber', (int)$_GET['subscriber']);

		if( $subscriber && $subscriber->get('code') == $_GET['code'] )
		{
			$subscriber->set('active', 1);
			$subscriber->save();
			return true;
		}
		else
		{
			return false;
		}
	}

    /**
     * Checks code and removes subscriber
     * @access public
     * @return boolean true on removed, false on not found
     */
    public function unsubscribe()
	{
		$subscriber = $this->modx->getObject('dnSubscriber', (int)$_GET['subscriber']);

		if( $subscriber && $subscriber->get('code') == $_GET['code'] )
		{
			$subscriber->remove();
			return true;
		}
		else
		{
			return false;
		}
	}

    /**
     * Process email queue and send messages.
     * @access public
     */
    public function processQueue()
    {
       $this->modx->getService('mail', 'mail.modPHPMailer');

       $settings = $this->modx->getObject('dnSettings', 1);

       $c = $this->modx->newQuery('dnQueue');
       $c->limit(50);
       $c->where( array('sent' => 0) );
       $queue = $this->modx->getCollection('dnQueue', $c);
       foreach($queue as $qitem)
       {
           $nwl = $this->modx->getObject('dnNewsletter',   $qitem->get('newsletter'));
           $this->modx->mail->set(modMail::MAIL_BODY,      $qitem->get('message'));
           $this->modx->mail->set(modMail::MAIL_FROM,      $settings->get('email') );
           $this->modx->mail->set(modMail::MAIL_FROM_NAME, $settings->get('name') );
           $this->modx->mail->set(modMail::MAIL_SENDER,    $settings->get('bounceemail'));
           $this->modx->mail->set(modMail::MAIL_SUBJECT,   $nwl->get('title'));
           $this->modx->mail->address('to',                $qitem->get('to'));
           $this->modx->mail->setHTML(true);
           if (!$this->modx->mail->send()) {
               $this->modx->log(modX::LOG_LEVEL_ERROR,'An error occurred while trying to send the email: '.$err);
           }
           $this->modx->mail->reset();

           //update status
           $qitem->set('sent', 1);
           $qitem->save();
       }
   }

    /**
     * Gets a Chunk and caches it; also falls back to file-based templates
     * for easier debugging.
     *
     * @access public
     * @param string $name The name of the Chunk
     * @param array $properties The properties for the Chunk
     * @return string The processed content of the Chunk
     */
    public function getChunk($name,$properties = array()) {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->_getTplChunk($name);
            if (empty($chunk)) {
                $chunk = $this->modx->getObject('modChunk',array('name' => $name),true);
                if ($chunk == false) return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }
    /**
     * Returns a modChunk object from a template file.
     *
     * @access private
     * @param string $name The name of the Chunk. Will parse to name.chunk.tpl
     * @return modChunk/boolean Returns the modChunk object if found, otherwise
     * false.
     */
    private function _getTplChunk($name) {
        $chunk = false;
        $f = $this->config['chunksPath'].strtolower($name).'.chunk.tpl';
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }
}