<?php
/**
 * Newsletters Config
 *
 * @package newsletters
 */
require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';




$corePath = $modx->getOption('core_path').'components/ditsnews/';
require_once $corePath.'model/ditsnews/ditsnews.class.php';
$modx->ditsnews = new Ditsnews($modx);

$modx->lexicon->load('ditsnews:default');
$lexicons = $modx->lexicon->fetch('ditsnews.',false);

$output = array();

header('Content-type: text/javascript');
foreach($lexicons as $key => $value) {
    echo 'MODx.lang[\''.$key.'\'] = "'.$value.'"'.PHP_EOL;
}
