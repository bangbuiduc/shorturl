<?php
global $bangbd_shorturl_db_version;
$bangbd_shorturl_db_version = '1.0';

global $wpdb;

$table_name = $wpdb->prefix . BS_PLUGIN_TABLE;

$sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `short_url` varchar(20) NOT NULL,
			  `real_url` text NOT NULL,
			  `user_id` int(11) NOT NULL,
			  `created_at` datetime NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `short_url` (`short_url`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

add_option( 'bangbd_shorturl_db_version', $bangbd_shorturl_db_version );