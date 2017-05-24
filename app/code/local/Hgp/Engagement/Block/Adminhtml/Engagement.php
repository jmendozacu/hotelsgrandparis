<?php

class Hgp_Engagement_Block_Adminhtml_Engagement extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_engagement';
    $this->_blockGroup = 'engagement';
    //$this->_headerText = Mage::helper('engagement')->__('Item Manager');
    //$this->_addButtonLabel = Mage::helper('engagement')->__('Add Item');
    parent::__construct();
  }
}