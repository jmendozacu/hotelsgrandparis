<?php

class Hgp_Map_Block_Adminhtml_Map_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('map_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('map')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('map')->__('Item Information'),
          'title'     => Mage::helper('map')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('map/adminhtml_map_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}