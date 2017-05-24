<?php

class Hgp_Presentation_Block_Adminhtml_Presentation_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('presentation_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('presentation')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('presentation')->__('Liste des param&egrave;tres'),
          'title'     => Mage::helper('presentation')->__('Item information'),
          'content'   => $this->getLayout()->createBlock('presentation/adminhtml_presentation_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}