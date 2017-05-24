<?php

class Hgp_Engagement_Model_Mysql4_Engagement extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the hgp_homeslide_id refers to the key field in your database table.
        $this->_init('engagement/engagement', 'hgp_engagement_id');
    }
}