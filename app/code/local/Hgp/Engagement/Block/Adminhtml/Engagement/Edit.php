<?php

class Hgp_Engagement_Block_Adminhtml_Engagement_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'engagement';
        $this->_controller = 'adminhtml_engagement';

        $this->_updateButton('save', 'label', Mage::helper('engagement')->__('Save'));
        $this->_addButton('add', 'label', Mage::helper('engagement')->__('Add'));

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('engagement_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'engagement_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'engagement_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('engagement_data') && Mage::registry('engagement_data')->getId() ) {
            return Mage::helper('engagement')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('engagement_data')->getTitle()));
        } else {
            return Mage::helper('engagement')->__('Gestion du bloc "Nos engagements"');
        }
    }
}