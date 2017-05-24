<?php

class Hgp_Linksexchange_Model_Mysql4_Linksexchange_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('linksexchange/linksexchange');
    }
}