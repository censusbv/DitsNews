<?php
if($options[xPDOTransport::PACKAGE_ACTION] == xPDOTransport::ACTION_UPGRADE) {
	$action = 'upgrade';	
} elseif ($options[xPDOTransport::PACKAGE_ACTION] == xPDOTransport::ACTION_INSTALL) {
	$action = 'install';	
}

$success = false;
switch ($action) {  
	case 'upgrade':
	case 'install':
		// Create a reference to MODx since this resolver is executed from WITHIN a modCategory
		$modx =& $object->xpdo; 

		if (!isset($modx->ditsnews) || $modx->ditsnews == null) {
			$modx->addPackage('ditsnews', $modx->getOption('core_path').'components/ditsnews/model/');
		    $modx->ditsnews = $modx->getService('ditsnews', 'DitsNews', $modx->getOption('core_path').'components/ditsnews/model/ditsnews/');
		}

		$mgr = $modx->getManager();
        $mgr->createObjectContainer('dnNewsletter');
        $mgr->createObjectContainer('dnGroup');
        $mgr->createObjectContainer('dnSubscriber');
        $mgr->createObjectContainer('dnGroupSubscribers');
        $mgr->createObjectContainer('dnQueue');
        $mgr->createObjectContainer('dnSettings');

		$success = true;
		break;
}