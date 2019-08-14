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
 * Export entity
 *
 * @category    Invodo
 * @package     Invodo_Video
 */
class Invodo_Video_Model_Product_Export_Entity extends Mage_ImportExport_Model_Export_Entity_Product
{
    /**
     * Max length for fields
     *
     * @var array
     */
    protected $_maxLength = array(
        'name'              => 100,
        'short_description' => 2048,
        'sku'               => 64,
        'manufacturer'      => 120
    );

    /**
     * Default values for row
     *
     * @var array
     */
    protected $_rowTemplate = array(
        'name'              => 'NONE',
        'short_description' => 'NONE',
        'sku'               => 'NONE',
        'manufacturer'      => 'NONE'
    );

    /**
     * Get attributes codes which are appropriate for export.
     *
     * @return array
     */
    protected function _getExportAttrCodes()
    {
        if (null === self::$attrCodes) {
            self::$attrCodes = array('sku', 'short_description', 'name', 'manufacturer');
        }

        return self::$attrCodes;
    }

    public function export()
    {
        //Execution time may be very long
        set_time_limit(0);

        /** @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
        $validAttrCodes  = $this->_getExportAttrCodes();
        $writer          = $this->getWriter();
        $defaultStoreId  = Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID;

        $memoryLimit = trim(ini_get('memory_limit'));
        $lastMemoryLimitLetter = strtolower($memoryLimit[strlen($memoryLimit)-1]);
        switch($lastMemoryLimitLetter) {
            case 'g':
                $memoryLimit *= 1024;
            case 'm':
                $memoryLimit *= 1024;
            case 'k':
                $memoryLimit *= 1024;
                break;
            default:
                // minimum memory required by Magento
                $memoryLimit = 250000000;
        }

        // Tested one product to have up to such size
        $memoryPerProduct = 100000;
        // Decrease memory limit to have supply
        $memoryUsagePercent = 0.8;
        // Minimum Products limit
        $minProductsLimit = 500;

        $limitProducts = intval(($memoryLimit  * $memoryUsagePercent - memory_get_usage(true)) / $memoryPerProduct);
        if ($limitProducts < $minProductsLimit) {
            $limitProducts = $minProductsLimit;
        }
        $offsetProducts = 0;

        while (true) {
            ++$offsetProducts;

            $dataRows        = array();
            $rowMultiselects = array();

            // prepare multi-store values and system columns values
            foreach ($this->_storeIdToCode as $storeId => &$storeCode) { // go through all stores
                $collection = $this->_prepareEntityCollection(Mage::getResourceModel('catalog/product_collection'));
                $collection
                    ->setStoreId($storeId)
                    ->setPage($offsetProducts, $limitProducts);
                if ($collection->getCurPage() < $offsetProducts) {
                    break;
                }
                $collection->load();

                if ($collection->count() == 0) {
                    break;
                }

                foreach ($collection as $itemId => $item) { // go through all products
                    $rowIsEmpty = true; // row is empty by default

                    foreach ($validAttrCodes as &$attrCode) { // go through all valid attribute codes
                        $attrValue = $item->getData($attrCode);

                        if (!empty($this->_attributeValues[$attrCode])) {
                            if ($this->_attributeTypes[$attrCode] == 'multiselect') {
                                $attrValue = explode(',', $attrValue);
                                $attrValue = array_intersect_key(
                                    $this->_attributeValues[$attrCode],
                                    array_flip($attrValue)
                                );
                                $rowMultiselects[$itemId][$attrCode] = $attrValue;
                            } else if (isset($this->_attributeValues[$attrCode][$attrValue])) {
                                $attrValue = $this->_attributeValues[$attrCode][$attrValue];
                            } else {
                                $attrValue = null;
                            }
                        }
                        // do not save value same as default or not existent
                        if ($storeId != $defaultStoreId
                            && isset($dataRows[$itemId][$defaultStoreId][$attrCode])
                            && $dataRows[$itemId][$defaultStoreId][$attrCode] == $attrValue
                        ) {
                            $attrValue = null;
                        }
                        if (is_scalar($attrValue)) {
                            $dataRows[$itemId][$storeId][$attrCode] = $attrValue;
                            $rowIsEmpty = false; // mark row as not empty
                        }
                    }
                    if ($rowIsEmpty) { // remove empty rows
                        unset($dataRows[$itemId][$storeId]);
                    }

                    $item = null;
                }
                $collection->clear();
            }

            if ($collection->getCurPage() < $offsetProducts) {
                break;
            }

            if ($offsetProducts == 1) {
                // create export file
                $headerCols = array(
                    'name'                  => 'title',
                    'short_description'     => 'description',
                    'sku'                   => 'id',
                    'manufacturer'          => 'brand'
                );
                $writer->setHeaderCols($headerCols);
            }

            foreach ($dataRows as $productId => &$productData) {
                foreach ($productData as &$dataRow) {
                    if (!empty($rowMultiselects[$productId])) {
                        foreach ($rowMultiselects[$productId] as $attrKey => $attrVal) {
                            if (!empty($rowMultiselects[$productId][$attrKey])) {
                                $dataRow[$attrKey] = array_shift($rowMultiselects[$productId][$attrKey]);
                            }
                        }
                    }

                    $dataRow = $this->_trimDataRow($dataRow);
                    $dataRow = $this->_fillEmptyRow($dataRow);
                    $writer->writeRow($dataRow);
                }
            }
        }

        return $writer->getContents();
    }

    /**
     * Apply filter to collection
     *
     * @param Mage_Eav_Model_Entity_Collection_Abstract $collection
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _prepareEntityCollection(Mage_Eav_Model_Entity_Collection_Abstract $collection)
    {
        parent::_prepareEntityCollection($collection);

        if (isset($this->_parameters['website'])) {
            try {
                $website = Mage::app()->getWebsite($this->_parameters['website']);
                $collection->addWebsiteFilter(array($website->getId()));
            } catch (Exception $e) {
                Mage::log('Website is not exist');
            }
        }

        return $collection;
    }

    /**
     * Trims fields
     *
     * @param array $dataRow
     * @return array
     */
    protected function _trimDataRow(array $dataRow)
    {
        /** @var Mage_Core_Helper_String $helper */
        $helper = Mage::helper('core/string');

        foreach ($this->_maxLength as $field => $length) {
            if (!isset($dataRow[$field]) || $helper->strlen($dataRow[$field]) <= $length) {
                continue;
            }

            $dataRow[$field] = $helper->substr($dataRow[$field], 0, $length);
        }

        return $dataRow;
    }

    /**
     * Fills empty values
     *
     * @param array $dataRow
     * @return array
     */
    protected function _fillEmptyRow(array $dataRow)
    {
        return array_merge($this->_rowTemplate, $dataRow);
    }
}