<?php
class Hgp_Homeslide_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	//exit('on rentre');
		//$_objSlide = Mage::getModel('homeslide/homeslide')->getCollection();
			
		$this->loadLayout(); 
		$this->renderLayout();
    }
    
    public function calculdateAction()
    {
    	date_default_timezone_set('Europe/Paris');
    	$dateDebut = $this->getRequest()->getParam('date');
    	$nbNuits = $this->getRequest()->getParam('nbNuits');
    	$dateReelle = new Zend_Date($dateDebut, 'yyyy-MM-dd', 'en_US');//Le format est tres important
    	$dateFin= $dateReelle->addDay((int)$nbNuits)->toString('yyyy-MM-dd');
    	echo($dateFin);exit;
    }
}