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
class Hgp_Homeslide_Block_Adminhtml_Homeslide_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('homeslideGrid');
        $this->setDefaultSort('hgp_homeslide_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $this->setCollection(Mage::getModel('homeslide/homeslide')->getCollection());
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('hgp_homeslide_id', array(
            'header'    => Mage::helper('homeslide')->__('ID'),
            'align'     => 'right',
            'width'     => '50px',
            'index'     => 'hgp_homeslide_id',
            'type'      => 'number',
        ));
        
        $this->addColumn('hgp_homeslide_store', array(
            'header'    => Mage::helper('homeslide')->__('Store'),
            'align'     => 'right',
            'width'     => '50px',
            'index'     => 'hgp_homeslide_store',
            'type'      => 'number',
        ));

        $this->addColumn('hgp_homeslide_h3', array(
            'header'    => Mage::helper('homeslide')->__('Titre H3'),
            'align'     => 'left',
            'index'     => 'hgp_homeslide_h3',
        ));
        
        $this->addColumn('hgp_homeslide_pdt_id', array(
            'header'    => Mage::helper('homeslide')->__('Hotel ID'),
            'align'     => 'right',
        	'width'     => '50px',
            'index'     => 'hgp_homeslide_pdt_id',
        ));

        $this->addColumn('hgp_homeslide_img', array(
            'header'    => Mage::helper('homeslide')->__('Nom IMG'),
            'align'     => 'left',
            'index'     => 'hgp_homeslide_img',
        ));

        $this->addColumn('hgp_homeslide_p', array(
            'header'    => Mage::helper('homeslide')->__('Texte visuel'),
            'align'     => 'left',
            'index'     => 'hgp_homeslide_p',
        ));
        
        $this->addColumn('hgp_homeslide_a', array(
            'header'    => Mage::helper('homeslide')->__('Link IMG'),
            'align'     => 'left',
            'index'     => 'hgp_homeslide_a',
        ))
        ;
        $this->addColumn('hgp_homeslide_pds', array(
            'header'    => Mage::helper('homeslide')->__('Coeff.'),
            'align'     => 'right',
            'width'     => '50px',
            'index'     => 'hgp_homeslide_pds',
        	'type'      => 'number',
        ));


        Mage::dispatchEvent('homeslide_adminhtml_grid_prepare_columns', array('block'=>$this));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
