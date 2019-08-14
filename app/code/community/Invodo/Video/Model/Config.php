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
 * Works with module configuration
 *
 * @category    Invodo
 * @package     Invodo_Video
 */
class Invodo_Video_Model_Config
{
    /**
     * Retrieves config for log group field
     *
     * @param string $field
     * @param null $store
     * @return mixed
     */
    public function getGeneralConfig($field = '', $store = null)
    {
        return $this->getConfig('general', $field, $store);
    }

    /**
     * Retrieves config by group and field
     *
     * @param string $group
     * @param string $field
     * @param null $store
     * @return mixed
     */
    public function getConfig($group, $field, $store = null)
    {
        $path = rtrim("invodo_video/{$group}/$field", '/');

        return Mage::getStoreConfig($path, $store);
    }
}