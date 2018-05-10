<?php
add_action( 'init', 'teamtestimonial_init' );
add_shortcode( 'teamtestimonial', 'shortcode_in_teamtestimonial' );
add_shortcode( 'teamform', 'shortcode_in_teamtestimonial_form' );
add_action('wp_ajax_team_form', 'ajax_request_team_form');
add_action('wp_ajax_nopriv_team_form', 'ajax_request_team_form');
add_action('wp_ajax_team_file', 'ajax_request_team_file');
add_action('wp_ajax_nopriv_team_file', 'ajax_request_team_file');
add_filter('views_edit-team','update_team_quicklinks');

function teamtestimonial_init() {

team_init();
}
function team_init() {
$args = array(
  'labels'	=> array(
                        'name'                =>        'Team testimonial',
			'all_items'           => 	'Team testimonial',
			'menu_name'	      =>	'Team testimonial',
			'singular_name'       =>	'Team testimonial',
			'edit_item'           =>	'Edit Team testimonial',
			'new_item'            =>	'New Team testimonial',
			'view_item'           =>	'View Team testimonial',
			'search_items'        =>	'Search Team testimonial',
			'not_found'	          =>	'No Team testimonial found.',
			'not_found_in_trash'  => 'No Team testimonial found in trash.'
					),
	'supports'      =>	array( 'title','editor','thumbnail','comments','author','custom-fields' ),
	'show_in_menu'  =>	'edit.php?post_type=videos',
	'public'		    =>	true
);
register_post_type( 'team', $args );
}
/* shortcode in teamtestimonial page [teamtestimonial] */
  function shortcode_in_teamtestimonial($atts){
   $atts = shortcode_atts( array('count' => ''), $atts, 'team' );
   $count = ($atts['count']) ? $atts['count'] : -1;
   $type = 'team';
   $args=array(
   'post_type' => $type,
   'post_status' => 'publish',
   'posts_per_page' => $count,
   'orderby' => 'date',
   'order' => 'ASC'
   );
  $output = '';
   $loop = new WP_Query($args);
   if($loop->have_posts()) {
        $output .='<ul data-autoslide="3000" class="testimonials slider-content ts-cont psWithBullets">';
   while ( $loop->have_posts() ): $loop->the_post(); ?>
<?php $img = get_post_meta(get_the_ID(),'team_image_url',true);
       
        $output .= '<li class="ts-slide ts-loaded" style="left: 0px;"><article>';
	$output .= '<div class="testimonial-content"><p>'. substr(get_the_content(), 0, 200) .'</p><span class="cp-load-after-post"></span></div>';
	$output .= '<div class="testimonial-vcard"><div class="wf-td"><span class="alignleft"><img width="60" height="60" alt="" title="client" src="'. $img .'" class="lazy-load preload-me is-loaded" sizes="60px" srcset="'. $img .'"></span></div><div class="wf-td"><span class="text-primary">'. get_the_title() .'</span><br></div></div>';
        $output .= '</article></li>';
?>
   <?php endwhile;
 $output .='</ul>';
   }
  wp_reset_query();
  return $output;
  }
  
 /* End shortcode in teamtestimonial page */
