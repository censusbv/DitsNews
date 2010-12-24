<?php
$newsletterArray = (array) json_decode($_REQUEST['formData']);

if (isset($newsletterArray['id']) && !empty($newsletterArray['id']) && $newsletterArray['id'] != 0) {
	$newsletter = $modx->getObject('dnNewsletter', $newsletterArray['id']);
	$newsletter->fromArray(array(
		'title' => $newsletterArray['title'],
		'date' => (int) $newsletterArray['date'],
		'document' => (int) $newsletterArray['document']
	));
} else {
	$newsletter = $modx->newObject('dnNewsletter', array(
        'title' => $newsletterArray['title'],
        'date' => time(),
        'document' => (int) $newsletterArray['document']
	));
}

//add groups
$sendToGroups = array();
$groups = $modx->getCollection('dnGroup');
if( is_array($groups) ) {
    foreach($groups as $group) {
        $id = $group->get('id');
        if( $newsletterArray['groups_'.$id] ) {
            $sendToGroups[] = $group->get('id');
        }
    }
}

// Return values
if ($newsletter->save()) {
    if(count($sendToGroups)) {
        $modx->ditsnews->queueMessages($newsletter->get('id'), (int)$newsletterArray['document'], $sendToGroups);
    }
	return $modx->error->success('', $newsletter);
} else {
	return $modx->error->failure('');
}