<?php

class Hgp_Presentation_Block_Adminhtml_Presentation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'presentation';
        $this->_controller = 'adminhtml_presentation';

        $this->_updateButton('save', 'label', Mage::helper('presentation')->__('Save'));
        $this->_addButton('add', 'label', Mage::helper('presentation')->__('Add'));

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('presentation_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'presentation_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'presentation_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('presentation_data') && Mage::registry('presentation_data')->getId() ) {
            return Mage::helper('presentation')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('presentation_data')->getTitle()));
        } else {
            return Mage::helper('presentation')->__('Gestion du bloc "Pr&eacute;sentation"');
        }
    }
}