<?php

class Hgp_Meteo_Model_Meteo extends Mage_Core_Model_Abstract 
{
	public function _construct() 
	{
		parent::_construct ();
		$this->_init ( 'meteo/meteo' );
	}
	
	/*
	 * Recuperation de la liste de Meteo
	 */
	public function getItems($storeId = 0) 
	{
		$lisItems = self::getCollection()
					->addFilter('hgp_store_fk', $storeId)
		            ->getItems();
		             
		$_arrItems = array ();
		
		if (!$lisItems) {
			
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
					
					$_arrItems [] = $_arrDatas;
				}
			
			}
			return $_arrItems;
		
		} else {
			
			return false;
		}
	}
	
	public function getXMLFile($id) 
	{
				
		$_arrData = array();
		$_xmlFile = null;
		
		$_unobjMeteo = self::getCollection ()
			->addFilter ( 'hgp_meteo_id', $id )
			->getLastItem ();
			
		if ($_unobjMeteo){
			
			$_xmlFile =  $_unobjMeteo->hgp_url;
		}
		
		return $_xmlFile;
	}
	

}