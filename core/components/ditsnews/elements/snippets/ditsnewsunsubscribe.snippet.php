w<?php
require_once MODX_CORE_PATH.'/components/ditsnews/model/ditsnews/ditsnews.class.php';
$ditsnews = new Ditsnews($modx);

if( $ditsnews->unsubscribe() )
{
 return $modx->lexicon('ditsnews.subscribers.unsubscribe.success');
}
else
{
 return $modx->lexicon('ditsnews.subscribers.unsubscribe.err');
}