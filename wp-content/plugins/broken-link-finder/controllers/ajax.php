<?php
class MOBLC_Ajax
{
	function __construct(){
		add_action( 'admin_init'  , array( $this, 'moblc_broken_link_checker_ajax' ) );
	}

	function moblc_broken_link_checker_ajax(){
		add_action( 'wp_ajax_moblc_broken_link_checker', array($this,'moblc_broken_link_checker') );
	}

	function moblc_broken_link_checker(){
	global $moblc_db_queries;
	 $option = sanitize_text_field($_POST['option']);
	  switch($option) {
	   	case 'moblc_check_links_from_pages':
			$this->start_scan();
			break;
		case 'progress_bar':
			$this->get_scan_progress();
			break;
		case 'moblc_stop_scan':
			$this->stop_scan();
			break;
		case 'moblc_ajax_to_scan':
		$this->ajax_to_scan();
			break;
	  }
	}


	function start_scan(){	
		global $moblc_db_queries,$wpdb;
		$nonce = sanitize_text_field($_POST['nonce']);
	   	if ( ! wp_verify_nonce( $nonce, 'moblc-link-nonce' ) ){
	   		wp_send_json('ERROR');
	   	}

	   	if($moblc_db_queries->get_option('moblc_scan_message')!== false){
			wp_send_json('Already Scanning');
			exit;
	   	}
	   	if ( ! wp_next_scheduled( 'moblc_scan_cron_hook' ) ) {
	   		update_option('moblc_cron',0);
    		wp_schedule_event( time(), 'max_time', 'moblc_scan_cron_hook' );
		}
	   	$moblc_db_queries->delete_history();
	   	if(!$moblc_db_queries->count_of_pages())
	   		wp_send_json('No Data');   		
		$moblc_db_queries->update_option('moblc_scan_message','page');		
		$moblc_db_queries->update_option('moblc_page_scanning',1);
		$moblc_db_queries->update_option('moblc_link_scanning',1);
	}

	function get_scan_progress(){
			global $moblc_db_queries;
			$nonce = sanitize_text_field($_POST['nonce']);
		   	if ( ! wp_verify_nonce( $nonce, 'moblc-link-nonce' ) ){
		   		wp_send_json('ERROR');
		   	}
			$scan_type=$moblc_db_queries->get_option("moblc_scan_message");;
			$message='';
			if($scan_type=='page'){
				$ptotal=$moblc_db_queries->get_option("moblc_total_pages");
				$pscan =$moblc_db_queries->get_option("moblc_page_scanning");
				$ltotal=$moblc_db_queries->get_option("moblc_total_links");
				$lscan =$moblc_db_queries->get_option("moblc_link_scanning");
				$btotal=$moblc_db_queries->count_broken_links();				
			}
			if(!$ptotal){
				wp_send_json('No Data');
			}
			if(!$ltotal){
				$ltotal = 1;
				$lscan  = 1;
			}
			$width = (($pscan-1)/$ptotal)*100+($lscan*(100/$ptotal)/$ltotal);
			$width = number_format($width,0);
			if($width==100){
				$moblc_db_queries->delete_option('moblc_link_scanning');
			   	$moblc_db_queries->delete_option('moblc_page_scanning');
			   	$moblc_db_queries->delete_option('moblc_total_pages');
			   	$moblc_db_queries->delete_option('moblc_total_links');
			   	$moblc_db_queries->delete_option('moblc_scan_message');
				$timestamp = wp_next_scheduled('moblc_scan_cron_hook' );
				wp_unschedule_event( $timestamp,'moblc_scan_cron_hook' );	
			}	
			$response['lscan'] 		=$lscan;
			$response['ltotal'] 	=$ltotal;
			$response['pscan'] 		=$pscan;
			$response['ptotal'] 	=$ptotal;			
			$response['btotal'] 	=$btotal;
			$response['width'] 		=$width;
			wp_send_json($response);
	}

	function stop_scan(){
		$nonce = sanitize_text_field($_POST['nonce']);
	   	if ( ! wp_verify_nonce( $nonce, 'moblc-link-nonce' ) ){
	   		wp_send_json('ERROR');
	   	}
		global $moblc_db_queries;
		$moblc_db_queries->delete_option('moblc_link_scanning');
		$moblc_db_queries->delete_option('moblc_page_scanning');
		$moblc_db_queries->delete_option('moblc_total_pages');
		$moblc_db_queries->delete_option('moblc_total_links');
		$moblc_db_queries->delete_option('moblc_scan_message');
		$timestamp = wp_next_scheduled('moblc_scan_cron_hook' );
		wp_unschedule_event( $timestamp,'moblc_scan_cron_hook' );
		wp_send_json('SUCCESS');			
	}

	function ajax_to_scan(){
		$nonce = sanitize_text_field($_POST['nonce']);
	   	if ( ! wp_verify_nonce( $nonce, 'moblc-link-nonce' ) ){
	   		wp_send_json('ERROR');
	   	}
		global $moblc_db_queries;
			$scan_type=$moblc_db_queries->get_option("moblc_scan_message");
			if(!$scan_type)
				exit;
			if($scan_type=='page'){
				$pscan= $moblc_db_queries->get_option("moblc_page_scanning")-1;
				$lscan= $moblc_db_queries->get_option("moblc_link_scanning")-1;
	   			$this->check_links_from_pages($pscan,$lscan);
			}	
	}

function check_time($s_time)
{
 	$max_time = ini_get('max_execution_time');
 	if(($max_time - (time()-$s_time))<=5)
 		return true;
 	return false;
	
}
}new MOBLC_Ajax;