<?php
class MOBLC_Cron
{

    function __construct()
    {
        add_action('moblc_scan_cron_hook', array( $this, 'moblc_scan_cron_hook_exec'          ));
        add_filter('cron_schedules', array( $this, 'moblc_scan_cron_hook_intervals'     ));
    }

    function moblc_scan_cron_hook_exec()
    {
        global $moblc_db_queries;
            $scan_type=$moblc_db_queries->get_option("moblc_scan_message");
        if (!$scan_type) {
            $timestamp = wp_next_scheduled('moblc_scan_cron_hook');
            wp_unschedule_event($timestamp, 'moblc_scan_cron_hook');
        }
        if ($scan_type=='page') {
            $pscan= $moblc_db_queries->get_option("moblc_page_scanning")-1;
            $lscan= $moblc_db_queries->get_option("moblc_link_scanning")-1;
            $this->check_links_from_pages($pscan, $lscan);
        }
    }

    function moblc_scan_cron_hook_intervals($schedules)
    {
        $schedules['max_time'] = array(
        'interval' => 100,
        'display' => __('Once 100 Seconds')
        );
        $schedules['weekly'] = array(
        'interval' => 604800,
        'display' => __('Once Weekly')
        );
        $schedules['monthly'] = array(
            'interval' => 2635200,
            'display' => __('Once a month')
        );
        return $schedules;
    }

