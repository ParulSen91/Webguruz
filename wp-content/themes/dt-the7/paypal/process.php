<?php
include '../../../../wp-load.php';
                         global $wpdb;
include_once("config.php");
include_once("functions.php");
include_once("paypal.class.php");
	$paypal= new MyPayPal();
	
	print_r($_GET);

	//Post Data received from product list page.
	if($_GET['paypal']=='checkout'){
		//-------------------- prepare products -------------------------
		$uid=$_GET['userID'];
		
		$products = [];
		/*echo $total ="SELECT * FROM wgttgw_orders WHERE id= ".$_GET['userID'];
		echo 'hjhj';
           exit;
		*/
		// set an item via POST request
		
		$products[0]['ItemName'] = $_GET['itemname'];//"Webguruz Packages"; //Item Name
		$products[0]['ItemPrice'] = $_GET['itemprice'];//250; //Item Price   
		$products[0]['ItemQty']	= 1; // Item Quantity
		$name = $_GET['name'];
		$email = $_GET['email'];
		 $tel=$_GET['tel'];
                $u_data = array('name'=>$name,'email'=>$email,'tel'=>$tel,'page'=>$_GET['page'],'pack'=>$_GET['itemname']);
                $user_data = serialize($u_data);
		$products[0]['userInfo'] = $user_data;//$_GET['data'];
		$products[0]['userID'] = $_GET['userID'];
			
		
		//-------------------- prepare charges -------------------------
		
		$charges = [];
		
		//Other important variables like tax, shipping cost
		$charges['TotalTaxAmount'] = 0;  //Sum of tax for all items in this order. 
		$charges['HandalingCost'] = 0;  //Handling cost for this order.
		$charges['InsuranceCost'] = 0;  //shipping insurance cost for this order.
		$charges['ShippinDiscount'] = 0; //Shipping discount for this order. Specify this as negative number.
		$charges['ShippinCost'] = 0; 
		
		$paypal->SetExpressCheckout($products, $charges);		
	}
	if($_GET['token'] !='' && $_GET['PayerID'] !=''){
	
		$paypal->CreateRecurringPaymentsProfile();
	}
	else{
		
		//order form
		

	}
