<?php 
ob_start();
$status = $_POST['status'];
$statusdetails = $_POST['statusdetails'];
$textarea = $_POST['textarea'];
$vid = $_POST['vid'];
$amount = $_POST['amount'];

$arr = array(
            'properties' => array(
               array(
                    'property' => 'lead_status_comment',
                    'value' => $textarea
                ),
               array(
                    'property' => 'lead_status_details',
                    'value' => $statusdetails
                ),
               array(
                    'property' => 'reporting_lead_status',
                    'value' => $status
                ),
               array(
                    'property' => 'listed_amount',
                    'value' => $amount
                )

            )
        );
        $post_json = json_encode($arr);
        $hapikey = '3f6591c7-fbb3-4d6c-904d-93888e0df23a';
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact/vid/'.$vid.'/profile?hapikey=' . $hapikey;
        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
        $response = array("Errors"=>$curl_errors,"Status"=>$status_code,"Response"=>$response);
        //echo "curl Errors: " . $curl_errors;
        //echo "\nStatus code: " . $status_code;
        //echo "\nResponse: " . $response; 
       print_r(json_encode($response));
?>
