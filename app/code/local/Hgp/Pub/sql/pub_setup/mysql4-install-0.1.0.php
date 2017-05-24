<?php

$installer = $this;

$installer->run("

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for hgp_pub
-- ----------------------------
DROP TABLE IF EXISTS {$this->getTable('hgp_pub')};
CREATE TABLE {$this->getTable('hgp_pub')} (
  `hgp_pub_id` tinyint(6) NOT NULL AUTO_INCREMENT,
  `hgp_pub_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_pub_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_pub_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#',
  `hgp_pub_store` tinyint(6) NOT NULL DEFAULT '0',
  `hgp_pub_link_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'More',
  PRIMARY KEY (`hgp_pub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    
");

$installer->endSetup();