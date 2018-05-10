<?php
//parse_str($_POST['data'], $_POST);
//print_r($_POST['data']);
	 // Mysql insert statment
include('db-connect.php');

$reffer = explode('?',$_SERVER['REQUEST_URI']);
$reffer_quote = $reffer[1];

/*if (isset($_POST['submit']))*/
if ('1'=='1')
{
        $cptcha = $_POST['g-recaptcha-response'];

           $recaptcha_secret = "6LdgFykUAAAAANW6cu-0Kx6A057h2ZRFK9_Qgz5a";

        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".$cptcha);
        $response = json_decode($response, true);

        if($response['success']!='1'){
        	echo 'capcha-error';
        	exit;

        }

		$filename = $_FILES["file"]["name"];
		//echo $_SERVER['PHP_SELF'];
		 $target_dir = $_SERVER['DOCUMENT_ROOT'] ."/wp-content/themes/dt-the7/images/quote/";
		
		$target_file = $target_dir . basename($_FILES["file"]["name"]);
		//chmod($target_file, 0777);
		//chmod($target_file, 0777);
		 move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

	$refference = $_POST['refference'];
	$name = $_POST['fname'];	

	$email = $_POST['email'];
				$isd = $_POST['isd'];
	$phone = $_POST['phone'];
	$skype_id = $_POST['skype_id'];
	$website = $_POST['website'];
	$est_budget = $_POST['est_budget'];
	$des = $_POST['des'];

	 $servicevalues = $_POST['service'];
	//$service = $_REQUEST['service']; //= implode(',',$servicevalues);

	$file = $filename;
	$isd_phone =$isd."-".$phone; 
	$sql = "INSERT INTO quote (refference,name,email,phone,skype_id,website,est_budget,des,service,file) VALUES ('$refference','$name','$email','$isd_phone','$skype_id','$website','$est_budget','$des','$servicevalues','$file')";

	if (mysqli_query($conn, $sql))
	{
													 $to = $email;
													
										 $subject = "REQUEST A FREE QUOTE";
									
											$headers = array();

										// Override the default 'From' address
										$headers['From'] = 'provider@webguruz.in';

										// Send the message as HTML
										$headers['Content-Type'] = 'text/html';

										// Enable open tracking (requires HTML email enabled)
										$headers['X-PM-Track-Opens'] = true;
										$mail_attachment[0] = array($_SERVER['DOCUMENT_ROOT'] ."/wp-content/themes/dt-the7/images/quote/".$file);
										
 
									$file2 = 'https://www.webguruz.in/wp-content/uploads/2017/09/webguruz-ppt.pdf'; // URL to the file
									
										$contents = file_get_contents($file2); // read the remote file
										touch('companyprofile.pdf'); // create a local EMPTY copy
										file_put_contents('companyprofile.pdf', $contents);

										$mail_attachment[1] = array($_SERVER['DOCUMENT_ROOT'] ."/wp-content/themes/dt-the7/companyprofile.pdf");
										
									

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
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Thanks for submitting your requirements.</p></td>
							</tr>
							<tr>
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">You are Awesome !!</p></td>
							</tr>
							<tr>
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Why ?</p></td>
							</tr>
								<tr>
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">You have signed up with us for the '.$servicevalues.'. We will surely give you services better than you would have expected. We will get back to you within 48 hours.</p></td>
							</tr>
							
							<tr>
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;"> The information submitted by you will remain confidential.</p></td>
							</tr>
							<tr>
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Thanks for choosing us</p></td>
							</tr>
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
								<td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">E-mail: <a href="mailto:info@webguruz.co.uk" style="color:#a0a0a0; text-decoration:none;">info@webguruz.in</a><br />
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
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Webguruz Technologies Pvt. Ltd was established in 2008. It employs around 50 employees. The company has its head office in Chandigarh,INDIA and one Branch office in Croydon, UK. </p></td>
							</tr>
							
							<tr>
								<td style="padding:0px 0 0;"><p style="color:#606060; font-size:14px; padding-bottom:10px; margin-top:0px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Copyright © 2016  Webguruz Technologies Private Limited. All rights reserved.</p></td>
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
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; padding-top:15px;">Here are the details of Enquiry :</td>';
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
						$message2 .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left;font-weight:normal;padding-left:15px;border-right:1px solid #acacac;border-left:1px solid #acacac;"><strong>Skype id:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$skype_id.'</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Website:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac;">'.$website.'</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Web service want:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$servicevalues.'</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Estimate budget:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$est_budget.'</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Reference:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac;">'.$refference.'</td>';
						$message2 .='</tr>';
						$message2 .='<tr>';
						$message2 .='<td height="40" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; padding-top:15px; border-left:1px solid #acacac; border-bottom:1px solid #acacac; padding-bottom:15px;"><strong>Description:</strong></td>';
						$message2 .='<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; padding-top:15px; border-bottom:1px solid #acacac; border-right:1px solid #acacac; padding-bottom:15px;">'.$des.'</td>
							</tr>';
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
								<td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">E-mail: <a href="mailto:info@webguruz.co.uk" style="color:#a0a0a0; text-decoration:none;">info@webguruz.in</a><br />
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
								<td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Webguruz Technologies Pvt. Ltd was established in 2008. It employs around 50 employees. The company has its head office in Chandigarh,INDIA and one Branch office in Croydon, UK.</p></td>
							</tr>
							
							<tr>
								<td style="padding:0px 0 0;"><p style="color:#606060; font-size:14px; padding-bottom:10px; margin-top:0px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Copyright © 2016  Webguruz Technologies Private Limited. All rights reserved.</p></td>
							</tr>
						</table>
						</td>
							</tr>
						</table>
						</td>
							</tr>';
						$message2 .='</table>';
														 $to2= 'provider@webguruz.in';
										 wp_mail($to,$subject,$message,$headers,$mail_attachment[1]);
														$updated = wp_mail($to2,$subject,$message2,$headers,$mail_attachment[0]);
								$msg = "successfully";

						$apiKey = '9d8007d3cca6afbe56cffb2db08fc6b1-us14'; //'a7d4e38b7d85a02d246491509d90c62a-us10';
						$listId = 'b727f45465'; //'07ffb5973a';
						$double_optin=false;
						$send_welcome=false;
						$email_type = 'html';
						 // MailChimp API URL
										$memberID = md5(strtolower($email));
										$dataCenter = substr($apiKey,strpos($apiKey,'-')+1);
										$url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listId . '/members/' . $memberID;
										
										// member information
										$json = json_encode([
												'email_address' => $email,
												'status'        => 'subscribed',
												'merge_fields'  => [
														'FNAME'     => $name,
														'PHONE'     => $phone
												]
										]);
										
										// send a HTTP POST request with curl
										$ch = curl_init($url);
										curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
										curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										curl_setopt($ch, CURLOPT_TIMEOUT, 10);
										curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
										curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
										curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
										$result = curl_exec($ch);
										$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
										curl_close($ch);
										
										// store the status message based on response code
										if ($httpCode == 200) {
												 $_SESSION['msg'] = '<p style="color: #34A853">You have successfully subscribed.</p>';
										} 
										else {
												switch ($httpCode) {
														case 214:
																$msgk = 'You are already subscribed.';
																break;
														default:
																$msgk = 'Some problem occurred, please try again.';
																break;
												}
												$_SESSION['msg'] = '<p style="color: #EA4335">'.$msg.'</p>';
										}
						//end mailchimp api
							} 
							else 
							{
								echo "Error: " . $sql . "<br>" . mysqli_error($conn);
							}
						echo $msg;
						 
						} 
?>