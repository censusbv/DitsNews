<?php
$xpdo_meta_map['dnNewsletter']= array (
  'package' => 'ditsnews',
  'table' => 'ditsnews_newsletters',
  'composites' => 
  array (
    'Queue' => 
    array (
      'class' => 'dnQueue',
      'local' => 'id',
      'foreign' => 'newsletter',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'fields' => 
  array (
    'title' => '',
    'date' => 0,
    'message' => '',
  ),
  'fieldMeta' => 
  array (
    'title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'date' => 
    array (
      'dbtype' => 'int',
      'precision' => '20',
      'phptype' => 'timestamp',
      'null' => false,
      'default' => 0,
    ),
    'message' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
);
