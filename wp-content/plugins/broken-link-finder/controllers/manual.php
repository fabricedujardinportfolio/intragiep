<?php 
global $moblc_dirname,$scanned_link_count, $moblc_db_queries;
$interval					= (ini_get('max_execution_time') - 15)*1000;
include $moblc_dirname.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'manual.php';