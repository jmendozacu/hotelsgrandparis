<?php

class Hgp_Meteo_Block_Adminhtml_Meteo_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{

		/*
		 * Recuperation de la collection d'items
		 */

		$count = 0;
		$paramStore = $this->getRequest()->getParam('store', 1);
		
		$listMeteo = Mage::getModel('meteo/meteo')
		             ->getCollection()
		             ->addFilter('hgp_store_fk', $paramStore)
		             ->load()
		             ->getLastItem()
		             ->getData();
		             
		             //print_r($listMeteo);exit;
			
		if (!$listMeteo) return false;

		/*
		 * Emplacement des fichiers
		 */
		$_moduleBasedir =  Mage::getBaseUrl('media') . '/meteo/';

		$_imgInterface = $_moduleBasedir . 'images/';

		/*
		 * Construction du formulaire du Backend
		 */
		$form = new Varien_Data_Form();
		$this->setForm($form);
		
		$paramStore = $this->getRequest()->getParam('store', 1);		
		
		 if (!Mage::app()->isSingleStoreMode()) {
	            $form->addField('hgp_store_fk_', 'select', array(
	                'label'     => $this->__('Store'),
	                'title'     => $this->__('Store'),
	                'name'      => 'hgp_store_fk_',
	                'required'  => true,
	                'values'    => array(1 => 'English', 2 => 'Français'),
	                'onchange'  => 'javascript:window.location.href=\''.$this->getUrl('/*/*/store', array('store' => ($paramStore == 1) ? $paramStore+1 : $paramStore-1)).'\'', 
	            ));
	            $form->addValues(array('hgp_store_fk_' => $paramStore));	            
	     }
			
		$fieldset = $form->addFieldset('meteo_form', array('legend'=>Mage::helper('meteo')->__('Meteo')));
			
		$fieldset->addField('hgp_meteo_id', 'hidden', array(
			'label'     => Mage::helper('meteo')->__('Id'),
			'name'      => 'hgp_meteo_id',
			'value'     => $listMeteo['hgp_meteo_id'],
		));
			
		$fieldset->addField('hgp_meteo_lang', 'text', array(
			'label'     => Mage::helper('meteo')->__('lang'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_meteo_lang',				
			'value'     => $listMeteo['hgp_meteo_lang'],
		));
			
		$fieldset->addField('hgp_store_fk', 'hidden', array(
			'label'     => Mage::helper('meteo')->__('Store'),
			'name'      => 'hgp_store_fk',				
			'value'     => $paramStore,
		));
					
		$fieldset->addField('hgp_meteo_intro', 'text', array(
			'label'     => Mage::helper('meteo')->__('title'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_meteo_intro',				
			'value'     => $listMeteo['hgp_meteo_intro'],
		));
			
		$fieldset->addField('hgp_meteo_today', 'text', array(
			'label'     => Mage::helper('meteo')->__('today'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_meteo_today',				
			'value'     => $listMeteo['hgp_meteo_today'],
		));
			
		$fieldset->addField('hgp_meteo_unite', 'text', array(
			'label'     => Mage::helper('meteo')->__('unite'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_meteo_unite',				
			'value'     => $listMeteo['hgp_meteo_unite'],
		));
			
		$fieldset->addField('hgp_meteo_particule', 'text', array(
			'label'     => Mage::helper('meteo')->__('particule'),
			'name'      => 'hgp_meteo_particule',				
			'value'     => $listMeteo['hgp_meteo_particule'],
		));
			
		$fieldset->addField('hgp_meteo_date_format', 'text', array(
			'label'     => Mage::helper('meteo')->__('format date'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_meteo_date_format',				
			'value'     => $listMeteo['hgp_meteo_date_format'],
		));
			
		$fieldset->addField('hgp_meteo_city', 'text', array(
			'label'     => Mage::helper('meteo')->__('city'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_meteo_city',				
			'value'     => $listMeteo['hgp_meteo_city'],
		));

		return parent::_prepareForm();

	}




}