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
 * Exports products
 *
 * @category    Invodo
 * @package     Invodo_Video
 */
class Invodo_Video_Model_Product_Export extends Mage_ImportExport_Model_Export
{
    /**
     * Create instance of entity adapter and returns it.
     *
     * @throws Exception
     * @return Mage_ImportExport_Model_Export_Entity_Abstract
     */
    protected function _getEntityAdapter()
    {
        if (!$this->_entityAdapter) {
            try {
                $this->_entityAdapter = Mage::getModel('invodo_video/product_export_entity');
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::throwException(
                    Mage::helper('importexport')->__('Invalid entity model')
                );
            }
            if (! $this->_entityAdapter instanceof Mage_ImportExport_Model_Export_Entity_Abstract) {
                Mage::throwException(
                    Mage::helper('importexport')->__('Entity adapter obejct must be an instance of Mage_ImportExport_Model_Export_Entity_Abstract')
                );
            }

            $this->_entityAdapter->setParameters($this->getData());
        }

        return $this->_entityAdapter;
    }

    /**
     * Get writer object.
     *
     * @throws Mage_Core_Exception
     * @return Mage_ImportExport_Model_Export_Adapter_Abstract
     */
    protected function _getWriter()
    {
        if (!$this->_writer) {
            try {
                $this->_writer = Mage::getModel('invodo_video/product_export_adapter');
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::throwException(
                    Mage::helper('importexport')->__('Invalid adapter model')
                );
            }
            if (! $this->_writer instanceof Mage_ImportExport_Model_Export_Adapter_Abstract) {
                Mage::throwException(
                    Mage::helper('importexport')->__('Adapter object must be an instance of %s', 'Mage_ImportExport_Model_Export_Adapter_Abstract')
                );
            }
        }

        return $this->_writer;
    }
}