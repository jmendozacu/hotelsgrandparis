<?php

class Hgp_Meteo_Model_Mysql4_Meteo_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('meteo/meteo');
    }
}