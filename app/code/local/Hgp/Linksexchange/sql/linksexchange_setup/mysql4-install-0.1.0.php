<?php

$installer = $this;

$installer->run("

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for hgp_linksexchange
-- ----------------------------

DROP TABLE IF EXISTS {$this->getTable('hgp_linksexchange')};
CREATE TABLE {$this->getTable('hgp_linksexchange')} (
  `hgp_linksexchange_id` int(6) NOT NULL auto_increment,
  `hgp_linksexchange_category_id` int(2) NOT NULL,
  `hgp_linksexchange_store_id` smallint(1) default '1',
  `hgp_linksexchange_site_name` varchar(255) NOT NULL,
  `hgp_linksexchange_site_description` text NOT NULL,
  `hgp_linksexchange_site_url_label` varchar(255) NOT NULL,
  `hgp_linksexchange_site_url_link` varchar(255) NOT NULL,
  `hgp_linksexchange_site_url_title` varchar(255) default NULL,
  `hgp_linksexchange_contact_email` varchar(255) NOT NULL,
  `hgp_linksexchange_contact_tel` varchar(255) NOT NULL,
  `hgp_linksexchange_site_page_cible` varchar(255) NOT NULL,
  `hgp_linksexchange_ordre` int(3) default NULL,
  `hgp_linksexchange_date_creation` varchar(255) default NULL,
  `hgp_linksexchange_date_modification` varchar(255) default NULL,
  `hgp_linksexchange_user_modif` varchar(255) default NULL,
  `hgp_linksexchange_actif` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`hgp_linksexchange_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

");

$installer->endSetup();