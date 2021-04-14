<?php

	global $moblc_dirname,$moblc_db_queries;
	
	if(current_user_can( 'manage_options' )  && isset($_POST['option']))
	{
		$option = sanitize_text_field($_POST['option']);
		switch($option)
		{
			case "moblc_send_query":
				moblc_handle_support_form(sanitize_email($_POST['query_email']),sanitize_text_field($_POST['query']),sanitize_text_field($_POST['query_phone']));	break;
		}
	}

	$current_user 	= wp_get_current_user();
	$email 			= $moblc_db_queries->get_option("email");
	$phone 			= $moblc_db_queries->get_option("admin_phone");

	
	if(empty($email))
		$email 		= $current_user->user_email;

	include $moblc_dirname . 'views'.DIRECTORY_SEPARATOR.'support.php';

	function moblc_handle_support_form($email,$query,$phone)
	{
		$nonce = sanitize_text_field($_POST['nonce']);
		if(!wp_verify_nonce($nonce,'sendQueryNonce'))
		{
			do_action('moblc_show_message', MOBLC_Messages::showMessage('ERROR'),'ERROR');
			return;	
		}
		if( empty($email) || empty($query) )
		{
			do_action('moblc_show_message', MOBLC_Messages::showMessage('SUPPORT_FORM_VALUES'),'ERROR');
			return;
		}

		$contact_us = new MOBLC_Api();
		$contact_us->submit_contact_us($email, $phone, $query);

		if(json_last_error() == JSON_ERROR_NONE) 
		{
			do_action('moblc_show_message', MOBLC_Messages::showMessage('SUPPORT_FORM_SENT'),'SUCCESS');
			return;
		}
			
		do_action('moblc_show_message', MOBLC_Messages::showMessage('SUPPORT_FORM_ERROR'),'ERROR');
		return;
	}