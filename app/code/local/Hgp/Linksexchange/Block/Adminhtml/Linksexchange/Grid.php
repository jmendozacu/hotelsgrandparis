<?php
/**
 * Hgp_GooglemapLocator extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Hgp
 * @package    Hgp_GooglemapLocator
 * @copyright  Copyright (c) 2009 Hotels Grand Paris 
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   HotelsGrandParis
 * @package    Hgp_GooglemapLocator
 * @author     Brice POTE <brice.pote@hotelsgrandparis.com>
 */
class Hgp_Linksexchange_Block_Adminhtml_Linksexchange_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('linksexchangeGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('hgp_linksexchange_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $this->setCollection(Mage::getModel('linksexchange/linksexchange')->getCollection());
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
                
    	$this->addColumn('hgp_linksexchange_id', array(
            'header'    => Mage::helper('linksexchange')->__('ID'),
            'align'     => 'center',
            'width'     => '50px',
            'index'     => 'hgp_linksexchange_id',
        ));
    	
    	if (!Mage::app()->isSingleStoreMode()) {
    	    $this->addColumn('hgp_linksexchange_store_id', array(
    	    'header'    => Mage::helper('linksexchange')->__('Store'),
    	    'align'     => 'left',
    	    'width'     => '80px',
    	    'type'      => 'options',
    	    'options'   => array(1 => $this->__('English'), 2 => $this->__('Français')),
    	    'index'     => 'hgp_linksexchange_store_id',
    	    ));
    	}
    	
    	$this->addColumn('hgp_linksexchange_category', array(
    			'header'    => Mage::helper('linksexchange')->__('Categorie'),
    			'align'     => 'left',
    			'index'     => 'hgp_linksexchange_category',
    			'type'      => 'options',
    			'width'     => '150px',
    			'options'   => Mage::Helper('linksexchange')->getCategory(),
    	));

        $this->addColumn('hgp_linksexchange_site_name', array(
            'header'    => Mage::helper('linksexchange')->__('Nom du site'),
            'align'     => 'left',
        	'width'     => '250px',
            'index'     => 'hgp_linksexchange_site_name',
        ));
        
        $this->addColumn('hgp_linksexchange_site_url_label', array(
            'header'    => Mage::helper('linksexchange')->__('Label lien'),
            'align'     => 'left',
        	'width'     => '250px',
            'index'     => 'hgp_linksexchange_site_url_label',
        ));

        $this->addColumn('hgp_linksexchange_contact_email', array(
            'header'    => Mage::helper('linksexchange')->__('Email de contact'),
            'align'     => 'left',
        	'width'     => '200px',
            'index'     => 'hgp_linksexchange_contact_email',
        ));

        $this->addColumn('hgp_linksexchange_contact_tel', array(
            'header'    => Mage::helper('linksexchange')->__('Telephone'),
            'align'     => 'left',
        	 'width'     => '70px',
            'index'     => 'hgp_linksexchange_contact_tel',
        ));
        
        $this->addColumn('hgp_linksexchange_date_modification', array(
            'header'    => Mage::helper('linksexchange')->__('Derniere modif'),
            'align'     => 'right',
        	'width'     => '30px',
            'index'     => 'hgp_linksexchange_date_modification',
        	'gmtoffset' => true,
        	'type'      =>'datetime',
        ))
        ;
        $this->addColumn('hgp_linksexchange_ordre', array(
            'header'    => Mage::helper('linksexchange')->__('Ordre'),
            'align'     => 'center',
            'width'     => '20px',
            'index'     => 'hgp_linksexchange_ordre',
        ));

		$this->addColumn('hgp_linksexchange_actif', array(
				'header'    => Mage::helper('linksexchange')->__('Actif'),
				'align'     => 'center',
				'index'     => 'hgp_linksexchange_actif',
				'type'      => 'options',
				'width'     => '70px',
				'options'   => array(
						1 => Mage::helper('linksexchange')->__('Oui'),
						0 => Mage::helper('linksexchange')->__('Non')
				),
		));
		
		//$this->addExportType('*/*/exportCsv', Mage::helper('linksexchange')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('linksexchange')->__('XML'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
