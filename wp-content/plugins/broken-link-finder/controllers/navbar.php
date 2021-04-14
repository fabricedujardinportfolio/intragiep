<?php
	global $moblc_utility,$moblc_dirname;

	$profile_url		= add_query_arg( array('page' => 'moblc_account'		), $_SERVER['REQUEST_URI'] );
	$support_url		= add_query_arg( array('page' => 'moblc_support'		), $_SERVER['REQUEST_URI'] );
	$manual_url			= add_query_arg( array('page' => 'moblc_manual'			), $_SERVER['REQUEST_URI'] );
	$scheduled_url		= add_query_arg( array('page' => 'moblc_scheduled'		), $_SERVER['REQUEST_URI'] );
	$deep_url			= add_query_arg( array('page' => 'moblc_deep'			), $_SERVER['REQUEST_URI'] );
	$report_url			= add_query_arg( array('page' => 'moblc_report'			), $_SERVER['REQUEST_URI'] );
	$upgrade_url		= add_query_arg( array('page' => 'moblc_upgrade'		), $_SERVER['REQUEST_URI'] );
	$logo_url			= plugin_dir_url(dirname(__FILE__)) . 'includes/images/miniorange_logo.png';
    $active_tab 		= sanitize_text_field($_GET['page']);
	include $moblc_dirname . 'views'.DIRECTORY_SEPARATOR.'navbar.php';
