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
class Hgp_GooglemapLocator_Block_Adminhtml_Location_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('location_form', array(
            'legend'=>Mage::helper('googlemaplocator')->__('Item Location Info')
        ));

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('googlemaplocator')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
        ));

        $fieldset->addField('address_display', 'textarea', array(
            'name'      => 'address_display',
            'label'     => Mage::helper('googlemaplocator')->__('Address to be displayed'),
            'class'     => 'required-entry',
            'style'     => 'height:50px',
            'required'  => true,
            'note'      => Mage::helper('googlemaplocator')->__('This address will be shown to visitor and should have multiple lines formatting'),
        ));

        $fieldset->addField('phone', 'text', array(
            'name'      => 'phone',
            'label'     => Mage::helper('googlemaplocator')->__('Phone'),
        ));

        $fieldset->addField('website_url', 'text', array(
            'name'      => 'website_url',
            'label'     => Mage::helper('googlemaplocator')->__('Website URL / Email'),
            'note'      => Mage::helper('googlemaplocator')->__('For websites URL please start with http://'),
        ));

        $fieldset->addField('notes', 'textarea', array(
            'name'      => 'notes',
            'style'     => 'height:50px',
            'label'     => Mage::helper('googlemaplocator')->__('Notes'),
        ));

        $fieldset = $form->addFieldset('geo_form', array(
            'legend'=>Mage::helper('googlemaplocator')->__('Geo Location')
        ));

        $fieldset->addField('address', 'textarea', array(
            'name'      => 'address',
            'style'     => 'height:50px',
            'label'     => Mage::helper('googlemaplocator')->__('Address for geo location'),
            'note'      => Mage::helper('googlemaplocator')->__('This address will be used to calculate latitude and longitude, free format is allowed.<br/>If left empty, will be copied from address to be displayed.'),
        ));

        $fieldset->addField('longitude', 'text', array(
            'name'      => 'longitude',
            'label'     => Mage::helper('googlemaplocator')->__('Longitude'),
            'note'      => Mage::helper('googlemaplocator')->__('If empty, will attempt to retrieve using the geo location address.'),
        ));

        $fieldset->addField('latitude', 'text', array(
            'name'      => 'latitude',
            'label'     => Mage::helper('googlemaplocator')->__('Latitude'),
        ));

        Mage::dispatchEvent('googlemaplocator_adminhtml_edit_prepare_form', array('block'=>$this, 'form'=>$form));

        if (Mage::registry('location_data')) {
            $form->setValues(Mage::registry('location_data')->getData());
        }

        return parent::_prepareForm();
    }
}