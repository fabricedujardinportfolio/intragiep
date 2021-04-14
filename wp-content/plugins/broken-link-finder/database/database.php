<?php
class MOBLC_DATABASE
{
        private $linkDetailsTable;

    function __construct()
    {
        global $wpdb;
        $this->linkDetailsTable     = $wpdb->prefix.'moblc_link_details_table';
        $this->scanStatusTable      = $wpdb->prefix.'moblc_scan_status_table';
    }

    function plugin_activate()
    {
        require_once(ABSPATH . 'wp-admin'.DIRECTORY_SEPARATOR .'includes'.DIRECTORY_SEPARATOR .'upgrade.php');
        $this->generate_tables();
        add_site_option('moblc_activated_time', time());
        update_site_option('moblc_plugin_redirect', true);
    }

    function generate_tables()
    {
        global $wpdb;
            
        $tableName = $this->linkDetailsTable;
        if ($wpdb->get_var("show tables like '$tableName'") != $tableName) {
            $sql = "CREATE TABLE " . $tableName . " (
				`id` bigint NOT NULL AUTO_INCREMENT,
				`link_hash` VARCHAR(40) NOT NULL,
				`link` mediumtext NOT NULL,
				`page_title` mediumtext NOT NULL ,
				`status_code` mediumtext NOT NULL ,
				`loading_time` mediumtext NOT NULL,
					PRIMARY KEY id (id),
					UNIQUE KEY link_hash (link_hash));";
            dbDelta($sql);
        }

        $tableName = $this->scanStatusTable;
        if ($wpdb->get_var("show tables like '$tableName'") != $tableName) {
            $sql = "CREATE TABLE " . $tableName . " (
				`option` VARCHAR(30) NOT NULL UNIQUE,
				`value` mediumtext NOT NULL);";
            dbDelta($sql);
        }
    }

    function update_option($option, $value)
    {
        global $wpdb;
        $sql = "INSERT INTO $this->scanStatusTable (`option`,`value`) VALUES('".$option."','".$value."') ON DUPLICATE KEY UPDATE `value` ='".$value."'";
        $wpdb->query($sql);
        return;
    }


    function get_option($option)
    {
        global $wpdb;
        $sql = "SELECT `value` FROM $this->scanStatusTable WHERE `option` like '".$option."'";
        $result = $wpdb->get_results($sql);
        if (sizeof($result)>0) {
            return $result[0]->value;
        } else {
            return false;
        }
    }


    function delete_option($option)
    {
        global $wpdb;
        $sql = "DELETE FROM $this->scanStatusTable WHERE `option` like '".$option."'";
        $wpdb->query($sql);
        return;
    }
    function get_column_names($table)
    {
        global $wpdb;
        $table = $wpdb->prefix.$table;
        return $existing_columns = $wpdb->get_col("DESC ".$table, 0);
    }

    function get_table_data($table)
    {
        global $wpdb;
        $table = $wpdb->prefix.$table;
        return $wpdb->get_results("SELECT * FROM ".$table." order by `id`");
    }

    function count_of_pages()
    {
        global $wpdb;
        $pages      = $wpdb->get_results("select `ID` from {$wpdb->prefix}posts where `post_status`='publish'");
        $n          =   sizeof($pages);
        $this->update_option('moblc_total_pages', $n);
        if ($n>0) {
            return true;
        } else {
            return false;
        }
    }

    function delete_history()
    {
        global $wpdb;
        $sql = "TRUNCATE $this->linkDetailsTable";
        $wpdb->query($sql);
        return;
    }

    function count_broken_links()
    {
        global $wpdb;
        $sql = "SELECT COUNT(*) from $this->linkDetailsTable WHERE `status_code` not like \"3%\"";
        return $wpdb->get_var($sql);
    }
}
