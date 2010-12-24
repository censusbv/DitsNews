<?php
/**
 * Get a list of subscribers
 *
 *
 * @package ditsnews
 * @subpackage processors.subscribers.list
 */


/* setup default properties */
$isLimit    = !empty($_REQUEST['limit']);
$start      = $modx->getOption('start',$_REQUEST,0);
$limit      = $modx->getOption('limit',$_REQUEST,9999999);
$sort       = $modx->getOption('sort',$_REQUEST,'id');
$dir        = $modx->getOption('dir',$_REQUEST,'ASC');

/* query for subscribers */
$c = $modx->newQuery('dnSubscriber');
$count = $modx->getCount('dnSubscriber',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$subscribers = $modx->getCollection('dnSubscriber',$c);

/* iterate through subscribers */
$list = array();
foreach ($subscribers as $subscriber) {
        $subscriber = $subscriber->toArray();
        $list[] = $subscriber;
}
return $this->outputArray($list,$count);