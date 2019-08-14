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
 * Renders conversion section
 *
 * @category    Invodo
 * @package     Invodo_Video
 */
abstract class Invodo_Video_Block_Conversion_Abstract extends Mage_Core_Block_Template
{
    /**
     * All events
     *
     * @var array
     */
    protected $_events = array();

    /**
     * Set events property, checks ability to render
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _toHtml()
    {
        /** @var Invodo_Video_Helper_Data $helper */
        $helper = Mage::helper('invodo_video');

        if (!$helper->isEnabled()) {
            return '';
        }

        /** @var Invodo_Video_Model_Config $config */
        $config = Mage::getSingleton('invodo_video/config');

        if (!$config->getGeneralConfig('enable_conversion_tracking')) {
            return '';
        }

        $this->_initEvents();

        if (!count($this->_events)) {
            return '';
        }

        return parent::_toHtml();
    }

    /**
     * Initializes events property
     *
     * @return void
     */
    protected abstract function _initEvents();

    /**
     * Retrieves events
     *
     * @return array
     */
    public function getEvents()
    {
        return $this->_events;
    }

    /**
     * Retrieves event name
     *
     * @param array $event
     * @return bool
     */
    public function getEventName(array $event)
    {
        return isset($event['name']) ? $event['name'] : false;
    }

    /**
     * Retrieves event params
     *
     * @param array $event
     * @return bool|string
     */
    public function getEventParams(array $event)
    {
        return isset($event['params']) ? json_encode($event['params']) : false;
    }
}