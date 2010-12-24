<?php
$xpdo_meta_map['dnGroup']= array (
  'package' => 'ditsnews',
  'table' => 'ditsnews_groups',
  'composites' => 
  array (
    'Subscribers' => 
    array (
      'class' => 'dnGroupSubscribers',
      'local' => 'id',
      'foreign' => 'group',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'fields' => 
  array (
    'name' => '',
    'public' => 0,
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
    'public' => 
    array (
      'dbtype' => 'int',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
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
          'message' => 'Name is required.',
        ),
      ),
    ),
  ),
);
