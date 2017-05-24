<?php

class Hgp_Pub_Block_Adminhtml_Pub extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_pub';
    $this->_blockGroup = 'pub';
    //$this->_headerText = Mage::helper('pub')->__('Item Manager');
    //$this->_addButtonLabel = Mage::helper('pub')->__('Add Item');
    parent::__construct();
  }
}