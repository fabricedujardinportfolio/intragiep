<?php	
	
echo'<!--Register with miniOrange-->
	<form name="f" method="post" action="">
		<input type="hidden" name="option" value="moblc_register_customer" />
		<input type="hidden" name="nonce" value='. wp_create_nonce( "moblc-account-nonce" ).' >
		<div class="mo_wpns_divided_layout">
		<div class="mo_wpns_setting_layout" style="margin-bottom:30px;">
			
				<h3>Register with miniOrange</h3>
				<p>Just complete the short registration below to configure miniOrange 2-Factor plugin. Please enter a valid email id that you have access to.</p>
				<table class="mo_wpns_settings_table">
					<tr>
						<td><b><font color="#FF0000">*</font>Email:</b></td>
						<td><input class="mo_wpns_table_textbox" type="email" name="email"
							required placeholder="person@example.com"
							value="'.esc_html($user->user_email).'" /></td>
					</tr>

					<tr>
						<td><b><font color="#FF0000">*</font>Password:</b></td>
						<td><input class="mo_wpns_table_textbox" required type="password"
							name="password" placeholder="Choose your password (Min. length 6)" /></td>
					</tr>
					<tr>
						<td><b><font color="#FF0000">*</font>Confirm Password:</b></td>
						<td><input class="mo_wpns_table_textbox" required type="password"
							name="confirmPassword" placeholder="Confirm your password" /></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td><br /><input type="submit" name="submit" value="Register" style="width:100px;"
							class="mo_wpns_button mo_wpns_button1" />
							<a class="mo_wpns_button mo_wpns_button1" href="#mo2f_account_exist">Existing User? Log In</a>

					</tr>
				</table>
		</div>	
		</div>
	</form>
	 <form name="f" method="post" action="" class="moblc_verify_customerform">
        <input type="hidden" name="option" value="moblc_goto_verifycustomer">
         <input type="hidden" name="nonce" value='. wp_create_nonce( "moblc-account-nonce" ).' >
       </form>';
?>
    <script>
		
        jQuery('a[href=\"#mo2f_account_exist\"]').click(function (e) {
            jQuery('.moblc_verify_customerform').submit();
        });
		
		
		
    </script>