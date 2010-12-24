<?php
require_once MODX_CORE_PATH.'/components/ditsnews/model/ditsnews/ditsnews.class.php';
$ditsnews = new Ditsnews($modx);

if( $ditsnews->confirmSignup() )
{
 return $modx->lexicon('ditsnews.subscribers.confirm.success');
}
else
{
 return $modx->lexicon('ditsnews.subscribers.confirm.err');
}