<?php

class Hgp_Linksexchange_Block_Adminhtml_Linksexchange_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'linksexchange';
        $this->_controller = 'adminhtml_linksexchange';

    	$this->_updateButton('save', 'label', Mage::helper('linksexchange')->__('Save Link Item'));
        $this->_updateButton('delete', 'label', Mage::helper('linksexchange')->__('Delete Link Item'));
		
        if( $this->getRequest()->getParam($this->_objectId) ) {
            $model = Mage::getModel('linksexchange/linksexchange')
                ->load($this->getRequest()->getParam($this->_objectId));
            Mage::register('linksexchange_data', $model);
        }
    }

    public function getHeaderText()
    {
        if( Mage::registry('linksexchange_data') && Mage::registry('linksexchange_data')->getId() ) {
        	return Mage::helper('linksexchange')->__('Edition du link : %s', Mage::registry('linksexchange_data')->getId());
        } else {
            return Mage::helper('linksexchange')->__('New link Item');
        }
    }    
}