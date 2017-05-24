<?php

class Hgp_Homeslide_Block_Adminhtml_Homeslide_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('homeslide_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('homeslide')->__('Slideshow Home'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('homeslide')->__('Fiche du Carrousel'),
          'title'     => Mage::helper('homeslide')->__('Fiche du Carrousel'),
          'content'   => $this->getLayout()->createBlock('homeslide/adminhtml_homeslide_edit_tab_form')->toHtml(),
      ));

                //$this->addTab('customer_options', array(
                    //'label' => Mage::helper('homeslide')->__('Custom Options'),
                   // 'url'   => $this->getUrl('*/*/options', array('_current' => true)),
                   // 'class' => 'ajax',
               // ));


      return parent::_beforeToHtml();
  }
}