<div class="mo_wpns_next_divided_layout">
    <div style="width: 100%;">
        <button id="moblc_scan_report_sub_tabs" class="moblc_sub_tabs" onclick="moblc_scan_report_function()" style="background: #20b2aa;color: white;">Scan Report</button>
        <button id="moblc_email_report_sub_tabs" class="moblc_sub_tabs" onclick="moblc_email_report_function()">Email Report</button>
        <button id="moblc_report_on_dashboard_sub_tabs" class="moblc_sub_tabs" onclick="moblc_report_on_dashboard_function()">Report on Dashboard</button>
    </div>
</div>

<div id="moblc_scan_report_div" style="display: block;">
<?php
echo'<br><br>
<div class="mo_wpns_next_divided_layout">
	<div class="mo_wpns_setting_layout">';
if ($size>0) {
    echo '<form name ="download_report_form" id="download_report_form" method="post" align="right">
                	<input type="hidden" name="option"value="moblc_download_report_csv"/>
					<input type="hidden" name="nonce" value="'.wp_create_nonce("DownloadReportNonce").'"/>
					<input type="submit" name="download" id="download" class="mo_wpns_button mo_wpns_button1" value="Download Report in CSV"/>
				</form><br><br>';
}

echo'	<table id="report" class="display" cellspacing="0" width="100%">
		    <thead>
			   <tr>
		        <th class="moblc_th">Link</th>
				<th class="moblc_th">Page/Post</th>
				<th class="moblc_th">Status</th>
		        </tr>
		    </thead>
		    <tbody>';
foreach ($records as $record) {
    $statusAndLink = explode('-', $record->status_code,2);
    $status_code = (int)($statusAndLink[0]);
    if($status_code<300 || $status_code>=400)
    echo "<tr><td class='moblc_td'>".esc_html($record->link)."</td><td class='moblc_td'>".esc_html($record->page_title)."</td><td class='moblc_td'>".esc_html($status_code)."</td></tr>";
}

echo'	    </tbody>
		</table>
        <a href="#mo2fa_redirection_links" onclick="mo2fa_redirected_link_details()"><button id="mo2fa_redirected_link_button"  class="mo_wpns_button mo_wpns_button1">Click here to view redirected links</button></a>
	</div>
</div>';?>
</div>

<div id="moblc_scan_report_div" style="display: block;">
<?php

echo'<br><br>
<div class="mo_wpns_next_divided_layout">
    <div id="mo2fa_redirection_links" class="mo_wpns_setting_layout" style="display: none;">';
if ($size>0) {
    echo '<form name ="download_report_form" id="download_report_form" method="post" align="right">
                    <input type="hidden" name="option"value="moblc_download_report_csv"/>
                    <input type="hidden" name="nonce" value="'.wp_create_nonce("DownloadRedirectionReportNonce").'"/>
                    <input type="submit" name="download" id="download" class="mo_wpns_button mo_wpns_button1" value="Download Report in CSV"/>
                </form><br><br>';
}

echo'   <table id="redirection_report" class="display" cellspacing="0" width="100%">
            <thead>
               <tr>
                <th class="moblc_th moblc_width1">Link</th>
                <th class="moblc_th moblc_width2">Page/Post</th>
                <th class="moblc_th moblc_width1">Redirected to</th>
                </tr>
            </thead>
            <tbody>';
foreach ($records as $record) {
    $statusAndLink = explode('-', $record->status_code,2);
    $status_code = $statusAndLink[0];
    if($status_code>=300 && $status_code<400 && sizeof($statusAndLink)==2){
    $redirection_link = ($statusAndLink[1]);
    echo "<tr><td class='moblc_td'>".esc_html($record->link)."</td><td class='moblc_td'>".esc_html($record->page_title)."</td><td class='moblc_td'>".esc_html($redirection_link)."</td></tr>";
}
}

echo'       </tbody>
        </table>
    </div>
</div>';

?>
</div>
<script>
    jQuery(document).ready(function() {
        jQuery("#report").DataTable({
            "order": [[ 1, "desc" ]]
        });
    } );
    jQuery(document).ready(function() {
        jQuery("#redirection_report").DataTable({
            "order": [[ 1, "desc" ]]
        });
    } );
    function mo2fa_redirected_link_details(){
        jQuery('#mo2fa_redirected_link_button').hide();
        jQuery('#mo2fa_redirection_links').show();

    }
</script>

