<?php

class Hgp_Presentation_Block_Presentation extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }

     public function getPresentation()
     {
        if (!$this->hasData('presentation')) {
            $this->setData('presentation', Mage::registry('presentation'));
        }
        return $this->getData('presentation');

    }
}