<?php

class Hgp_Linksexchange_Model_Mysql4_Linksexchange extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the hgp_linksexchange_id refers to the key field in your database table.
        $this->_init('linksexchange/linksexchange', 'hgp_linksexchange_id');
    }
}