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
class Hgp_GooglemapLocator_Block_Adminhtml_Location_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('locationsGrid');
        $this->setDefaultSort('location_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $this->setCollection(Mage::getModel('googlemaplocator/location')->getCollection());
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('location_id', array(
            'header'    => Mage::helper('googlemaplocator')->__('ID'),
            'align'     => 'right',
            'width'     => '50px',
            'index'     => 'location_id',
            'type'      => 'number',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('googlemaplocator')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));

        $this->addColumn('address', array(
            'header'    => Mage::helper('googlemaplocator')->__('Address'),
            'align'     => 'left',
            'index'     => 'address',
        ));

        $this->addColumn('website_url', array(
            'header'    => Mage::helper('googlemaplocator')->__('URL'),
            'index'     => 'website_url',
        ));

        $this->addColumn('phone', array(
            'header'    => Mage::helper('googlemaplocator')->__('Phone'),
            'index'     => 'phone',
        ));

        $this->addColumn('longitude', array(
            'header'    => Mage::helper('googlemaplocator')->__('Longitude'),
            'align'     => 'right',
            'index'     => 'longitude',
            'width'     => '50px',
            'type'      => 'number',
        ));

        $this->addColumn('latitude', array(
            'header'    => Mage::helper('googlemaplocator')->__('Latitude'),
            'align'     => 'right',
            'index'     => 'latitude',
            'width'     => '50px',
            'type'      => 'number',
        ));

        Mage::dispatchEvent('googlemaplocator_adminhtml_grid_prepare_columns', array('block'=>$this));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
