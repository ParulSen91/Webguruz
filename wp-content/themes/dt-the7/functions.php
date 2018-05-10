<?php
/**
 * Vogue theme.
 *
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since 1.0.0
 */
if ( ! isset( $content_width ) ) {
  $content_width = 1200; /* pixels */
}

/**
 * Initialize theme.
 *
 * @since 1.0.0
 */
require( trailingslashit( get_template_directory() ) . 'inc/init.php' );

 register_sidebar( array(
    'name' => __( 'Recent Post'),
    'id' => 'recent-post',
    'description' => __( 'Widget Area for Recent Post', 'twentyten' ),
    'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
    'after_widget' => "</li>",
    'before_title' => '<h3 class="widget-title">',
    'after_title' => '</h3>',
) ); 

function customize_scripts() {
wp_enqueue_script( 'customize-script-4', get_template_directory_uri() . '/custom/js/custom.js');
}
add_action( 'wp_enqueue_scripts', 'customize_scripts' );


add_action( 'init', 'create_tag_taxonomies', 0 );

//create two taxonomies, genres and tags for the post type "tag"
function create_tag_taxonomies() 
{
  // Add new taxonomy, NOT hierarchical (like tags)
  $labels = array(
    'name' => _x( 'Tags', 'taxonomy general name' ),
    'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Tags' ),
    'popular_items' => __( 'Popular Tags' ),
    'all_items' => __( 'All Tags' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Tag' ), 
    'update_item' => __( 'Update Tag' ),
    'add_new_item' => __( 'Add New Tag' ),
    'new_item_name' => __( 'New Tag Name' ),
    'separate_items_with_commas' => __( 'Separate tags with commas' ),
    'add_or_remove_items' => __( 'Add or remove tags' ),
    'choose_from_most_used' => __( 'Choose from the most used tags' ),
    'menu_name' => __( 'Tags' ),
  ); 

  register_taxonomy('tag','dt_portfolio',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'tag' ),
  ));
}

/*add table applyonline*/
/*function contactform7_before_send_mail( $form_to_DB ) {

global $wpdb;


$form_to_DB = WPCF7_Submission::get_instance();

if ( $form_to_DB ) {
$formData = $form_to_DB->get_posted_data();
}
$date = date("Y-m-d");
$position =$formData['position'];
$address =$formData['address'];
$telstd =$formData['tel-206'];

$telphone =$formData['tel-389'];
$reff =$formData['referredby'];
$name =$formData['name'];

$email =$formData['email'];
$mobile =$formData['mobile'];
$work_exp =$formData['work_exp'];

$captcha =$formData['quiz-853'];
$resume =$formData['resume'];
$referredby =$formData['referredby'];
$shortmess =$formData['shortmess'];


$wpdb->insert( 'applyonline', array( 'submitted' => $date , 'position' => $position, 'address' => $address, 'tel206' => $telstd, 'tel389' => $telphone, 'reff' => $reff, 'name' => $name, 'email' => $email, 'mobile' => $mobile, 'work_exp' => $work_exp, 'quiz853' => $captcha, 'resume' => $resume,'linkedInprofile' => $referredby,'shortdesc' => $shortmess), array( '%s' ) );

}*/


//remove_all_filters ('wpcf7_before_send_mail');
/*add_action( 'wpcf7_before_send_mail', 'contactform7_before_send_mail' );*/

function remove_cssjs_ver( $src ) {
 if( strpos( $src, '?ver=' ) )
 $src = remove_query_arg( 'ver', $src );
 return $src;
}
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );

//defer_all_filters ('defer_parsing_of_js');
function defer_parsing_of_js ( $url ) {
//if ( FALSE === strpos( $url, '.js' ) ) return $url;
if ( strpos( $url, 'jquery.js' ) ) return $url;
return "$url";
}
add_filter( 'clean_url', 'defer_parsing_of_js', 11, 1 );

//*form blog page*//
add_action('wp_ajax_formblog_filter', 'ajax_formblog_filter');
add_action('wp_ajax_nopriv_formblog_filter', 'ajax_formblog_filter');

