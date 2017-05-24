<?php

class Hgp_Meteo_Block_Adminhtml_Meteo extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_meteo';
    $this->_blockGroup = 'meteo';
    //$this->_headerText = Mage::helper('meteo')->__('Item Manager');
    //$this->_addButtonLabel = Mage::helper('meteo')->__('Add Item');
    parent::__construct();
  }
}