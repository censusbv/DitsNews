<?php
$outputArray = array();

//get groups of subscriber
$subscriberGroupsArray = array();
if( $_REQUEST['subscriberId'] ) {
    $subscriberGroups = $modx->getCollection('dnGroupSubscribers', array('subscriber' => (int)$_REQUEST['subscriberId']));
    foreach($subscriberGroups as $subscriberGroup) {
        $subscriberGroupsArray[] = $subscriberGroup->get('group');
    }
}
unset($subscriberGroups);


$groups = $modx->getCollection('dnGroup');
foreach( $groups as $group ) {
    $outputArray[] = array(
        'id' => $group->get('id'),
        'name' => $group->get('name'),
        'checked' => in_array($group->get('id'), $subscriberGroupsArray)
    );
}

return $modx->error->success('', $outputArray);







