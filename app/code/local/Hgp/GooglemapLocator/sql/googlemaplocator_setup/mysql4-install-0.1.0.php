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

$this->startSetup()->run("

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for hgp_googlemaplocator
-- ----------------------------
DROP TABLE IF EXISTS {$this->getTable('hgp_googlemaplocator')};
CREATE TABLE {$this->getTable('hgp_googlemaplocator')} (
  `location_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `latitude` decimal(15,10) NOT NULL,
  `longitude` decimal(15,10) NOT NULL,
  `address_display` text NOT NULL,
  `notes` text NOT NULL,
  `website_url` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `product_types` varchar(255) NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

")->endSetup();
