<?php 
class MOBLC_Post
{
	function __construct(){
		add_action('admin_init'	,	array(	$this,'moblc_handle_post'	)	);
	}

	function moblc_handle_post(){		
		if(isset($_POST['option']) and ! empty($_POST['option'])){
			$option = sanitize_text_field($_POST['option']);
			switch ($option) {
				case 'moblc_download_report_csv':
					$this->download_report_csv();
					break;
			}
		}
	}

function download_report_csv(){
		$nonce = sanitize_text_field($_POST['nonce']);
	   	if ( ! wp_verify_nonce( $nonce, 'DownloadReportNonce' ) && ! wp_verify_nonce( $nonce, 'DownloadRedirectionReportNonce' ) ){
	   		exit;
	   	}
	   	$redirect_link_request = wp_verify_nonce( $nonce, 'DownloadRedirectionReportNonce' )?true:false;
		$generatedDate = date('d-m-Y His');
		global $moblc_db_queries;
		$csv_output = '';
		$table = 'moblc_link_details_table';
		$separator=',';
		$result = $moblc_db_queries->get_column_names($table);
		if (count($result) > 0) {
			$i= 0;
		    foreach($result as $row) {
		    	if($i != 1 && $i != 5)
			    $csv_output = $csv_output . $row. $separator;
			$i++;
		    }
		    $csv_output = substr($csv_output, 0, -1);
		}
	    $csv_output .= "\n";

	    $values =    $moblc_db_queries->get_table_data($table);
	    $sid = 1;
		foreach ($values as $rowr) 
		{
			$i= 0;
			if($redirect_link_request){
				foreach ($rowr as $field) {

					if($i!=1 && $i!=5 && strlen($rowr->status_code)>3){
						if($i == 0)
							$csv_output = $csv_output . $sid. $separator;
						else{
							$arr = explode('-',trim($field),2);
							if($i==4){
								if(sizeof($arr)>=2){
									$csv_output = $csv_output . $arr[1]. $separator;
								}else{
									$csv_output = $csv_output . trim($field). $separator;
								}
							}
							else{
								$csv_output = $csv_output . trim($field). $separator;
							}
						}
					}
				$i++;
				}
			}else{
				foreach ($rowr as $field) {
					if($i != 1 && $i!=5 && strlen($rowr->status_code)==3){
						if($i == 0)
							$csv_output = $csv_output . $sid. $separator;
						else
							$csv_output = $csv_output . trim($field). $separator;
					}
				$i++;
				}
			}
			$csv_output = substr($csv_output, 0, -1);
		    $csv_output .= "\n"; 
		    $sid++;
		}   
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);            
		header("Content-Type: application/x-excel");
		header('Content-Disposition: attachment; filename="report' . $generatedDate . '.csv";' );
		header("Content-Transfer-Encoding: binary");
		echo $csv_output;
		exit;
	}

}new MOBLC_Post;