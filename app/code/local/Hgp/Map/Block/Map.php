<?php

class Hgp_Map_Block_Map extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

     public function getMap()
     {
        if (!$this->hasData('map')) {
            $this->setData('map', Mage::registry('map'));
        }
        return $this->getData('map');

    }
}