/* shortcode teamtestimonial form page */
function shortcode_in_teamtestimonial_form(){
$team_form='';

$team_form .='<div class="team-test-page"><form id="team_testimonial" enctype="multipart/form-data" name="team_testimonial" class="team_testimonial_form" method="post" action="">
	<ul class="toprow">
<li><div class="team_block">
		<label>Your Name<span>*</span></label>
		<input type="text" name="team_name" id="team_name" maxlength="25" class="team_require" value="" />
		<div class="team_title_error wpvp_error"></div>
</div></li>
<li><div class="team_block">
        <div  class="team_position">
			<label>Choose Service</label>
			<select class="team_select " name="team_position" id="team_position">
              <option value="Web Development">Web Development</option><option value="Digital Marketing">Digital Marketing</option><option value="150">Mobile App Development</option><option value="Search engine optimization">Search engine optimization</option><option value="Software Testing">Software Testing</option><option value="Web Design">UX Design</option></select></div>
        </div></li>
</ul>
<ul class="bottomrow">
<li><div class="team_block">
		<label>Description</label>
		<textarea name="team_desc" id="team_desc"></textarea>
	</div></li>
<li><div class="team_block">
		<label>Image<span>*</span></label>
		<input type="file" id="teamimg" name="teamimg" class="team_require" value="" />
		<div class="wpvp_file_error wpvp_error"></div>
       
        <progress id="progress" value="0" style="display:none;"></progress><a id="closebar" class="closebar" style="display:none;">Close</a>
       
	</div></li>
<li><progress id="progress_data" value="0" style="display:none;"></progress>
       <div class="team_testimonial_mess">
		</div>
	<input type="hidden" name="team_action" value="team_upload" />
	<p class="wpvp_submit_block">
		<input type="button" action="create" class="team-submit" name="team-upload" value="Submit" />
	</p></li>
</ul>
</form></div>';

return $team_form;
}
/* ajax_request_team_form */
function ajax_request_team_form(){
require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');
global $current_user, $wpdb;
//print_r($_POST);
//print_r($_FILES);
get_currentuserinfo();
$user_id = $current_user->ID;
$size_limit = 5242880;
$title =$_POST['name']; $desc = $_POST['desc']; $team_position = $_POST['team_position']; 
$error = false;
$post = array(
				
				'post_author' => $user_id,
				'post_content' => $desc,
				'post_title' => $title,
				'post_type' => 'team',
				'post_status' => 'pending',
                                'meta_input' => array('team_position' => $team_position)
			);
			$post_id = wp_insert_post($post);
			if(!is_wp_error($post_id)){
                         foreach ($_FILES as $file){
                          if($file['size']>$size_limit){
                           $error = true;
                           $response = array('status'=>'error','msg'=>'File size is larger than 5MB!');
                          } else {
                           //$attach_id = media_handle_upload( $file, $post_id );
                           //set_post_thumbnail($post_id, $attach_id);
                           $override = array( 'test_form' => FALSE );
			   $uploaded_file = wp_handle_upload($file, $override);
					if($uploaded_file){
						$attachment = array(
							'post_title' => $file['name'],
							'post_content' => '',
							'post_type' => 'attachment',
							'post_parent' => 0,
							'post_mime_type' => $file['type'],
							'guid' => $uploaded_file['url']
						);
						$attach_id = wp_insert_attachment($attachment,$uploaded_file[ 'file' ]);
						wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $uploaded_file['file'] ) );
                                                  set_post_thumbnail($post_id, (int) $attach_id);
                                              update_post_meta($post_id,'team_image_url',$uploaded_file['url']);
                                             $postt_url = get_permalink($post_id);
                                               $response = array('status'=>'success','msg'=>$post_id);
                                   } else{
                                       $error = true;
                                       $response = array('status'=>'error','msg'=>$uploaded_file['error']);
                                        }
                          }
                         } 
                         
			} else {
			$response = array('status'=>'error','msg'=>$post_id->get_error_message());
			}
                     if($error){
                         echo json_encode($response); 
                         wp_delete_post( $post_id, true );
                       } else{
                      echo json_encode($response); 
                        $url = admin_url('post.php?post='.$post_id.'&action=edit');
                        $admin = get_bloginfo('admin_email');
			$subject = 'Team: New Testimonials Submitted';
                        //$headers = 'From: My Name <careers@webguruz.in>' . "\r\n";
			$message = '';
  $message .='<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:40px; text-align:left; font-weight:bold; color:#1fb5ac;">Dear Admin</td>
  </tr>
<tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; padding-top:15px">Here are the details of Enquiry :</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
    <div style="width:600px; float:left;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="40" width="150px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac;  border-left:1px solid #acacac; border-top:1px solid #acacac;"><strong>Name: </strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac; border-top:1px solid #acacac;">'.$title.'</td>
  </tr>
  <tr>
    <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Description:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac;">'.substr($desc, 0, 100).'.</td>
  </tr>
 <tr>
    <td colspan="2" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:center; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;"><a href="'.$url.'" target="_blank">Click here to view</a></td>
  </tr>
<tr>
    <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left;background:#e8e8e8; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Approval:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;background:#e8e8e8;  border-right:1px solid #acacac;"><a href="'.$url.'" target="_blank">Approval</a></td>
  </tr>
</table>
</div>
    </td>
  </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; color:#1fb5ac;">Thanks</td>
    </tr>
    <tr>
      <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; color:#1fb5ac; padding:5px 0px;">Webguruz Admin</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="100%" align="center" id="backgroundTable"><table width="570" border="0" cellspacing="0" cellpadding="0" class="devicewidth">
  <tr>
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Webguruz Technologies Pvt. Ltd was established in 2008. It employs around 50 employees. The company has its head office in Chandigarh with two branches, one in Croydon U.K,  and the second branch in india.<br /><br />

We’re proud to have these big names on our client list. </p></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="http://webguruz.in/wp-content/uploads/email/slogan1.png" alt="" /></td>
    <td align="center"><img src="http://webguruz.in/wp-content/uploads/email/slogan2.png" alt="" /></td>
    <td align="center"><img src="http://webguruz.in/wp-content/uploads/email/slogan3.png" alt="" /></td>
    <td align="center"><img src="http://webguruz.in/wp-content/uploads/email/slogan4.png" alt="" /></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td style="padding:15px 0 0;"><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Copyright © 2016  Webguruz Technologies Private Limited. All rights reserved.</p></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>
</table>';
$send_draft_notice = wp_mail('info@webguruz.in', $subject, $message);
                      
                         }
die;
}

/* ajax_request_team_file */
function ajax_request_team_file(){
$size_limit = 5242880;
//print_r($_POST);
//print_r($_FILES);
foreach($_FILES as $file){
if($file['size']>$size_limit){
$responsefile = array('status'=>'error','msg'=>'File size is larger than 5MB!');
echo json_encode($responsefile);
} else{
$responsefile = array('status'=>'success','msg'=>'');
echo json_encode($responsefile);
}
}
die;
}
function update_team_quicklinks($views) {
 
     unset($views['mine']);
 
     return $views;
 
}
?>
