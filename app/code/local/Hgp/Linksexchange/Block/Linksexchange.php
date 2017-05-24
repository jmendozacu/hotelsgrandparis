<?php

class Hgp_Linksexchange_Block_Linksexchange extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

     public function getLinksexchange()
     {
        if (!$this->hasData('linksexchange')) {
            $this->setData('linksexchange', Mage::registry('linksexchange'));
        }
        return $this->getData('linksexchange');

    }
}