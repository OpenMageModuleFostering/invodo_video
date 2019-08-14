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
 * Module helper
 *
 * @category    Invodo
 * @package     Invodo_Video
 */
class Invodo_Video_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Video type: inline
     *
     * @var int
     */
    const VIDEO_TYPE_INLINE = 1;

    /**
     * Video type: overlay
     *
     * @var int
     */
    const VIDEO_TYPE_OVERLAY = 2;

    /**
     * Source type: POD ID
     *
     * @var int
     */
    const SOURCE_TYPE_POD = 1;

    /**
     * Source type: MPD ID
     *
     * @var int
     */
    const SOURCE_TYPE_MPD = 2;

    /**
     * Source type: REF ID
     *
     * @var int
     */
    const SOURCE_TYPE_REF = 3;

    /**
     * Default video width
     *
     * @var string
     */
    const DEFAULT_VIDEO_WIDTH = 480;

    /**
     * Default video width
     *
     * @var string
     */
    const DEFAULT_VIDEO_HEIGHT = 270;

    /**
     * Overlay call-to-action: custom image
     * @var int
     */
    const OVERLAY_ACTION_CUSTOM_IMAGE = 1;

    /**
     * Overlay call-to-action: invodo thumbnail
     *
     * @var int
     */
    const OVERLAY_ACTION_INVODO_THUMBNAIL = 2;

    /**
     * Overlay call-to-action: invodo previw
     *
     * @var int
     */
    const OVERLAY_ACTION_INVODO_PREVIEW = 3;

    /**
     * Events name in registry
     *
     * @var string
     */
    const EVENTS_REGISTRY_NAME = 'invodo_video_events';

    /**
     * Increment id
     *
     * @var int
     */
    protected static $_incrementId = 0;

    /**
     * Retrieves Video script tag
     *
     * @return string
     */
    public function getScriptTag()
    {
        /** @var Invodo_Video_Model_Config $config */
        $config = Mage::getSingleton('invodo_video/config');
        $siteKey = $config->getGeneralConfig('site_key');

        if ($siteKey) {
            return sprintf('<script type="text/javascript" src="//e.invodo.com/4.0/s/%s.js"></script>' . "\n", $siteKey);
        }
    }

    /**
     * Checks if module enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        /** @var Invodo_Video_Model_Config $config */
        $config = Mage::getSingleton('invodo_video/config');
        $siteKey = $config->getGeneralConfig('site_key');

        return $siteKey ? true : false;
    }

    /**
     * Retrieves new increment id
     *
     * @return int
     */
    public static function getIncrementId()
    {
        return ++self::$_incrementId;
    }

    /**
     * Splits resolution to width and height
     *
     * @param $resolution
     * @return array
     */
    public function splitResolution($resolution)
    {
        preg_match('/^([1-9]\d{2,3})x([1-9]\d{2,3})$/', $resolution, $matches);

        if ($matches) {
            $result = array(
                'width'     => $matches[1],
                'height'    => $matches[2],
            );
        } else {
            $result = array(
                'width'     => self::DEFAULT_VIDEO_WIDTH,
                'height'    => self::DEFAULT_VIDEO_HEIGHT,
            );
        }

        return $result;
    }
}