<?php
include('db-connect.php');
/*if (isset($_POST['submit']))*/
if ($_POST['action_type']=='check_promo')
{
 Global $wpdb;
  
   /*print_r($_POST);*/
   $name=$_POST["promo"];
   $cur_date= date("Y-m-d");
    $qry= "SELECT discount_percent FROM promocode WHERE name = '".$name."' AND '".$cur_date."' BETWEEN valid_from AND valid_to ";
    $results = $wpdb->get_var( $qry);
    print_r($results);

}

if ($_POST['action_type']=='saveinfo')
{
	$name = $_POST['name'];

	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$package_name = $_POST['package_name'];
	$service_name = $_POST['service_name'];

	//$service = $_REQUEST['service']; //= implode(',',$servicevalues);

	
	 $sql = "INSERT INTO wgttgw_orders (name,email,phone,service_name,package_name,package_money) VALUES ('$name','$email','$phone','$service_name','$package_name','$package_money')";
			if (mysqli_query($conn, $sql))
			{
				echo $last_id = $conn->insert_id;
					 $to = 'provider@webguruz.in';
					/* $to = 'chirag@webguruz.in';*/
													
										 $subject = "LEAD FOR SERVICE PACKAGE";
									
											$headers = array();

										// Override the default 'From' address
										$headers['From'] = 'info@webguruz.in';

										// Send the message as HTML
										$headers['Content-Type'] = 'text/html';

										// Enable open tracking (requires HTML email enabled)
										$headers['X-PM-Track-Opens'] = true;
										$mail_attachment = array($_SERVER['DOCUMENT_ROOT'] ."/wp-content/themes/dt-the7/images/quote/".$file);
									
								 
																 
																		
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
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; padding-top:15px;">Here are the details of interested customer for service package: '.$service_name.'</td>';
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
						$message2 .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left;font-weight:normal;padding-left:15px;border-right:1px solid #acacac;border-left:1px solid #acacac;"><strong>Service Name:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$service_name.'</td>';
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
								<td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">E-mail: <a href="mailto:info@webguruz.co.uk" style="color:#a0a0a0; text-decoration:none;">info@webguruz.co.uk</a><br />
						Website: <a href="http://webguruz.in/" target="_blank" style="color:#a0a0a0; font-family:Arial, Helvetica, sans-serif; text-decoration:none;">www.webguruz.co.uk</a> </p></td>
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
														/* $to2= 'chirag@webguruz.in';*/
													
														 $updated = wp_mail($to2,$subject,$message2,$headers);


			}
}
	
?>