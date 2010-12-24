<?php
require_once dirname(__FILE__).'/../../../../config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';

require_once MODX_CORE_PATH.'/components/ditsnews/model/ditsnews/ditsnews.class.php';

include_once (MODX_CORE_PATH . "model/modx/modx.class.php");

$modx= new modX();
$modx->initialize('web');

$ditsnews = new Ditsnews($modx);

$ditsnews->processQueue();
?>