//Construct Loop & Results
function ajax_formblog_filter()
{
global $wpdb;
parse_str($_POST['data'], $array);
$fname = $array['fname'];
$email = $array['email'];
$subject = $array['blogtitle'];
if(empty($fname) || empty($email)){
echo "Please enter name and email!";
}
else{
$to ='info@webguruz.in';
 $headers = array();

        // Override the default 'From' address
        $headers['From'] = 'info@webguruz.in';

        // Send the message as HTML
        $headers['Content-Type'] = 'text/html';

        // Enable open tracking (requires HTML email enabled)
        $headers['X-PM-Track-Opens'] = true;
  
        $file2 = 'https://www.webguruz.in/wp-content/uploads/2017/09/webguruz-ppt.pdf'; // URL to the file
                  
                    $contents = file_get_contents($file2); // read the remote file
                    touch('companyprofile.pdf'); // create a local EMPTY copy
                    file_put_contents('companyprofile.pdf', $contents);

                    $mail_attachment_rec = array($_SERVER['DOCUMENT_ROOT'] ."/wp-content/themes/dt-the7/companyprofile.pdf");

        
$message = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
$message = '<tr>
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
  $message .= '<tr>';
    $message .= '<td style="font-family:Arial, Helvetica, sans-serif; font-size:40px; text-align:left; font-weight:bold; color:#1fb5ac;">Dear Business Team</td>';
  $message .= '</tr>';
  $message .= '<tr>';
   $message .= ' <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold;">Here are the details of Enquiry :</td>';
  $message .= '</tr>';
  $message .= '<tr>';
    $message .= '<td>';
    $message .= '<div style="width:600px; float:left;">';
    $message .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
  $message .= '<tr>';
    $message .= '<td height="40" width="150px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac;  border-left:1px solid #acacac; border-top:1px solid #acacac;"><strong>Name: </strong></td>';
    $message .= '<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac; border-top:1px solid #acacac;">'.$fname.'</td>';
  $message .= '</tr>';
  $message .= '<tr>';
    $message .= '<td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac;border-bottom:1px solid #acacac; border-left:1px solid #acacac;"><strong>Email:</strong></td>';
    $message .= '<td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;border-bottom:1px solid #acacac;  border-right:1px solid #acacac;">'.$email.'</td>';
  $message .= '</tr>';
$message .= '</table>';
$message .= '</div>';
    $message .= '</td>';
  $message .= '</tr>';
   $message .= ' <tr>';
      $message .= '<td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; color:#1fb5ac;">Thanks</td>';
    $message .= '</tr>';
    $message .= '<tr>';
     $message .= ' <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; text-align:left; font-weight:bold; color:#1fb5ac; padding:5px 0px;">Webguruz</td>';
   $message .= ' </tr>';
    $message .= '<tr>';
    $message .= '<td>&nbsp;</td>';
  $message .= '</tr>';
$message .= '<tr>
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
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Webguruz Technologies Pvt. Ltd was established in 2008. It employs around 50 employees. The company has its head office in Chandigarh,INDIA and one Branch office in Croydon, UK.<br /><br />
 </tr>
  
  <tr>
    <td style="padding:0px 0 0;"><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif; margin-top: 0;">Copyright © 2018  Webguruz Technologies Private Limited. All rights reserved.</p></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>';
$message .= '</table>'; 


//==============mess 2 //
$message2 = '<div style="margin:0; padding:0;">
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
    <td><h1 style="font-size:24px; color:#000000; text-align:left; font-family:Arial, Helvetica, sans-serif; padding:0">Dear '.$fname.'</h1></td>
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
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">We will get back to you within 48 hours. The information submitted by<br />you will remain confidential.</p></td>
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
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Webguruz Technologies Pvt. Ltd was established in 2008. It employs around 50 employees. The company has its head office in Chandigarh,INDIA and one Branch office in Croydon, UK.<br /><br />
 </p></td>
  </tr>
  <tr>
  
  </tr>
  <tr>
    <td style="padding:0px 0 0;"><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif; margin-top: 0;">Copyright © 2018  Webguruz Technologies Private Limited. All rights reserved.</p></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>
</table>
</div>';   



//====
 $results = $wpdb->get_var( "SELECT COUNT(email) FROM formblog WHERE email = '".$email."'" );
if($results == 0){
//echo $results->email;
$response = wp_mail( $to, $subject, $message, $headers );
 $response2 = wp_mail( $email, $subject, $message2, $headers, $mail_attachment_rec );
 $user_id = $wpdb->insert( 
  'formblog', 
  array(
        'name' => $fname,
        'email'  => $email
    )
);

    if ( ! is_wp_error( $user_id ) ) {
     echo "Thankyou for form submitting";

  }else {
       echo "error";
        }
  }else{
     echo "Email already exist";
      }
}
die;
}
//*End form blog page*//
//==shortcode form blog page// 
function shortcode_in_formblog(){
$contents = '';
$contents .='<form method="post" action="" name="formblog" id="formblog"> ';
$contents .='<div id="formblog-message"></div>';
$contents .='<div class="row">';
$contents .='<div class="col-md-6 textleft">';
$contents .='<div class="form-group">';
$contents .='<label class="control-label">Your Name</label>';
$contents .='<div class="input-group" id="first">';
$contents .='<input type="text"  id="fname" class="form-control" name="fname" placeholder="Enter name"/>';
$contents .='</div>';
$contents .='</div>';
$contents .='</div>';
                        $contents .='<div class="col-md-6 textleft">';
                          $contents .='<div class="form-group">';
                            $contents .='<label class="control-label">Your Email</label>';
                            $contents .='<div class="input-group" id="second">';
                              $contents .='<input type="text"  id="email" name="email" class="form-control" placeholder="Enter your mail"/>';
                           $contents .='</div>';
                          $contents .='</div>';
                        $contents .='</div>';
                      $contents .='</div>';
                      $contents .='<div class="row">';
                       $contents .='<div class="col-md-12">';
                        $contents .='<input id="blogtitle" type="hidden" value="'.get_the_title().'" class="form-control" name="blogtitle" />';               
                       $contents .='<input id="formblogbtn" type="button" value="Submit" class="fblog-btn" name="submit" />';
                        $contents .='</div>';
                      $contents .='</div>';
                    $contents .='</form>';
return $contents;
}
add_shortcode( 'formblog', 'shortcode_in_formblog' );
//*form blog page*//
add_action('wp_ajax_request_filter', 'ajax_request_filter');
add_action('wp_ajax_nopriv_request_filter', 'ajax_request_filter');

