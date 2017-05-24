<?php

class Hgp_Homeslide_Model_Homeslide extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('homeslide/homeslide');
	}

	/*
	 * Recuperation de la liste de HomeSlide selon un tirage aleatoire
	 */
	public function getItems($storeId = 1, $nb_items = 0, $byRand = TRUE)
	{
		             
	    $results = array();
	    //exit('nb_itemps = ' .$nb_items);
		$arrDatas = self::getCollection()
		             ->addFilter('hgp_homeslide_store', $storeId)
		             ->addFilter('hgp_homeslide_pds', 1)
		             ->getItems();
		
		if ($arrDatas && $byRand) $results = Hgp_Lib_Tools::melangeTableau($arrDatas);
		
		if (($results) && ($nb_items > 0)){
		 
		    /**
		     * On prend tout le tableau
		     * mais on ne retourne que le nombre d'items
		     * necessaire
		     */
		    for($i = 0; $i < $nb_items; $i++){
		        
		        $result[] = $results[$i];
		    }
		} else {
		    
		    $result = $arrDatas;
		}
				
		
		$lisItems = $result;
		             
		if (!$lisItems) {
			
			return false;
		}

		$_arrItems = array();
		$count = 0;
		
		if ($lisItems){

			$count = count($lisItems);
		}

		/*
		 * Construction du tableau
		 */		
		if ($lisItems){

			foreach($lisItems as $listItem){

				$_arrDatas = $listItem->getData();

				if ($_arrDatas){
						
					$_arrItems[] = $_arrDatas;
				}

			}
			return $_arrItems;
				
		} else {

			return false;
		}
	}

	public function cleanUrl($_strUrl)
	{

		$_strNewUrl = str_replace('//', '/', $_strUrl);
		return $_strNewUrl;
	}

	public function uploadFile($location, $nomChamp, $datas)
	{
		try {

//			$param = func_get_args();
//			print_r($param);exit;
			
			/* Starting upload */
			$uploader = new Varien_File_Uploader($nomChamp);

			// Any extention would work
			$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
			$uploader->setAllowRenameFiles(false);

			// Set the file upload mode
			// false -> get the file directly in the specified folder
			// true -> get the file in the product like folders
			//	(file.jpg will go in something like /media/f/i/file.jpg)
			$uploader->setFilesDispersion(false);

			// We set media as the upload dir
			//print_r($_FILES[$nomChamp]);exit;
			$uploader->save($location, $_FILES[$nomChamp]['name'] );
			return $_FILES[$nomChamp]['name'];


		} catch (Exception $e) {

			return false;
		}
	}


}