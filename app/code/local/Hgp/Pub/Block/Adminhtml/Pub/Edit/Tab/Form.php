<?php

class Hgp_Pub_Block_Adminhtml_Pub_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{

		/*
		 * Recuperation de la collection d'items
		 */
		
		$paramStore = $this->getRequest()->getParam('store', 1);
		
		$_objPub = Mage::getModel('pub/pub');
		
		$listItems = $_objPub
		             ->getCollection()
		             ->addFilter('hgp_pub_store', $paramStore)
		             ->load()
		             ->getLastItem()
		             ->getData();
	
		$count = 0;

		if ($listItems){

			$count = count($listItems);
		}

		/*
		 * Emplacement des fichiers
		 */
		$_moduleBasedir =  Mage::getBaseUrl('media') . '/pub/';

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
			
		$fieldset = $form->addFieldset('pub_form_', array('legend'=>Mage::helper('pub')->__('Pub ')));
		
		$fieldset->addField('hgp_pub_id', 'hidden', array(
			'label'     => Mage::helper('pub')->__('Id'),
			'name'      => 'hgp_pub_id_',
			'value'     => $listItems['hgp_pub_id'],
		));
				
		$fieldset->addField('hgp_pub_title', 'text', array(
			'label'     => Mage::helper('pub')->__('Title'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_pub_title',				
			'value'     => $listItems['hgp_pub_title'],
		));

		$fieldset->addField('hgp_pub_url', 'text', array(
			'label'     => Mage::helper('pub')->__('URL'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_pub_url',
			'value'     => $listItems['hgp_pub_url'],
		));
			
		$fieldset->addField('hgp_pub_link_label', 'text', array(
			'label'     => Mage::helper('pub')->__('Label link'),
			'class'     => 'required-entry',
			'required'  => false,
			'name'      => 'hgp_pub_link_label',
			'value'     => $listItems['hgp_pub_link_label'],
		));	

		$fieldset->addField('hgp_pub_store', 'hidden', array(
			'label'     => Mage::helper('pub')->__('Store'),
			'name'      => 'hgp_pub_store',
			'value'     => $paramStore,
		));	

		$fieldset->addField('hgp_pub_img', 'image', array(
			'label'     => Mage::helper('pub')->__('Photo'),
			'required'  => false,
			'name'      => 'hgp_pub_img',
			'value'     => $_imgInterface . $listItems['hgp_pub_img'],
		));		

		return parent::_prepareForm();

	}




}