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
 * Renders form element
 *
 * @category    Invodo
 * @package     Invodo_Video
 */
class Invodo_Video_Block_Adminhtml_Widget_Renderer_Sourcetype extends Mage_Core_Block_Abstract
{
    /**
     * Prepares element
     *
     * @param Varien_Data_Form_Element_Abstract $element Form Element
     * @return Varien_Data_Form_Element_Abstract
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $element->setData('separator', '<br />');
        $element->setRequired(false);
        $element->setClass($element->getClass() . ' validate-one-required-by-name');

        if ($element->getValue() === null) {
            $element->setValue(Invodo_Video_Helper_Data::SOURCE_TYPE_REF);
        }

        /** @var Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element $renderer */
        $renderer = $element->getRenderer();

        if ($renderer instanceof Mage_Adminhtml_Block_Widget_Form_Renderer_Fieldset_Element) {
            $newRenderer = clone $renderer;
            $newRenderer->setTemplate('invodo/video/widget/form/renderer/sourcetype.phtml');
            $element->setRenderer($newRenderer);
        }

        return $element;
    }
}