<?php

class Hgp_Engagement_Block_Engagement extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

     public function getEngagement()
     {
        if (!$this->hasData('engagement')) {
            $this->setData('engagement', Mage::registry('engagement'));
        }
        return $this->getData('engagement');

    }
}