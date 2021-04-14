<?php
/**
  Plugin Name: File Manager Advanced Shortcode
  Plugin URI: https://advancedfilemanager.com/product/file-manager-advanced-shortcode-wordpress/
  Description: Shortcodes for advanced file manager
  Author: modalweb
  Version: 2.2
  Author URI: https://advancedfilemanager.com/
**/
define('fmas_file',__FILE__);
define('fmas_ver','2.2');
if(!class_exists('file_manager_advanced_shortcode')) {
class file_manager_advanced_shortcode {
	var $ver = '2.2';
    /* constructor */
	public function __construct() {
       add_action( 'init', array($this,'file_manager_advanced_directory'));
	   add_shortcode('file_manager_advanced',array($this,'file_manager_advanced_return'));
	   add_action( 'init', array(&$this,'fma_shortcode_updates'));
       add_shortcode( 'fma_user_role', array($this,'fma_check_user_role'));
       add_shortcode( 'fma_user', array($this,'fma_check_user'));
	}
    /* shortcode */
	public function file_manager_advanced_return($atts) {
    if(class_exists('class_fma_shortcode') && !is_admin()) {
		include('pages/shortcode.php');
		return $fma_adv;
    } else {
       $plugin_url_text = '<strong>Please install <a href="https://wordpress.org/plugins/file-manager-advanced/"> File Manager Advanced </a> Plugin to make shortcode work.</strong>';
       return $plugin_url_text;
    }
    }
    /* Directory */
    public function file_manager_advanced_directory() {
         if(is_user_logged_in()) {
                    $current_user = wp_get_current_user();
                    $upload_dir   = wp_upload_dir();
                    if ( isset( $current_user->user_login ) && ! empty( $upload_dir['basedir'] ) ) {
                        $user_dirname = $upload_dir['basedir'].'/file-manager-advanced/users/'.$current_user->user_login;
                            if ( ! file_exists( $user_dirname ) ) {
                              wp_mkdir_p( $user_dirname );
                        }
                    }
              }
    }
	/* User Role Shortcode */
	// use: [fma_user_role role="subscriber, author"]shortcode[/fma_user_role]
	public function fma_check_user_role( $atts, $content = null ) {
        extract( shortcode_atts( array(
                'role' => 'role' ), $atts ) );
        $user = wp_get_current_user();
        $roles = explode(',', $role);
        $allowed_roles = $roles;
        if( array_intersect($allowed_roles, $user->roles ) ) {
                return apply_filters('the_content',$content);
        }
   }
   /* User Shortcode */
	// use: [fma_user user="1,2"]shortcode[/fma_user]
	public function fma_check_user( $atts, $content = null ) {
        extract( shortcode_atts( array(
                'user' => 'user' ), $atts ) );
        $cuser = wp_get_current_user();
        $users = explode(',', $user);
        $allowed_users = $users;
        if( in_array($cuser->ID, $allowed_users ) ) {
                return apply_filters('the_content',$content);
        }
   }
	   public function fma_shortcode_updates()
	   {
		    $path = $_SERVER['REQUEST_URI'];
			$file = basename($path, ".php");
			$file_name = explode('?', $file);
			if(($file_name[0] == 'plugins.php') || ($file_name[0] == 'plugins')) {
		    require_once ( 'upgrade/upgrade.php');
			$fma_plugin_current_version = $this->ver;
			$fma_plugin_remote_path = 'http://modalwebstore.com/upgrade/';
			$fma_plugin_slug = plugin_basename( __FILE__ );
			$fma_license_order = '1';
			$fma_license_key = 'success';
		      new file_manager_advanced_shortcode_updates( $fma_plugin_current_version, $fma_plugin_remote_path, $fma_plugin_slug, $fma_license_order, $fma_license_key );
			}
	   }
	}
new file_manager_advanced_shortcode;
}