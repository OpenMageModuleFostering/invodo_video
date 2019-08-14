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
 * Abstract renderer for product page
 *
 * @category    Invodo
 * @package     Invodo_Video
 */
abstract class Invodo_Video_Block_Product_Video_Abstract extends Mage_Catalog_Block_Product_View_Abstract
{
    /**
     * Config
     *
     * @var Invodo_Video_Model_Config
     */
    protected $_config;

    /**
     * Initializes config
     */
    protected function _construct()
    {
        $this->_config = Mage::getSingleton('invodo_video/config');

        return parent::_construct();
    }

    /**
     * Retrieves video type
     *
     * @return int
     */
    public abstract function getVideoType();

    /**
     * Check if we can render
     *
     * @return string
     */
    protected function _toHtml()
    {
        /** @var Invodo_Video_Helper_Data $helper */
        $helper = Mage::helper('invodo_video');

        if (!$helper->isEnabled()) {
            return '';
        }

        // enabled or not on PDP
        if (!$this->_config->getGeneralConfig('enabled_on_pdp')) {
            return '';
        }

        // can render according to PDP type configuration
        if ($this->getVideoType() != $this->_config->getGeneralConfig('pdp_video_type')) {
            return '';
        }

        // check if product video disabled for current product
        if ($this->getProduct()->getData('invodo_video_enabled') !== null
            && !$this->getProduct()->getData('invodo_video_enabled')
        ) {
            return '';
        }

        if (!$this->_canShow()) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * Checks if we can show our block
     *
     * @return bool
     */
    protected function _canShow()
    {
        return true;
    }

    /**
     * Retrieves video source value
     *
     * @return string
     */
    public function getSourceValue()
    {
        return addslashes($this->getProduct()->getSku());
    }
}