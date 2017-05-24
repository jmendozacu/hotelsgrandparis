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
class Hgp_GooglemapLocator_Block_Adminhtml_Location_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'googlemaplocator';
        $this->_controller = 'adminhtml_location';

        $this->_updateButton('save', 'label', Mage::helper('googlemaplocator')->__('Save Location'));
        $this->_updateButton('delete', 'label', Mage::helper('googlemaplocator')->__('Delete Location'));

        if( $this->getRequest()->getParam($this->_objectId) ) {
            $model = Mage::getModel('googlemaplocator/location')
                ->load($this->getRequest()->getParam($this->_objectId));
            Mage::register('location_data', $model);
        }


    }

    public function getHeaderText()
    {
        if( Mage::registry('location_data') && Mage::registry('location_data')->getId() ) {
            return Mage::helper('googlemaplocator')->__("Edit Location", $this->htmlEscape(Mage::registry('location_data')->getTitle()));
        } else {
            return Mage::helper('googlemaplocator')->__('New Location');
        }
    }
}
