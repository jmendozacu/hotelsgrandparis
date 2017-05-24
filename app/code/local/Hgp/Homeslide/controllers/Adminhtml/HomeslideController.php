<?php

class Hgp_Homeslide_Adminhtml_HomeslideController extends Mage_Adminhtml_Controller_action 
{


	public function indexAction() 
	{
		$this->loadLayout ();
		
		$this->_setActiveMenu ( 'hgp/homeslide' );
		$this->_addBreadcrumb ( Mage::helper ( 'adminhtml' )->__ ( 'Item Manager' ), Mage::helper ( 'adminhtml' )->__ ( 'Item Manager' ) );
		$this->_addContent ( $this->getLayout ()->createBlock ( 'homeslide/adminhtml_homeslide' ) );
		
		$this->renderLayout ();
	}
	
	public function editAction() 
	{
		
		$key = $this->getRequest ()->getParam ( 'key' );
		
		if ($key) {
			
			$this->loadLayout ();
			
			$this->_setActiveMenu ( 'hgp/homeslide' );
			
			$this->_addBreadcrumb ( Mage::helper ( 'adminhtml' )->__ ( 'Item Manager' ), Mage::helper ( 'adminhtml' )->__ ( 'Item Manager' ) );
			
			$this->_addContent ( $this->getLayout ()->createBlock ( 'homeslide/adminhtml_homeslide_edit' ) )->_addLeft ( $this->getLayout ()->createBlock ( 'homeslide/adminhtml_homeslide_edit_tabs' ) );
			
			$this->renderLayout ();
		} else {
			
			Mage::getSingleton ( 'adminhtml/session' )->addError ( Mage::helper ( 'homeslide' )->__ ( 'Item does not exist' ) );
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
				
				// Enregistrement des autres elements du formulaire
				$model = Mage::getModel('homeslide/homeslide')
						->setId($this->getRequest()->getParam('id'))						
	                    ->setHgpHomeslideH3($this->getRequest()->getParam('hgp_homeslide_h3'))
	                    ->setHgpHomeslideStore($this->getRequest()->getParam('hgp_homeslide_store'))
	                    ->setHgpHomeslidePdtId($this->getRequest()->getParam('hgp_homeslide_pdt_id'))
	                    ->setHgpHomeslideP($this->getRequest()->getParam('hgp_homeslide_p'))
	                    ->setHgpHomeslideA($this->getRequest()->getParam('hgp_homeslide_a'))
	                    ->setHgpHomeslidePds($this->getRequest()->getParam('hgp_homeslide_pds'))
	                    ->setHgpHomeslideImg($this->getRequest()->getParam('hgp_homeslide_img'))
	                    ->setHgpHomeslideTbs($this->getRequest()->getParam('hgp_homeslide_tbs'));
     
	            $model->save();                 
											
				if ($this->getRequest ()->getParam ('id')){			
					Mage::getSingleton('adminhtml/session')->addSuccess ( Mage::helper ('adminhtml')->__('Slide Items was successfully updated'));
					$this->_redirect ('*/*/edit', array ('id' => $this->getRequest ()->getParam ('id')));
				} else {
					Mage::getSingleton('adminhtml/session')->addSuccess ( Mage::helper ('adminhtml')->__('Slide Items was successfully added'));
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
		if ($this->getRequest ()->getParam ( 'id' ) > 0) {
			try {
				$model = Mage::getModel ( 'homeslide/homeslide' );
				/* @var $model Mage_Rating_Model_Rating */
				$model->setId ( $this->getRequest ()->getParam ( 'id' ) )->delete ();
				Mage::getSingleton ( 'adminhtml/session' )->addSuccess ( Mage::helper ( 'adminhtml' )->__ ( 'Slide Item was successfully deleted' ) );
				$this->_redirect ( '*/*/' );
			} catch ( Exception $e ) {
				Mage::getSingleton ( 'adminhtml/session' )->addError ( $e->getMessage () );
				$this->_redirect ( '*/*/edit', array ('id' => $this->getRequest ()->getParam ( 'id' ) ) );
			}
		}
		$this->_redirect ( '*/*/' );
	}
	
	protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream') 
	{
		$response = $this->getResponse ();
		$response->setHeader ( 'HTTP/1.1 200 OK', '' );
		$response->setHeader ( 'Pragma', 'public', true );
		$response->setHeader ( 'Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true );
		$response->setHeader ( 'Content-Disposition', 'attachment; filename=' . $fileName );
		$response->setHeader ( 'Last-Modified', date ( 'r' ) );
		$response->setHeader ( 'Accept-Ranges', 'bytes' );
		$response->setHeader ( 'Content-Length', strlen ( $content ) );
		$response->setHeader ( 'Content-type', $contentType );
		$response->setBody ( $content );
		$response->sendResponse ();
		die ();
	}
}