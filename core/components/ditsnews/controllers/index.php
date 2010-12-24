<?php
require_once dirname(dirname(__FILE__)) . '/model/ditsnews/ditsnews.class.php';
$ditsnews = new Ditsnews($modx);

//create tables
$modx->getCollection('dnNewsletter');
$modx->getCollection('dnSettings');
$modx->getCollection('dnSubscriber');
$modx->getCollection('dnGroup');
$modx->getCollection('dnGroupSubscribers');
$modx->getCollection('dnQueue');

return $ditsnews->initialize('mgr');