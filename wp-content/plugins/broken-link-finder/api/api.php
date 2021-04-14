<?php

class MOBLC_Api
{

    public static function wp_remote_post($url, $args = array()){
        $response = wp_remote_post($url, $args);
        if(!is_wp_error($response)){
            return $response['body'];
        } else {
            $message = 'Please enable curl extension. <a href="admin.php?page=mo_2fa_troubleshooting">Click here</a> for the steps to enable curl.';

            return json_encode( array( "status" => 'ERROR', "message" => $message ) );
        }
    }

    public static function make_curl_call( $url, $fields, $http_header_array =array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic")) {
        if ( gettype( $fields ) !== 'string' ) {
            $fields = json_encode( $fields );
        }

        $args = array(
            'method' => 'POST',
            'body' => $fields,
            'timeout' => '5',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $http_header_array
        );

        $response = self::wp_remote_post($url, $args);
        return $response;

    }


    public static function get_customer_key($email, $password) 
    {
        $url    = MOBLC_Constants::HOST_NAME. "/moas/rest/customer/key";
        $fields = array (
                    'email'     => $email,
                    'password'  => $password
                );
        $json       = json_encode($fields);
        $response   = self::make_curl_call($url, $json);
        return $response;
    }

    function check_customer($email)
    {
        $url    = MOBLC_Constants::HOST_NAME . "/moas/rest/customer/check-if-exists";
        $fields = array(
                    'email'     => $email,
                );
        $json     = json_encode($fields); 
        $response = self::make_curl_call($url, $json);
        return $response;
    }

    public static function create_customer($email, $company, $password, $phone = '', $first_name = '', $last_name = '')
    {
        $url = MOBLC_Constants::HOST_NAME . '/moas/rest/customer/add';
        $fields = array (
            'companyName'    => $company,
            'areaOfInterest' => 'Broken Link Finder',
            'firstname'      => $first_name,
            'lastname'       => $last_name,
            'email'          => $email,
            'phone'          => $phone,
            'password'       => $password
        );
        $json = json_encode($fields); 
        $response = self::make_curl_call($url, $json);
        return $response;
    }

   function submit_contact_us( $q_email, $q_phone, $query )
    {
        $current_user = wp_get_current_user();
        $url          = MOBLC_Constants::HOST_NAME . "/moas/rest/customer/contact-us";
        global $mowafutility;
        $query = '[Broken Link Checker | Finder -V '.MOBLC_VERSION.']: ' . $query;
        
        $fields = array(
                    'firstName' => $current_user->user_firstname,
                    'lastName'  => $current_user->user_lastname,
                    'company'   => $_SERVER['SERVER_NAME'],
                    'email'     => $q_email,
                    'ccEmail'   => '2fasupport@xecurify.com',
                    'phone'     => $q_phone,
                    'query'     => $query
                );
        $field_string = json_encode( $fields );
        $response = self::make_curl_call($url, $field_string);
        return $response;
    }

    function send_email_alert($email,$phone,$message,$feedback_option){
        global $user;
        $url = MOBLC_Constants::HOST_NAME . '/moas/api/notify/send';
        $customerKey = MOBLC_Constants::DEFAULT_CUSTOMER_KEY;
        $apiKey      = MOBLC_Constants::DEFAULT_API_KEY;
        $fromEmail   = 'no-reply@xecurify.com';
        if ($feedback_option == 'moblc_skip_feedback') 
        {
            $subject = "Deactivate [Feedback Skipped]: Broken Link Checker/Finder";
        }
        elseif ($feedback_option == 'moblc_feedback') 
        {
            $subject = "Feedback: WordPress Broken Link Checker/Finder - ". $email;
        }

        $user  = wp_get_current_user();
        $query = '[WordPress Broken Link Checker/Finder Plugin: - V '.MOBLC_VERSION.']: ' . $message;


        $content='<div >Hello, <br><br>First Name :'.$user->user_firstname.'<br><br>Last  Name :'.$user->user_lastname.'   <br><br>Company :<a href="'.$_SERVER['SERVER_NAME'].'" target="_blank" >'.$_SERVER['SERVER_NAME'].'</a><br><br>Phone Number :'.$phone.'<br><br>Email :<a href="mailto:'.$email.'" target="_blank">'.$email.'</a><br><br>Query :'.$query.'</div>';


        $fields = array(
            'customerKey'   => $customerKey,
            'sendEmail'     => true,
            'email'         => array(
                'customerKey'   => $customerKey,
                'fromEmail'     => $fromEmail,
                'fromName'      => 'Xecurify',
                'toEmail'       => '2fasupport@xecurify.com',
                'toName'        => '2fasupport@xecurify.com',
                'subject'       => $subject,
                'content'       => $content
            ),
        );

        $field_string = json_encode($fields);
        $authHeader   = $this->createAuthHeader($customerKey,$apiKey);
        $response     = self::make_curl_call($url, $field_string,$authHeader);
        return $response;

    }

    function createAuthHeader($customerKey, $apiKey) {
        $currentTimestampInMillis = round(microtime(true) * 1000);
        $currentTimestampInMillis = number_format($currentTimestampInMillis, 0, '', '');

        /* Creating the Hash using SHA-512 algorithm */
        $stringToHash   = $customerKey . $currentTimestampInMillis . $apiKey;;
        $hashValue      = hash( "sha512", $stringToHash );

        $headers = array(
            "Content-Type"  => "application/json",
            "Customer-Key"  => $customerKey,
            "Timestamp"     => $currentTimestampInMillis,
            "Authorization" => $hashValue
        );

        return $headers;
    }
}