<?php

	global $moblc_utility,$moblc_dirname;
	$controller = $moblc_dirname . 'controllers'.DIRECTORY_SEPARATOR;

	
	if(current_user_can('administrator'))
	{
		include $controller 	 . 'navbar.php';

	if( isset( $_GET[ 'page' ])) 
	{
		$page = sanitize_text_field($_GET[ 'page' ]);
		switch($page)
		{
			case 'moblc_manual':
		        include $controller . 'manual.php';	   			break;
		    case 'moblc_scheduled':
		        include $controller . 'scheduled.php';	   		break;
		    case 'moblc_deep':
		        include $controller . 'deep.php';	   			break;
			case 'moblc_account':
				include $controller . 'account.php';			break;
			case 'moblc_report':
				include $controller . 'report.php';				break;	
			case 'moblc_upgrade':
				include $controller . 'upgrade.php';			break;		
		}
	}

		include $controller . 'support.php';
	}
