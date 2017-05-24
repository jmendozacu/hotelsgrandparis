<?php

class Hgp_Linksexchange_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getUserName() 
    {
        if (!Mage::getSingleton('admin/session')->isLoggedIn()) return '';
    
        $userAdmin = Mage::getSingleton('admin/session')->getUser();
        return trim($userAdmin->getFirstname() . ' ' . $userAdmin->getLastname());
    }
    
    public function getFrenchDate($magentoDate) 
    {
        $date = new Zend_Date($magentoDate);
        $date_jour = $date->get(Zend_Date::DATETIME, 'fr_FR');
        return $date_jour;
    }
    
    public function getCategory() 
    {
        $arr_category = array(
						    1 => $this->__('Nos adherents'),
						    2 => $this->__('Des adresses en France'),
        					3 => $this->__('Notre selection dadresses a Paris')
						);
        return $arr_category;
    }
    
    
    public function getCategoryByLang($storeId) 
    {
        $response = array();
        $_entry = self::getCategory();
        $count = count($_entry);
        $compteur = 1;
        for($i=1;$i<=$count;$i++){
            $line = $_entry[$i];
            if($line[0] == $storeId){
                $response[$i] = $line;
                $compteur++;
            }
        }
        return $response;
    }
    
    /*
     * Clean les Datas acceptées par un FORM
    */
    public function escaptePostDatas(array $postDatas)
    {
        $cleanDatas = array();
        $count = count($postDatas);
        if($count){
            foreach($postDatas as $key => $value){
                $cleanDatas[$key] =  trim(Mage::Helper('core')->htmlEscape($value));
            }
        }
        return $cleanDatas;
    }
}