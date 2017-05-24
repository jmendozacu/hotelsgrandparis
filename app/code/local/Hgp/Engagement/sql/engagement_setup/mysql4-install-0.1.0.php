<?php

$installer = $this;

$installer->run("

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for hgp_engagement
-- ----------------------------
DROP TABLE IF EXISTS {$this->getTable('hgp_engagement')};
CREATE TABLE {$this->getTable('hgp_engagement')} (
  `hgp_engagement_id` tinyint(6) NOT NULL AUTO_INCREMENT,
  `hgp_engagement_contenu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_engagement_store_fk` tinyint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`hgp_engagement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    
");

$installer->endSetup();