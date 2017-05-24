<?php

class Hgp_Linksexchange_Model_Linksexchange extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('linksexchange/linksexchange');
	}
	
	/*
	 * Return comments of one Hotel
	* with Hotel SKU ans Langue
	*/
	public function getHotelCommentsByLangueAndHotelSku($hotelSku, $langue)
	{
	    $arrDatas = array();
	
	    //Recuperation de l'ID commentaires de FastBooking
	    $hotelId = Mage::getModel('commentaires/listehotel')->getIdHotelBySku($hotelSku);
	
	    //Si on ne veut pas les commentaires
	    // ou qu'on ne les trouve pas on renvoie un array vide
	    if(null == $hotelId) return $arrResponse;
	
	    $arrDatas = Mage::getModel('commentaires/commentaires')
	    ->getCollection()
	    ->setOrder('commentaires_date', 'DESC')
	    ->addFieldToFilter('commentaires_hotel_id',(int) $hotelId)
	    ->addFieldToFilter('commentaires_actif', 1)
	    ->addFieldToFilter('commentaires_langue', $langue)
	    ->getData();
	     
	    //On inverse pour mettre les date plus recentes en premier
	    //if($arrDatas) $arrDatas = array_reverse($arrDatas);
	    if($arrDatas) return $arrDatas;
	    return array();
	}
	
	public function getLinksexchangeByCategory($langue)
	{
	    $arrDatas = Mage::getModel('linksexchange/linksexchange')
	    ->getCollection()
	    ->addFieldToFilter('hgp_linksexchange_actif', 1)
	    ->addFieldToFilter('hgp_linksexchange_store_id', $langue)
		->setOrder('hgp_linksexchange_category', 'ASC', 'hgp_linksexchange_ordre', 'ASC')
	    ->getData();
		
		if($arrDatas) return $arrDatas;
	    return array();
	}



}