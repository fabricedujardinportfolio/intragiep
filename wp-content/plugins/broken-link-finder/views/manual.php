<?php
echo'<br><br><div class="mo_wpns_next_divided_layout"  id = "new_scan_div">
		<div class="mo_wpns_setting_layout">
			<div style="text-align:center;">
				<h1 >Scan for deadlinks present on your wordpress site.</h1>
				<br><br>
				<input type="button" name="manual_scan" id="manual_scan" value="Start New Scan" class="mo_wpsn_button mo_wpsn_button1" style="padding: 25px 64px;border-radius: 50em;font-size: x-large;font-family: cursive;" />
				<br>
			</div>
		</div>
	 </div>';
echo'<div class="mo_wpns_next_divided_layout" id="mo_progress" hidden>
		<div class="mo_wpns_setting_layout">
				<table style="width:100%;margin-right:0px;">
				<tr><td>
				<h3 id="progress_message" style="float:left">Scan in progress....</h3>
				</td><td style="width:30%;">
				<div id="moblc_view_report" hidden>
					<a class="mo_wpns_button mo_wpns_button1" style="float:right;" href="'.$report_url.'" >
						view report
					</a>
				</div>
				</td>
				</tr>
				</table>
				<div id="mo_wpns_progress" class="mo_wpns_progress">
						<div id="mo_wpns_progress_bar" class="mo_wpns_progress_bar">0%</div>
					</div> <br>
					  <table>
					    <thead>
					      <tr>
					        <th class="moblc_th">Total Posts & Pages</th>
					        <th class="moblc_th">Scanning Now<br>(current page/post)</th>
					        <th class="moblc_th">Total Links<br> in current page/post</th>
					        <th class="moblc_th">Scanned Links from current page/post</th>
					        <th class="moblc_th">Broken Links</th>
					      </tr>
					    </thead>
					    <tbody>
					      <tr>
					        <td class="moblc_td" id="ptotal" style="padding:19px;font-size: xx-large;"></td>
					        <td class="moblc_td" id="pscan" style="padding:19px;font-size: xx-large;"></td>
					        <td class="moblc_td" id="ltotal" style="padding:19px;font-size: xx-large;"></td>
					        <td class="moblc_td" id="lscan" style="padding:19px;font-size: xx-large;"></td>
					        <td class="moblc_td" id="btotal" style="padding:19px;font-size: xx-large;">0</td>
					      </tr>
					    </tbody>
					  </table><br><br>
					
					<input type="button" name="stop_scan" id="stop_scan" value="Stop Scan" class="mo_wpsn_button mo_wpsn_button1" />
			<div id="download_report" hidden>
				You can check the result in report tab or Downlod CSV from here.
				<form name ="download_report_form" id="download_report_form" method="post">
                <input type="hidden" name="option"value="moblc_download_report_csv"/>
				<input type="hidden" name="nonce"
				value="'.wp_create_nonce("DownloadReportNonce").'"/>
				<input type="submit" name="download" id="download" class="mo_wpns_button mo_wpns_button1" value="Download Report in CSV"/><br><br>
				</form>
			</div>
		</div>
	</div>';
?>

<script>
    var progress_bar, remote_call;
    var is_scanning = '<?php echo $moblc_db_queries->get_option("moblc_scan_message");?>';
    if(is_scanning){
        jQuery('#mo_progress').show();
        jQuery('#new_scan_div').hide(); 
        jQuery('#manual_scan').css('backgroundColor','#20b2aa');
        jQuery('#manual_scan').prop('disabled', true);
        moblc_status_progress();
        progress_bar= setInterval(moblc_status_progress, 30000);
    }

    jQuery('#stop_scan').click(function(){      
        clearInterval(remote_call);
        clearInterval(progress_bar);
        var data = {
            'action'                    : 'moblc_broken_link_checker',
            'option'                    : 'moblc_stop_scan',
            'nonce'                     : '<?php echo wp_create_nonce("moblc-link-nonce");?>'
            };
            jQuery.post(ajaxurl, data, function(response) {
                if(response == 'ERROR')
                    error_msg("Your query could not be submitted. Please try again.");
                else if(response == 'SUCCESS'){                 
                    success_msg("Scan Aborted.");                   
                    moblc_reset_scan_progress();
                    jQuery('#stop_scan').hide();
                    jQuery('#progress_message').empty();
                    jQuery('#progress_message').append("");
                    jQuery('#new_scan_div').show(); 
                    jQuery('#manual_scan').attr('disabled', false);
                    jQuery('#mo_progress').hide();
                }
            });
    });
    jQuery('#manual_scan').click(function(){
        var data = {
            'action'                    : 'moblc_broken_link_checker',
            'option'                    : 'moblc_check_links_from_pages',
            'nonce'                     : '<?php echo wp_create_nonce("moblc-link-nonce");?>'
            };
            jQuery.post(ajaxurl, data, function(response) {
                if(response == 'Already Scanning'){
                    error_msg('Already Scanning');
                }
                else if(response == 'ERROR')
                    error_msg("Your query could not be submitted. Please try again.");
                else if(response == 'No Data')
                    error_msg("Your site do not have any published page to check for broken links");
                else{                   
                    success_msg('Scan Started');
                    moblc_reset_scan_progress();                    
                    jQuery("#progress_message").empty();
                    jQuery("#progress_message").append("Scan in progress....");                 
                    jQuery('#stop_scan').show();
                    jQuery('#new_scan_div').hide(); 
                    jQuery('#mo_progress').show();
                    jQuery('#manual_scan').css('backgroundColor','#20b2aa');
                    jQuery('#manual_scan').prop('disabled', true);
                    progress_bar= setInterval(moblc_status_progress, 30000);
                    jQuery('#download_report').hide();
                    jQuery('#moblc_view_report').hide();
                    // remote_call = setInterval(moblc_call_ajax_for_scan,<?php echo $interval;?>);
                    // moblc_call_ajax_for_scan();
                }
            });
    });
