<?php

class Hgp_Engagement_Model_Mysql4_Engagement_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('engagement/engagement');
    }
}