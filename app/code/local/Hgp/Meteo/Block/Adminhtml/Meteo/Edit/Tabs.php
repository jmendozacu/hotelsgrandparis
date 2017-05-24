<?php

class Hgp_Meteo_Block_Adminhtml_Meteo_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('meteo_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('meteo')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('meteo')->__('Liste des param&egrave;tres'),
          'title'     => Mage::helper('meteo')->__('Item information'),
          'content'   => $this->getLayout()->createBlock('meteo/adminhtml_meteo_edit_tab_form')->toHtml(),
      ));

                //$this->addTab('customer_options', array(
                    //'label' => Mage::helper('meteo')->__('Custom Options'),
                   // 'url'   => $this->getUrl('*/*/options', array('_current' => true)),
                   // 'class' => 'ajax',
               // ));


      return parent::_beforeToHtml();
  }
}