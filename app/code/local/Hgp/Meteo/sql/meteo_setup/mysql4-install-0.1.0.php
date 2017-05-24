<?php

$installer = $this;

$installer->run("

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for hgp_meteo
-- ----------------------------
DROP TABLE IF EXISTS {$this->getTable('hgp_meteo')};
CREATE TABLE {$this->getTable('hgp_meteo')} (
  `hgp_meteo_id` tinyint(6) NOT NULL AUTO_INCREMENT,
  `hgp_meteo_intro` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_meteo_today` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Today',
  `hgp_meteo_particule` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_meteo_city` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `hgp_meteo_date_format` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'dd MMM YYYY',
  `hgp_meteo_lang` char(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `hgp_meteo_unite` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '&deg;C',
  `hgp_store_fk` tinyint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`hgp_meteo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    
");

$installer->endSetup();