<?php
/**
 * NOTICE OF LICENSE
 *
 * Subject to the terms, conditions and limitations of this EULA,
 * Company hereby grants you a limited, nonexclusive, nontransferable,
 * non-assignable license, without rights to sublicense, to install or have installed,
 * display and use the Software (in object code only) only on the computers
 * to which the Software is downloaded.  The terms and conditions of this EULA
 * will govern any upgrades, updates, patches, hotfixes and/or
 * additional versions of the Software provided by Company, at Company’s sole
 * discretion, that replace and/or supplement the original Software (collectively, “Update”),
 * unless such Update is accompanied by or references a separate license
 * agreement in which case the terms and conditions of that agreement will
 * govern.  If this EULA governs your use of an Update, such Update shall be
 * considered Software for purposes of this EULA. Unless earlier terminated
 * as provided herein, the term of each individual license granted under this
 * EULA begins on the date of acceptance of this EULA and shall terminate only
 * as otherwise set forth herein.Each party recognizes that
 * Company grants no licenses except for the license expressly set forth.
 *
 * @category    Invodo
 * @package     Invodo_Video
 * @copyright   Copyright (c) 2013 INVODO (http://www.invodo.com/)
 * @license     http://opensource.org/licenses/OSL-3.0 Open Source Software
 */

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = Mage::getModel('catalog/resource_setup', 'invodo_video_setup');
$installer->startSetup();

//adds new attribute
$installer->addAttribute(
    Mage_Catalog_Model_Product::ENTITY,
    'invodo_video_enabled',
    array(
        'type'                          => 'int',
        'group'                         => 'General',
        'label'                         => 'Enable Invodo Videos',
        'input'                         => 'select',
        'source'                        => 'eav/entity_attribute_source_boolean',
        'global'                        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'                       => true,
        'required'                      => false,
        'user_defined'                  => true,
        'default'                       => 1,
        'visible'                       => true,
        'searchable'                    => false,
        'filterable'                    => false,
        'filterable_in_search'          => false,
        'visible_in_advanced_search'    => false,
        'comparable'                    => false,
        'visible_on_front'              => false,
        'unique'                        => false,
        'is_configurable'               => 0,
        'used_for_sort_by'              => false,
        'used_in_product_listing'       => false
    )
);

//add attribute to group
$attributeId = Mage::getSingleton('eav/config')
    ->getAttribute(Mage_Catalog_Model_Product::ENTITY, 'invodo_video_enabled')
    ->getId();

$installer->addAttributeToGroup(Mage_Catalog_Model_Product::ENTITY, 'Default', 'General', $attributeId, 50);
$installer->endSetup();