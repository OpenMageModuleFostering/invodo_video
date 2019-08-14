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

/**
 * Renders form
 *
 * @category    Invodo
 * @package     Invodo_Video
 */
class Invodo_Video_Block_Adminhtml_System_Config_Form extends Mage_Adminhtml_Block_System_Config_Form
{
    /**
     * Adds specific field types
     *
     * @return array
     */
    protected function _getAdditionalElementTypes()
    {
        $types = parent::_getAdditionalElementTypes();
        $types['autoplay']              = $this->_getClassName('autoplay');
        $types['videoresolution']       = $this->_getClassName('videoresolution');
        $types['overlayactionsource']   = $this->_getClassName('overlayactionsource');
        $types['export']                = $this->_getClassName('export');

        return $types;
    }

    /**
     * Gets class name
     *
     * @param string $class
     * @return string
     */
    protected function _getClassName($class)
    {
        $class = 'invodo_video/adminhtml_system_config_form_field_' . $class;

        return Mage::getConfig()->getBlockClassName($class);
    }
}