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
class Hgp_GooglemapLocator_Block_Adminhtml_Location_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('location_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('googlemaplocator')->__('Manage Locations'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('googlemaplocator')->__('Location Information'),
            'title'     => Mage::helper('googlemaplocator')->__('Location Information'),
            'content'   => $this->getLayout()->createBlock('googlemaplocator/adminhtml_location_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}