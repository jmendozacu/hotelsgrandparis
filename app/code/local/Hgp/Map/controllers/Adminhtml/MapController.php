<?php

class Hgp_Map_Adminhtml_MapController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('hgp/map')
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

			$this->_setActiveMenu('hgp/map');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('map/adminhtml_map_edit'))
			->_addLeft($this->getLayout()->createBlock('map/adminhtml_map_edit_tabs'));
			
			$this->renderLayout();
		} else {

			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('map')->__('Item does not exist'));
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
				
				
				if ($data){

					/*
					 * Emplacement des fichiers
					 */
					$ds = '/';
					$_moduleBaseUrl =  Mage::getBaseUrl('media') . $ds .'map' . $ds;								
					$_urlInterface  = $_moduleBaseUrl . 'images' . $ds;
					
					$_moduleBaseDir =  Mage::getBaseDir('media') . DS .'map' . DS;
					$_pathInterface = $_moduleBaseDir . 'images' . DS;

				} else {

					return false;
				}
				
				$id = (isset($data['hgp_map_id']) && !empty($data['hgp_map_id'])) ? $data['hgp_map_id'] : 0;
					
				$_objMap = Mage::getModel('map/map');
				
				$_unobjMap = $_objMap->load($id);

				if ($_unobjMap){

					$_unobjMap->hgp_map_title  = $data['hgp_map_title'];
					$_unobjMap->hgp_map_url    = $data['hgp_map_url'];
					$_unobjMap->hgp_map_store  = $data['hgp_map_store'];
															
					/*
					 * Gestion des champs image
					 */
						
					//Photo Large
					$imgPhoto = str_replace($_urlInterface, '',$data['hgp_map_img']['value']);
					if (!isset($data['hgp_map_img']['delete'])){						
						
						//UPLOAD de l'image + MAJ en BD
						if (isset($_FILES['hgp_map_img']['name']) && !empty($_FILES['hgp_map_img']['name'])){
						
							$_unobjMap->hgp_map_img = $_objMap->uploadFile($_pathInterface, 'hgp_map_img', $_FILES);
						}						
					} else {

						//Suppression du visuel
						$_unobjMap->hgp_map_img = '';
						if ($imgPhoto != ''){
							
							unlink($_pathInterface . $imgPhoto);
						}
					}
					
					$_unobjMap->save();
						
				}
				
				//Success Message
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('map')->__('Maps correctement mis &agrave; jour'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/' . '/store/'.$data['hgp_map_store']);
				return;
				
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('map')->__('Rien &agrave; sauvegarder'));
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


	protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
	{
		$response = $this->getResponse();
		$response->setHeader('HTTP/1.1 200 OK','');
		$response->setHeader('Pragma', 'public', true);
		$response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
		$response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
		$response->setHeader('Last-Modified', date('r'));
		$response->setHeader('Accept-Ranges', 'bytes');
		$response->setHeader('Content-Length', strlen($content));
		$response->setHeader('Content-type', $contentType);
		$response->setBody($content);
		$response->sendResponse();
		die;
	}
}