<?php

class Hgp_Map_Block_Adminhtml_Map_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'map';
        $this->_controller = 'adminhtml_map';

        $this->_updateButton('save', 'label', Mage::helper('map')->__('Save'));

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('map_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'map_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'map_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('map_data') && Mage::registry('map_data')->getId() ) {
            return Mage::helper('map')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('map_data')->getTitle()));
        } else {
            return Mage::helper('map')->__('Gestion de la MAP');
        }
    }
}