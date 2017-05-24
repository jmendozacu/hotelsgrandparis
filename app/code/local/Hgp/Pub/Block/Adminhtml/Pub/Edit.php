<?php

class Hgp_Pub_Block_Adminhtml_Pub_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'pub';
        $this->_controller = 'adminhtml_pub';

        $this->_updateButton('save', 'label', Mage::helper('pub')->__('Save'));

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('pub_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'pub_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'pub_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('pub_data') && Mage::registry('pub_data')->getId() ) {
            return Mage::helper('pub')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('pub_data')->getTitle()));
        } else {
            return Mage::helper('pub')->__('Gestion de la Pub');
        }
    }
}