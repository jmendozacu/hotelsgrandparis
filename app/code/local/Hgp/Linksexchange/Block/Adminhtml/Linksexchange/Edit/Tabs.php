<?php

class Hgp_Linksexchange_Block_Adminhtml_Linksexchange_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('linksexchange_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('linksexchange')->__('Links Exchange'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('linksexchange')->__('Fiche du lien'),
          'title'     => Mage::helper('linksexchange')->__('Fiche du lien'),
          'content'   => $this->getLayout()->createBlock('linksexchange/adminhtml_linksexchange_edit_tab_form')->toHtml(),
      ));

      return parent::_beforeToHtml();
  }
}