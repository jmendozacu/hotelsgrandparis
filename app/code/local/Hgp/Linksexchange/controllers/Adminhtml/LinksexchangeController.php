<?php

class Hgp_Linksexchange_Adminhtml_LinksexchangeController extends Mage_Adminhtml_Controller_action 
{


	public function indexAction() 
	{
		$this->loadLayout ();
		
		$this->_setActiveMenu ('hgp/linksexchange');
		$this->_addBreadcrumb (Mage::helper('adminhtml' )->__ ('Item Manager'), Mage::helper ('adminhtml' )->__ ('Item Manager'));
		$this->_addContent($this->getLayout()->createBlock('linksexchange/adminhtml_linksexchange'));
		
		$this->renderLayout ();
	}
	
	public function editAction() 
	{
		
		$key = $this->getRequest ()->getParam ('key');
		
		if ($key) {
			$this->loadLayout ();
			$this->_setActiveMenu ( 'hgp/linksexchange' );
			$this->_addBreadcrumb ( Mage::helper ( 'adminhtml' )->__ ( 'Item Manager' ), Mage::helper ( 'adminhtml' )->__ ( 'Item Manager' ) );
			$this->_addContent ( $this->getLayout ()->createBlock ( 'linksexchange/adminhtml_linksexchange_edit' ) )->_addLeft ( $this->getLayout ()->createBlock ( 'linksexchange/adminhtml_linksexchange_edit_tabs' ) );
			$this->renderLayout ();
		} else {
			Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'linksexchange' )->__ ( 'Item does not exist' ) );
			$this->_redirect ( '*/*/' );
		}
	}
	
	public function newAction() 
	{
		$this->editAction ();
	}
	
	public function saveAction() 
	{
		//-----------------------------------------------
		if ($data = $this->getRequest()->getParams()) {
        
			try {
			    if(null != $data['hgp_linksexchange_id']){
				    $model = Mage::getModel('linksexchange/linksexchange')
						->setId($this->getRequest()->getParam('id'))						
	                    ->setHgpLinksexchangeCategory($data['hgp_linksexchange_category'])
	                    ->setHgpLinksexchangeStoreId($data['hgp_linksexchange_store_id'])
	                    ->setHgpLinksexchangeSiteName($data['hgp_linksexchange_site_name'])
	                    ->setHgpLinksexchangeSiteDescription($data['hgp_linksexchange_site_description'])
	                    ->setHgpLinksexchangeSiteUrlLabel($data['hgp_linksexchange_site_url_label'])
	                    ->setHgpLinksexchangeSiteUrlLink($data['hgp_linksexchange_site_url_link'])
	                    ->setHgpLinksexchangeSiteUrlTitle($data['hgp_linksexchange_site_url_title'])
	                    ->setHgpLinksexchangeContactEmail($data['hgp_linksexchange_contact_email'])
	                    ->setHgpLinksexchangeContactTel($data['hgp_linksexchange_contact_tel'])
	                    ->setHgpLinksexchangeSitePageCible($data['hgp_linksexchange_site_page_cible'])
	                    ->setHgpLinksexchangeOrdre($data['hgp_linksexchange_ordre'])
	                    ->setHgpLinksexchangeDateModification(Mage::getSingleton('core/date')->gmtDate())
	                    ->setHgpLinksexchangeUserModif(Mage::helper('linksexchange')->getUserName())
	                    ->setHgpLinksexchangeActif($data['hgp_linksexchange_actif']);
			    }else{
				    $model = Mage::getModel('linksexchange/linksexchange')
						->setId($this->getRequest()->getParam('id'))						
	                    ->setHgpLinksexchangeCategory($data['hgp_linksexchange_category'])
	                    ->setHgpLinksexchangeStoreId($data['hgp_linksexchange_store_id'])
	                    ->setHgpLinksexchangeSiteName($data['hgp_linksexchange_site_name'])
	                    ->setHgpLinksexchangeSiteDescription($data['hgp_linksexchange_site_description'])
	                    ->setHgpLinksexchangeSiteUrlLabel($data['hgp_linksexchange_site_url_label'])
	                    ->setHgpLinksexchangeSiteUrlLink($data['hgp_linksexchange_site_url_link'])
	                    ->setHgpLinksexchangeSiteUrlTitle($data['hgp_linksexchange_site_url_title'])
	                    ->setHgpLinksexchangeContactEmail($data['hgp_linksexchange_contact_email'])
	                    ->setHgpLinksexchangeContactTel($data['hgp_linksexchange_contact_tel'])
	                    ->setHgpLinksexchangeSitePageCible($data['hgp_linksexchange_site_page_cible'])
	                    ->setHgpLinksexchangeOrdre(isset($data['hgp_linksexchange_ordre'])? $data['hgp_linksexchange_ordre']:1)
	                    ->setHgpLinksexchangeDateCreation(Mage::getSingleton('core/date')->gmtDate())
	                    ->setHgpLinksexchangeDateModification(Mage::getSingleton('core/date')->gmtDate())
	                    ->setHgpLinksexchangeUserModif((Mage::helper('linksexchange')->getUserName() != '') ? Mage::helper('linksexchange')->getUserName():'')
	                    ->setHgpLinksexchangeActif(isset($data['hgp_linksexchange_actif'])? $data['hgp_linksexchange_actif']:0);
			    }
	            $model->save(); 
	            //Important pour vider le formulaire de la session
	            //Mage::getSingleton('adminhtml/session')->setFormData(false);
											
				if ($this->getRequest ()->getParam ('id')){			
					Mage::getSingleton('adminhtml/session')->addSuccess ( Mage::helper ('adminhtml')->__('Link Items was successfully updated'));
					$this->_redirect ('*/*/edit', array ('id' => $this->getRequest ()->getParam ('id')));
				} else {
					Mage::getSingleton('adminhtml/session')->addSuccess ( Mage::helper ('adminhtml')->__('Link Items was successfully added'));
					$this->_redirect ('*/*/');
				}
				return;
			} catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
		}
	}

	public function deleteAction() 
	{
		if ($this->getRequest ()->getParam ('id') > 0) {
			try {
				$model = Mage::getModel ( 'linksexchange/linksexchange' );
				/* @var $model Mage_Rating_Model_Rating */
				$model->setId ( $this->getRequest ()->getParam ('id'))->delete ();
				Mage::getSingleton ('adminhtml/session')->addSuccess (Mage::helper('adminhtml')->__ ('Link Item was successfully deleted'));
				$this->_redirect( '*/*/' );
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError ($e->getMessage());
				$this->_redirect ('*/*/edit', array ('id' => $this->getRequest()->getParam ('id')));
			}
		}
		$this->_redirect ( '*/*/' );
	}
}