//Construct Loop & Results
function ajax_request_filter()
{
require( trailingslashit( get_template_directory() ) . 'request_data.php' );
die;
}
add_action('wp_ajax_special_offer', 'ajax_special_offer');
add_action('wp_ajax_nopriv_special_offer', 'ajax_special_offer');

//Construct Loop & Results
function ajax_special_offer()
{
require( trailingslashit( get_template_directory() ) . 'special_offer_code.php' );
die;
}

function category_dropdown_filter( $cat_args ) {
        $cat_args['show_option_none'] = __('Select Category');
        return $cat_args;
}
add_filter( 'widget_categories_dropdown_args', 'category_dropdown_filter' );

//============seo Custom Post==

add_action('init', 'project_custom_init');  
  
  /*-- Custom Post Init Begin --*/
  function project_custom_init()
  {
    $labels = array(
    'name' => _x('Seo Projects', 'post type general name'),
    'singular_name' => _x('Project', 'post type singular name'),
    'add_new' => _x('Add New', 'project'),
    'add_new_item' => __('Add New Project'),
    'edit_item' => __('Edit Project'),
    'new_item' => __('New Project'),
    'view_item' => __('View Project'),
    'search_items' => __('Search Projects'),
    'not_found' =>  __('No projects found'),
    'not_found_in_trash' => __('No projects found in Trash'),
    'parent_item_colon' => '',
    'menu_name' => 'Seo Project'

    );
    
   $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array('title','editor','author','thumbnail','excerpt','comments', 'post-formats', 'custom-fields')
    );
    // The following is the main step where we register the post.
    register_post_type('seoproject',$args);
    
    // Initialize New Taxonomy Labels
    $labels = array(
    'name' => _x( 'Category', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Types' ),
    'all_items' => __( 'All Categorys' ),
    'parent_item' => __( 'Parent Category' ),
    'parent_item_colon' => __( 'Parent Category:' ),
    'edit_item' => __( 'Edit Category' ),
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    );
    // Custom taxonomy for Project Tags
    register_taxonomy('seocategory',array('seoproject'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'seocategory' ),
    ));
    
  }
  /*-- Custom Post Init Ends --*/

