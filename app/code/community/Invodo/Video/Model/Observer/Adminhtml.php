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
 * Observer for adminhtml events
 *
 * @category    Invodo
 * @package     Invodo_Video
 */
class Invodo_Video_Model_Observer_Adminhtml
{
    /**
     * Adds editor handle for configuration section
     *
     * @param Varien_Event_Observer $observer $observer
     */
    public function controllerActionLayoutLoadBefore($observer)
    {
        /** @var Mage_Adminhtml_System_ConfigController $action */
        $action = $observer->getAction();
        /** @var Mage_Core_Model_Layout $layout */
        $layout = $observer->getLayout();
        $acceptedActions = array(
            'adminhtml_system_config_edit',
            'adminhtml_widget_instance_edit'
        );
        $actionName = $action->getFullActionName();

        if (!in_array($actionName, $acceptedActions)) {
            return;
        }

        if ($actionName == 'adminhtml_system_config_edit'
            && $action->getRequest()->getParam('section') != 'invodo_video'
        ) {
            return;
        }

        $layout->getUpdate()->addHandle('editor');
    }

    /**
     * Replaces block
     *
     * @param Varien_Event_Observer $observer
     */
    public function adminhtmlCmsWysiwygImagesIndexRenderBefore($observer)
    {
        if (!Mage::app()->getRequest()->getParam('invodo_video')) {
            return;
        }

        $layout = Mage::app()->getLayout();
        $name = 'wysiwyg_images.js';
        $previous = $layout->getBlock($name);

        if (!$previous) {
            return;
        }

        $parent = $previous->getParentBlock();
        $parent->unsetChild($name);
        $block = $layout->createBlock('invodo_video/adminhtml_cms_wysiwyg_images_content', $name);
        $block->setTemplate('cms/browser/js.phtml');
        $parent->insert($block);
    }
}