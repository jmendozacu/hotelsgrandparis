<?php

class Hgp_Pub_Block_Pub extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

     public function getPub()
     {
        if (!$this->hasData('pub')) {
            $this->setData('pub', Mage::registry('pub'));
        }
        return $this->getData('pub');

    }
}