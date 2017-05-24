<?php

$installer = $this;

$installer->run("

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for hgp_homeslide
-- ----------------------------
DROP TABLE IF EXISTS {$this->getTable('hgp_homeslide')};
CREATE TABLE {$this->getTable('hgp_homeslide')} (
  `hgp_homeslide_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `hgp_homeslide_h3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_homeslide_store` smallint(6) NOT NULL DEFAULT '0',
  `hgp_homeslide_tbs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hgp_homeslide_img` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hgp_homeslide_p` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_homeslide_a` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#',
  PRIMARY KEY (`hgp_homeslide_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

");

$installer->endSetup();