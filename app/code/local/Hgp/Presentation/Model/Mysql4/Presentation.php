<?php

class Hgp_Presentation_Model_Mysql4_Presentation extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the hgp_presentation_id refers to the key field in your database table.
        $this->_init('presentation/presentation', 'hgp_presentation_id');
    }
}