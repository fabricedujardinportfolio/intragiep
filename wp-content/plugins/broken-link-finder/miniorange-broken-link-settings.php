<?php
/**
 * Plugin Name: miniOrange Broken Link Checker/Finder
 * Description: Simple & user friendly Plugin. This plugin provides features like broken link checker, loading time of the pages, report of broken link in csv/xml format, etc.
 * Version: 2.0.1
 * Author: miniOrange
 * Author URI: https://miniorange.com
 * License: GPL2
 */

    define('MOBLC_HOST_NAME', 'https://login.xecurify.com');
    define('MOBLC_VERSION', '2.0.1');
    define('MOBLC_TEST_MODE', false);

class MOBLC
{

    function __construct()
    {
        register_deactivation_hook(__FILE__, array( $this, 'moblc_deactivate'           ));
        register_activation_hook(__FILE__, array( $this, 'moblc_activate'             ));
        add_action('admin_menu', array( $this, 'moblc_widget_menu'          ));
        add_action('admin_enqueue_scripts', array( $this, 'moblc_settings_style'       ));
        add_action('admin_enqueue_scripts', array( $this, 'moblc_settings_script'      ));
        add_action('moblc_show_message', array( $this, 'moblc_show_message'         ), 1, 2);
        add_action('admin_footer', array( $this, 'moblc_feedback_request'     ));
        add_action( 'admin_init', array( $this, 'moblc_auth_save_settings' ) );
        $this->moblc_includes();
    }

    function moblc_auth_save_settings()
    {
        if (get_site_option('moblc_plugin_redirect')) {
            delete_site_option('moblc_plugin_redirect');
            wp_redirect(admin_url() . 'admin.php?page=moblc_manual');
            exit;
        }
    }
    function moblc_widget_menu()
    {
        $menu_slug =  'moblc_manual';

        add_menu_page('Broken Link Checker', 'Broken Link Checker', 'activate_plugins', $menu_slug, array( $this, 'moblc'), plugin_dir_url(__FILE__) . 'includes'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'miniorange_icon.png');

        add_submenu_page($menu_slug, 'Broken Link Checker', 'Broken Link Scan', 'administrator', 'moblc_manual', array( $this, 'moblc'), 1);
        add_submenu_page($menu_slug, 'Broken Link Checker', 'Scheduled Scan', 'administrator', 'moblc_scheduled', array( $this, 'moblc'), 2);
        add_submenu_page($menu_slug, 'Broken Link Checker', 'Deep Scan', 'administrator', 'moblc_deep', array( $this, 'moblc'), 3);
        add_submenu_page($menu_slug, 'Broken Link Checker', 'Report', 'administrator', 'moblc_report', array( $this, 'moblc'), 4);
        add_submenu_page($menu_slug, 'Broken Link Checker', 'Upgrade', 'administrator', 'moblc_upgrade', array( $this, 'moblc'), 5);
    }


    function moblc()
    {
        include 'controllers'.DIRECTORY_SEPARATOR.'main_controller.php';
    }

    function moblc_activate()
    {
        if (is_network_admin()) {
            wp_die(__('Site Admin can activate the plugin.'));
        }
        global $moblc_db_queries;
        $moblc_db_queries->plugin_activate();
        update_site_option('moblc_update_on_actiate', 1);
    }