function shortcode_in_video(){
$videos = '';
$videos .='<div class="videos">';
$videos .=''.do_shortcode('[wpvp_upload_video]').'';
$videos .='</div>';
return $videos;
}
add_shortcode( 'videos', 'shortcode_in_video' );
//======= Get video testimonials
add_shortcode( 'testimonial', 'shortcode_in_testimonial' );
function shortcode_in_testimonial($atts){
$atts = shortcode_atts( array('count' => ''), $atts, 'videos' );
   $count = ($atts['count']) ? $atts['count'] : 6;
   $type = 'videos';
   $args=array(
   'post_type' => $type,
   'post_status' => 'publish',
   'posts_per_page' => -1,
   'orderby' => 'date',
   'order' => 'ASC'
   );  
$testimonial = '';
$loop = new WP_Query($args);
   if($loop->have_posts()) {
   $testimonial .='<div class="client-testimonials"><ul>';
   while ( $loop->have_posts() ): $loop->the_post();
   $position = get_post_meta(get_the_ID(),'wpvp_position', true); 
   $company = get_post_meta(get_the_ID(),'wpvp_company', true); 
   $email = get_post_meta(get_the_ID(),'wpvp_email', true);
   $content = get_the_content();
   $urlDir = get_template_directory_uri();
   //$site_url = get_site_url();
$image_url = get_post_meta(get_the_ID(),'image_url', true);
//$image_url = (get_post_meta(get_the_ID(),'image_url', true)) ? get_post_meta(get_the_ID(),'image_url', true) : $urlDir.'/images/male-avatar-1.jpg'; 
   $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()), 'thumbnail' );
$testimonial .='<li>
              <div class="client-image">
                <img src="' . $image_url .'" alt="clien-1" />
                </div>
                <div class="client-details">
                  <h4>' . get_the_title() . '</h4>
                    <span>' . $position. '</span>
                    <span>' . $company . '</span>
                </div>
                <div class="client-text">
               <p>'.substr($content, 0, 100).'</p>
                    <a class="js-open-modal" href="#" data-modal-id="popup'.get_the_ID().'">Read More</a>
                </div>
                <div id="popup'.get_the_ID().'" class="modal-box">
  <header> <a href="#" class="js-modal-close close"><img src="'.$urlDir.'/images/cross.png" alt="close" /></a>
    <div class="small-client-image">
     <img src="' . $image_url .'" alt="clien-1" />
    </div>
    <h3>' . get_the_title() . ', ' . $position . ', ' . $company . ' </h3>
  </header>
  <div class="modal-body">
    <p>'.$content.'</p>
  </div>
</div></li>';
     
endwhile;
$testimonial .='</ul></div>';
   }
  wp_reset_query();
return $testimonial;
}

add_shortcode( 'videos', 'shortcode_in_video' );
//======= Get video testimonials
add_shortcode( 'testimonialvideo', 'shortcode_in_testimonialvideo' );
function shortcode_in_testimonialvideo($atts){
$atts = shortcode_atts( array('count' => ''), $atts, 'videos' );
   $count = ($atts['count']) ? $atts['count'] : 6;
   $type = 'videos';
   $args=array(
   'post_type' => $type,
   'post_status' => 'publish',
   'posts_per_page' => $count,
   'orderby' => 'date',
   'order' => 'ASC',
   'meta_query' => array(
          array(
            'key' => 'eg_youtube_ratio',
            'value' => '',
            'compare' => '!='
            )
          )
   );  
$testimonialvideo = '';
$loop = new WP_Query($args);
   if($loop->have_posts()) {
   $testimonialvideo .='<div class="client-testimonials-video"><ul>';
   while ( $loop->have_posts() ): $loop->the_post();
   $position = get_post_meta(get_the_ID(),'wpvp_position', true); 
   $company = get_post_meta(get_the_ID(),'wpvp_company', true); 
   $video = get_post_meta(get_the_ID(),'eg_youtube_ratio', true); 
   $content = get_the_content();
   $urlDir = get_template_directory_uri();
   $url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()), 'thumbnail' );

