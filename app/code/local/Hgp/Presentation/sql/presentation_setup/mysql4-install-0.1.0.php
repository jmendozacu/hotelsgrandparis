<?php

$installer = $this;

$installer->run("

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for hgp_presentation
-- ----------------------------
DROP TABLE IF EXISTS {$this->getTable('hgp_presentation')};
CREATE TABLE {$this->getTable('hgp_presentation')} (
  `hgp_presentation_id` tinyint(6) NOT NULL AUTO_INCREMENT,
  `hgp_presentation_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_presentation_contenu` text COLLATE utf8_unicode_ci NOT NULL,
  `hgp_presentation_teaser` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hgp_presentation_store_fk` tinyint(6) NOT NULL DEFAULT '1',
  `hgp_presentation_link_label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_presentation_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#',
  PRIMARY KEY (`hgp_presentation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    
");

$installer->endSetup();