<?php

class Hgp_Meteo_Block_Meteo extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

     public function getMeteo()
     {
        if (!$this->hasData('meteo')) {
            $this->setData('meteo', Mage::registry('meteo'));
        }
        return $this->getData('meteo');

    }
}