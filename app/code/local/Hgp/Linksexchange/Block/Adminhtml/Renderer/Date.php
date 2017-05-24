<?php 
class Hgp_Linksexchange_Block_Adminhtml_Renderer_Date extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
	public function render(Varien_Object $row)
    {
         $data = $row->getData($this->getColumn()->getIndex());
         $date = Varien_Date::convertZendToStrftime($data, true, false);
         return $date;
    }
}