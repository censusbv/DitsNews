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

//get all groups including checked/unchecked for current subscriber
$groups = $modx->getCollection('dnGroup');
foreach( $groups as $group ) {

    if($_REQUEST['memberCount']) {
        $c = $modx->newQuery('dnGroupSubscribers');
        $c->where( array('group' => $group->get('id')) );
        $members = $modx->getCount('dnGroupSubscribers', $c);
    } else {
        $members = -1;
    }

    $outputArray[] = array(
        'id' => $group->get('id'),
        'name' => $group->get('name'),
        'checked' => (int)in_array($group->get('id'), $subscriberGroupsArray),
        'members' => $members
    );
}

return $modx->error->success('', $outputArray);