<?php 
class Hgp_Taches_Block_Adminhtml_Button extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        
        //$url = Mage::getBaseUrl() . '../cron.php';
        $url = Mage::getBaseUrl() . '../hgpsc2010.php';
        
        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
                    ->setType('button')
                    ->setClass('run-cron')
                    ->setLabel('Lancer')
                    ->setOnClick("ajax_button('".$url."')")
                    ->toHtml();

        return $html;
    }
}
?>
