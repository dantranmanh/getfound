<?php
$installer = $this;
$installer->startSetup();
$installer->run("
 
-- DROP TABLE IF EXISTS {$this->getTable('headerimage')};
CREATE TABLE {$this->getTable('headerimage')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `month_id` int(11) NOT NULL,
  `month_label` text(100) NOT NULL,
  `path` text(100) NOT NULL,
  
  PRIMARY KEY (`id`)
 ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 INSERT INTO {$installer->getTable('headerimage')} VALUES (1,1,'January',''); 
 INSERT INTO {$installer->getTable('headerimage')} VALUES (2,2,'February',''); 
 INSERT INTO {$installer->getTable('headerimage')} VALUES (3,3,'March',''); 
 INSERT INTO {$installer->getTable('headerimage')} VALUES (4,4,'April',''); 
 INSERT INTO {$installer->getTable('headerimage')} VALUES (5,5,'May',''); 
 INSERT INTO {$installer->getTable('headerimage')} VALUES (6,6,'June',''); 
 INSERT INTO {$installer->getTable('headerimage')} VALUES (7,7,'July',''); 
 INSERT INTO {$installer->getTable('headerimage')} VALUES (8,8,'August',''); 
 INSERT INTO {$installer->getTable('headerimage')} VALUES (9,9,'September',''); 
 INSERT INTO {$installer->getTable('headerimage')} VALUES (10,10,'October',''); 
 INSERT INTO {$installer->getTable('headerimage')} VALUES (11,11,'November',''); 
 INSERT INTO {$installer->getTable('headerimage')} VALUES (12,12,'December',''); 

");
  $installer->endSetup();

?>