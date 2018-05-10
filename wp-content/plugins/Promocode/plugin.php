<?php
/*
* Plugin Name: Promocode By Wgt
* Plugin URI: http://www.minustheagent.com.au/
* Description: Create your WordPress shortcode <php echo do_shortcode('[test]');?>.
* Version: 1.0
* Author: Jyoti Panwar
* Author URI: http://google.com
*/

// Example 1 : WP Shortcode to display form on any page or post.
//require( '/home/minusth/public_html/wp-blog-header.php' );
global $wpdb;
add_action( 'admin_menu', 'register_promocode_menu' );
   
function register_promocode_menu()
{

	add_submenu_page( 'options-general.php', 'Custom_Promocode', 'Custom_Promocode', 'manage_options', 'Custom_Promocode', 'Custom_Promocode' );
	
}

function Custom_Promocode(){

	
?>
		 <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"
        type="text/javascript"></script>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css"
        rel="Stylesheet" type="text/css" />
        <script type="text/javascript">
		        jQuery(function () {
		            jQuery('#custom_from').datepicker({
		                dateFormat: "dd/mm/yy",
		                changeMonth: true,
		                changeYear: true
		            });

		             jQuery('#custom_to').datepicker({
		                dateFormat: "dd/mm/yy",
		                changeMonth: true,
		                changeYear: true
		            });
		        });
		    </script>
		    <style type="text/css">
		        body
		        {
		            font-family: Arial;
		            font-size: 10pt;
		        }
		        #custom_from
		        {
		            
		            background-repeat: no-repeat;
		            padding-left: 25px;
		        }
		        #custom_to
		        {
		          
		            background-repeat: no-repeat;
		            padding-left: 25px;
		        }
		    </style>

		<form method="POST" id="addPromo" >
			<table class="table-responsive" style="border:1px solid;" cellspacing="5" cellpadding="5">
				<tr>
				<th style="text-align:right;">PromoCode</th>
				<td><input type="text" name="custom_promocode" id="custom_promocode" value="<?php echo $promocode;?>" required ></td>
			</tr>
			
			<tr>
				<th style="text-align:right;">Discount(%)</th>
				<td><input type="text" required name="custom_discount" id="custom_discount" value=""></td>
			</tr>
			<tr>
				<th style="text-align:right;">From</th>
				<td><input type="text" required name="custom_from" id="custom_from" value=""></td>
			</tr>
			<tr>
				<th style="text-align:right;">To</th>
				<td><input type="text" required name="custom_to" id="custom_to" value=""></td>
			</tr>
			<tr>
				<!--<th style="text-align:right;">Sell/Rent</th>
				<td>Sell<input type="radio" name="sell_rent" id="sell_rent" value="SELL">
			Rent<input type="radio" name="sell_rent" id="sell_rent" value="RENT"></td>-->
				
			</tr>
			<tr>
			<td style="text-align:right;"><input type="submit" name="sbmt" id="sbmt" value="Save" class="button button-primary button-large"></td>
			</tr>
		    
		</table>
		</form>
		<p class="msg"></p>

		<?php
		global $wpdb;

 $sql="SELECT * from promocode";
        $res=$wpdb->get_results($sql);
?>
<h1 align="center"><u>Webguruz Packages Table</u></h1>
<table align="center" border="1">
   <tr>
      <th>id</th>
      <th>Promocode</th>
      <th>Discount Percentage</th>
      <th>Valid From</th>
      <th>Valid To</th>
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
       <?php echo $r->discount_percent; ?>
         </td>
          <td>
       <?php  echo $r->valid_from; ?>
         </td>
          <td>
       <?php echo $r->valid_to; ?>
        </td>
      
        </tr>
   <?php 
 } ?>
 </table>
		<script>
		jQuery(document).ready(function($){ 
		
		$( "#addPromo" ).submit(function( event ) {
  
			  event.preventDefault();
			  var serializedData= $( "#addPromo" ).serialize()+'&action=promocode';
			  var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;

						/*alert(formdata)*/

						$.ajax({


					                      type: 'POST',
					                      url: ajax_url,
					                      action: 'promocode',
					                      data: serializedData,
					                        
					                      

					                      success: function(data)
					                     		 {

					                     
					                                     if(data=='already exist'){
					                                     	
					                                         $('.msg').html('This promocode is already exist.').css('color','red');
					                                         
					                                               
					                                        }
					                                        else{

					                                        $('.msg').html('Added successfully!!');
					                                        $("#addPromo").trigger("reset");
					                                    
					                                         $('#addPromo').each(function(){
					                                         this.reset();
					                                             });
					                                         location.reload();
					                                        }
					                                          
					                    		  }
					                      
					                    });
			});
			});
		</script>
<?php
		
}
?>