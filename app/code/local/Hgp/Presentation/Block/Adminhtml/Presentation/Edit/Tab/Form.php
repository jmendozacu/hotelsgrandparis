<?php

class Hgp_Presentation_Block_Adminhtml_Presentation_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{

		/*
		 * Recuperation de la collection d'items
		 */

		$paramStore = $this->getRequest()->getParam('store', 1);
		$count = 0;
		$_objPresentation = Mage::getModel('presentation/presentation');
		
		$listItems = $_objPresentation
			         ->getCollection()
			         ->addFilter('hgp_presentation_store_fk', $paramStore)
			         ->load()
			         ->getLastItem()
			         ->getData();
		
		if ($listItems){

			$count = count($listItems);
		}

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
			
		$fieldset = $form->addFieldset('presentation_form_', array('legend'=>Mage::helper('presentation')->__('Presentation ')));
		
		$fieldset->addField('hgp_presentation_id', 'hidden', array(
			'label'     => Mage::helper('presentation')->__('Id'),
			'name'      => 'hgp_presentation_id',
			'value'     => $listItems['hgp_presentation_id'],
		));
		
		$fieldset->addField('hgp_presentation_title', 'text', array(
			'label'     => Mage::helper('presentation')->__('Title'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_presentation_title',				
			'value'     => $listItems['hgp_presentation_title'],
		));
		
		$fieldset->addField('hgp_presentation_contenu', 'textarea', array(
			'label'     => Mage::helper('presentation')->__('Content'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_presentation_contenu',				
			'value'     => $listItems['hgp_presentation_contenu'],
		));
		
		$fieldset->addField('hgp_presentation_link_label', 'text', array(
			'label'     => Mage::helper('presentation')->__('Link label'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_presentation_link_label',				
			'value'     => $listItems['hgp_presentation_link_label'],
		));
		
		$fieldset->addField('hgp_presentation_url', 'text', array(
			'label'     => Mage::helper('presentation')->__('Url'),
			'class'     => 'required-entry',
			'required'  => false,
			'name'      => 'hgp_presentation_url',				
			'value'     => $listItems['hgp_presentation_url'],
		));
		
		$fieldset->addField('hgp_presentation_teaser', 'text', array(
			'label'     => Mage::helper('presentation')->__('Teaser'),
			'class'     => 'required-entry',
			'required'  => false,
			'name'      => 'hgp_presentation_teaser',				
			'value'     => $listItems['hgp_presentation_teaser'],
		));
		
		$fieldset->addField('hgp_presentation_store_fk', 'hidden', array(
			'label'     => Mage::helper('presentation')->__('Store'),
			'name'      => 'hgp_presentation_store_fk',				
			'value'     => $listItems['hgp_presentation_store_fk'],
		));

		return parent::_prepareForm();
	}




}