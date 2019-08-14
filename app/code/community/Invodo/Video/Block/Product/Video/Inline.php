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
 * Renders inline type of video on PDP
 *
 * @category    Invodo
 * @package     Invodo_Video
 *
 * Retrieves video width
 * @method int getWidth()
 *
 * Retrieves video height
 * @method int getHeight()
 */
class Invodo_Video_Block_Product_Video_Inline extends Invodo_Video_Block_Product_Video_Abstract
{
    /**
     * Sets width and height
     */
    protected function _construct()
    {
        parent::_construct();

        /** @var Invodo_Video_Helper_Data $helper */
        $helper = Mage::helper('invodo_video');
        $resolution = $helper->splitResolution($this->_config->getGeneralConfig('pdp_video_resolution'));
        $this->addData($resolution);

        return $this;
    }

    /**
     * @see Invodo_Video_Block_Product_Video_Abstract::getVideoType
     */
    public function getVideoType()
    {
        return Invodo_Video_Helper_Data::VIDEO_TYPE_INLINE;
    }

    /**
     * Retrieves auto-play flag
     *
     * @return int
     */
    public function getAutoPlay()
    {
        return $this->_config->getGeneralConfig('pdp_video_auto_play');
    }
}