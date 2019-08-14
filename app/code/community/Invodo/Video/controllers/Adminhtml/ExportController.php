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
 * Exports products from admin configuration screen
 *
 * @category    Invodo
 * @package     Invodo_Video
 */
class Invodo_Video_Adminhtml_ExportController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Load data and create file for download.
     *
     * @return this
     */
    public function exportAction()
    {
        try {
            /** @var $model Invodo_Video_Model_Product_Export */
            $model = Mage::getModel('invodo_video/product_export');
            $model->setData($this->getRequest()->getParams());
            $model->setData('entity', 'catalog_product');
            $model->setData('export_filter', array(
                'visibility'    => Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH
            ));

            return $this->_prepareDownloadResponse(
                $model->getFileName(),
                $model->export(),
                $model->getContentType()
            );
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            $this->_getSession()->addError($this->__('No valid data sent'));
        }

        return $this->_redirect('*/*/index');
    }
}