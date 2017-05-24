<?php

class Hgp_Map_Block_Adminhtml_Map_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{

		/*
		 * Recuperation de la collection d'items
		 */
	
		$paramStore = $this->getRequest()->getParam('store', 1);	
		$count = 0;
		
		$listItems = Mage::getModel('map/map')
		           ->getCollection()
		           ->addFilter('hgp_map_store', $paramStore)
		           ->load()
		           ->getLastItem()
		           ->getData();
		/*
		 * Emplacement des fichiers
		 */
		$_moduleBasedir =  Mage::getBaseUrl('media') . '/map/';

		$_imgInterface = $_moduleBasedir . 'images/';

		/*
		 * Construction du formulaire du Backend
		 */
		$form = new Varien_Data_Form();
		$this->setForm($form);
							
		 if (!Mage::app()->isSingleStoreMode()) {
	            $form->addField('param_store', 'select', array(
	                'label'     => $this->__('Store'),
	                'title'     => $this->__('Store'),
	                'name'      => 'param_store',
	                'required'  => true,
	                'values'    => array(1 => 'English', 2 => 'Français'),
	                'onchange'  => 'javascript:window.location.href=\''.$this->getUrl('/*/*/store', array('store' => ($paramStore == 1) ? $paramStore+1 : $paramStore-1)).'\'',  
	            ));
	            $form->addValues(array('param_store' => $paramStore));	            
	     }

			
		$fieldset = $form->addFieldset('map_form', array('legend'=>Mage::helper('map')->__('Map')));
		
		$fieldset->addField('hgp_map_id', 'hidden', array(
			'label'     => Mage::helper('map')->__('Id'),
			'name'      => 'hgp_map_id',
			'value'     => $listItems['hgp_map_id'],
		));
				
		$fieldset->addField('hgp_map_title', 'text', array(
			'label'     => Mage::helper('map')->__('Title'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_map_title',				
			'value'     => $listItems['hgp_map_title'],
		));

		$fieldset->addField('hgp_map_url', 'text', array(
			'label'     => Mage::helper('map')->__('URL'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_map_url',
			'value'     => $listItems['hgp_map_url'],
		));	

		$fieldset->addField('hgp_map_store', 'hidden', array(
			'label'     => Mage::helper('map')->__('Store'),
			'name'      => 'hgp_map_store',
			'value'     => $paramStore,
		));	

		$fieldset->addField('hgp_map_img', 'image', array(
			'label'     => Mage::helper('map')->__('Photo'),
			'required'  => false,
			'name'      => 'hgp_map_img',
			'value'     => $_imgInterface . $listItems['hgp_map_img'],
		));		

		return parent::_prepareForm();

	}

}