    function check_links_from_pages($page_index, $link_index)
    {
        global $moblc_db_queries,$wpdb;
        $linkDetailsTable = $wpdb->prefix.'moblc_link_details_table';
        $query      = "INSERT INTO $linkDetailsTable (`link_hash`,`link`,`page_title`,`status_code`,`loading_time`) VALUES";
        $count      = 0;
        $s_time     = time();
        $pages      = $wpdb->get_results("select `ID` from {$wpdb->prefix}posts where `post_status`='publish'");
        $psize      = sizeof($pages);
        $flag       = false;
        for ($page_index; $page_index < $psize; $page_index++) {
            $moblc_db_queries->update_option('moblc_page_scanning', $page_index+1);
            $page_id = $pages[$page_index]->ID;
            $base    = get_permalink($page_id);
            $content    = $wpdb->get_results("select `post_content`,`post_title` from {$wpdb->prefix}posts where `id`=$page_id");
            $title      = $content[0]->post_title;
            $content    = $content[0]->post_content;
            $links      = preg_split("/<a/", $content);
            $lsize      = sizeof($links);
            $hash_links = array();
            for ($index=0; $index<$lsize; $index++) {
                $link = $links[$index];
                if (strpos($link, "href") !== false) {
                    $link       = preg_replace("/.*\s*href=[\"|']/sm", "", $link);
                    $link       = preg_replace("/[\"|'].*/s", "", $link);
                    $link       = trim($link);
                    if (!empty($link) && $link != '#') {
                        $hash = md5($link);
                        $hash_links [$hash] = $link;
                    }
                }
            }
            $links      = preg_split("/<img/", $content);
            $lsize      = sizeof($links);
            for ($index=0; $index<$lsize; $index++) {
                $link = $links[$index];
                if (strpos($link, "src") !== false) {
                    $link       = preg_replace("/.*\s*src=[\"|']/sm", "", $link);
                    $link       = preg_replace("/[\"|'].*/s", "", $link);
                    $link       = trim($link);
                    if (!empty($link) && $link != '#') {
                        $hash = md5($link);
                        $hash_links [$hash] = $link;
                    }
                }
            }
            $links      = preg_split("/<link/", $content);
            $lsize      = sizeof($links);
            for ($index=0; $index<$lsize; $index++) {
                $link = $links[$index];
                if (strpos($link, "href") !== false) {
                    $link       = preg_replace("/.*\s(.*?)(href=[\"|'])/m", "", $link);
                    $link       = preg_replace("/[\"|'].*/s", "", $link);
                    $link       = trim($link);
                    if (!empty($link) && $link != '#') {
                        $hash = md5($link);
                        $hash_links [$hash] = $link;
                    }
                }
            }
            $links      = preg_split("/<iframe/", $content);
            $lsize      = sizeof($links);
            for ($index=0; $index<$lsize; $index++) {
                $link = $links[$index];
                if (strpos($link, "src") !== false) {
                    $link       = preg_replace("/.*\s(.*?)(src=[\"|'])/m", "", $link);
                    $link       = preg_replace("/[\"|'].*/s", "", $link);
                    $link       = trim($link);
                    if(strpos($link, "/embed/") !== false){
                       list(,$video_id) = explode( '/embed/', $link );
                       $link = 'https://youtube.com/watch?v='.$video_id;                       
                       list($video_id,) = explode( '?', $video_id );
                       $link = 'https://youtube.com/watch?v='.$video_id;
                    }
                    if (!empty($link) && $link != '#') {
                        $hash = md5($link);
                        $hash_links [$hash] = $link;
                    }
                }
            }
            if (sizeof($hash_links)) {
                $hashs  = array_keys($hash_links);
                $lsize  = sizeof($hash_links);
                $moblc_db_queries->update_option('moblc_total_links', $lsize);
                for ($link_index; $link_index<$lsize; $link_index++) {
                    $moblc_db_queries->update_option('moblc_link_scanning', $link_index+1);
                    if ($this->check_time($s_time) || $count >= 10) {
                                $moblc_db_queries->update_option('moblc_page_scanning', $page_index+1);
                                $query = substr($query, 0, -1);
                                $query.=" ON DUPLICATE KEY UPDATE `status_code`= VALUES(status_code);";
                        if ($flag) {
                            $wpdb->query($query);
                        }
                                exit();
                    }
                    $count++;
                    $link_hash = $hashs[$link_index];
                    $link      = $hash_links[$link_hash];
                    if (!empty($link) && filter_var($link, FILTER_VALIDATE_URL)) {
                        $link       = trim(moblc_relative_to_absolute($link, $base));
                        $stime      = time();
                            
                        if (strpos($link, "://youtube") == true || strpos($link, "://www.youtube") == true) {
                            $body       = file_get_contents($link);

                            if (strpos($body, 'Video unavailable') == false) {
                                 $ch = curl_init($link);
                               $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
                               curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                               curl_setopt($ch, CURLOPT_TIMEOUT, 0);
                               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                               curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                               curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
                               $val = curl_exec($ch);
                               $response = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
                                if (isset($response)) {
                                    $status = $response;
                                } else {
                                    $status = 'invalid link';
                                }
                            }else{
                                $status = 404;
                            }
                        } else {
                             $ch = curl_init($link);
                               $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
                               curl_setopt($ch, CURLOPT_USERAGENT, $agent);
                               curl_setopt($ch, CURLOPT_TIMEOUT, 0);
                               curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                               curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
                               $val = curl_exec($ch);
                               $response = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
                               $redirected_url = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
                            if (isset($response)) {
                                $status = $response;
                            } else {
                                $status = 'invalid link';
                            }
                        }

                        $ltime      = time();
                        $time       = ($ltime - $stime).'s';
                        if ($status > 300 ) {
                            if($status>300 && $status<400)
                               $status=$status."-".$redirected_url;
                            $flag = true;
                            $query.=" ('".$link_hash."','".$link."','".$title."','".$status."','".$time."'),";
                        }
                    }
                }
            }
            $link_index = 0;
        }
        $query = substr($query, 0, -1);
        $query.=" ON DUPLICATE KEY UPDATE `status_code`= VALUES(status_code);";
        if ($flag) {
            $wpdb->query($query);
        }
        $timestamp = wp_next_scheduled('moblc_scan_cron_hook');
        wp_unschedule_event($timestamp, 'moblc_scan_cron_hook');
    }

    function check_time($s_time)
    {
        $max_time = ini_get('max_execution_time');
        if (($max_time - (time()-$s_time))<=10) {
            return true;
        }
        return false;
    }
}new MOBLC_Cron;
