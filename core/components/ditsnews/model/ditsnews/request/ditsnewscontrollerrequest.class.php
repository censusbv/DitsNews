<?php
require_once MODX_CORE_PATH . 'model/modx/modrequest.class.php';
/**
 * Encapsulates the interaction of MODx manager with an HTTP request.
 *
 * {@inheritdoc}
 *
 * @package ditsnews
 * @extends modRequest
 */
class ditsnewsControllerRequest extends modRequest {
    public $actionVar = 'action';
    public $defaultAction = 'index';

    function __construct(Ditsnews &$ditsnews) {
        parent :: __construct($ditsnews->modx);
        $this->ditsnews =& $ditsnews;
    }

    /**
     * Extends modRequest::handleRequest and loads the proper error handler and
     * actionVar value.
     *
     * {@inheritdoc}
     */
    public function handleRequest() {
        $this->loadErrorHandler();

        /* save page to manager object. allow custom actionVar choice for extending classes. */
        $this->action = isset($_REQUEST[$this->actionVar]) ? $_REQUEST[$this->actionVar] : $this->defaultAction;

        $modx =& $this->modx;
        $ditsnews =& $this->ditsnews;
        $viewHeader = include $this->ditsnews->config['corePath'].'controllers/mgr/header.php';

        $f = $this->ditsnews->config['corePath'].'controllers/mgr/'.$this->action.'.php';
        if (file_exists($f)) {
            $viewOutput = include $f;
        } else {
            $viewOutput = 'Controller not found: '.$f;
        }

        return $viewHeader.$viewOutput;
    }
}