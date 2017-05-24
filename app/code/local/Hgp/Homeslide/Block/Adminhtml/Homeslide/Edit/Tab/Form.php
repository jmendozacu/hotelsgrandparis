<?php

class Hgp_Homeslide_Block_Adminhtml_Homeslide_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
	
		/*
		 * Recuperation de la collection d'items
		 */

		
		/*
		 * Emplacement des fichiers
		 */
		$_moduleBasedir =  Mage::getBaseUrl('media') . '/homeslide/';

		$_imgInterface = $_moduleBasedir . 'images/';
		$_imgPhoto     = $_moduleBasedir . 'photos/';
		$_imgThumbs    = $_moduleBasedir . 'thumbnails/';

		/*
		 * Construction du formulaire du Backend
		 */
		
		$form = new Varien_Data_Form();
		$this->setForm($form);
						
	
			
		$fieldset = $form->addFieldset('homeslide_form', array('legend'=>Mage::helper('homeslide')->__('Slide ')));	
								
		$fieldset->addField('hgp_homeslide_id', 'hidden', array(
		'label'     => Mage::helper('homeslide')->__('Id'),
		'name'      => 'hgp_homeslide_id',
		));
		
		if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('hgp_homeslide_store', 'select', array(
                'label'     => $this->__('Store'),
                'title'     => $this->__('Store'),
                'name'      => 'hgp_homeslide_store',
                'required'  => true,
                'values'    => array(1 => 'English', 2 => 'Français'),  
            ));            
        }	
				
		$fieldset->addField('hgp_homeslide_h3', 'text', array(
		'label'     => Mage::helper('homeslide')->__('Title'),
		'class'     => 'required-entry',
		'required'  => true,
		'name'      => 'hgp_homeslide_h3',				
		));
		
		$fieldset->addField('hgp_homeslide_pdt_id', 'text', array(
		'label'     => Mage::helper('homeslide')->__('Hotel Id'),
		'class'     => 'required-entry',
		'required'  => true,
		'name'      => 'hgp_homeslide_pdt_id',				
		));
		
		$fieldset->addField('hgp_homeslide_p', 'textarea', array(
		'label'     => Mage::helper('homeslide')->__('Summary'),
		'class'     => 'required-entry',
		'required'  => true,
		'name'      => 'hgp_homeslide_p',
		));

		$fieldset->addField('hgp_homeslide_a', 'text', array(
		'label'     => Mage::helper('homeslide')->__('URL'),
		'class'     => 'required-entry',
		'required'  => true,
		'name'      => 'hgp_homeslide_a',
		));	
				
		$fieldset->addField('hgp_homeslide_img', 'text', array(
		'label'     => Mage::helper('homeslide')->__('Photo'),
		'name'      => 'hgp_homeslide_img',
		'note'      => Mage::helper('homeslide')->__('Saisir uniquement le nom du fichier image ex : monimage.jpg')
		));
					
		$fieldset->addField('hgp_homeslide_tbs', 'text', array(
		'label'     => Mage::helper('homeslide')->__('Thumb'),
		'name'      => 'hgp_homeslide_tbs',
		'note'      => Mage::helper('homeslide')->__('Saisir uniquement le nom du fichier image ex : monimage.jpg')
		));			

//		$fieldset->addField('hgp_homeslide_img', 'image', array(
//		'label'     => Mage::helper('homeslide')->__('Photo'),
//		'required'  => false,
//		'name'      => 'hgp_homeslide_img',
//		));
//
//		$fieldset->addField('hgp_homeslide_tbs', 'image', array(
//		'label'     => Mage::helper('homeslide')->__('Thumb'),
//		'required'  => false,
//		'name'      => 'hgp_homeslide_tbs',
//		));	
				
		$fieldset->addField('hgp_homeslide_pds', 'select', array(
		'label'     => Mage::helper('homeslide')->__('Coeff.'),
		'title'     => Mage::helper('homeslide')->__('Coeff.'),
		'required'  => false,
		'name'      => 'hgp_homeslide_pds',
		'style'     => 'width:150px;',
		'note'      => Mage::helper('homeslide')->__('Permet d\'augmenter les chances d\une image d\'apparaitre dans le Slide'),
		'values'     => array(0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5),
		));	

	 	Mage::dispatchEvent('homeslide_adminhtml_edit_prepare_form', array('block'=>$this, 'form'=>$form));

	 	// Chargement des infos du formulaire 
        if ($arrDatas = Mage::getModel('homeslide/homeslide')->load($this->getRequest()->getParam('id'))) {
           
            // MAJ du PATH pour les images
//           if (isset($arrDatas['hgp_homeslide_tbs']) && !empty($arrDatas['hgp_homeslide_tbs'])) $arrDatas['hgp_homeslide_tbs'] = $_imgThumbs . $arrDatas['hgp_homeslide_tbs'];
//           if (isset($arrDatas['hgp_homeslide_img']) && !empty($arrDatas['hgp_homeslide_img'])) $arrDatas['hgp_homeslide_img'] = $_imgPhoto . $arrDatas['hgp_homeslide_img'];
           
           $form->setValues($arrDatas);
        }

		return parent::_prepareForm();
	}

}