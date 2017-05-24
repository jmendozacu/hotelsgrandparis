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
class Hgp_GooglemapLocator_LocationController extends Mage_Core_Controller_Front_Action
{
    public function mapAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function searchAction()
    {
        $dom = new DOMDocument("1.0");
        $node = $dom->createElement("markers");
        $parnode = $dom->appendChild($node);

        try {
            $num = (int)Mage::getStoreConfig('googlemaplocator/general/num_results');
            $units = Mage::getStoreConfig('googlemaplocator/general/distance_units');
            $collection = Mage::getModel('googlemaplocator/location')->getCollection()
                ->addAreaFilter(
                    $this->getRequest()->getParam('lat'),
                    $this->getRequest()->getParam('lng'),
                    $this->getRequest()->getParam('radius'),
                    $this->getRequest()->getParam('units', $units)
                )
                ->addProductTypeFilter($this->getRequest()->getParam('type'));

            $privateFields = Mage::getConfig()->getNode('global/googlemaplocator/private_fields');
            foreach ($collection as $loc){
                $node = $dom->createElement("marker");
                $newnode = $parnode->appendChild($node);
                $newnode->setAttribute("units", $units);
                foreach ($loc->getData() as $k=>$v) {
                    if (!$privateFields->$k) {
                        $newnode->setAttribute($k, $v);
                    }
                }
            }
        } catch (Exception $e) {
            $node = $dom->createElement('error');
            $newnode = $parnode->appendChild($node);
            $newnode->setAttribute('message', $e->getMessage());
        }

        $this->getResponse()->setHeader('Content-Type', 'text/xml')->setBody($dom->saveXml());
    }
}
