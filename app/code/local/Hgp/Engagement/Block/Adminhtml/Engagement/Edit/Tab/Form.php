<?php

class Hgp_Engagement_Block_Adminhtml_Engagement_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{

		/*
		 * Recuperation de la collection d'items
		 */
		
		$paramStore = $this->getRequest()->getParam('store', 1);
	
		$count = 0;
		$_objEngagement = Mage::getModel('engagement/engagement')
			             ->getCollection()
			             ->addFilter('hgp_engagement_store_fk', $paramStore)
			             ->load()
			             ->getData();

		$listEngagement = $_objEngagement;

		$count = 0;
		
		if ($listEngagement){

			$count = count($listEngagement);
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

		for ($i=0;$i<$count;$i++){
			
			$fieldset[$i] = $form->addFieldset('engagement_form_' . $i, array('legend'=>Mage::helper('engagement')->__('Engagement ' . ($i+1))));
			
			$fieldset[$i]->addField('hgp_engagement_id' . $i, 'hidden', array(
			'label'     => Mage::helper('engagement')->__('Id'),
			'name'      => 'hgp_engagement_id' . $i,
			'value'     => $listEngagement[$i]['hgp_engagement_id'],
			));
			
			$fieldset[$i]->addField('hgp_engagement_contenu' . $i, 'text', array(
			'label'     => Mage::helper('engagement')->__('contenu'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'hgp_engagement_contenu' . $i,				
			'value'     => $listEngagement[$i]['hgp_engagement_contenu'],
			));
			
			$fieldset[$i]->addField('hgp_engagement_store_fk' . $i, 'hidden', array(
			'label'     => Mage::helper('engagement')->__('store'),
			'name'      => 'hgp_engagement_store_fk' . $i,				
			'value'     => $paramStore,
			));
												
		}

		return parent::_prepareForm();

	}




}