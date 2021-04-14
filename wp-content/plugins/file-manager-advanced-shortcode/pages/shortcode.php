<?php
wp_enqueue_script('jquery');
 $fma_adv = '<input type="hidden" name="_fmakey" id="fmakey" value="'. wp_create_nonce( 'fmaskey' ).'">';

 $shortcodeAtts = shortcode_atts( array(
        'login' => 'yes',
        'roles' => 'all',
        'path' => '%',
		'url' => '',
		'path_type' => 'inside',
		'write' => 'false',
		'read' => 'true',
		'hide' => '',
		'operations' => 'all',
		'block_users' => '',
		'view' => 'grid',
		'theme' => 'light',
		'lang' => 'en',
		'dateformat' => 'M d, Y h:i A',
		'hide_path' =>  'no',
		'enable_trash' => 'no',
		'height' => '',
		'width' => '',
		'ui' => '',
    ), $atts );

				 $elfCss = [
					'commands.css',
					'common.css',
					'contextmenu.css',
					'cwd.css',
					'dialog.css',
					'fonts.css',
					'navbar.css',
					'quicklook.css',
					'statusbar.css',
					'toast.css',
					'toolbar.css'
				];

			wp_enqueue_style( 'query-ui-1.12.0', plugins_url('library/jquery/jquery-ui-1.12.0.css', fma_file));

			foreach($elfCss as $elCss) {
				wp_enqueue_style( $elCss, plugins_url('library/css/'.$elCss.'', fma_file));	
			}
			wp_enqueue_style( 'fma_theme', plugins_url('library/css/theme.css', fma_file));
			if(isset($shortcodeAtts['theme']) && $shortcodeAtts ['theme'] == 'dark') {
			  wp_enqueue_style( 'fma_themee', plugins_url('library/themes/dark/css/theme.css', fma_file));
			}
			else if(isset($shortcodeAtts['theme']) && $shortcodeAtts ['theme'] == 'grey') {
			  wp_enqueue_style( 'fma_themee', plugins_url('library/themes/grey/css/theme.css', fma_file));
			}
			else if(isset($shortcodeAtts['theme']) && $shortcodeAtts ['theme'] == 'windows10') {
			  wp_enqueue_style( 'fma_themee', plugins_url('library/themes/windows10/css/theme.css', fma_file));
			}
			 else if(isset($shortcodeAtts['theme']) && $shortcodeAtts ['theme'] == 'bootstrap') {
			  wp_enqueue_style( 'fma_themee', plugins_url('library/themes/bootstrap/css/theme.css', fma_file));
			}
			wp_enqueue_style( 'fma_custom', plugins_url('library/css/custom_style_filemanager_advanced.css', fma_file));

			wp_enqueue_script( 'afm-jquery-1.12.4', plugins_url('library/jquery/jquery-1.12.4.js', fma_file));

			wp_enqueue_script( 'afm-jquery-ui-1.12.0', plugins_url('library/jquery/jquery-ui-1.12.0.js', fma_file));
		
			wp_enqueue_script( 'afm-elFinder', plugins_url('library/js/elFinder.js', fma_file));
			wp_enqueue_script( 'afm-elFinder.version', plugins_url('library/js/elFinder.version.js', fma_file));
			wp_enqueue_script( 'afm-jquery.elfinder', plugins_url('library/js/jquery.elfinder.js', fma_file));
			wp_enqueue_script( 'afm-elFinder.mimetypes', plugins_url('library/js/elFinder.mimetypes.js', fma_file));
			wp_enqueue_script( 'afm-elFinder.options', plugins_url('library/js/elFinder.options.js', fma_file));
			wp_enqueue_script( 'afm-elFinder.options.netmount', plugins_url('library/js/elFinder.options.netmount.js', fma_file));
			wp_enqueue_script( 'afm-elFinder.history', plugins_url('library/js/elFinder.history.js', fma_file));
			wp_enqueue_script( 'afm-elFinder.command', plugins_url('library/js/elFinder.command.js', fma_file));
			wp_enqueue_script( 'afm-elFinder.resources', plugins_url('library/js/elFinder.resources.js', fma_file));
		
			wp_enqueue_script( 'afm-jquery.dialogelfinder', plugins_url('library/js/jquery.dialogelfinder.js', fma_file));
		

			wp_enqueue_script( 'afm-button', plugins_url('library/js/ui/button.js', fma_file));
			wp_enqueue_script( 'afm-contextmenu', plugins_url('library/js/ui/contextmenu.js', fma_file));
			wp_enqueue_script( 'afm-cwd', plugins_url('library/js/ui/cwd.js', fma_file));
			wp_enqueue_script( 'afm-dialog', plugins_url('library/js/ui/dialog.js', fma_file));
			wp_enqueue_script( 'afm-fullscreenbutton', plugins_url('library/js/ui/fullscreenbutton.js', fma_file));
			wp_enqueue_script( 'afm-navbar', plugins_url('library/js/ui/navbar.js', fma_file));
			wp_enqueue_script( 'afm-navdock', plugins_url('library/js/ui/navdock.js', fma_file));
			wp_enqueue_script( 'afm-overlay', plugins_url('library/js/ui/overlay.js', fma_file));
			wp_enqueue_script( 'afm-panel', plugins_url('library/js/ui/panel.js', fma_file));
			wp_enqueue_script( 'afm-path', plugins_url('library/js/ui/path.js', fma_file));
			//wp_enqueue_script( 'afm-places', plugins_url('library/js/ui/places.js', fma_file));
			wp_enqueue_script( 'afm-searchbutton', plugins_url('library/js/ui/searchbutton.js', fma_file));
			wp_enqueue_script( 'afm-sortbutton', plugins_url('library/js/ui/sortbutton.js', fma_file));
			wp_enqueue_script( 'afm-stat', plugins_url('library/js/ui/stat.js', fma_file));
			wp_enqueue_script( 'afm-toast', plugins_url('library/js/ui/toast.js', fma_file));
			wp_enqueue_script( 'afm-toolbar', plugins_url('library/js/ui/toolbar.js', fma_file));
			wp_enqueue_script( 'afm-tree', plugins_url('library/js/ui/tree.js', fma_file));
			wp_enqueue_script( 'afm-uploadButton', plugins_url('library/js/ui/uploadButton.js', fma_file));
			wp_enqueue_script( 'afm-viewbutton', plugins_url('library/js/ui/viewbutton.js', fma_file));
			wp_enqueue_script( 'afm-workzone', plugins_url('library/js/ui/workzone.js', fma_file));
		

			wp_enqueue_script( 'afm-archive', plugins_url('library/js/commands/archive.js', fma_file));
			wp_enqueue_script( 'afm-back', plugins_url('library/js/commands/back.js', fma_file));
			wp_enqueue_script( 'afm-chmod', plugins_url('library/js/commands/chmod.js', fma_file));
			wp_enqueue_script( 'afm-colwidth', plugins_url('library/js/commands/colwidth.js', fma_file));
			wp_enqueue_script( 'afm-copy', plugins_url('library/js/commands/copy.js', fma_file));
			wp_enqueue_script( 'afm-cut', plugins_url('library/js/commands/cut.js', fma_file));
			wp_enqueue_script( 'afm-download', plugins_url('library/js/commands/download.js', fma_file));
			wp_enqueue_script( 'afm-duplicate', plugins_url('library/js/commands/duplicate.js', fma_file));
			wp_enqueue_script( 'afm-edit', plugins_url('library/js/commands/edit.js', fma_file));
			wp_enqueue_script( 'afm-empty', plugins_url('library/js/commands/empty.js', fma_file));
			wp_enqueue_script( 'afm-extract', plugins_url('library/js/commands/extract.js', fma_file));
			wp_enqueue_script( 'afm-forward', plugins_url('library/js/commands/forward.js', fma_file));
			wp_enqueue_script( 'afm-fullscreen', plugins_url('library/js/commands/fullscreen.js', fma_file));
			wp_enqueue_script( 'afm-getfile', plugins_url('library/js/commands/getfile.js', fma_file));
			wp_enqueue_script( 'afm-help', plugins_url('library/js/commands/help.js', fma_file));
			wp_enqueue_script( 'afm-hidden', plugins_url('library/js/commands/hidden.js', fma_file));
			//wp_enqueue_script( 'afm-hide', plugins_url('library/js/commands/hide.js', fma_file));
			wp_enqueue_script( 'afm-home', plugins_url('library/js/commands/home.js', fma_file));
			wp_enqueue_script( 'afm-info', plugins_url('library/js/commands/info.js', fma_file));
			wp_enqueue_script( 'afm-mkdir', plugins_url('library/js/commands/mkdir.js', fma_file));
			wp_enqueue_script( 'afm-mkfile', plugins_url('library/js/commands/mkfile.js', fma_file));
			wp_enqueue_script( 'afm-netmount', plugins_url('library/js/commands/netmount.js', fma_file));
			wp_enqueue_script( 'afm-open', plugins_url('library/js/commands/open.js', fma_file));
			wp_enqueue_script( 'afm-opendir', plugins_url('library/js/commands/opendir.js', fma_file));
			wp_enqueue_script( 'afm-opennew', plugins_url('library/js/commands/opennew.js', fma_file));
			wp_enqueue_script( 'afm-paste', plugins_url('library/js/commands/paste.js', fma_file));
			wp_enqueue_script( 'afm-quicklook', plugins_url('library/js/commands/quicklook.js', fma_file));
			wp_enqueue_script( 'afm-quicklook.plugins', plugins_url('library/js/commands/quicklook.plugins.js', fma_file));
			wp_enqueue_script( 'afm-reload', plugins_url('library/js/commands/reload.js', fma_file));
			wp_enqueue_script( 'afm-rename', plugins_url('library/js/commands/rename.js', fma_file));
			wp_enqueue_script( 'afm-resize', plugins_url('library/js/commands/resize.js', fma_file));
			wp_enqueue_script( 'afm-restore', plugins_url('library/js/commands/restore.js', fma_file));
			wp_enqueue_script( 'afm-rm', plugins_url('library/js/commands/rm.js', fma_file));
			wp_enqueue_script( 'afm-search', plugins_url('library/js/commands/search.js', fma_file));
			wp_enqueue_script( 'afm-selectall', plugins_url('library/js/commands/selectall.js', fma_file));
			wp_enqueue_script( 'afm-selectinvert', plugins_url('library/js/commands/selectinvert.js', fma_file));
			wp_enqueue_script( 'afm-selectnone', plugins_url('library/js/commands/selectnone.js', fma_file));
			wp_enqueue_script( 'afm-sort', plugins_url('library/js/commands/sort.js', fma_file));
			wp_enqueue_script( 'afm-undo', plugins_url('library/js/commands/undo.js', fma_file));
			wp_enqueue_script( 'afm-up', plugins_url('library/js/commands/up.js', fma_file));
			wp_enqueue_script( 'afm-upload', plugins_url('library/js/commands/upload.js', fma_file));
			wp_enqueue_script( 'afm-view', plugins_url('library/js/commands/view.js', fma_file));
			wp_enqueue_script( 'afm-quicklook.googledocs', plugins_url('library/js/extras/quicklook.googledocs.js', fma_file));

			if(isset($shortcodeAtts['lang'])) {
				$locale = $shortcodeAtts['lang'];
				 wp_enqueue_script( 'fma_lang', plugins_url('library/js/i18n/elfinder.'.$locale.'.js', fma_file));
			   }

			wp_enqueue_script( 'codemirror', plugins_url('library/codemirror/lib/codemirror.js',  fma_file ));
			wp_enqueue_style( 'codemirror', plugins_url('library/codemirror/lib/codemirror.css', fma_file));
			wp_enqueue_script( 'htmlmixed', plugins_url('library/codemirror/mode/htmlmixed/htmlmixed.js',  fma_file ));
			wp_enqueue_script( 'xml', plugins_url('library/codemirror/mode/xml/xml.js',  fma_file ));
			wp_enqueue_script( 'css', plugins_url('library/codemirror/mode/css/css.js',  fma_file ));
			wp_enqueue_script( 'javascript', plugins_url('library/codemirror/mode/javascript/javascript.js',  fma_file ));
			wp_enqueue_script( 'clike', plugins_url('library/codemirror/mode/clike/clike.js',  fma_file ));
			wp_enqueue_script( 'php', plugins_url('library/codemirror/mode/php/php.js',  fma_file ));	
		 
