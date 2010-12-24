<?php
if($_GET['smartytags'] == 1) {
  $modx->setPlaceholders(
    array(
      'firstname' => '{{$firstname}}',
      'lastname' => '{{$lastname}}',
      'fullname' => '{{$fullname}}',
      'company' => '{{$company}}',
      'email' => '{{$email}}',
      'unsubscribe' => '{{$unsubscribe}}'
    )
  );
}