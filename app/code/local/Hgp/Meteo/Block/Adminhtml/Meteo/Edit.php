<?php

class Hgp_Meteo_Block_Adminhtml_Meteo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'meteo';
        $this->_controller = 'adminhtml_meteo';

        $this->_updateButton('save', 'label', Mage::helper('meteo')->__('Save'));
        $this->_addButton('add', 'label', Mage::helper('meteo')->__('Add'));

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('meteo_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'meteo_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'meteo_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('meteo_data') && Mage::registry('meteo_data')->getId() ) {
            return Mage::helper('meteo')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('meteo_data')->getTitle()));
        } else {
            return Mage::helper('meteo')->__('Gestion du bloc met&eacute;o');
        }
    }
}