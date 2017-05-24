<?php

class Hgp_Presentation_Helper_Image extends Varien_Data_Form_Element_Image
{
    protected function _getUrl()
    {
        $url = false;
        if ($this->getValue()) {
            $url = Mage::getBaseUrl('media').'catalog/category/'. $this->getValue();
        }
        return $url;
    }
}
