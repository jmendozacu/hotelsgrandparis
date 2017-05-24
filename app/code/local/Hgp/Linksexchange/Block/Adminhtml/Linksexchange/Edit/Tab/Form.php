<?php

class Hgp_Linksexchange_Block_Adminhtml_Linksexchange_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{

		/*
		 * Construction du formulaire du Backend
		 */
		
		$form = new Varien_Data_Form();
		$this->setForm($form);
		
		//Champs du formulaire avec calendrier
		$arrDatas = array();
		$id = $this->getRequest()->getParam('id', 0);
		$date_creation = $date_modification = null;

		if($id != 0){
	        $arrDatas = Mage::getModel('linksexchange/linksexchange')->load($this->getRequest()->getParam('id')); 
	        if($arrDatas){
	            $date_creation = Mage::app()->getLocale()->storeDate(
	            								0, 
	            								new Zend_Date($arrDatas['hgp_linksexchange_date_creation'], Varien_Date::DATETIME_INTERNAL_FORMAT), 
	            								true
	            							);
	            
	            $date_modification = Mage::app()->getLocale()->storeDate(
	            								0, 
	            								new Zend_Date($arrDatas['hgp_linksexchange_date_modification'], Varien_Date::DATETIME_INTERNAL_FORMAT), 
	            								true
	            							);

	        }
		}
			
		$fieldset = $form->addFieldset('linksexchange_form', array('legend'=>Mage::helper('linksexchange')->__('Links Exchange ')));	
								
		$fieldset->addField('hgp_linksexchange_id', 'hidden', array(
		'label'     => Mage::helper('linksexchange')->__('Id'),
		'name'      => 'hgp_linksexchange_id',
		));
		
		if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('hgp_linksexchange_store_id', 'select', array(
                'label'     => $this->__('Store'),
                'title'     => $this->__('Store'),
                'name'      => 'hgp_linksexchange_store_id',
                'required'  => true,
                'values'    => array(1 => $this->__('English'), 2 => $this->__('Français'))
            ));            
        }	
				
		$fieldset->addField('hgp_linksexchange_category', 'select', array(
		'label'     => Mage::helper('linksexchange')->__('id Category'),
		'class'     => 'required-entry',
		'required'  => true,
		'name'      => 'hgp_linksexchange_category',	
		'values'    => Mage::Helper('linksexchange')->getCategory(),
		));
		
		$fieldset->addField('hgp_linksexchange_site_name', 'text', array(
		'label'     => Mage::helper('linksexchange')->__('Nom du site'),
		//'class'     => 'required-entry',
		'required'  => false,
		'name'      => 'hgp_linksexchange_site_name',				
		));
		
		$fieldset->addField('hgp_linksexchange_site_description', 'textarea', array(
		'label'     => Mage::helper('linksexchange')->__('Description (200 caractères)'),
		//'class'     => 'required-entry',
		'required'  => false,
		'name'      => 'hgp_linksexchange_site_description',
		));

		$fieldset->addField('hgp_linksexchange_site_url_label', 'text', array(
		'label'     => Mage::helper('linksexchange')->__('Texte de votre lien'),
		'class'     => 'required-entry',
		'required'  => true,
		'name'      => 'hgp_linksexchange_site_url_label',
		));	
		
		$fieldset->addField('hgp_linksexchange_site_url_link', 'text', array(
		'label'     => Mage::helper('linksexchange')->__('URL de votre site'),
		'class'     => 'required-entry',
		'note' => $this->__('Sans le http://'),
		'required'  => true,
		'name'      => 'hgp_linksexchange_site_url_link',
		));	
		
		$fieldset->addField('hgp_linksexchange_site_url_title', 'text', array(
		'label'     => Mage::helper('linksexchange')->__('Title du lien'),
		'class'     => 'required-entry',		
		'required'  => true,
		'name'      => 'hgp_linksexchange_site_url_title',
		));	
		
		$fieldset->addField('hgp_linksexchange_contact_email', 'text', array(
		'label'     => Mage::helper('linksexchange')->__('E-mail'),
		//'class'     => 'required-entry',
		'required'  => false,
		'name'      => 'hgp_linksexchange_contact_email',
		));	
		
		$fieldset->addField('hgp_linksexchange_contact_tel', 'text', array(
		'label'     => Mage::helper('linksexchange')->__('Téléphone'),
		//'class'     => 'required-entry',
		'note' => $this->__('Format : 11 22 33 44 55'),
		'required'  => false,
		'name'      => 'hgp_linksexchange_contact_tel',
		));
		
		$fieldset->addField('hgp_linksexchange_site_page_cible', 'text', array(
		'label'     => Mage::helper('linksexchange')->__('Page de votre site où notre lien apparaîtra'),
		//'class'     => 'required-entry',
		'note' => $this->__('Sans le http://'),
		'required'  => false,
		'name'      => 'hgp_linksexchange_site_page_cible',
		));	
		
		$fieldset->addField('hgp_linksexchange_date_modification', 'note', array(
				'label'     => Mage::helper('linksexchange')->__('Date de modification'),
				'text'      => ($id!=0) ? Mage::helper('linksexchange')->getFrenchDate($date_modification):'',
		));
		
		$fieldset->addField('hgp_linksexchange_date_creation', 'note', array(
				'label'     => Mage::helper('linksexchange')->__('Date de création'),
				'text'      => ($id!=0) ? Mage::helper('linksexchange')->getFrenchDate($date_creation):'',
		));
		
		$fieldset->addField('hgp_linksexchange_user_modif', 'note', array(
				'label'     => Mage::helper('linksexchange')->__('Utilisateur Modif'),
				'required'  => false,
				'text'      => isset($arrDatas['hgp_linksexchange_user_modif']) ? $arrDatas['hgp_linksexchange_user_modif']: '',
		));
		
		$fieldset->addField('hgp_linksexchange_ordre', 'text', array(
				'label'     => Mage::helper('linksexchange')->__('Ordre'),
				'required'  => true,
		        'class'     => 'required-entry',
		        'style'     => 'width: 30px;', 
				'name'      => 'hgp_linksexchange_ordre',
		        'note'      => 'Laisser 1 par défaut',
		));
				
		$fieldset->addField('hgp_linksexchange_actif', 'select', array(
		'label'     => Mage::helper('linksexchange')->__('Actif.'),
		'title'     => Mage::helper('linksexchange')->__('Actif.'),
		'required'  => false,
		'name'      => 'hgp_linksexchange_actif',
		'style'     => 'width:150px;',
		'values'    => array(1 => 'Oui', 0 => 'Non'),
		'note'      => 'Si 0 Le lien n\'apparaitra pas',  
		));	

	 	Mage::dispatchEvent('linksexchange_adminhtml_edit_prepare_form', array('block'=>$this, 'form'=>$form));

	 	// Chargement des infos du formulaire 
        if ($arrDatas) {
           $form->setValues($arrDatas);
        }

		return parent::_prepareForm();
	}

}