$testimonialvideo .='<li>
              <div class="client-video">
                <iframe width="265" height="225" src="'.$video.'" frameborder="0" autoplay="false" allowfullscreen></iframe>
               
                </div>
                <div class="client-details">
                  <h4>' . get_the_title() . '</h4>
                    <span>' . $position. '</span>
                    <span>' . $company . '</span>
                </div></li>';

     
endwhile;
$testimonialvideo .='</ul></div>';
   }
  wp_reset_query();
return $testimonialvideo;
}

require( trailingslashit( get_template_directory() ) . 'teamtestimonial/teamtestimonial.php' );
//======== schedule call form data ===========
add_action('wp_ajax_schedule_form', 'ajax_request_schedule_form');
add_action('wp_ajax_nopriv_schedule_form', 'ajax_request_schedule_form');

function ajax_request_schedule_form(){
include('/home/proglasscpanel/webguruz.in/wp-content/themes/dt-the7/google-api-php-client/src/Google_Client.php');
include('/home/proglasscpanel/webguruz.in/wp-content/themes/dt-the7/google-api-php-client/src/contrib/Google_CalendarService.php'); 
//$sltCountry =$_POST['sltCountry'];
// print_r($_POST);
  $sltTimeZone =$_POST['sltTimeZone']; $datetimepicker = $_POST['datetimepicker3']; $name = $_POST['name']; $email = $_POST['email']; $phone = $_POST['phone'];
$desc = $_POST['desc']; 
global $wpdb;
//$sltCountry =$_POST['sltCountry'];
/*$rows = $wpdb->get_results( "SELECT * FROM timezonesdb WHERE countrycode = '$sltCountry' group by countryname" );
//print_r($rows);
foreach($rows as $rec) {
$counrty = $rec->countryname;
}*/

$datetime1 = date('Y-m-d H:i:s',strtotime($_POST['datetimepicker3']));
$date = new DateTime($datetime1, new DateTimeZone($sltTimeZone));
$start_RFC3339 = $date->format('Y-m-d\TH:i:sP');
$date->add(new DateInterval('PT'.'30'.'M'));
$end_RFC3339 = $date->format('Y-m-d\TH:i:sP');
//echo $end_RFC3339 = date("c", strtotime('+30 minutes', strtotime($datetime1)));
$sql = $wpdb->insert('wgt_schedule_call', array('name' => $name,'email' => $email,'phone'=>$phone,'desc'=> $desc,'timezone'=>$sltTimeZone,'date_time'=>$datetime1));
$client = new Google_Client();
$token= $_POST['code'];
$client->setApplicationName("Google Calendar PHP Starter Application");
session_start();
// Visit https://code.google.com/apis/console?api=calendar to generate your
// client id, client secret, and to register your redirect uri.
 $scopes = "https://www.googleapis.com/auth/calendar";
 $client->setClientId('886799774079-8gc3gv5ulo5a3kktb1fl4u33hak3e3uc.apps.googleusercontent.com');
 $client->setClientSecret('zADa38M444Z6CXPjWb-n9pCT');
// $client->setRedirectUri(get_template_directory_uri().'/getCode.php');
 $client->setDeveloperKey('AIzaSyDYBKTvT13ME5_Vc3Dr37TdsVkMp43Q4jE');
 $client->setScopes($scopes);
 $cal = new Google_CalendarService($client);
  $client->setAccessToken('{"access_token":"ya29.GlusBHO70UexRNPzidJc3X96QMOyg2lL4O-Lff7VonzZEvTaoYm00rQHAIgM-L5x0wv3M2qR0coGV1WHWm_fG8vKphAwdcR42bgkdJzTkLY4yickidZkMCH9lAkp","expires_in":3600,"refresh_token":"1/9cA9AcMREc4ruCyvOdoXV1evr9gBd8YxPLP3BcHrTXU","token_type":"Bearer","created":1503125829}');
  
  $event = new Google_Event();
  $event->setSummary('Call Scheduled with '.$_POST['name']);
  $event->setLocation('Webguruz Technologies');
  $start = new Google_EventDateTime();
  $start->setDateTime($start_RFC3339);
  $event->setStart($start);
  $end = new Google_EventDateTime();
  $end->setDateTime($end_RFC3339);
  $event->setEnd($end);
  $attendee1 = new Google_EventAttendee();
  $attendee1->setEmail($_POST['email']);
  $attendee2 = new Google_EventAttendee();
  $attendee2->setEmail('provider@webguruz.in');
  $attendees = array($attendee1, $attendee2);
  $event->attendees = $attendees;
  $calendarId = 'primary';
  $optParams = Array(
        'sendNotifications' => true,
);
 /* print_r($event);*/
  $createdEvent = $cal->events->insert( $calendarId , $event, $optParams);
//date_default_timezone_set($sltTimeZone);

$date_time = date("F d , Y , h:i A", strtotime($datetimepicker)); 
//date("F d, Y , h:i A");
$siteurl = site_url();
//$admin = get_bloginfo('admin_email');
      $subject = 'Schedule Call';
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
    <td width="208"><a href="'.$siteurl.'"><img src="http://webguruz.in/wp-content/uploads/email/logo.png" alt="" /></a></td>
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
 <!--tr>
     <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Country:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$counrty.'.</td>
  </tr-->
  <tr>
    <td height="40" width="150px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac;  border-left:1px solid #acacac; border-top:1px solid #acacac;"><strong>TimeZone: </strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac; border-top:1px solid #acacac;">'.$sltTimeZone.'</td>
  </tr>
  <tr>
     <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Date time:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$date_time.'.</td>
  </tr>
  <tr>
    <td height="40" width="150px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac;  border-left:1px solid #acacac; border-top:1px solid #acacac;"><strong>Name: </strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac; border-top:1px solid #acacac;">'.$name.'</td>
  </tr>
<tr>
   <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Email:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$email.'.</td>
  </tr>
<tr>
    <td height="40" width="150px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac;  border-left:1px solid #acacac; border-top:1px solid #acacac;"><strong>Phone: </strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac; border-top:1px solid #acacac;">'.$phone.'</td>
  </tr>
<tr>
   <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Description:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$desc.'.</td>
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
    <td align="center"><p style="line-height:23px; font-size:16px; color:#a0a0a0; font-family:Arial, Helvetica, sans-serif;">E-mail: <a href="mailto:info@webguruz.in" style="color:#a0a0a0; text-decoration:none;">info@webguruz.in</a><br />
Website: <a href="'.$siteurl.'" target="_blank" style="color:#a0a0a0; font-family:Arial, Helvetica, sans-serif; text-decoration:none;">www.webguruz.in</a> </p></td>
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
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Webguruz Technologies Pvt. Ltd was established in 2008. It employs around 50 employees. The company has its head office in Chandigarh,INDIA and one Branch office in Croydon, UK.<br /><br />
 </tr>
 
  <tr>
    <td style="padding:0px 0 0;"><p style="color:#606060; font-size:14px; margin-top: 0; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Copyright © 2018  Webguruz Technologies Private Limited. All rights reserved.</p></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>
</table>';
$message_u .='<div style="margin:0; padding:0;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#dbdbdb">
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
    <td><h1 style="font-size:24px; color:#000000; text-align:left; font-family:Arial, Helvetica, sans-serif; padding:0">Dear '.$name.'</h1></td>
  </tr>
  <tr>
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Thank you for your submit schedule
.</p></td>
  </tr>
  <tr>
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Thank You for providing us your schedule. We will get in touch with you as per the date and time indicated by you.</p></td>
  </tr>
<tr>
    <td>
    <div style="width:100%; float:left;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <!--tr>
     <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;border-top: 1px solid #acacac;"><strong>Country:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;border-top: 1px solid #acacac;">'.$counrty.'.</td>
  </tr-->
  <tr>
    <td height="40" width="150px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac;  border-left:1px solid #acacac; border-top:1px solid #acacac;"><strong>TimeZone: </strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac; border-top:1px solid #acacac;">'.$sltTimeZone.'</td>
  </tr>
  <tr>
     <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Date time:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$date_time.'.</td>
  </tr>
  <tr>
    <td height="40" width="150px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac;  border-left:1px solid #acacac; border-top:1px solid #acacac;"><strong>Name: </strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac; border-top:1px solid #acacac;">'.$name.'</td>
  </tr>
<tr>
   <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;"><strong>Email:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;">'.$email.'.</td>
  </tr>
<tr>
    <td height="40" width="150px" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px; border-right:1px solid #acacac;  border-left:1px solid #acacac; border-top:1px solid #acacac;"><strong>Phone: </strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; background:#e8e8e8; padding-left:15px;  border-right:1px solid #acacac; border-top:1px solid #acacac;">'.$phone.'</td>
  </tr>
<tr>
   <td height="40" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px; border-right:1px solid #acacac; border-left:1px solid #acacac;border-bottom: 1px solid #acacac;"><strong>Description:</strong></td>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; text-align:left; font-weight:normal; padding-left:15px;  border-right:1px solid #acacac;border-bottom: 1px solid #acacac;">'.$desc.'.</td>
  </tr>
</table>
</div>
    </td>
  </tr>
  <tr>
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">As always, we appreciate your confidence and trust in us.</p></td>
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
    <td><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif;">Webguruz Technologies Pvt. Ltd was established in 2008. It employs around 50 employees. The company has its head office in Chandigarh,INDIA and one Branch office in Croydon, UK.<br /></p></td>
  </tr>
  <tr>
    <td style="padding:0px 0 0;"><p style="color:#606060; font-size:14px; padding-bottom:10px; line-height:21px; font-family:Arial, Helvetica, sans-serif; margin-top: 0;">Copyright © 2018  Webguruz Technologies Private Limited. All rights reserved.</p></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>
</table>
</div>';
//$send_draft_notice = wp_mail('info@webguruz.in', $subject, $message);
//$send_draft_notice_u = wp_mail($email, $subject, $message_u);
$response = array('status'=>'success','msg'=>'true');
echo json_encode($response); 

die;
}
//======== country data ===========
add_action('wp_ajax_country_form', 'ajax_request_country_form');
add_action('wp_ajax_nopriv_country_form', 'ajax_request_country_form');

