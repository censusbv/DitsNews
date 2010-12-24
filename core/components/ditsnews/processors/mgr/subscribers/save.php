<?php
$subscriberArray = (array) json_decode($_REQUEST['formData']);

$details = array(
		'firstname' => $subscriberArray['firstname'],
        'lastname'  => $subscriberArray['lastname'],
        'company'   => $subscriberArray['company'],
        'email'     => $subscriberArray['email'],
        'active'     => $subscriberArray['active']
);

if (isset($subscriberArray['id']) && !empty($subscriberArray['id']) && $subscriberArray['id'] != 0) {
	$subscriber = $modx->getObject('dnSubscriber', $subscriberArray['id']);
	$subscriber->fromArray($details);
} else {
    $details['code'] =  md5( time().$subscriberArray['firstname'].$subscriberArray['lastname']);
	$subscriber = $modx->newObject('dnSubscriber', $details);
}

if ($subscriber->save()) {
    //remove current groups
    $curGroups = $subscriber->getMany('Groups');
    foreach($curGroups as $curGroup){
        $curGroup->remove();
    }
    
    //add new groups
    $groups = $modx->getCollection('dnGroup');
    if( is_array($groups) ) {
        foreach($groups as $group) {
            $id = $group->get('id');
            if( $subscriberArray['groups_'.$id] ) {
                $newGroup = $modx->newObject('dnGroupSubscribers', array('group' => $id, 'subscriber' => $subscriber->get('id'))  );
                $newGroup->save();
            }
        }
    }

	return $modx->error->success('', $subscriber);
} else {
	return $modx->error->failure('');
}