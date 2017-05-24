<?php

class Hgp_Homeslide_Model_Mysql4_Homeslide extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the hgp_homeslide_id refers to the key field in your database table.
        $this->_init('homeslide/homeslide', 'hgp_homeslide_id');
    }
}