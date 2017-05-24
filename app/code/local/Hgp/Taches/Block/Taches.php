<?php

class Hgp_Taches_Block_Engagement extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

     public function getEngagement()
     {
        if (!$this->hasData('taches')) {
            $this->setData('taches', Mage::registry('taches'));
        }
        return $this->getData('taches');

    }
}