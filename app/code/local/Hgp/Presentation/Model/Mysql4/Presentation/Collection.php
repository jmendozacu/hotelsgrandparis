<?php

class Hgp_Presentation_Model_Mysql4_Presentation_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('presentation/presentation');
    }
}