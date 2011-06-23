<?php
if ($options[xPDOTransport::PACKAGE_ACTION] == xPDOTransport::ACTION_UPGRADE) {
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

		$modx->exec("ALTER TABLE {$modx->getTableName('dnQueue')} DROP `message`");
        $modx->exec("ALTER TABLE {$modx->getTableName('dnQueue')} DROP `to`");
        $modx->exec("ALTER TABLE {$modx->getTableName('dnQueue')} ADD `subscriber` INT(10) UNSIGNED NOT NULL, ADD INDEX (`subscriber`)");
        $modx->exec("ALTER TABLE {$modx->getTableName('dnSettings')} DROP `confirmpage`");
        $modx->exec("ALTER TABLE {$modx->getTableName('dnSettings')} DROP `unsubscribepage`");
        $modx->exec("ALTER TABLE {$modx->getTableName('dnSettings')} DROP `template`");
        $modx->exec("ALTER TABLE {$modx->getTableName('dnSubscriber')} ADD `signupdate` INT(20) UNSIGNED NOT NULL");
        $modx->exec("ALTER TABLE {$modx->getTableName('dnNewsletter')} ADD `message` TEXT NOT NULL default ''");
        $modx->exec("ALTER TABLE {$modx->getTableName('dnNewsletter')} DROP `document`");

		$success = true;
		break;
}
