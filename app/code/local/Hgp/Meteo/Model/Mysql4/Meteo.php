<?php

class Hgp_Meteo_Model_Mysql4_Meteo extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the hgp_homeslide_id refers to the key field in your database table.
        $this->_init('meteo/meteo', 'hgp_meteo_id');
    }
}