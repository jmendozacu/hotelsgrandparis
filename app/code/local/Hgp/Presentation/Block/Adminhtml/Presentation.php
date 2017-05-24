<?php

class Hgp_Presentation_Block_Adminhtml_Presentation extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_presentation';
    $this->_blockGroup = 'presentation';
    parent::__construct();
  }
}