    function moblc_deactivate()
    {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}moblc_link_details_table");
        $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}moblc_scan_status_table");
        delete_site_option('moblc_activated_time');
    }

    function moblc_settings_style($hook)
    {
        if (strpos($hook, 'page_moblc')) {
            wp_enqueue_style('moblc_admin_settings_style', plugins_url('includes'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'style_settings.css', __FILE__));
            wp_enqueue_style('moblc_admin_settings_datatable_style', plugins_url('includes'.DIRECTORY_SEPARATOR.'css'.DIRECTORY_SEPARATOR.'jquery.dataTables.min.css', __FILE__));
        }
    }

    function moblc_settings_script($hook)
    {
        wp_enqueue_script('moblc_admin_settings_script', plugins_url('includes'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'settings_page.js', __FILE__), array('jquery'));
        if (strpos($hook, 'page_moblc')) {
            wp_enqueue_script('moblc_admin_datatable_script', plugins_url('includes'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'jquery.dataTables.min.js', __FILE__), array('jquery'));
        }
    }

    function moblc_includes()
    {
        require('handler'.DIRECTORY_SEPARATOR.'cron.php');
        require('controllers'.DIRECTORY_SEPARATOR.'ajax.php');
        require('database'.DIRECTORY_SEPARATOR.'database.php');
        require('api'.DIRECTORY_SEPARATOR.'api.php');
        require('helper'.DIRECTORY_SEPARATOR.'constants.php');
        require('helper'.DIRECTORY_SEPARATOR.'messages.php');
        require('helper'.DIRECTORY_SEPARATOR.'remote_methods.php');
        require('helper'.DIRECTORY_SEPARATOR.'utility.php');
        require('handler'.DIRECTORY_SEPARATOR.'feedback_form.php');
    }

    function moblc_show_message($content, $type)
    {
        if ($type=="CUSTOM_MESSAGE") {
              echo "<div class='overlay_not_JQ_success' id='pop_up_success'><p class='popup_text_not_JQ'>".esc_html($content)."</p> </div>";
            ?>
                <script type="text/javascript">
                 setTimeout(function () {
                    var element = document.getElementById("pop_up_success");
                       element.classList.toggle("overlay_not_JQ_success");
                       element.innerHTML = "";
                        }, 4000);
                        
                </script>
                <?php
        }
        if ($type=="NOTICE") {
               echo "<div class='overlay_not_JQ_error' id='pop_up_error'><p class='popup_text_not_JQ'>".esc_html($content)."</p> </div>";
            ?>
                <script type="text/javascript">
                 setTimeout(function () {
                    var element = document.getElementById("pop_up_error");
                       element.classList.toggle("overlay_not_JQ_error");
                       element.innerHTML = "";
                        }, 4000);
                        
                </script>
                <?php
        }
        if ($type=="ERROR") {
            echo "<div class='overlay_not_JQ_error' id='pop_up_error'><p class='popup_text_not_JQ'>".esc_html($content)."</p> </div>";
            ?>
                <script type="text/javascript">
                 setTimeout(function () {
                    var element = document.getElementById("pop_up_error");
                       element.classList.toggle("overlay_not_JQ_error");
                       element.innerHTML = "";
                        }, 4000);
                        
                </script>
                   <?php
        }
        if ($type=="SUCCESS") {
            echo "<div class='overlay_not_JQ_success' id='pop_up_success'><p class='popup_text_not_JQ'>".esc_html($content)."</p> </div>";
            ?>
                    <script type="text/javascript">
                     setTimeout(function () {
                        var element = document.getElementById("pop_up_success");
                           element.classList.toggle("overlay_not_JQ_success");
                           element.innerHTML = "";
                            }, 4000);
                            
                    </script>
            <?php
        }
    }

    function moblc_feedback_request()
    {
        if ('plugins.php' != basename($_SERVER['PHP_SELF'])) {
            return;
        }
        global $moblc_dirname;

        $email = get_option("mo2f_email");
        if (empty($email)) {
            $user = wp_get_current_user();
            $email = $user->user_email;
        }
        $imagepath=plugins_url('/includes/images/', __FILE__);
        wp_enqueue_style('wp-pointer');
        wp_enqueue_script('wp-pointer');
        wp_enqueue_script('utils');
        wp_enqueue_style('moblc_admin_plugins_page_style', plugins_url('/includes/css/feedback_style.css?ver=4.8.60', __FILE__));

        include $moblc_dirname . 'views'.DIRECTORY_SEPARATOR.'feedback_form.php';
    }
}new MOBLC;