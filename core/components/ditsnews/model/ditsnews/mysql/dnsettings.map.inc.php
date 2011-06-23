<?php
$xpdo_meta_map['dnSettings']= array (
  'package' => 'ditsnews',
  'table' => 'ditsnews_settings',
  'fields' => 
  array (
    'name' => '',
    'email' => '0',
    'bounceemail' => '0',
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'email' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '0',
    ),
    'bounceemail' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '0',
    ),
  ),
  'validation' => 
  array (
    'rules' => 
    array (
      'name' => 
      array (
        'preventBlank' => 
        array (
          'type' => 'xPDOValidationRule',
          'rule' => 'xPDOMinLengthValidationRule',
          'value' => '1',
          'message' => 'Name is required',
        ),
      ),
      'email' => 
      array (
        'validEmail' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^[_a-zA-Z0-9-]+(\\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\\.[a-zA-Z0-9-]+)+$/i',
          'message' => 'Email address invalid',
        ),
      ),
      'bounceemail' => 
      array (
        'validBounceEmail' => 
        array (
          'type' => 'preg_match',
          'rule' => '/^[_a-zA-Z0-9-]+(\\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\\.[a-zA-Z0-9-]+)+$/i',
          'message' => 'Bounce email address invalid',
        ),
      ),
    ),
  ),
);
