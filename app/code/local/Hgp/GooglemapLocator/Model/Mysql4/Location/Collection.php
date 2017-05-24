<?php
/**
 * Hgp_GooglemapLocator extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Hgp
 * @package    Hgp_GooglemapLocator
 * @copyright  Copyright (c) 2009 Hotels Grand Paris 
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   HotelsGrandParis
 * @package    Hgp_GooglemapLocator
 * @author     Brice POTE <brice.pote@hotelsgrandparis.com>
 */
class Hgp_GooglemapLocator_Model_Mysql4_Location_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('googlemaplocator/location');
    }

    public function addAreaFilter($center_lat, $center_lng, $radius, $units='mi')
    {
        $conn = $this->getConnection();
        $dist = sprintf(
            "(%s*acos(cos(radians(%s))*cos(radians(`latitude`))*cos(radians(`longitude`)-radians(%s))+sin(radians(%s))*sin(radians(`latitude`))))",
            $units=='mi' ? 3959 : 6371,
            $conn->quote($center_lat),
            $conn->quote($center_lng),
            $conn->quote($center_lat)
        );
        $this->_select = $conn->select()->from(array('main_table' => $this->getResource()->getMainTable()), array('*', 'distance'=>$dist))
            ->where('`latitude` is not null and `latitude`<>0 and `longitude` is not null and `longitude`<>0 and '.$dist.'<=?', $radius)
            ->order('distance');
        return $this;
    }

    public function addProductTypeFilter($type)
    {
        if ($type) {
            $this->_select->where('find_in_set(?, product_types)', $type);
        }
        return $this;
    }
}
