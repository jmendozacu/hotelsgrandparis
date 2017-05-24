<?php

class Hgp_Meteo_Adminhtml_MeteoController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction()
	{
		$this->loadLayout()
		
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

			$this->_setActiveMenu('hgp/meteo');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('meteo/adminhtml_meteo_edit'))
			->_addLeft($this->getLayout()->createBlock('meteo/adminhtml_meteo_edit_tabs'));

			$this->renderLayout();
		} else {

			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('meteo')->__('Item does not exist'));
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
				
				$_objMeteo = Mage::getModel('meteo/meteo');

				if ($data){

					/*
					 * Emplacement des fichiers
					 */
					$ds = '/';
					$_moduleBaseUrl =  Mage::getBaseUrl('media') . $ds .'meteo' . $ds;								
					$_urlInterface  = $_moduleBaseUrl . 'images' . $ds;
					
					$_moduleBaseDir =  Mage::getBaseDir('media') . DS .'meteo' . DS;
					$_pathInterface = $_moduleBaseDir . 'images' . DS;

				} else {

					return false;
				}

					$id = (isset($data['hgp_meteo_id']) && !empty($data['hgp_meteo_id'])) ? $data['hgp_meteo_id'] : 0;

					$_unobjMeteo = $_objMeteo->load($id);

				if ($_unobjMeteo){

					$_unobjMeteo->setData($data);
					$_unobjMeteo->save();						
				}
				
				//Success Message
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('meteo')->__('M&eacute;t&eacute;o correctement mis &agrave; jour'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/' . '/store/'.$data['hgp_store_fk']);
				return;
				
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('meteo')->__('Rien &agrave; sauvegarder'));
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