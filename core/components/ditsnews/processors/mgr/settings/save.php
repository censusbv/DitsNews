<?php
$settingsArray = (array) json_decode($_REQUEST['formData']);

$allSettingsArray = array(
    'name' => $settingsArray['name'],
    'email' => $settingsArray['email'],    
    'bounceemail' => $settingsArray['bounceemail'],
	'chunktpl' => $settingsArray['chunktpl']
);

foreach($allSettingsArray as $key => $value) {
	$setting = $modx->getObject('modSystemSetting', array(
		'key' => $key,
		'namespace' => 'ditsnews'
	));
	$setting->set('value', $value);
	if (!$setting->save()) {
		return $modx->error->failure('');
	}
}

return $modx->error->success('', $allSettingsArray);