function moblc_status_progress(){
        var data={
            'action':'moblc_broken_link_checker',
            'option':'progress_bar',
            'nonce' : '<?php echo wp_create_nonce("moblc-link-nonce");?>'
        };
        jQuery.post(ajaxurl, data, function(response){
            if(response == 'ERROR')
                    error_msg("Your query could not be submitted. Please try again.");
            else{
                var bar= document.getElementById("mo_wpns_progress_bar");
                var width       = response['width'];

                jQuery('#lscan').empty();
                jQuery('#lscan').append(response['lscan']);
                jQuery('#ltotal').empty();
                jQuery('#ltotal').append(response['ltotal']);
                jQuery('#pscan').empty();
                jQuery('#pscan').append(response['pscan']);
                jQuery('#ptotal').empty();
                jQuery('#ptotal').append(response['ptotal']);               
                jQuery('#btotal').empty();
                jQuery('#btotal').append(response['btotal']);

                if(width >=100 )
                {
                    success_msg('Scan Completed');
                    jQuery("#progress_message").empty();
                    if(response['btotal'] <= 0)
                        var scan_complete_msg = "Congratualtions !!! No Broken Links Found on your site.";
                    else
                        var scan_complete_msg = "Scan Completed. Please check the report for more details.";
                    jQuery("#progress_message").append(scan_complete_msg);          
                    jQuery('#manual_scan').val('Start New Scan');
                    jQuery('#manual_scan').attr('disabled', false);
                    if(response['btotal']>0){
                        jQuery('#download_report').show();
                        jQuery('#moblc_view_report').show();
                    }
                    jQuery('#stop_scan').hide();
                    jQuery('#new_scan_div').show(); 
                    clearInterval(remote_call); 
                    clearInterval(progress_bar);
                }

                width = width +"%";
                jQuery("#mo_wpns_progress_bar").css('width',width);
                jQuery("#mo_wpns_progress_bar").empty();
                jQuery("#mo_wpns_progress_bar").append(width);
            }
        });
}


function moblc_call_ajax_for_scan(){
    var data={
            'action':'moblc_broken_link_checker',
            'option':'moblc_ajax_to_scan',
            'nonce' : '<?php echo wp_create_nonce("moblc-link-nonce");?>'
        };
        jQuery.post(ajaxurl, data, function(response){
            if(response == 'Completed'){
                success_msg('Scan Completed.<br> You can download the report or Can check the result in report tab.');
                jQuery('#new_scan_div').show(); 
                clearInterval(remote_call);
            }
            else if(response == 'ERROR')
                error_msg("Your query could not be submitted. Please try again.");  
        });
}

function moblc_reset_scan_progress(){   
    jQuery('#lscan').empty();
    jQuery('#ltotal').empty();
    jQuery('#pscan').empty();
    jQuery('#ptotal').empty();              
    jQuery('#btotal').empty();
    jQuery('#btotal').append('0');
    width = 0 +"%";
    jQuery("#mo_wpns_progress_bar").css('width',width);
    jQuery("#mo_wpns_progress_bar").empty();
    jQuery("#mo_wpns_progress_bar").append(width);
}
</script>