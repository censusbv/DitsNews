<?php
/**
 * @package ditsnews
 */
class Ditsnews {
    /**
     * Constructs the Ditsnews object
     *
     * @param modX &$modx A reference to the modX object
     * @param array $config An array of configuration options
     */
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
            'connectorUrl' => $assetsUrl.'connector.php',
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
                if (!$this->modx->loadClass('ditsnewsControllerRequest',$this->config['modelPath'].'ditsnews/request/',true,true)) {
                    return 'Could not load controller request handler.';
                }
                $this->request = new ditsnewsControllerRequest($this);
                return $this->request->handleRequest();
            break;
        }
        return true;
    }

    //Sets placeholders of newsletter template
    public function setPlaceholders($scriptProperties) {

        $placeholderTags = array(
            'firstname'     => $this->modx->getOption('firstnameTag', $scriptProperties, 'firstname'),
            'lastname'      => $this->modx->getOption('lastnameTag', $scriptProperties, 'lastname'),
            'fullname'      => $this->modx->getOption('fullnameTag', $scriptProperties, 'fullname'),
            'company'       => $this->modx->getOption('companyTag', $scriptProperties, 'company'),
            'email'         => $this->modx->getOption('emailTag', $scriptProperties, 'email'),
            'unsubscribe'   => $this->modx->getOption('unsubscribeTag', $scriptProperties, 'unsubscribe')
        );

        //change standard placeholders to entities ([[ to &#91;&#91; and ]] to &#93;&#93;), including default value
        if($_GET['sending']) {
            $this->modx->setPlaceholders(array(
                $placeholderTags['firstname'] => '&#91;&#91;+firstname:default=`'.$this->modx->getOption('firstnameDefault', $scriptProperties, '').'`&#93;&#93;',
                $placeholderTags['lastname'] => '&#91;&#91;+lastname:default=`'.$this->modx->getOption('lastnameDefault', $scriptProperties, '').'`&#93;&#93;',
                $placeholderTags['fullname'] => '&#91;&#91;+fullname:default=`'.$this->modx->getOption('fullnameDefault', $scriptProperties, '').'`&#93;&#93;',
                $placeholderTags['company'] => '&#91;&#91;+company:default=`'.$this->modx->getOption('companyDefault', $scriptProperties, '').'`&#93;&#93;',
                $placeholderTags['email'] => '&#91;&#91;+email:default=`'.$this->modx->getOption('emailDefault', $scriptProperties, '').'`&#93;&#93;'
            ));
        }
        else {
            $this->modx->setPlaceholders(array(
                $placeholderTags['firstname'] => $this->modx->getOption('firstnameDefault', $scriptProperties, ''),
                $placeholderTags['lastname'] => $this->modx->getOption('lastnameDefault', $scriptProperties, ''),
                $placeholderTags['fullname'] => $this->modx->getOption('fullnameDefault', $scriptProperties, ''),
                $placeholderTags['company'] => $this->modx->getOption('companyDefault', $scriptProperties, ''),
                $placeholderTags['email'] => $this->modx->getOption('emailDefault', $scriptProperties, '')
            ));
        }
    }

    public function processQueue() {

        $c = $this->modx->newQuery('dnQueue');
        $c->limit(50);
        $c->where( array('sent' => 0) );
        $queue = $this->modx->getCollection('dnQueue', $c);

        // $settings = $this->modx->getObject('dnSettings', 1);
		$settings = $this->getSettings();
        if(sizeof($settings)==0) {
			$this->modx->log(modX::LOG_LEVEL_ERROR,'ditsnews settings not found ');
            die('ditsnews settings not found');
        }

        $this->modx->getService('mail', 'mail.modPHPMailer');

        foreach($queue as $qitem) {
            $newsletter = $qitem->getOne('Newsletter');
            $subscriber = $qitem->getOne('Subscriber');
            $message = $newsletter->get('message');

            //get message including parsed placeholders
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($message);
            $message = $chunk->process(array(
                'firstname' => $subscriber->get('firstname'),
                'lastname' => $subscriber->get('lastname'),
                'fullname' => $subscriber->get('firstname').' '.$subscriber->get('lastname'),
                'company' => $subscriber->get('company'),
                'email' => $subscriber->get('email'),
                'code' => $subscriber->get('code')
            ));
            unset($chunk);

            $dom = new DOMDocument('1.0', 'utf-8');
            $dom->loadHTML($message);

            //get site_url from base tag or default MODX setting
            $site_url = $dom->getElementsByTagName('base')->item(0)->getAttribute('href');
            if(empty($site_url)) {
                $site_url = $this->modx->getOption('site_url');
            }

            //convert local link URLs to full URLs
            $links = $dom->getElementsByTagName('a');
            foreach($links as $link) {
                if( $href = $link->getAttribute('href') ) {
                    if(substr($href, 0, 7) != 'http://' && substr($href, 0, 7) != 'mailto:') {
                        $newhref = $site_url.$href;
                        //add tracking vars
                        $newhref .= ( strpos($newhref, '?') ? '&amp;' : '?' );
                        $newhref .= 'nwl='.$qitem->get('newsletter');
                        $newhref .= '&amp;s='.$subscriber->get('id');
                        $newhref .= '&amp;c='.$subscriber->get('code');
                        $link->setAttribute('href',$newhref);
                    }
                }
            }

            //convert local image URLs to full URLs
            $images = $dom->getElementsByTagName('img');
            foreach($images as $image) {
                if($src = $image->getAttribute('src')) {
                   if(substr($src, 0, 7) != 'http://') {
                        $image->setAttribute('src', $site_url.$src);
                   }
                }
            }
            $message = $dom->saveHTML();

            $this->modx->mail->set(modMail::MAIL_BODY,      $message);
            $this->modx->mail->set(modMail::MAIL_FROM,      $settings['email'] );
            $this->modx->mail->set(modMail::MAIL_FROM_NAME, $settings['name'] );
            $this->modx->mail->set(modMail::MAIL_SENDER,    $settings['bounceemail']);
            $this->modx->mail->set(modMail::MAIL_SUBJECT,   $newsletter->get('title'));
            $this->modx->mail->address('to',                $subscriber->get('email'));
            $this->modx->mail->setHTML(true);
            if (!$this->modx->mail->send()) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'An error occurred while trying to send newsletter to'.$subscriber->get('email'));
            }
            $this->modx->mail->reset();

            //update status
            $qitem->set('sent', 1);
            $qitem->save();
        }
    }

    public function signup($fields, $confirmPage=0)
    {
        if( !$this->checkUniqueEmail($fields['email']) ) {
            $this->errormsg[] = $this->modx->lexicon('ditsnews.subscribers.signup.err.emailunique');
            return false;
        }

		$subscriber = $this->modx->newObject('dnSubscriber');
		$subscriber->fromArray($fields);
		$subscriber->set('code', md5( time().$fields['firstname'].$fields['lastname'] ));
		$subscriber->set('active', 0);
        $subscriber->set('signupdate', time());
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
        // $settings = $this->modx->getObject('dnSettings', 1);
		$settings = $this->getSettings();
        if(sizeof($settings)==0) {
			$this->modx->log(modX::LOG_LEVEL_ERROR,'ditsnews settings not found ');
            die('ditsnews settings not found');
        }

        // $settings = $this->modx->getObject('dnSettings', 1);

        //sent confirm message
        $confirmUrl =  $this->modx->makeUrl($confirmPage, '', '?s='.$subscriber->get('id').'&amp;c='.$subscriber->get('code'), 'full');

        $message = $this->modx->getChunk('ditsnewssignupmail', array('confirmUrl' => $confirmUrl, 'firstname' => $subscriber->get('firstname'), 'lastname' => $subscriber->get('lastname')));

        $this->modx->getService('mail', 'mail.modPHPMailer');
        $this->modx->mail->set(modMail::MAIL_BODY, $message);
        $this->modx->mail->set(modMail::MAIL_FROM, $settings['email'] );
        $this->modx->mail->set(modMail::MAIL_FROM_NAME, $settings['name'] );
        $this->modx->mail->set(modMail::MAIL_SENDER, $settings['name'] );
        $this->modx->mail->set(modMail::MAIL_SUBJECT, $this->modx->lexicon('ditsnews.subscribers.confirm.subject'));
        $this->modx->mail->address('to', $subscriber->get('email') );
        $this->modx->mail->address('reply-to', $settings['email'] );
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
		$subscriber = $this->modx->getObject('dnSubscriber', (int)$_GET['s']);

		if( $subscriber && $subscriber->get('code') == $_GET['c'] )
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
		$subscriber = $this->modx->getObject('dnSubscriber', (int)$_GET['s']);

		if( $subscriber && $subscriber->get('code') == $_GET['c'] )
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
                $chunk = $this->modx->getObject('modChunk',array('name' => $name));
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
     * @param string $name The name of the Chunk. Will parse to name.$postfix
     * @param string $postfix The default postfix to search for chunks at.
     * @return modChunk/boolean Returns the modChunk object if found, otherwise
     * false.
     */
    private function _getTplChunk($name,$postfix = '.chunk.tpl') {
        $chunk = false;
        $f = $this->config['chunksPath'].strtolower($name).$postfix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }
    /**
     * Returns settings from modSystemSetting.
     *
     * @access public
     * @return Array of settings
     */
    public function getSettings() {
		$get_settings = $this->modx->getCollection('modSystemSetting', array('namespace' => 'ditsnews'));
		$settings = array();
		foreach ( $get_settings as $setting ) {
			$settings[$setting->get('key')] = $setting->get('value');
		}
        return $settings;
    }
}