wp_register_script( "fma-shortcode-js", plugins_url('js/shortcode.js', dirname( __FILE__ ) ), array('jquery') );
wp_localize_script( 'fma-shortcode-js', 'fmaatts', array(
	'ajaxurl' => admin_url('admin-ajax.php'),
	'lang' => (isset($shortcodeAtts['lang']) && !empty($shortcodeAtts['lang'])) ? $shortcodeAtts['lang'] : 'en',
	'view' => (isset($shortcodeAtts['view']) && !empty($shortcodeAtts['view'])) ? $shortcodeAtts['view'] : 'grid',
	'dateformat' => (isset($shortcodeAtts['dateformat']) && !empty($shortcodeAtts['dateformat'])) ? $shortcodeAtts['dateformat'] : 'M d, Y h:i A',
    'action'=> 'fma_load_shortcode_fma_ui',
	'fmakey' =>  wp_create_nonce('fmaskey'),
	'path' => $shortcodeAtts['path'],
	'url' =>  $shortcodeAtts['url'],
    'w' => $shortcodeAtts['write'],
	'r' => $shortcodeAtts['read'],
	 'hide' => $shortcodeAtts['hide'],
	 'operations' => $shortcodeAtts['operations'],
	  'path_type' => $shortcodeAtts['path_type'],
	  'hide_path' => $shortcodeAtts['hide_path'],
	  'enable_trash' => $shortcodeAtts['enable_trash'],
	  'height' => $shortcodeAtts['height'],
	  'width' => $shortcodeAtts['width'],
	  'ui' => $shortcodeAtts['ui']
	)
);        
wp_enqueue_script( 'fma-shortcode-js' );

