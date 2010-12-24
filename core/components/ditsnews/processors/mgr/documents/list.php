<?php
/**
 * Get a list of documents
 *
 *
 * @package ditsnews
 * @subpackage processors.documents.list
 */


/* setup default properties */
$isLimit    = !empty($_REQUEST['limit']);
$start      = $modx->getOption('start',$_REQUEST,0);
$limit      = $modx->getOption('limit',$_REQUEST,9999999);
$sort       = $modx->getOption('sort',$_REQUEST,'id');
$dir        = $modx->getOption('dir',$_REQUEST,'ASC');

/* Get settings */
$settings = $modx->getObject('dnSettings', 1);

/* query for resources */
$c = $modx->newQuery('modResource');
$c->where(array('template' => $settings->get('template')));
$count = $modx->getCount('modResource',$c);

$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$resources = $modx->getCollection('modResource',$c);

/* iterate through resources */
$list = array();
foreach ($resources as $resource) {
        $resource = $resource->toArray();
        $list[] = $resource;
}
return $this->outputArray($list,$count);