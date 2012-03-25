<?php
$settings_values = array();
$allSettingsArray = array(
	'name' => 'Your name',
	'email' => 'your@email.tld',
	'bounceemail' => 'your@email.tld',
	'chunktpl' => '',
	'chunksignupmail' => 'ditsnewssignupmail'
);

foreach($allSettingsArray as $key => $default_value) {
	$setting = $modx->getObject('modSystemSetting', array(
		'key' => $key,
		'namespace' => 'ditsnews'
	));
	if ($setting == null) {
		$setting = $modx->newObject('modSystemSetting');
		$setting->set('key',$key);
		$setting->set('xtype','textfield');
		$setting->set('namespace','ditsnews');
		$setting->set('value', $default_value);
		$setting->save();
		$settings_values[$key] = $default_value;
	} else {
		$settings_values[$key] = $setting->get('value');
	}
}
return $modx->error->success('', $settings_values);