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
 * Module frontend observer
 *
 * @category    Invodo
 * @package     Invodo_Video
 */
class Invodo_Video_Model_Observer
{
    /**
     * Adds event on product was added to cart
     *
     * @param Varien_Event_Observer $observer
     */
    public function checkoutCartAddProductComplete($observer)
    {
        /** @var Invodo_Video_Model_Config $config */
        $config = Mage::getSingleton('invodo_video/config');

        if (!$config->getGeneralConfig('enable_conversion_tracking')) {
            return;
        }

        /** @var Invodo_Video_Model_Session $session */
        $session = Mage::getSingleton('invodo_video/session');
        /** @var Mage_Catalog_Model_Product $product */
        $product = $observer->getProduct();
        /** @var Mage_Core_Controller_Request_Http $request */
        $request = $observer->getRequest();

        if (!$product instanceof Mage_Catalog_Model_Product || !$product->getId()) {
            return;
        }

        $qty = $request->getParam('qty');

        if ($qty) {
            $filter = new Zend_Filter_LocalizedToNormalized(
                array('locale' => Mage::app()->getLocale()->getLocaleCode())
            );
            $qty = $filter->filter($qty);
        } else {
            $qty = (int)$qty;
        }

        $session->addEvent('cartAdd', array(
            'mpd'       => $product->getSku(),
            'quantity'  => $qty,
            'price'     => $product->getFinalPrice($qty)
        ));
    }

    /**
     * Adds event on order was placed
     *
     * @param Varien_Event_Observer $observer
     */
    public function checkoutOnepageControllerSuccessAction($observer)
    {
        /** @var Invodo_Video_Model_Config $config */
        $config = Mage::getSingleton('invodo_video/config');

        if (!$config->getGeneralConfig('enable_conversion_tracking')) {
            return;
        }

        $orderIds = (array)$observer->getData('order_ids');

        if (!$orderIds) {
            return;
        }

        $orderId = array_shift($orderIds);
        /** @var Mage_Sales_Model_Order $order */
        $order = Mage::getModel('sales/order')->load($orderId);

        if (!$order->getId()) {
            return;
        }

        $events = array();

        /** @var $item Mage_Sales_Model_Order_Item */
        foreach ($order->getAllVisibleItems() as $item) {
            $events[] = array(
                'name'      => 'itemPurchase',
                'params'    => array(
                    'mpd'       => $item->getSku(),
                    'quantity'  => $item->getQtyOrdered(),
                    'price'     => $item->getBaseRowTotal()
                )
            );
        }

        Mage::register(Invodo_Video_Helper_Data::EVENTS_REGISTRY_NAME, $events);
    }
}