<?php
/*
Plugin Name: Applyonline
Description: Booking Quote for TheScoutGroup
Version: 0.1
Author: jai
Author URI: http://webguruz.in
*/

/** Step 2 (from text above). */

/** Step 1. */


ob_start();
define( 'AP_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
add_action( 'admin_menu', 'register_my_custom_menu' );
add_action( 'admin_init', 'my_calling_admin_init' );


	function my_calling_admin_init()
	{
		/* Register our stylesheet. */
		wp_register_style( 'myPluginStylesheet', plugins_url('call.css', __FILE__) );
		wp_register_style( 'uicss', plugins_url('jquery-ui-1.10.3.custom.css', __FILE__) );
		
	}
	function register_my_custom_menu()
	{
		$call = add_menu_page( 'Candidate Tracker', 'Candidate Tracker', 'manage_options', 'calling', 'calling', '', 8);
		//$call1 = add_submenu_page( 'calling', 'Show Enquiry List', 'Show Enquiry List');
		add_action( 'admin_print_styles-' . $call, 'my_call_admin_styles' );
	}
	function calling()
	{
		$action= $_GET["action"];
                $applyed= $_POST["applyed"];

		switch($action)
		{
			case "import":
		  		show_import_list();
		  		break;
			
			case "sendjobinvitation":
		  		show_sendjobinvitation($applyed);
		  		break;	

			default:
				add_booking_quote();		  	
		}
	}

	function my_call_admin_styles()
	{
		/* It will be called only on your plugin admin page, enqueue our stylesheet here */  
		wp_enqueue_style( 'myPluginStylesheet' );
		wp_enqueue_style( 'uicss' );
 	
	}
/**
* show_export_list
*/
function show_import_list()
	{ ?>
<div class="wrap">
 <h2>Candidate import</h2>
<form name="import" method="post" enctype="multipart/form-data">
    	<input type="file" name="file" /><br />
        <input type="submit" name="submit" value="Submit" />
    </form>
<?php global $wpdb;
require_once('excel_reader2.php');
 
if(isset($_POST["submit"]))
	{

		$file = $_FILES['file']['tmp_name'];
                $storagename = $_FILES["file"]["name"];
                $filetype = pathinfo($storagename,PATHINFO_EXTENSION);
                $handle = fopen($file, "r");
		$c = 0;
                  
                 if($filetype=='csv'){
               while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
		{
                     if($c!=0){
                        //print_r($filesop);
		        $submitted = $filesop[1];
			$position = $filesop[2];
                        $address = $filesop[3];
                        $tel206 = $filesop[4];
                        $tel389 = $filesop[5];
                        $reff = $filesop[6];
                        $name = $filesop[7];
                        $email = $filesop[8];
                        $mobile = $filesop[9];
                        $work_exp = $filesop[10];
                        $quiz853 = $filesop[11];
                        $resume = $filesop[12];

                        $query = "insert into applyonline (submitted, position, address, tel206, tel389, reff, name, email, mobile, work_exp, quiz853, resume) values('".$submitted."','".$position."','".$address."','".$tel206."','".$tel389."','".$reff."','".$name."','".$email."','".$mobile."','".$work_exp."','".$quiz853."','".$resume."')";
			//$query = "INSERT INTO wotcm_users (user_login, user_email) VALUES ('$name','$email')";
			$inserted = $wpdb->query($query);
}
			$c = $c + 1;

		}
  if($inserted){
   echo "<br />Data Inserted in dababase";
     }
   else{
   echo "<br />Not Data Inserted in dababase";
    }
  }//end if filetype
  else{
  echo "<br />Upload only csv file";
  }
}
 
?>
 </div>
<?php
}
/*show_export_list end*/

function add_booking_quote()
	{
global $wpdb;
?>

<div class="wrap">
 <h2>Candidate Tracker</h2>
<script>
function toggle(source) {
    var checkboxes = document.querySelectorAll('input[id="applyed"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}
</script>
<br /><br />
<form method="post"  name="form1" id="form1" >
<div class="alignleft actions bulkactions">
<select id="position" name="position" class="position">
<option value="">Select Position</option>
<?php 
$positions = $wpdb->get_results("SELECT position FROM applyonline  GROUP BY position "); 

foreach($positions as $data){ ?>
<option value="<?php echo $data->position; ?>"><?php echo $data->position; ?></option>	
<?php } ?>
</select>
<input type="Submit"  value="Apply" id="apply" name="apply">
</div>
<div class="alignleft actions">
<select id="exp" name="exp" class="exp">
<option value="">Select Experience</option>
<?php 
$work_exps = $wpdb->get_results("SELECT work_exp FROM applyonline  GROUP BY work_exp "); 

foreach($work_exps as $data){ ?>
<option value="<?php echo $data->work_exp; ?>"><?php echo $data->work_exp; ?></option>	
<?php } ?>
</select>
<input type="Submit"  value="Apply" id="apply" name="apply">
</div>
</form>
<div class="export alignleft actions"><a href="<?php echo home_url(); ?>/exportdata.php" class="btn button exportbtn">Export</a></div>
<div class="importapdata alignleft actions"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=calling&action=import" class="btn button exportbtn">Import</a></div>
<?php  
$position2= $_POST["position"];
$exp= $_POST["exp"];
if(isset($position2) || isset($exp)){
$posts = $wpdb->get_results("SELECT * FROM applyonline WHERE position='".$position2."' OR work_exp='".$exp."'"); 

}
else {
$posts = $wpdb->get_results("SELECT * FROM applyonline ORDER BY id DESC"); 

}
?>
<form method="post"   name="form2" id="form2" action="<?php echo home_url(); ?>/wp-admin/admin.php?page=calling&action=sendjobinvitation" >
<table border="1" class="wp-list-table widefat fixed">
<tr><th><input type="checkbox"  value="" id="applyall" name="applyall" onclick="toggle(this);"></th><th>Position</th><th>Name</th><th>Email</th><th>Address</th><th>Mobile</th><th>Phone No.</th><th>Experience</th></tr>
<?php foreach($posts as $post){  ?>
<tr><td><input type="checkbox"  value="<?php echo $post->id; ?>" id="applyed" name="applyed[]"></td><td><?php echo $post->position; ?></td><td><?php echo $post->name; ?></td><td><?php echo $post->email; ?></td><td><?php echo $post->address; ?></td><td><?php echo $post->mobile; ?></td><td><?php echo $post->tel206.'-'.$post->tel389; ?></td><td><?php echo $post->work_exp; ?></td></tr>
<?php } ?>
</table>
<!--a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=calling&action=sendjobinvitation" class="btn button exportbtn">Send Job Invitation</a-->
<input type="Submit"  value="Send Job Invitation" id="mailInv" name="mailInv">
</form>

</div>
<?php
}
function show_sendjobinvitation($applyed)
{
//print_r($applyed);
global $wpdb;
$applyIds = $_POST["applyed"];
if(isset($_POST["mail"])){ 
$appl_subject = isset($_POST["subject"]) ? $_POST["subject"]:'New Opening';
$appl_massage = isset($_POST["massage"]) ? $_POST["massage"]:'Interested Candidates who are looking for a job Change can revert back at hr@webguruz.in';
foreach($applyIds as $applyid){ 
if(isset($applyid)){
$posts = $wpdb->get_results("SELECT * FROM applyonline WHERE id=".$applyid); 
} else{
$posts = $wpdb->get_results("SELECT * FROM applyonline "); 
}
$query = "insert into applionline_mails (subject, massages) values('".$appl_subject."','".$appl_massage."')";
$insted = $wpdb->get_results($query); 
 $to = $posts[0]->email;
 $positions = $posts[0]->position;
	$subject = ''.$appl_subject.'';
			$headers = "From: Webguruz <info@webguruz.in>" . "\r\n" ;
			$headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			//$message = "Dear ".$posts[0]->name."\r\n";
                        //$message .= "\r\n ".$appl_massage;


$message = '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#dfdfdf;">';
$message .= '<tr>';
$message .= '<td>';
$message .= '<div style="width:600px; margin:0px auto;">';
$message .= '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#fff;">';
$message .= '<tr>';
$message .= '<td><img src="http://webguruz.in/wp-content/uploads/2016/10/email1-top.jpg" width="600" height="156" alt=""></td>';
$message .= ' </tr>';
$message .= '<tr>';
$message .= '<td style="font-family:Trebuchet MS, Arial, Helvetica, sans-serif; font-size:36px; text-align:center; font-weight:bold;">&nbsp;</td>';
$message .= '</tr>';
$message .= ' <tr>';
$message .= '<td style="font-family: Arial, Helvetica, sans-serif; font-size:36px; text-align:center; font-weight:bold;">Dear '.$posts[0]->name.' </td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td  style="font-family: Arial, Helvetica, sans-serif; font-size:24px; text-align:center; font-weight:normal; color:#228990;">Greetings!!</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>&nbsp;</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td style="font-family: Arial, Helvetica, sans-serif; font-size:17px; text-align:center; font-weight:normal; color:#606060;">New Opening for '.$positions.'</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>&nbsp;</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td style="font-family:Arial, Helvetica, sans-serif; font-size:17px; text-align:center; font-weight:normal; color:#606060;">'.$appl_massage.'</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>&nbsp;</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td style="font-family: Arial, Helvetica, sans-serif; font-size:20px; text-align:center; font-weight:normal; color:#f2a702;">Cheers!!</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td style="font-family:Arial, Helvetica, sans-serif; font-size:20px; text-align:center; font-weight:normal; color:#f2a702;">Team Webguruz</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td style="font-family: Arial, Helvetica, sans-serif; font-size:20px; text-align:center; font-weight:normal; color:#f2a702;">&nbsp;</td>';
$message .= '</tr>';
$message .= ' <tr>';
$message .= '<td style="background:url(http://webguruz.in/wp-content/uploads/2016/10/email-bottom.jpg) no-repeat">';
$message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
$message .= ' <tr>';
$message .= '<td>&nbsp;</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td style="font-family:Trebuchet MS, Arial, Helvetica, sans-serif; font-size:20px; text-align:center; font-weight:normal; color:#fff;">Corporate Head Office-India:</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>&nbsp;</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; font-weight:normal; color:#a0a0a0;">IT-C2, Dibon Building, 4th Floor, Sector 67, <br>
Mohali, India. Pin:160062 </td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>&nbsp;</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; font-weight:normal; color:#a0a0a0;">Phone: +91 172 4666 711-712<br>
    Mobile: 9592016444
</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>&nbsp;</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:center; font-weight:normal; color:#a0a0a0;">E-mail: info@webguruz.co.uk<br>
   Website: www.webguruz.co.uk 
   </td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>&nbsp;</td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td align="center"><a href="#"><img src="http://webguruz.in/wp-content/uploads/2016/10/f-icon.gif" width="37" height="37" alt="" style="margin-right:2px;"></a><a href="#"><img src="http://webguruz.in/wp-content/uploads/2016/10/twitter.gif" width="37" height="37" alt="" style="margin-right:2px;"></a><a href="#"><img src="http://webguruz.in/wp-content/uploads/2016/10/in.gif" width="37" height="37" alt="" style="margin-right:2px;"></a><a href="#"><img src="http://webguruz.in/wp-content/uploads/2016/10/gplus.gif" width="37" height="37" alt="" style="margin-right:2px;"></a><a href="#"><img src="http://webguruz.in/wp-content/uploads/2016/10/youtube.gif" width="37" height="37" alt="" style="margin-right:2px;"></a></td>';
$message .= '</tr>';
$message .= '<tr>';
$message .= '<td>&nbsp;</td>';
$message .= '</tr>';
$message .= '</table>';
$message .= '</td>';
$message .= '</tr>';
$message .= '</table>';
$message .= '</div>';
$message .= '</td>';
$message .= '</tr>';
$message .= '</table>';
	//================="&booking_fee=".$booking_fee."&credit_card=".$credit_fee.================Removed after Cleaning Fee from above line.//
	
			$updated = wp_mail($to,$subject,$message);		
 }
}
?>
<div class="wrap">
<h2>Send Job Invitation</h2>
<?php 
			
			if(isset($updated))
			{ 
			?>
			<div class="updated notice notice-success is-dismissible below-h2" id="message">
				<p> Mails Sent Successfully. </p>
				<button class="notice-dismiss" type="button">
				<span class="screen-reader-text">Dismiss this notice.</span>
				</button>
			</div>
			<?php } ?>
<form method="post"  name="form2" id="form2">
<?php 
$appl_mails = $wpdb->get_results("SELECT * FROM applionline_mails ORDER BY id DESC LIMIT 1"); 
$subject = $appl_mails[0]->subject;
$massages = $appl_mails[0]->massages;
if(isset($applyed)){
foreach($applyed as $apply){ 
echo '<input type="hidden"  value="'.$apply.'" id="applyed" name="applyed[]" >';
} }?>
<div id="titlewrap">
<lable>Subject</lable>
<input type="text"  value="<?php echo $subject; ?>" id="subject" name="subject" ></br>
</div>
<div class="inside">
<lable>Massage</lable><br>
<textarea  cols="40" rows="4" id="massage" name="massage" ><?php echo $massages; ?></textarea>
</div>
<input type="Submit"  value="Send Job Invitation" id="mail" name="mail">
</form>
</div>
<?php
}
