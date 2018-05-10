<?php 

	class MyPayPal {
		
		function GetItemTotalPrice($item){
		
			//(Item Price x Quantity = Total) Get total amount of product;
			return $item['ItemPrice'] * $item['ItemQty']; 
		}
		
		function GetProductsTotalAmount($products){
		
			$ProductsTotalAmount=0;

			foreach($products as $p => $item){
				
				$ProductsTotalAmount = $ProductsTotalAmount + $this -> GetItemTotalPrice($item);	
			}
			
			return $ProductsTotalAmount;
		}
		
		function GetGrandTotal($products, $charges){
			
			//Grand total including all tax, insurance, shipping cost and discount
			
			$GrandTotal = $this -> GetProductsTotalAmount($products);
			
			foreach($charges as $charge){
				
				$GrandTotal = $GrandTotal + $charge;
			}
			
			return $GrandTotal;
		}
		
		function SetExpressCheckout($products, $charges, $noshipping='1'){
			
			//Parameters for SetExpressCheckout, which will be sent to PayPal
			
			$padata  = 	'&METHOD=SetExpressCheckout';
			
			$padata .= 	'&RETURNURL='.urlencode(PPL_RETURN_URL);
			$padata .=	'&CANCELURL='.urlencode('https://www.webguruz.in/cancel/');
			$padata .=	'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE");
			
			$padata .=	'&L_BILLINGTYPE0='.urlencode("RecurringPayments");
			$padata .=	'&L_BILLINGAGREEMENTDESCRIPTION0='.urlencode("Membership");
			
			foreach($products as $p => $item){
				
				$padata .=	'&L_PAYMENTREQUEST_0_NAME'.$p.'='.urlencode($item['ItemName']);
				$padata .=	'&L_PAYMENTREQUEST_0_NUMBER'.$p.'='.urlencode($item['ItemNumber']);
				$padata .=	'&L_PAYMENTREQUEST_0_DESC'.$p.'='.urlencode($item['ItemDesc']);
				$padata .=	'&INITAMT='.urlencode($item['ItemPrice']); 
				$padata .=	'&AMT='.urlencode($item['ItemPrice']); 
				$padata .=	'&L_PAYMENTREQUEST_0_AMT'.$p.'='.urlencode($item['ItemPrice']);
				$padata .=	'&L_PAYMENTREQUEST_0_QTY'.$p.'='. urlencode($item['ItemQty']);				
			}		

				
			$padata .=	'&NOSHIPPING='.$noshipping; //set 1 to hide buyer's shipping address, in-case products that does not require shipping
						
			$padata .=	'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($this -> GetProductsTotalAmount($products));
			
			$padata .=	'&PAYMENTREQUEST_0_TAXAMT='.urlencode($charges['TotalTaxAmount']);
			$padata .=	'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($charges['ShippinCost']);
			$padata .=	'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($charges['HandalingCost']);
			$padata .=	'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($charges['ShippinDiscount']);
			$padata .=	'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($charges['InsuranceCost']);
			$padata .=	'&PAYMENTREQUEST_0_AMT='.urlencode($this->GetGrandTotal($products, $charges));
			$padata .=	'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode(PPL_CURRENCY_CODE);
			
			//paypal custom template
			
			$padata .=	'&LOCALECODE='.PPL_LANG; //PayPal pages to match the language on your website;
			$padata .=	'&LOGOIMG='.PPL_LOGO_IMG; //site logo
			$padata .=	'&CARTBORDERCOLOR=FFFFFF'; //border color of cart
			$padata .=	'&ALLOWNOTE=1';
						
			############# set session variable we need later for "DoExpressCheckoutPayment" #######
			
			$_SESSION['ppl_products'] =  $products;
			$_SESSION['ppl_charges'] 	=  $charges;
			
			// get user id
			$userID = $products[0]['userID'];
			
			$httpParsedResponseAr = $this->PPHttpPost('SetExpressCheckout', $padata);
			/*print_r($httpParsedResponseAr);
			exit;*/
			
			//Respond according to message we receive from Paypal
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){

				$paypalmode = (PPL_MODE=='sandbox') ? '.sandbox' : '';
				$paypalurl = 'https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"];
				header('Location: '.$paypalurl);
				//}
			}
			else{
				
				//Show error message
				
				echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
				
				echo '<pre>';
					echo "test";
					print_r($httpParsedResponseAr);
				
				echo '</pre>';
			}	
		}		
		
			
		function CreateRecurringPaymentsProfile(){ 
		
			if(!empty($_SESSION['ppl_products']) && !empty($_SESSION['ppl_charges'])){
				
				$products=$_SESSION['ppl_products']; 
				
				$charges=$_SESSION['ppl_charges'];
				
				$padata  = 	'&TOKEN='.urlencode($_GET['token']);
				$padata .= 	'&PAYERID='.urlencode($_GET['PayerID']);
				$padata .= 	'&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE");
				
				//set item info here, otherwise we won't see product details later	
				
				foreach($products as $p => $item){ 
					
					$padata .=	'&L_PAYMENTREQUEST_0_NAME'.$p.'='.urlencode($item['ItemName']);
					$padata .=	'&L_PAYMENTREQUEST_0_NUMBER'.$p.'='.urlencode($item['ItemNumber']);
					$padata .=	'&L_PAYMENTREQUEST_0_DESC'.$p.'='.urlencode($item['ItemDesc']);
					$padata .=	'&L_PAYMENTREQUEST_0_AMT'.$p.'='.urlencode($item['ItemPrice']);
					$padata .=	'&L_PAYMENTREQUEST_0_QTY'.$p.'='. urlencode($item['ItemQty']);
				}
				
				$padata .=	'&PROFILESTARTDATE='.gmdate("Y-m-d\TH:i:s\Z");
				$padata .=	'&DESC='.urlencode("Membership");
				$padata .=	'&BILLINGPERIOD='.urlencode("Month");
				$padata .=	'&BILLINGFREQUENCY='.urlencode(1);
				$padata .=	'&AMT='.urlencode($this->GetGrandTotal($products, $charges));
				$padata .=	'&INITAMT='.urlencode($this->GetGrandTotal($products, $charges));
				
				$padata .= 	'&PAYMENTREQUEST_0_ITEMAMT='.urlencode($this -> GetProductsTotalAmount($products));
				$padata .= 	'&PAYMENTREQUEST_0_TAXAMT='.urlencode($charges['TotalTaxAmount']);
				$padata .= 	'&PAYMENTREQUEST_0_SHIPPINGAMT='.urlencode($charges['ShippinCost']);
				$padata .= 	'&PAYMENTREQUEST_0_HANDLINGAMT='.urlencode($charges['HandalingCost']);
				$padata .= 	'&PAYMENTREQUEST_0_SHIPDISCAMT='.urlencode($charges['ShippinDiscount']);
				$padata .= 	'&PAYMENTREQUEST_0_INSURANCEAMT='.urlencode($charges['InsuranceCost']);
				$padata .= 	'&PAYMENTREQUEST_0_AMT='.urlencode($this->GetGrandTotal($products, $charges));
				$padata .= 	'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode(PPL_CURRENCY_CODE);
				
				
				//We need to execute the "CreateRecurringPaymentsProfile" at this point to Receive payment from user.
				
				$httpParsedResponseAr = $this->PPHttpPost('CreateRecurringPaymentsProfile', $padata);	
				//Check if everything went ok..
				if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
					ob_start();
					$profileID = $httpParsedResponseAr['PROFILEID'];
					echo '<h2>Success</h2>';
					
					
					if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]){
						
						echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
					}
					elseif('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]){
						
						echo '<div style="color:red">Transaction Complete, but payment may still be pending! '.
						'If that\'s the case, You can manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
					}
					
					$this->GetRecurringPaymentsProfileDetails($profileID);
				}
				else{
						
					echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
					
					echo '<pre>';
					
						print_r($httpParsedResponseAr);
						
					echo '</pre>'; 
					
				}
			}
			else{
				
				// Request Transaction Details
				
				$this->GetRecurringPaymentsProfileDetails();
			} 
		}
				
		function GetRecurringPaymentsProfileDetails($profileID){
			       include '../../../../wp-load.php';
                         global $wpdb;
				
			$padata = 	'&PROFILEID='.$profileID;
			
			$httpParsedResponseAr = $this->PPHttpPost('GetRecurringPaymentsProfileDetails', $padata, PPL_API_USER, PPL_API_PASSWORD, PPL_API_SIGNATURE, PPL_MODE);

			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
				
				
				$products=$_SESSION['ppl_products'];
                                $itemname = $products[0]['ItemName'];
                               // $ItemPrice = $products[0]['ItemPrice']
				$userInfo = $products[0]['userInfo'];
				$userID = $products[0]['userID'];
				$custom = unserialize($userInfo);
				//print_r($custom);
				 $name = $custom['name'];
				//$username =  $custom['username'];
				 $email =  $custom['email'];
				 $phone =  $custom['tel'];
                                 $page = $custom['page'];
                //$password =  md5($custom['password']);
				$membership =  $custom['membership'];
			
					$profile_id = urldecode($httpParsedResponseAr['PROFILEID']);
					$amount = urldecode($httpParsedResponseAr['AMT']); 
					date_default_timezone_set('Asia/Kolkata');
					$start_date = date("Y-m-d");
				$status = $httpParsedResponseAr['STATUS'];

$ordersinserted = $wpdb->update('wgttgw_orders', array('package_name' => $itemname,'package_money' => $amount, 'status'=>'success','profileid'=>$profile_id,'date'=>$start_date), array('id' => $userID));
				$sql="SELECT * from wgttgw_orders WHERE id =".$userID;
				$res=$wpdb->get_row($sql);
				/*print_r($res);
				exit;*/
					$name=$res->name;
					$email=$res->email;
					$phone=$res->phone;
					$service_name=$res->service_name;
					$package_name=$res->package_name;
					$package_money=$res->package_money;
						
					/********Email Start *********/


						$to = $email;
													
										 $subject = "Webguruz Service package purchased";
									
											$headers = array();

										// Override the default 'From' address
										$headers['From'] = 'info@webguruz.in';

										// Send the message as HTML
										$headers['Content-Type'] = 'text/html';

										// Enable open tracking (requires HTML email enabled)
										$headers['X-PM-Track-Opens'] = true;
										
									

						$message = '<div style="margin:0; padding:0;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#dbdbdb">
							<tr>
								<td width="100%"><table width="600" border="0" cellspacing="0" cellpadding="0" style="background:url(http://webguruz.in/wp-content/uploads/email/header-bg.jpg) center no-repeat; padding:5px; background-size:cover;">
							<tr>
								<td><table width="408" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="208"><a href="http://webguruz.in/"><img src="http://webguruz.in/wp-content/uploads/email/logo.png" alt="" /></a></td>
							</tr>
						</table>
						</td>
								<td align="right" width="100%">
								<table width="192" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><a href="https://www.facebook.com/webguruztechnologies/"><img src="http://webguruz.in/wp-content/uploads/email/fb.png" alt="" /></a></td>
								<td><a href="https://www.linkedin.com/company/webguru-technologies-pvt.-ltd.?trk=company_logo"><img src="http://webguruz.in/wp-content/uploads/email/in.png" alt="" /></a></td>
								<td><a href="https://twitter.com/Webguruz"><img src="http://webguruz.in/wp-content/uploads/email/twitter.png" alt="" /></a></td>
								<td><a href="https://plus.google.com/+WebguruzIn/"><img src="http://webguruz.in/wp-content/uploads/email/g-plus.png" alt="" /></a></td>
								<td><a href="https://www.youtube.com/channel/UC-xaX1FJWj40ED-cTm2Lq6w"><img src="http://webguruz.in/wp-content/uploads/email/youtube.png" alt="" /></a></td>
							</tr>
						</table>
						</td>
							</tr>
						</table>
						</td>
							</tr>
							<tr>
								<td><table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding:15px;">
							<tr>
								<td align="center"><table width="570" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#fff" style="padding:20px;">
							<tr>
								<td><h1 style="font-size:24px; color:#000000; text-align:left; font-family:Arial, Helvetica, sans-serif; padding:0; text-transform: capitalize;">Dear '.$name.'</h1></td>
							</tr>
							<tr>
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Thanks for purchasing our monthly services package.</p></td>
							</tr>
							
								<tr>
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">You have signed up with us for the '.$service_name.'. We will surely give you services better than you would have expected. We will get back to you within 48 hours.</p></td>
							</tr>
							
							<tr>
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;"> The information submitted by you will remain confidential.</p></td>
							</tr>
							<tr>
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Thanks for choosing us</p></td>
							</tr>';
$message .='<tr>';
						$message .='<td>&nbsp;</td>';
						$message .='</tr>';
						$message .='<tr>';
						$message .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; padding-top:15px;">Here are the details of New sold services package:</td>';
						$message .='</tr>';
						$message .='<tr>';
						$message .='<td>&nbsp;</td>';
						$message .='</tr>';
						$message .='<tr>';
						$message .='<td>';
						$message .='<div style="width:600px; float:left;">';
						$message .='<table width="100%" border="0" cellspacing="0" cellpadding="0">';
						$message .='<tr>';
						$message .='<td height="40" width="150px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac;  border-left:1px solid #acacac; border-top:1px solid #acacac;"><strong>Name: </strong></td>';
						$message .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac; border-top:1px solid #acacac;">'.$name.'</td>';
						$message .='</tr>';
						$message .='<tr>';
						$message .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Email:</strong></td>';
						$message .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$email.'</td>';
						$message .='</tr>';
						$message .='<tr>';
						$message .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Phone:</strong></td>';
						$message .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac;">'.$phone.'</td>';
						$message .='</tr>';
						$message .='<tr>';
						$message .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Service name:</strong></td>';
						$message .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$service_name.'</td>';
						$message .='</tr>';
						$message .='<tr>';
						$message .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Package Name:</strong></td>';
						$message .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$package_name.'</td>';
						$message .='</tr>';
						$message .='<tr>';
						$message .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Package Price:</strong></td>';
						$message .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$package_money.'</td>';
						$message .='</tr>';
						
						$message .='</table>';
						$message .='</div>';
						$message .='</td>';
						$message .='</tr>';
						$message .='<tr>';
						$message .='<td>&nbsp;</td>';
						$message .='</tr>

							<tr>
								<td style="color:#f2a702; font-size:18px; font-family:Arial, Helvetica, sans-serif;">Cheers!!<br />
						Team Webguruz</td>
							</tr>
						</table>
						</td>
							</tr>
						</table>
						</td>
							</tr>
							<tr>
								<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000" style="padding:30px 0;" >
							<tr>
								<td>
								<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center"><h2 style="color:#fff; text-transform:uppercase; font-size:18px; font-family:Arial, Helvetica, sans-serif;">Corporate Head Office-India:</h2></td>
							</tr>
							<tr>
								<td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">IT-C2, Dibon Building, 4th Floor, Sector 67, Mohali,<br /> India. Pin:160062</p></td>
							</tr>
							<tr>
								<td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">Phone: +91 172 4666 711-712<br />
								Mobile: 9592016444
						</p></td>
							</tr>
							<tr>
								<td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">E-mail: <a href="mailto:info@webguruz.in" style="color:#a0a0a0; text-decoration:none;">info@webguruz.in</a><br />
						Website: <a href="http://webguruz.in/" target="_blank" style="color:#a0a0a0; font-family:Arial, Helvetica, sans-serif; text-decoration:none;">www.webguruz.in</a> </p></td>
							</tr>
							 <tr>
								<td align="center">
								<table width="224" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td style="text-align:center"><a href="https://www.facebook.com/webguruztechnologies/"><img src="http://webguruz.in/wp-content/uploads/email/fb.png" alt="" /></a></td>
								<td style="text-align:center"><a href="https://www.linkedin.com/company/webguru-technologies-pvt.-ltd.?trk=company_logo"><img src="http://webguruz.in/wp-content/uploads/email/in.png" alt="" /></a></td>
								<td style="text-align:center"><a href="https://twitter.com/Webguruz"><img src="http://webguruz.in/wp-content/uploads/email/twitter.png" alt="" /></a></td>
								<td style="text-align:center"><a href="https://plus.google.com/+WebguruzIn/"><img src="http://webguruz.in/wp-content/uploads/email/g-plus.png" alt="" /></a></td>
								<td style="text-align:center"><a href="https://www.youtube.com/channel/UC-xaX1FJWj40ED-cTm2Lq6w"><img src="http://webguruz.in/wp-content/uploads/email/youtube.png" alt="" /></a></td>
							</tr>
						</table>
								</td>
							</tr>
						</table>
								</td>
							</tr>
						</table>
						</td>
							</tr>
						<tr>
									<td>&nbsp;</td>
								</tr>
							<tr>
								<td width="100%" align="center" id="backgroundTable"><table width="570" border="0" cellspacing="0" cellpadding="0" class="devicewidth">
							<tr>
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Webguruz Technologies Pvt. Ltd was established in 2008. It employs around 50 employees. The company has its head office in Chandigarh with two branches, one in Croydon U.K,  and the second branch in india.<br /><br /> </p></td>
							</tr>
							
							<tr>
								<td style="padding:15px 0 0;"><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Copyright © 2017  Webguruz Technologies Private Limited. All rights reserved.</p></td>
							</tr>
						</table>
						</td>
							</tr>
						</table>
						</td>
							</tr>
						</table>
						</div>';
																 
																 
																		
							$message2 ='<table width="100%" border="0" cellspacing="0" cellpadding="0">';
						$message2 ='<tr>
								<td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#dbdbdb">
							<tr>
								<td width="100%"><table width="600" border="0" cellspacing="0" cellpadding="0" style="background:url(http://webguruz.in/wp-content/uploads/email/header-bg.jpg) center no-repeat; padding:5px; background-size:cover;">
							<tr>
								<td><table width="408" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="208"><a href="http://webguruz.in/"><img src="http://webguruz.in/wp-content/uploads/email/logo.png" alt="" /></a></td>
							</tr>
						</table>
						</td>
								<td align="right" width="100%">
								<table width="192" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td><a href="https://www.facebook.com/webguruztechnologies/"><img src="http://webguruz.in/wp-content/uploads/email/fb.png" alt="" /></a></td>
								<td><a href="https://www.linkedin.com/company/webguru-technologies-pvt.-ltd.?trk=company_logo"><img src="http://webguruz.in/wp-content/uploads/email/in.png" alt="" /></a></td>
								<td><a href="https://twitter.com/Webguruz"><img src="http://webguruz.in/wp-content/uploads/email/twitter.png" alt="" /></a></td>
								<td><a href="https://plus.google.com/+WebguruzIn/"><img src="http://webguruz.in/wp-content/uploads/email/g-plus.png" alt="" /></a></td>
								<td><a href="https://www.youtube.com/channel/UC-xaX1FJWj40ED-cTm2Lq6w"><img src="http://webguruz.in/wp-content/uploads/email/youtube.png" alt="" /></a></td>
							</tr>
						</table>
						</td>
							</tr>
						</table>
						</td>
							</tr>';
						$message2 .='<tr>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:40px; text-align:left; font-weight:bold; color:#1fb5ac;">Dear Business Team</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td>&nbsp;</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; padding-top:15px;">Here are the details of New sold services package:</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td>&nbsp;</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td>';
						$message2 .='<div style="width:600px; float:left;">';
						$message2 .='<table width="100%" border="0" cellspacing="0" cellpadding="0">';
						$message2 .='<tr>';
						$message2 .='<td height="40" width="150px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac;  border-left:1px solid #acacac; border-top:1px solid #acacac;"><strong>Name: </strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac; border-top:1px solid #acacac;">'.$name.'</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Email:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$email.'</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Phone:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac;">'.$phone.'</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Service name:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$service_name.'</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Package Name:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$package_name.'</td>';
						$message2 .='</tr>';
								$message2 .='<tr>';
						$message2 .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Package Price:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$package_money.'</td>';
						$message2 .='</tr>';
						
						$message2 .='</table>';
						$message2 .='</div>';
						$message2 .='</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td>&nbsp;</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; color:#1fb5ac;">Thanks</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; color:#1fb5ac; padding:5px 0px;">Webguruz</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td>&nbsp;</td>';
						$message2 .=' </tr>';
						$message2 .='<tr>
								<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000" style="padding:30px 0;" >
							<tr>
								<td>
								<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
							<tr>
								<td align="center"><h2 style="color:#fff; text-transform:uppercase; font-size:18px; font-family:Arial, Helvetica, sans-serif;">Corporate Head Office-India:</h2></td>
							</tr>
							<tr>
								<td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">IT-C2, Dibon Building, 4th Floor, Sector 67, Mohali,<br /> India. Pin:160062</p></td>
							</tr>
							<tr>
								<td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">Phone: +91 172 4666 711-712<br />
								Mobile: 9592016444
						</p></td>
							</tr>
							<tr>
								<td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">E-mail: <a href="mailto:info@webguruz.in" style="color:#a0a0a0; text-decoration:none;">info@webguruz.in</a><br />
						Website: <a href="http://webguruz.in/" target="_blank" style="color:#a0a0a0; font-family:Arial, Helvetica, sans-serif; text-decoration:none;">www.webguruz.in</a> </p></td>
							</tr>
							 <tr>
								<td align="center">
								<table width="224" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td style="text-align:center"><a href="https://www.facebook.com/webguruztechnologies/"><img src="http://webguruz.in/wp-content/uploads/email/fb.png" alt="" /></a></td>
								<td style="text-align:center"><a href="https://www.linkedin.com/company/webguru-technologies-pvt.-ltd.?trk=company_logo"><img src="http://webguruz.in/wp-content/uploads/email/in.png" alt="" /></a></td>
								<td style="text-align:center"><a href="https://twitter.com/Webguruz"><img src="http://webguruz.in/wp-content/uploads/email/twitter.png" alt="" /></a></td>
								<td style="text-align:center"><a href="https://plus.google.com/+WebguruzIn/"><img src="http://webguruz.in/wp-content/uploads/email/g-plus.png" alt="" /></a></td>
								<td style="text-align:center"><a href="https://www.youtube.com/channel/UC-xaX1FJWj40ED-cTm2Lq6w"><img src="http://webguruz.in/wp-content/uploads/email/youtube.png" alt="" /></a></td>
							</tr>
						</table>
								</td>
							</tr>
						</table>
								</td>
							</tr>
						</table>
						</td>
							</tr>
							<tr>
								<td width="100%" align="center" id="backgroundTable"><table width="570" border="0" cellspacing="0" cellpadding="0" class="devicewidth">
							<tr>
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Webguruz Technologies Pvt. Ltd was established in 2008. It employs around 50 employees. The company has its head office in Chandigarh with two branches, one in Croydon U.K,  and the second branch in india.<br /><br /></p></td>
							</tr>
							
							<tr>
								<td style="padding:15px 0 0;"><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Copyright © 2016  Webguruz Technologies Private Limited. All rights reserved.</p></td>
							</tr>
						</table>
						</td>
							</tr>
						</table>
						</td>
							</tr>';
						$message2 .='</table>';
						$to2= 'provider@webguruz.in';
							wp_mail($to,$subject,$message,$headers);
														$updated = wp_mail($to2,$subject,$message2,$headers);


					/********Email End *********/


					$_SESSION['payment_success'] = "PaymentSuccess";
					if ($ordersinserted) {
						header ("Location: https://www.webguruz.in/thank-you/"); 
					} else {
						header ("Location: https://www.webguruz.in/cancel/");
					}
			
			} 
			else  {
				
				echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
				
				echo '<pre>';
				
					print_r($httpParsedResponseAr);  
					
				echo '</pre>';

			}
		}
		
		function CheckRecurringPaymentsProfileDetails($profileID){
			
			$padata = 	'&PROFILEID='.$profileID;
			  
			$httpParsedResponseAr = $this->PPHttpPost('GetRecurringPaymentsProfileDetails', $padata, PPL_API_USER, PPL_API_PASSWORD, PPL_API_SIGNATURE, PPL_MODE);

			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
				
				return $httpParsedResponseAr; 
			
			}
		}
		
		function PPHttpPost($methodName_, $nvpStr_) {
				
				// Set up your API credentials, PayPal end point, and API version.
				$API_UserName = urlencode(PPL_API_USER);
				$API_Password = urlencode(PPL_API_PASSWORD);
				$API_Signature = urlencode(PPL_API_SIGNATURE);
				
				$paypalmode = (PPL_MODE=='sandbox') ? '.sandbox' : '';
		
				$API_Endpoint = "https://api-3t".$paypalmode.".paypal.com/nvp";
				$version = urlencode('109.0');
			
				// Set the curl parameters.
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
				curl_setopt($ch, CURLOPT_VERBOSE, 1);
				//curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
				
				// Turn off the server and peer verification (TrustManager Concept).
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
			
				// Set the API operation, version, and API signature in the request.
				echo $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
			
				// Set the request as a POST FIELD for curl.
				curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
			
				// Get response from the server.
				$httpResponse = curl_exec($ch);
			
				if(!$httpResponse) {
					exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
				}
			
				// Extract the response details.
				$httpResponseAr = explode("&", $httpResponse);
			
				$httpParsedResponseAr = array();
				foreach ($httpResponseAr as $i => $value) {
					
					$tmpAr = explode("=", $value);
					
					if(sizeof($tmpAr) > 1) {
						
						$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
					}
				}
			
				if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
					
					exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
				}
			
			return $httpParsedResponseAr;
		}
	}
