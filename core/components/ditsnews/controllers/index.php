<?php
/**
 * @package ditsnews
 * @subpackage controllers
 */
require_once dirname(dirname(__FILE__)) . '/model/ditsnews/ditsnews.class.php';
$ditsnews = new Ditsnews($modx);

return $ditsnews->initialize('mgr');