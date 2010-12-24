<?php
$xpdo_meta_map['dnQueue']= array (
  'package' => 'ditsnews',
  'table' => 'ditsnews_queue',
  'aggregates' => 
  array (
    'Newsletter' => 
    array (
      'class' => 'dnNewsletter',
      'local' => 'newsletter',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'fields' => 
  array (
    'newsletter' => 0,
    'to' => '',
    'message' => '',
    'sent' => 0,
  ),
  'fieldMeta' => 
  array (
    'newsletter' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'to' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'message' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'sent' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
  ),
);
