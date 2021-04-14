<?php
	global $moblc_db_queries,$moblc_dirname;
 	
 	$records= $moblc_db_queries->get_table_data('moblc_link_details_table');
 	$size   = sizeof($records); 
 	include $moblc_dirname.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'report.php';
