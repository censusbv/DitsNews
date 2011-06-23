<?php
if (!isset($modx->ditsnews)) {
    $modx->addPackage('ditsnews', $modx->getOption('core_path').'components/ditsnews/model/');
    $modx->ditsnews = $modx->getService('ditsnews', 'DitsNews', $modx->getOption('core_path').'components/ditsnews/model/ditsnews/');
}
 
$dn =& $modx->ditsnews;
return $dn->setPlaceholders($scriptProperties);