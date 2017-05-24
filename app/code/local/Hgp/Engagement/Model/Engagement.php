<?php

class Hgp_Engagement_Model_Engagement extends Mage_Core_Model_Abstract 
{
	public function _construct() 
	{
		parent::_construct ();
		$this->_init ( 'engagement/engagement' );
	}
	
	/*
	 * Recuperation de la liste de Engagement
	 */
	public function getItems($idStore = null) 
	{
		$_objEngagement = self::getCollection();
		$_arrItems = array ();
		
		if ($_objEngagement) {
			
			$lisItems = $_objEngagement->load ();
		} else {
			
			return false;
		}
		
		$count = 0;
		if ($lisItems) {
			
			$count = count ( $lisItems );
		}
		
		/*
		 * Construction du tableau
		 */
		if ($lisItems) {
			
			foreach ( $lisItems as $listItem ) {
				
				$_arrDatas = $listItem->getData ();
				
				if ($_arrDatas) {
					
					if ($idStore != null){
						
						if($_arrDatas['hgp_engagement_store_fk'] == $idStore)	$_arrItems [] = $_arrDatas;
					} else {
						
						$_arrItems [] = $_arrDatas;
					}
				}
			
			}
			return $_arrItems;
		
		} else {
			
			return false;
		}
	}
	
	/*
	 * Recuperation du titre du bloc
	 */
	public function getTitle($idStore = 1) 
	{
		$title = Hgp_Lib_Tools::getParamConfig('engagement', 'titre');		
						
		return $title->$idStore;
	}
	

}