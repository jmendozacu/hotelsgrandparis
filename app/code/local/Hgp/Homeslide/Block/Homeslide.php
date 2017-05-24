<?php

class Hgp_Homeslide_Block_Homeslide extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

     public function getHomeslide()
     {
        if (!$this->hasData('homeslide')) {
            $this->setData('homeslide', Mage::registry('homeslide'));
        }
        return $this->getData('homeslide');

    }
}