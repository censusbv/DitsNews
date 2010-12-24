<?php
require_once MODX_CORE_PATH.'/components/ditsnews/model/ditsnews/ditsnews.class.php';
$ditsnews = new Ditsnews($modx);

if( $ditsnews->signup($scriptProperties['fields']) ) {
  return true;
}
else {
  $scriptProperties['hook']->errors['signup'] = $ditsnews->errormsg;
  return false;
}