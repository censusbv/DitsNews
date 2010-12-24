<?php
/**
 * Get a list of groups
 *
 *
 * @package ditsnews
 * @subpackage processors.groups.list
 */


/* setup default properties */
$isLimit    = !empty($_REQUEST['limit']);
$start      = $modx->getOption('start',$_REQUEST,0);
$limit      = $modx->getOption('limit',$_REQUEST,9999999);
$sort       = $modx->getOption('sort',$_REQUEST,'id');
$dir        = $modx->getOption('dir',$_REQUEST,'ASC');

/* query for groups */
$c = $modx->newQuery('dnGroup');
$count = $modx->getCount('dnGroup',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$groups = $modx->getCollection('dnGroup',$c);

/* iterate through groups */
$list = array();
foreach ($groups as $group) {

        $c = $modx->newQuery('dnGroupSubscribers');
        $c->where( array('group' => $group->get('id')) );
        $members = $modx->getCount('dnGroupSubscribers', $c);

        $group = $group->toArray();
        $group['members'] = (int)$members;
        $list[] = $group;
}
return $this->outputArray($list,$count);