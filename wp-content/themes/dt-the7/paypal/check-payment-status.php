<?php
//include_once("../connection.php");
include '../../../../wp-load.php';
//require_once WP_CONTENT_DIR . '/new-directory/my-file.php';
require_once 'config.php';
require_once 'functions.php';
require_once 'paypal.class.php';
global $wpdb;
	$paypal= new MyPayPal();
	
	$querys = $wpdb->get_results( "SELECT * FROM wgt_packages_orders" );//$conn->query("SELECT * FROM transaction_details");
       //print_r($querys);
	
foreach($querys as $row) {
		echo $id = $row->id; 
		$profile_id = $row->profileid;
		$oldStatus = $row->status;
		$response = $paypal->CheckRecurringPaymentsProfileDetails($profile_id);
		
		$newStatus = $response['STATUS'];
		date_default_timezone_set('Asia/Kolkata');
		$end_date = date("Y-m-d");		
		if($oldStatus != $newStatus) {
                  $update = $wpdb->update( 'wgt_packages_orders', array( 'status' => $newStatus),array( 'id' => $id ));
			//$update = "UPDATE transaction_details SET status='".$newStatus."' WHERE t_id='".$t_id."'";
			if ($update) {  
				echo "Record updated successfully";
				if($newStatus!="Active" && $newStatus!="Pending") {
                                 $update = $wpdb->update( 'wgt_packages_orders', array( 'end_date' => $end_date),array( 'id' => $id ));
					//$conn->query("UPDATE transaction_details SET end_date='".$end_date."' WHERE t_id='".$t_id."'");
				}
			} else {
				echo "Error updating record: " . $conn->error;
			}
		}
		
	}