function ajax_request_country_form(){
global $wpdb;
$sltCountry =$_POST['sltCountry'];
$rows = $wpdb->get_results( "SELECT * FROM timezonesdb WHERE countrycode = '$sltCountry' group by utc" );
//print_r($rows);
foreach($rows as $rec) {
//echo $rec->country_code.'--'. $rec->country_name;
echo '<option value="'.$rec->timezone.'">'.$rec->timezone.' UTC( '.$rec->utc.' )</option>';
}
die;
}
add_action( 'pre_get_posts', 'foo_modify_query_exclude_category' );
function foo_modify_query_exclude_category( $query ) {
    if ( ! is_admin() && is_main_query() && ! $query->get( 'cat' ) )
        $query->set( 'cat', '-5' );
}
add_action('template_redirect', 'post_redirect', 99);

function post_redirect()
{
   
    if( is_singular( 'seoproject' ) || is_post_type_archive( 'seoproject' ) || is_post_type_archive( 'dt_gallery' ) || is_tax( 'dt_portfolio_category' ) || is_post_type_archive( 'servicepackage' )) {
        wp_redirect( home_url(), 301 );
        exit();
    }
    elseif(is_date() ) {
         wp_redirect( home_url(), 301 );
         exit;
     }
}

function speed_stop_loading_wp_embed() {
if (!is_admin()) {
wp_deregister_script('wp-embed');
}
}
add_action('init', 'speed_stop_loading_wp_embed');

