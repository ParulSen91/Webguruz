<?php
/*
Plugin Name: packages
Plugin URI: https://webguruz.in
Description: Consist of various packages
Version: 1.0.0
Author: Webguruz
Author URI: https://webguruz.in
*/


function wpdocs_scripts_method() {
    /*wp_enqueue_script( 'bootstrap.min', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ),'', true );
     wp_enqueue_style( 'bootstrap.min', plugin_dir_url(__FILE__) . 'js/bootstrap.min.css' );
    */
    wp_enqueue_script( 'custom-script', plugin_dir_url( __FILE__ ) . 'js/custom_script.js', array( 'jquery' ),'', true );
     wp_enqueue_script( 'custom-valid', plugin_dir_url( __FILE__ ) . 'js/jquery.validate.min.js', array( 'jquery' ),'', true );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_scripts_method' );

//order details
function add_menu() {
add_menu_page('orders table','Order details', 'manage_options', 'my_new_menu', 'order_details', 'dashicons-editor-aligncenter', 7); 
}
add_action('admin_menu', 'add_menu');

function order_details() {
global $wpdb;
//echo "Page number=";
$page_num = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
$limit = 4; // Number of rows in page
 $offset = ( $page_num - 1 ) * $limit;
 $sql="SELECT * from wgttgw_orders";
        $res=$wpdb->get_results($sql);
/*        echo '<pre>';
print_r($res);

        echo '</pre>';*/

?>
<h1 align="center"><u>Webguruz Packages Table</u></h1>
<table align="center" border="1">
   <tr>
      <th>id</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Service Name</th>
      <th>Package Name</th>
      <th>Package Price</th>
      <th>Payment Status</th>
      <th>Payment Date</th>
    </tr>
   <?php foreach($res as $r)
    { ?>
        <tr> 
       <td>
       <?php echo $r->id; ?>
         </td>
          <td>
       <?php echo $r->name; ?>
         </td>
           <td>
       <?php echo $r->email; ?>
         </td>
          <td>
       <?php  echo $r->phone; ?>
         </td>
          <td>
       <?php echo $r->service_name; ?>
        </td>
       <td><?php echo $r->package_name; ?></td>
       <td><?php echo $r->package_money; ?></td>
       <td><?php echo $r->status; ?></td>
       <td><?php echo $r->date; ?></td>
      
        </tr>
   <?php 
 } ?>
 </table>
<?php
 }
?>