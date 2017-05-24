<?php

class Hgp_Linksexchange_Block_Adminhtml_Linksexchange extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {    
     $this->_blockGroup = 'linksexchange';
     $this->_controller = 'adminhtml_linksexchange';
     $this->_headerText = Mage::helper('linksexchange')->__('Manage Items LinksExchange');
     $this->_addButtonLabel = Mage::helper('linksexchange')->__('Add New Link Item');
     parent::__construct();
  }
}