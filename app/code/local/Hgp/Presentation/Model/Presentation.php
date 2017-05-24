<?php

class Hgp_Presentation_Model_Presentation extends Mage_Core_Model_Abstract 
{
	public function _construct() 
	{
		parent::_construct ();
		$this->_init ( 'presentation/presentation' );
	}
	
	/*
	 * Recuperation de la liste de Presentation
	 */
	public function getItems($idStore = null) 
	{
		$_objPresentation = self::getCollection();
		$_arrItems = array ();
		
		if ($_objPresentation) {
			
			$lisItems = $_objPresentation->load ();
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
						
						if($_arrDatas['hgp_presentation_store_fk'] == $idStore)	$_arrItems [] = $_arrDatas;
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
	public function getTitle($idStore = 0) 
	{
		if (!$idStore) return false;
		
		$arrTitre = array(
			1 => 'Nos presentations',	
			2 => 'Our commitments'
		);
		
		return $arrTitre[$idStore];
	}
	

}