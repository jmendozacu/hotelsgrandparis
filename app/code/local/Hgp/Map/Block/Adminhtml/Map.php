<?php

class Hgp_Map_Block_Adminhtml_Map extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_map';
    $this->_blockGroup = 'map';
    //$this->_headerText = Mage::helper('map')->__('Item Manager');
    //$this->_addButtonLabel = Mage::helper('map')->__('Add Item');
    parent::__construct();
  }
}