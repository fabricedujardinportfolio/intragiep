<?php

	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
		exit();

	global $wpdb;
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}moblc_link_details_table" );	
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}moblc_scan_status_table" );