if($shortcodeAtts['login'] == 'yes') {
if(is_user_logged_in()) {
   global $wp_roles;
   $current_user = wp_get_current_user();
$uid = $current_user->ID;
			$user = new WP_User( $uid );
			/*if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
				foreach ( $user->roles as $role ):
					$role;
				endforeach;
			}*/
	$roles = $shortcodeAtts['roles'];
if(empty($roles)){
 $roles = array();
}
else if($roles == 'all')
{
 $roles = array();
   $roless = $wp_roles->get_names();
	foreach($roless as $key => $mkrole)
	{
		$roles[] = $key;
	}
}
else if($roles != 'all')
{
  $roles = explode(',',$roles);
}
$fma_permission = false;
$fma_intersect = array_intersect($user->roles,$roles);
if(count($fma_intersect) > 0) {
	$fma_permission = true;
}
$block_users = $shortcodeAtts['block_users'];
if(empty($block_users))
{
 $block_users_Array = array('-1' => '-1');
}
else
{
$block_users_Array = explode(',', $block_users);
}
  if($fma_intersect && !in_array($uid, $block_users_Array)){
   $fma_adv .= '<div id="file_manager_advanced"></div>';
} else {
    $fma_adv .= 'Permissions Denied!';
}
 } else {
	$fma_adv .= '<strong>Login to access file manager. <a href="'.site_url().'/wp-login.php?redirect_to='.get_permalink().'&reauth=1" class="button">Click To Login</a></strong>';
 }
 } else {
	  $fma_adv .= '<div id="file_manager_advanced"></div>';

 }
 ?>