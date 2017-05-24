<?php

class Hgp_Engagement_Block_Adminhtml_Engagement_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('engagement_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('engagement')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('engagement')->__('Liste des param&egrave;tres'),
          'title'     => Mage::helper('engagement')->__('Item information'),
          'content'   => $this->getLayout()->createBlock('engagement/adminhtml_engagement_edit_tab_form')->toHtml(),
      ));

                //$this->addTab('customer_options', array(
                    //'label' => Mage::helper('engagement')->__('Custom Options'),
                   // 'url'   => $this->getUrl('*/*/options', array('_current' => true)),
                   // 'class' => 'ajax',
               // ));


      return parent::_beforeToHtml();
  }
}