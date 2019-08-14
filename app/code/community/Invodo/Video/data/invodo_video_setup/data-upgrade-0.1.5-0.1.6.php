<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
// add blocks
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_block'),
    array('block_name' => 'invodo_video/conversion_register', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_block'),
    array('block_name' => 'invodo_video/conversion_session', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_block'),
    array('block_name' => 'invodo_video/init', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_block'),
    array('block_name' => 'invodo_video/product_video_overlay', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_block'),
    array('block_name' => 'invodo_video/product_video_inline', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_block'),
    array('block_name' => 'core/text', 'is_allowed' => 1)
);

// add variable
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_variable'),
    array('variable_name' => 'invodo_video/general/site_key', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_variable'),
    array('variable_name' => 'invodo_video/general/enabled_on_pdp', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_variable'),
    array('variable_name' => 'invodo_video/general/pdp_video_type', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_variable'),
    array('variable_name' => 'invodo_video/general/pdp_video_resolution', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_variable'),
    array('variable_name' => 'invodo_video/general/pdp_video_auto_play', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_variable'),
    array('variable_name' => 'invodo_video/general/pdp_overlay_action', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_variable'),
    array('variable_name' => 'invodo_video/general/pdp_overlay_action_source', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_variable'),
    array('variable_name' => 'invodo_video/general/enable_conversion_tracking', 'is_allowed' => 1)
);
$installer->getConnection()->insertIgnore(
    $installer->getTable('admin/permission_variable'),
    array('variable_name' => 'invodo_video/general/export', 'is_allowed' => 1)
);

$installer->endSetup();