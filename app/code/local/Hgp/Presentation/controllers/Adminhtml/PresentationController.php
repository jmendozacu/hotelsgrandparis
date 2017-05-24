<?php

class Hgp_Presentation_Adminhtml_PresentationController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('hgp/presentation')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

		return $this;
	}

	public function indexAction()
	{

		$this->_forward('edit');
	}

	public function editAction()
	{

		$key     = $this->getRequest()->getParam('key');

		if ($key) {

			$this->loadLayout();

			$this->_setActiveMenu('hgp/presentation');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('presentation/adminhtml_presentation_edit'))
			->_addLeft($this->getLayout()->createBlock('presentation/adminhtml_presentation_edit_tabs'));

			$this->renderLayout();
		} else {

			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('presentation')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction()
	{
		$this->_forward('edit');
	}

	public function saveAction()
	{
		try {
			if ($data = $this->getRequest()->getPost()) {

				/*
				 * Parcours des donnees en POST
				 * en comptant le nombre de datas
				 *
				 */
				
				$id = (isset($data['hgp_meteo_id']) && !empty($data['hgp_meteo_id'])) ? $data['hgp_meteo_id'] : 0;
				
				$_objPresentation = Mage::getModel('presentation/presentation');

				if (!$data){

					return false;

				} 

				$id = (isset($data['hgp_presentation_id']) && !empty($data['hgp_presentation_id'])) ? $data['hgp_presentation_id'] : 0;

				$_unobjPresentation = $_objPresentation->load($id);

				if ($_unobjPresentation){
															
					$_unobjPresentation->setData($data);							
					$_unobjPresentation->save();
						
				}
				
				//Success Message
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('presentation')->__('Presentations correctement mis &agrave; jour'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/' . '/store/'.$data['hgp_presentation_store_fk']);
				return;
				
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('presentation')->__('Rien &agrave; sauvegarder'));
				$this->_redirect('*/*/');
				return;
			}
		
		}catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			Mage::getSingleton('adminhtml/session')->setFormData($data);
			$this->_redirect('*/*/', array('key' => $this->getRequest()->getParam('key')));
			return;
		}
	}
}