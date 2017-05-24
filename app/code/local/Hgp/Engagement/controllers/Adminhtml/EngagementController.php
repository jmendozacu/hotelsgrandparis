<?php

class Hgp_Engagement_Adminhtml_EngagementController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('engagement/items')
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

			$this->_setActiveMenu('hgp/engagement');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('engagement/adminhtml_engagement_edit'))
			->_addLeft($this->getLayout()->createBlock('engagement/adminhtml_engagement_edit_tabs'));

			$this->renderLayout();
		} else {

			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('engagement')->__('Item does not exist'));
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
				
				if (!isset($data['hgp_engagement_store_fk0'])){
					
					return false;
				}
				
				$_objEngagement = Mage::getModel('engagement/engagement');
				
				$listItems = $_objEngagement
				             ->getCollection()
							 ->addFilter('hgp_engagement_store_fk', $data['hgp_engagement_store_fk0'])
							 ->load()
							 ->getData();

				if ($listItems){

					$count = count($listItems);

				} else {

					return false;
				}

				for ($i=0;$i<$count;$i++){

					$id = (isset($data['hgp_engagement_id'.$i]) && !empty($data['hgp_engagement_id'.$i])) ? $data['hgp_engagement_id'.$i] : 0;

					$_unobjEngagement = $_objEngagement
					               ->getCollection()
					               ->addFilter('hgp_engagement_id', $id)
					               ->getLastItem();

					if ($_unobjEngagement){
										
						$_unobjEngagement->hgp_engagement_contenu       = $data['hgp_engagement_contenu'.$i];							
						$_unobjEngagement->hgp_engagement_store_fk      = $data['hgp_engagement_store_fk0'];							
						$_unobjEngagement->save();
							
					}
				}
				
				//Success Message
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('engagement')->__('Engagements correctement mis &agrave; jour'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);
				$this->_redirect('*/*/' . '/store/'.$data['hgp_engagement_store_fk0']);
				return;
				
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('engagement')->__('Rien &agrave; sauvegarder'));
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