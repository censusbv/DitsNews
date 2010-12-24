<?php
// sets up the MODX_ defines and the paths to the xPDO core
// you'll want to change this first line to point to the actual MODx install path
define('MODX_BASE_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
define('MODX_CORE_PATH', MODX_BASE_PATH.'core/');
define('COMPONENT_PATH', MODX_CORE_PATH.'/components/ditsnews/');

require_once (MODX_CORE_PATH . 'config/config.inc.php');
include_once (MODX_CORE_PATH . 'model/modx/modx.class.php');

// create the modx object and load the modPackageBuilder class
$modx = new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);

// build the schema, using the PackageBuilder's buildSchema function. It takes 2 parameters:
// - the location of the model directory where you want the files to generate to
// - the schema xml file
$builder->buildSchema(COMPONENT_PATH.'/model/', COMPONENT_PATH.'/model/schema/ditsnews.mysql.schema.xml');

echo 'Finished!';
exit();
?>