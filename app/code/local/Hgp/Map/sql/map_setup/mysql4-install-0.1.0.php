<?php

$installer = $this;

$installer->run("

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for hgp_map
-- ----------------------------
DROP TABLE IF EXISTS {$this->getTable('hgp_map')};
CREATE TABLE {$this->getTable('hgp_map')} (
  `hgp_map_id` tinyint(6) NOT NULL AUTO_INCREMENT,
  `hgp_map_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_map_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_map_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#',
  `hgp_map_store` tinyint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hgp_map_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    
");

$installer->endSetup();