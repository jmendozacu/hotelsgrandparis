<?php

class Hgp_Map_Model_Mysql4_Map extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the hgp_map_id refers to the key field in your database table.
        $this->_init('map/map', 'hgp_map_id');
    }
}