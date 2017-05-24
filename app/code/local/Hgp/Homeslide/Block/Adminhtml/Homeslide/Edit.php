<?php

class Hgp_Homeslide_Block_Adminhtml_Homeslide_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'homeslide';
        $this->_controller = 'adminhtml_homeslide';

    	$this->_updateButton('save', 'label', Mage::helper('homeslide')->__('Save Slide Item'));
        $this->_updateButton('delete', 'label', Mage::helper('homeslide')->__('Delete Slide Item'));
		
        if( $this->getRequest()->getParam($this->_objectId) ) {
            $model = Mage::getModel('homeslide/homeslide')
                ->load($this->getRequest()->getParam($this->_objectId));
            Mage::register('homeslide_data', $model);
        }
    }

    public function getHeaderText()
    {
        if( Mage::registry('homeslide_data') && Mage::registry('homeslide_data')->getId() ) {
        	return Mage::helper('homeslide')->__('Edition du slide : %s', Mage::registry('homeslide_data')->getId());
        } else {
            return Mage::helper('homeslide')->__('New Slide Item');
        }
    }    
}