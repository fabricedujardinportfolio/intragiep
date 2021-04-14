<?php 
	
	global $moblc_utility,$moblc_dirname,$moblc_db_queries;

	if ( current_user_can( 'manage_options' ) and isset( $_POST['option'] ) )
	{
		$option = sanitize_text_field(trim($_POST['option']));
		switch($option)
		{
			case "moblc_register_customer":
				moblc_register_customer();																	   	
				break;
			case "moblc_verify_customer":
				moblc_verify_customer();																	   		
				break;
			case "moblc_cancel":
				moblc_revert_back_registration();																   		
				break;
			case "moblc_reset_password":
				moblc_reset_password(); 																		  	   	
				break;
		    case "moblc_goto_verifycustomer":
		        moblc_goto_sign_in_page();   
		        break;
		}
	} 
	$user = wp_get_current_user();
	if ($moblc_db_queries->get_option ( 'verify_customer' ) == 'true')
	{
		$admin_email = $moblc_db_queries->get_option('email') ? $moblc_db_queries->get_option('email') : "";		
		include $moblc_dirname . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'login.php';
	}
	else if (! moblc_icr()) 
	{
		include $moblc_dirname . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'register.php';
	} 
	else
	{
		$email = $moblc_db_queries->get_option('email');
		$key   = $moblc_db_queries->get_option('customerKey');
		$api   = $moblc_db_queries->get_option('api_key');
		$token = $moblc_db_queries->get_option('customer_token');
		include $moblc_dirname . 'views'.DIRECTORY_SEPARATOR.'account'.DIRECTORY_SEPARATOR.'profile.php';
	}




	function moblc_register_customer()
	{
		global $moblc_db_queries, $moblc_utility;
		$nonce = sanitize_text_field($_POST['nonce']);
	   		if ( ! wp_verify_nonce( $nonce, 'moblc-account-nonce' ) ){
	   			do_action('moblc_show_message', MOBLC_Messages::showMessage('ERROR'), 'ERROR');
	   			return;
	   		}

		$email 			 = sanitize_email($_POST['email']);
		$company 		 = $_SERVER["SERVER_NAME"];

		$password 		 = sanitize_text_field($_POST['password']);
		$confirmPassword = sanitize_text_field($_POST['confirmPassword']);

		if( strlen( $password ) < 6 || strlen( $confirmPassword ) < 6)
		{         
			do_action('moblc_show_message', MOBLC_Messages::showMessage('PASS_LENGTH'), 'ERROR');
			return;
		}
		
		if( $password != $confirmPassword )
		{
			do_action('moblc_show_message', MOBLC_Messages::showMessage('PASS_MISMATCH'),'ERROR');
			return;
		}
		if( moblc_check_empty_or_null( $email ) || moblc_check_empty_or_null( $password ) 
			|| moblc_check_empty_or_null( $confirmPassword ) ) 
		{
			do_action('moblc_show_message',MOBLC_Messages::showMessage('REQUIRED_FIELDS'),'ERROR');
			return;
		} 

		$moblc_db_queries->update_option( 'email'		, $email 	);
		
		$moblc_db_queries->update_option( 'company'    	, $company 	);
		
		$moblc_db_queries->update_option( 'password'   	, $password );

		$customer = new MOBLC_Api();
		$content  = json_decode($customer->check_customer($email), true);
		switch ($content['status'])
		{
			case 'CUSTOMER_NOT_FOUND':
			      $customerKey = json_decode($customer->create_customer($email, $company, $password, $phone = '', $first_name = '', $last_name = ''), true);
				  
			   if(strcasecmp($customerKey['status'], 'SUCCESS') == 0) 
				{
					moblc_save_success_customer_config($email, $customerKey['id'], $customerKey['apiKey'], $customerKey['token'], $customerKey['appSecret']);
					moblc_get_current_customer($email,$password);
				}
				
				break;
			default:
				moblc_get_current_customer($email,$password);
				break;
		}

	}


   function moblc_goto_sign_in_page(){  
   		global $moblc_db_queries;	
		$nonce = sanitize_text_field($_POST['nonce']);
	   		if ( ! wp_verify_nonce( $nonce, 'moblc-account-nonce' ) ){		   			
		   		do_action('moblc_show_message', MOBLC_Messages::showMessage('ERROR'),'ERROR');
	   			return;
	   		}
   	   $moblc_db_queries->update_option('verify_customer','true');
   }

	function moblc_revert_back_registration()
	{		
		$nonce = sanitize_text_field($_POST['nonce']);
	   		if ( ! wp_verify_nonce( $nonce, 'moblc-account-nonce' ) ){
					do_action('moblc_show_message', MOBLC_Messages::showMessage('ERROR'),'ERROR');
	   			return;
	   		}
		$moblc_db_queries->delete_option('email');
		$moblc_db_queries->delete_option('verify_customer');
	}


	function moblc_reset_password()
	{
		global $moblc_db_queries;
		$nonce = sanitize_text_field($_POST['nonce']);
	   		if ( ! wp_verify_nonce( $nonce, 'moblc-account-nonce' ) ){
	   			do_action('moblc_show_message', MOBLC_Messages::showMessage('ERROR'),'ERROR');
	   			return;
	   		}
		$customer = new MOBLC_Api();
		$forgot_password_response = json_decode($customer->forgot_password());
		if($forgot_password_response->status == 'SUCCESS')
			do_action('moblc_show_message', MOBLC_Messages::showMessage('RESET_PASS'),'SUCCESS');
		return;
	}


	function moblc_verify_customer()
	{
		global $moblc_db_queries;		
		$nonce = sanitize_text_field($_POST['nonce']);
	   		if ( ! wp_verify_nonce( $nonce, 'moblc-account-nonce' ) ){
	   			do_action('moblc_show_message', MOBLC_Messages::showMessage('ERROR'),'ERROR');
	   			return;
	   		}
		global $moblc_utility;
		$email 	  = sanitize_email( $_POST['email'] );
		$password = sanitize_text_field( $_POST['password'] );

		if( moblc_check_empty_or_null( $email ) || moblc_check_empty_or_null( $password ) ) 
		{
			do_action('moblc_show_message', MOBLC_Messages::showMessage('REQUIRED_FIELDS'),'ERROR');
			return;
		} 
		moblc_get_current_customer($email,$password);
	}

	function moblc_get_current_customer($email,$password)
	{
		global $moblc_db_queries;
		$user   	 = wp_get_current_user();
		$customer 	 = new MOBLC_Api();
		$content     = $customer->get_customer_key($email, $password);
		$customerKey = json_decode($content, true);
		if(json_last_error() == JSON_ERROR_NONE) 
		{
			if(isset($customerKey['phone'])){
				$moblc_db_queries->update_option( 'admin_phone', $customerKey['phone'] );
			}
			$moblc_db_queries->update_option('email',$email);
			moblc_save_success_customer_config($email, $customerKey['id'], $customerKey['apiKey'], $customerKey['token'], $customerKey['appSecret']);
			do_action('moblc_show_message', MOBLC_Messages::showMessage('REG_SUCCESS'),'SUCCESS');
			return;
		} 
		else 
		{
			$moblc_db_queries->update_option('verify_customer', 'true');
			do_action('moblc_show_message', MOBLC_Messages::showMessage('ACCOUNT_EXISTS'),'ERROR');
		}
	}
	
		
	function moblc_save_success_customer_config($email, $id, $apiKey, $token, $appSecret)
	{
		global $moblc_db_queries;

		$user   = wp_get_current_user();
		$moblc_db_queries->update_option( 'customerKey'            	, $id 	  		);
		$moblc_db_queries->update_option( 'api_key'                	, $apiKey 		);
		$moblc_db_queries->update_option( 'customer_token'			, $token 	  	);
		$moblc_db_queries->update_option( 'app_secret'			 	, $appSecret 	);
		$moblc_db_queries->update_option( 'registration_status'		, 'SUCCESS' 	);
		$moblc_db_queries->delete_option( 'verify_customer'				  	);
		$moblc_db_queries->delete_option( 'mo_wpns_password'				);
	}

	function moblc_icr() 
	{
		global $moblc_db_queries;
		$email 			= $moblc_db_queries->get_option('email');
		$customerKey 	= $moblc_db_queries->get_option('customerKey');
		if( ! $email || ! $customerKey || ! is_numeric( trim( $customerKey ) ) )
			return 0;
		else
			return 1;
	}
	
	function moblc_check_empty_or_null( $value )
	{
		if( ! isset( $value ) || empty( $value ) )
			return true;
		return false;
	}
