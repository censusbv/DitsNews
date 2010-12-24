<?php
$groupArray = (array) json_decode($_REQUEST['formData']);

if (isset($groupArray['id']) && !empty($groupArray['id']) && $groupArray['id'] != 0) {
	$group = $modx->getObject('dnGroup', $groupArray['id']);
	$group->fromArray(array(
		'name' => $groupArray['name'],
		'public' => (int) $groupArray['public']
    ));
} else {
	$group = $modx->newObject('dnGroup', array(
		'name' => $groupArray['name'],
		'public' => (int) $groupArray['public']
	));
}

// Return values
if ($group->save()) {
	return $modx->error->success('', $group);
} else {
	return $modx->error->failure('');
}