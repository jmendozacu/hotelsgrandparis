<?php

class Hgp_Pub_Adminhtml_PubController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('hgp/pub')
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

			$this->_setActiveMenu('hgp/pub');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('pub/adminhtml_pub_edit'))
			->_addLeft($this->getLayout()->createBlock('pub/adminhtml_pub_edit_tabs'));
			
			$this->renderLayout();
		} else {

			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pub')->__('Item does not exist'));
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
				
				$_objPub = Mage::getModel('pub/pub');
				$listPub = $_objPub->getCollection()->load()->getData();

				if ($listPub){

					$count = count($listPub);
					/*
					 * Emplacement des fichiers
					 */
					$ds = '/';
					$_moduleBaseUrl =  Mage::getBaseUrl('media') . $ds .'pub' . $ds;								
					$_urlInterface  = $_moduleBaseUrl . 'images' . $ds;
					
					$_moduleBaseDir =  Mage::getBaseDir('media') . DS .'pub' . DS;
					$_pathInterface = $_moduleBaseDir . 'images' . DS;

				} else {

					return false;
				}

				$id = (isset($data['hgp_pub_id_']) && !empty($data['hgp_pub_id_'])) ? $data['hgp_pub_id_'] : 0;

				$_unobjPub = $_objPub
				               ->getCollection()
				               ->addFilter('hgp_pub_id', $id)
				               ->getLastItem();

				if ($_unobjPub){

					$_unobjPub->hgp_pub_title       = $data['hgp_pub_title'];
					$_unobjPub->hgp_pub_url         = $data['hgp_pub_url'];
					$_unobjPub->hgp_pub_store       = $data['hgp_pub_store'];
					$_unobjPub->hgp_pub_link_label  = $data['hgp_pub_link_label'];
															
					/*
					 * Gestion des champs image
					 */
					
					//Photo Large
					$imgPhoto = str_replace($_urlInterface, '',$data['hgp_pub_img']['value']);
					if (!isset($data['hgp_pub_img']['delete'])){						
						
						//UPLOAD de l'image + MAJ en BD
						
						if (isset($_FILES['hgp_pub_img']['name']) && !empty($_FILES['hgp_pub_img']['name'])){
						
							$_unobjPub->hgp_pub_img = $_objPub->uploadFile($_pathInterface, 'hgp_pub_img', $_FILES);
						}						
					} else {

						//Suppression du visuel
						$_unobjPub->hgp_pub_img = '';
						if ($imgPhoto != ''){
							
							unlink($_pathInterface . $imgPhoto);
						}
					}

					$_unobjPub->save();							
				}
				
				//Success Message
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('pub')->__('Pubs correctement mis &agrave; jour'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/' . '/store/'.$data['hgp_pub_store']);
				return;
				
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('pub')->__('Rien &agrave; sauvegarder'));
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