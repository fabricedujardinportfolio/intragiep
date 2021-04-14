<?php
	echo'<div>
				<div id ="moblc_message"></div>
				<div>
				<img  style="float:left;" src="'.esc_url($logo_url).'">					
				</div>
				<div>
				<h1 style="font-weight: 400;">miniOrange Broken Link Checker</h1> &nbsp;
				<a class="add-new-h2" href="'.esc_url($profile_url).'" hidden>Account</a>
				</div>
				<br>
			</div>';
	echo '<a id="moblc_manual" class="nav-tab '.esc_html(($active_tab == 'moblc_manual' 			  
						? 'nav-tab-active' : '')).'" href="'.esc_url($manual_url).'">Broken Link Scan</a>';
	echo '<a id="moblc_scheduled" class="nav-tab '.esc_html(($active_tab == 'moblc_scheduled' 			  
						? 'nav-tab-active' : '')).'" href="'.esc_url($scheduled_url).'"> Scheduled Scan</a>';
	echo '<a id="moblc_deep" class="nav-tab '.esc_html(($active_tab == 'moblc_deep' 			  
						? 'nav-tab-active' : '')).'" href="'.esc_url($deep_url).'">Deep Scan</a>';
	echo '<a id="moblc_report" class="nav-tab '.esc_html(($active_tab == 'moblc_report' 			  
						? 'nav-tab-active' : '')).'" href="'.esc_url($report_url).'">Report</a>';
	echo '<a id="moblc_upgrade" class="nav-tab '.esc_html(($active_tab == 'moblc_upgrade' 			  
						? 'nav-tab-active' : '')).'" href="'.esc_url($upgrade_url).'">Upgrade</a><br><br>';