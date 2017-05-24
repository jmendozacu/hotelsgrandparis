<?php

class Hgp_Homeslide_Block_Adminhtml_Homeslide extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {    
     $this->_blockGroup = 'homeslide';
     $this->_controller = 'adminhtml_homeslide';
     $this->_headerText = Mage::helper('homeslide')->__('Manage Items Homeslide');
     $this->_addButtonLabel = Mage::helper('homeslide')->__('Add New Slide Item');
     parent::__construct();
  }
}