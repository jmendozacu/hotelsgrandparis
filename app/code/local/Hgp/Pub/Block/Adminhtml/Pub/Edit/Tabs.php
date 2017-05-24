<?php

class Hgp_Pub_Block_Adminhtml_Pub_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('pub_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('pub')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('pub')->__('Item Information'),
          'title'     => Mage::helper('pub')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('pub/adminhtml_pub_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}