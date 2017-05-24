<?php

class Hgp_Map_Model_Map extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('map/map');
	}

	/*
	 * Recuperation de la liste de HomeSlide
	 */
	public function getItems()
	{
		$_objSlide = self::getCollection();
		$_arrItems = array();

		if ($_objSlide) {

			$lisItems = $_objSlide->load();
		} else {

			return false;
		}

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