<div id="moblc_email_report_div" style="display: none;">
    <div class="mo_wpns_next_divided_layout">
        <div class="mo_wpns_setting_layout">
            <h3>Email Reports&nbsp;&nbsp;<span style="color: red;">[ Premium ]</span>
            <label class="mo_wpns_switch" style="float:right">
            <input type=checkbox/>
            <span class="mo_wpns_slider mo_wpns_round"></span>
            </label>
            </h3><br><hr  style="margin-top:-1%;">
            <p><i>Report will be automatically emailed after every scan.        
            <input type="email" placeholder="Enter your email" style="float:right" disabled/><br><br>
            <input type="button" value="Save" class="mo_wpsn_button" onclick="moblc_report_save()">
            </i></p><br><br>
        </div>
    </div>
</div>

<div id="moblc_report_on_dashboard_div" style="display: none;">
    <div class="mo_wpns_next_divided_layout">
        <div class="mo_wpns_setting_layout">
            <h3>Report on dashboard for selected role&nbsp;&nbsp;<span style="color: red;">[ Premium ]</span>
                <label class="mo_wpns_switch" style="float:right">
                    <input type=checkbox>
                    <span class="mo_wpns_slider mo_wpns_round"></span>
                </label> 
            </h3><br><hr  style="margin-top:-1%;">
            <p>Select roles to display the scan report on dashboard. So that they can take action based on it.</p>
            <div>
            <input type="checkbox"  name="role" style="margin-top: 2px;"><label style="margin-right: 5%;line-height: 48px;">Administrator</label>
            <input type="checkbox"  name="role" style="margin-top: 2px;"><label style="margin-right: 5%;">Author</label>
            <input type="checkbox"  name="role" style="margin-top: 2px;"><label style="margin-right: 5%;">Subscriber</label>
            <input type="checkbox"  name="role" style="margin-top: 2px;"><label style="margin-right: 5%;">Contributor</label>
            <input type="checkbox"  name="role" style="margin-top: 2px;"><label >Editor</label>
            </div>
            <br>
            <input type="button"    value="Save" class="mo_wpsn_button" onclick="moblc_report_save()"> 
            <br><br>
        </div>
    </div>
</div>

<script type="text/javascript">
    function moblc_report_save()
    {
        error_msg('Upgrade to Premium');
    }
    function moblc_scan_report_function()
    {
        document.getElementById("moblc_scan_report_div").style.display = "block";
        document.getElementById("moblc_email_report_div").style.display = "none";
        document.getElementById("moblc_report_on_dashboard_div").style.display = "none";

        document.getElementById("moblc_scan_report_sub_tabs").style.background="#20b2aa";
        document.getElementById("moblc_scan_report_sub_tabs").style.color="white";
        document.getElementById("moblc_email_report_sub_tabs").style.background="white";
        document.getElementById("moblc_email_report_sub_tabs").style.color="black";
        document.getElementById("moblc_report_on_dashboard_sub_tabs").style.background="white";
        document.getElementById("moblc_report_on_dashboard_sub_tabs").style.color="black";
    }

    function moblc_email_report_function()
    {
        document.getElementById("moblc_scan_report_div").style.display = "none";
        document.getElementById("moblc_email_report_div").style.display = "block";
        document.getElementById("moblc_report_on_dashboard_div").style.display = "none";

        document.getElementById("moblc_scan_report_sub_tabs").style.background="white";
        document.getElementById("moblc_scan_report_sub_tabs").style.color="black";
        document.getElementById("moblc_email_report_sub_tabs").style.background="#20b2aa";
        document.getElementById("moblc_email_report_sub_tabs").style.color="white";
        document.getElementById("moblc_report_on_dashboard_sub_tabs").style.background="white";
        document.getElementById("moblc_report_on_dashboard_sub_tabs").style.color="black";
    }

    function moblc_report_on_dashboard_function()
    {
        document.getElementById("moblc_scan_report_div").style.display = "none";
        document.getElementById("moblc_email_report_div").style.display = "none";
        document.getElementById("moblc_report_on_dashboard_div").style.display = "block";

        document.getElementById("moblc_scan_report_sub_tabs").style.background="white";
        document.getElementById("moblc_scan_report_sub_tabs").style.color="black";  
        document.getElementById("moblc_email_report_sub_tabs").style.background="white";
        document.getElementById("moblc_email_report_sub_tabs").style.color="black";
        document.getElementById("moblc_report_on_dashboard_sub_tabs").style.background="#20b2aa";
        document.getElementById("moblc_report_on_dashboard_sub_tabs").style.color="white";
    }
</script>