// Remove comment-reply.min.js from footer
function comments_clean_header_hook(){
 wp_deregister_script( 'comment-reply' );
 }
add_action('init','comments_clean_header_hook');
/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param    array  $plugins  
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

/*add_action( 'init', 'custom_notificaion' );*/
add_action( 'init', 'codex_servicepackage_init' );
/**
 * Register a book post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_servicepackage_init() {
  $labels = array(
    'name'               => _x( 'Servicepackage', 'post type general name', 'your-plugin-textdomain' ),
    'singular_name'      => _x( 'Servicepackage', 'post type singular name', 'your-plugin-textdomain' ),
    'menu_name'          => _x( 'Servicepackages', 'admin menu', 'your-plugin-textdomain' ),
    'name_admin_bar'     => _x( 'Servicepackage', 'add new on admin bar', 'your-plugin-textdomain' ),
    'add_new'            => _x( 'Add New', 'servicepackage', 'your-plugin-textdomain' ),
    'add_new_item'       => __( 'Add New Servicepackage', 'your-plugin-textdomain' ),
    'new_item'           => __( 'New Servicepackage', 'your-plugin-textdomain' ),
    'edit_item'          => __( 'Edit Servicepackage', 'your-plugin-textdomain' ),
    'view_item'          => __( 'View Servicepackage', 'your-plugin-textdomain' ),
    'all_items'          => __( 'All Servicepackages', 'your-plugin-textdomain' ),
    'search_items'       => __( 'Search Servicepackages', 'your-plugin-textdomain' ),
    'parent_item_colon'  => __( 'Parent Servicepackages:', 'your-plugin-textdomain' ),
    'not_found'          => __( 'No Servicepackages found.', 'your-plugin-textdomain' ),
    'not_found_in_trash' => __( 'No Servicepackages found in Trash.', 'your-plugin-textdomain' )
  );

  $args = array(
    'labels'             => $labels,
                'description'        => __( 'Description.', 'your-plugin-textdomain' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'packages' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
  );

  register_post_type( 'servicepackage', $args );
}
function cf7_custom_textarea_validation($result, $tag) {
  $type = $tag['type'];
  $name = $tag['name'];
  
  //if empty give required field error
  if($type == 'textarea*' && $_POST[$name] == 'your-message'){
      $result['valid'] = false;
      $result['reason'][$name] = wpcf7_get_message( 'invalid_required' );
  }
  

  if($name == 'your-message'){
    $addressTa = $_POST['your-message'];
    
    if($addressTa != '') {
      if(!preg_match('/^[a-z0-9 .\-\@]+$/i', $addressTa )) {
        $result['valid'] = false;
        $result['reason'][$name] = 'Invalid format. Special characters are not allowed';
      }
    }
  }
  
  return $result;
  
}
//add fiter for text area validation
add_filter( 'wpcf7_validate_textarea', 'cf7_custom_textarea_validation', 10, 2 );
add_filter( 'wpcf7_validate_textarea*', 'cf7_custom_textarea_validation', 10, 2 );

add_action('wp_ajax_user_guide_code', 'ajax_user_guide_code');
add_action('wp_ajax_nopriv_user_guide_code', 'ajax_user_guide_code');

//Construct Loop & Results
function ajax_user_guide_code()
{
require( trailingslashit( get_template_directory() ) . 'user_guide_code.php' );
die;
}
add_action('wp_ajax_request_package_orders', 'ajax_request_package_orders');
add_action('wp_ajax_nopriv_request_package_orders', 'ajax_request_package_orders');

function ajax_request_package_orders()
{
require( trailingslashit( get_template_directory() ) . 'package_orders.php' );
die;
}

add_action('wp_ajax_promocode', 'ajax_promocode');
  add_action('wp_ajax_nopriv_promocode', 'ajax_promocode');

    //Construct Loop & Results
    function ajax_promocode()
    {
      Global $wpdb;
 /* print_r($_POST);*/
  $dateFrom = date("Y-m-d", strtotime(str_replace('/', '-', $_POST["custom_from"])));
 $dateTO = date("Y-m-d", strtotime(str_replace('/', '-', $_POST["custom_to"])));
 $qry='SELECT id from promocode WHERE name= "'.$_POST['custom_promocode'].'"';
 $res=$wpdb->get_var($qry);
 if($res > 0){

  echo 'already exist';

 }
 else{
   $sql =$wpdb->insert( 'promocode', array( 'name' => $_POST["custom_promocode"] , 'discount_percent' => $_POST["custom_discount"], 'valid_from' => $dateFrom, 'valid_to' => $dateTO), array( '%s' ) );
   print_r($sql);
 }
  
die;
    }
    add_filter( 'wpcf7_validate_textarea', 'custom_email_confirmation_validation_filter', 20, 2 );
 
function custom_email_confirmation_validation_filter( $result, $tag ) {
    $your_message = isset( $_POST['your-message'] ) ? trim( $_POST['your-message'] ) : '';
    if($your_message == 'Hello. And Bye.' )
         $result->invalidate( $tag, "Invalid Message" );
    return $result;
}

