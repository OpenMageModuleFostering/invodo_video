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
 * Renders widget
 *
 * @category    Invodo
 * @package     Invodo_Video
 *
 * Retrieves source type
 * @method string getSourceType()
 *
 * Retrieves auto-play option
 * @method bool getAutoPlay()
 *
 * Retrieves overlay action type
 * @method bool getOverlayAction()
 *
 * Retrieves video width
 * @method int getWidth()
 *
 * Retrieves video height
 * @method int getHeight()
 */
class Invodo_Video_Block_Widget extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{
    /**
     * Sets video size
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        /** @var Invodo_Video_Helper_Data $helper */
        $helper = Mage::helper('invodo_video');
        $resolution = $helper->splitResolution($this->getData('video_resolution'));
        $this->addData($resolution);

        return parent::_beforeToHtml();
    }

    /**
     * Checks module enabled correctly
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

        return parent::_toHtml();
    }

    /**
     * Widget type is inline
     *
     * @return bool
     */
    public function isInlineType()
    {
        return $this->getData('video_type') == Invodo_Video_Helper_Data::VIDEO_TYPE_INLINE;
    }

    /**
     * Retrieves source type as api param name
     *
     * @return string
     */
    public function getSourceTypeName()
    {
        if ($this->getSourceType() == Invodo_Video_Helper_Data::SOURCE_TYPE_MPD) {
            return 'mpd';
        } else {
            return 'refId';
        }
    }

    /**
     * Retrieves source value
     *
     * @return string
     */
    public function getSourceValue()
    {
        $value = $this->getData('source_value');

        return addslashes($value);
    }

    /**
     * Retrieves path to image for CTA
     *
     * @return string
     */
    public function getOverlayActionSource()
    {
        switch ($this->getOverlayAction()) {
            case Invodo_Video_Helper_Data::OVERLAY_ACTION_CUSTOM_IMAGE:
                $source = "'" . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) .
                    $this->getData('overlay_action_source') . "'";
                break;

            case Invodo_Video_Helper_Data::OVERLAY_ACTION_INVODO_THUMBNAIL:
                $source = sprintf('Invodo.Pod.getThumbnailByMpd("%s")', $this->getSourceValue());
                break;

            case Invodo_Video_Helper_Data::OVERLAY_ACTION_INVODO_PREVIEW:
                $source = sprintf('Invodo.Pod.getPosterByMpd("%s")', $this->getSourceValue());
                break;
        }

        return $source;
    }
}
