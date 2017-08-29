<?php
/**
 * Adaptive Payments
 *
 * @category   Location
 * @package    Location_AdaptivePayments
 * @author    Sushil Zore <sushilzore@gmail.com>
 */

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$installer->getTable('adaptivepayments/adaptivepayments')};
CREATE TABLE {$installer->getTable('adaptivepayments/adaptivepayments')} (
  `adaptivepayments_id` int(11) unsigned NOT NULL auto_increment,
  `vendor_id` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `payment_id` varchar(255) NOT NULL default '0',
  `transaction_id` varchar(255) NOT NULL default '0',
  `amount` int(11) NOT NULL default '0',
  `currency` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `status` varchar(255) NOT NULL default '',
  `request_time` datetime NULL,
  `response_time` datetime NULL,
  PRIMARY KEY (`adaptivepayments_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS {$installer->getTable('adaptivepayments/log')};
CREATE TABLE {$installer->getTable('adaptivepayments/log')} (
  `log_id` int(11) unsigned NOT NULL auto_increment,
  `adaptivepayments_id` int(11) unsigned NOT NULL,
  `request` text NOT NULL default '',
  `response` text NOT NULL default '',
  `ack` varchar(255) NOT NULL default '',
  `payment_exec_status` varchar(255) NOT NULL default '',
  `status` varchar(255) NOT NULL default '',
  `request_time` datetime NULL,
  `response_time` datetime NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();