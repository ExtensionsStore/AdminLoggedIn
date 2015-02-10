<?php

/**
 * AdminLoggedIn install
 *
 * @category   Aydus
 * @package    Aydus_AdminLoggedIn
 * @author     Aydus Consulting <davidt@aydus.com>
 */

$this->startSetup();

$this->run("CREATE TABLE IF NOT EXISTS {$this->getTable('aydus_adminloggedin_adminlogin')} (
`admin_user_id` INT(11) NOT NULL,
`ip_address` VARCHAR(20) NOT NULL,
`loggedin` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
`updated_at` DATETIME NOT NULL,
PRIMARY KEY ( `admin_user_id` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

$this->endSetup();