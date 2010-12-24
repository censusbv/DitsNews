<?php
$xpdo_meta_map['dnGroupSubscribers']= array (
  'package' => 'ditsnews',
  'table' => 'ditsnews_groups_subscribers',
  'aggregates' => 
  array (
    'Subscriber' => 
    array (
      'class' => 'dnSubscriber',
      'local' => 'subscriber',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Group' => 
    array (
      'class' => 'dnGroup',
      'local' => 'group',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
  'fields' => 
  array (
    'subscriber' => 0,
    'group' => 0,
  ),
  'fieldMeta' => 
  array (
    'subscriber' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
    'group' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
  ),
);
