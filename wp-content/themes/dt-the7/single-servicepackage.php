<?php
/**
 * The Template for displaying all single posts.
 *
 * @package The7
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header( 'single' ); 
?>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
			<div id="dialogForm" style="width:500px">
			    <form id="myform" method="post" class="package-form" >
			       
			        <input id="name" name="name" placeholder="Name" type="text"/><br/>
			      
			        <input  id="email" name="email" placeholder="Email" type="email"/><br/>
			     
			        <input  id="phone" name="phone" placeholder="Phone" type="text"/><br/>
			        <input  name="action_type" type="hidden" value="save_info" />
			        <input  name="service_name" type="hidden" value="<?php echo get_the_title(); ?>" />
			        <img id="loading-image" alt="loading" class="loadingimg" src="<?php echo bloginfo('template_url'); ?>/giphy.gif" style="display:none;"/>
			       <button type="button" id="getes" class="package-submit submit"> Submit </button>
			        
			    </form>
			    <p class="msg"></p>
			    
			</div>
			<script type="text/javascript">
					jQuery(document).ready(function($){  

					    $("#dialogForm").dialog({
					        modal: true,
					        closeOnEscape: false,
					        autoOpen: true,
							title:'Get Started',
							 width: '500px',

					        show: {effect: "blind", duration: 800, top: '400px'},
					          /*open: function(event, ui) {
							        $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
							    }*/
					    });

					  
					    $.validator.addMethod("loginRegex", function(value, element) {
					        return this.optional(element) || /^[a-z0-9\- . @\s]+$/i.test(value);
					    }, "Please enter only letters, numbers, or (@ , . , -) only.");
					   	
					   	$("#myform").validate({
        // Specify the validation rules

    
    
							        rules: {
							            name: {
							      required: true,
							      maxlength: 25,
							      loginRegex : true
							       },
							      email: {
							                required: true,
							                  email: true
							               },
							            phone: {
							      required: true,
							      number: true,
							      minlength: 10,
							      maxlength: 10
							       }
							       },
							       
							        // Specify the validation error messages
							        messages: {
							            name: {
							                   required: "Please enter name",
							                   minlength: "Minimum 3 Character",
							       maxlength: "Maximum 25 Character"
							            },
							      email: {
							                   required: "Please enter email address", 
							                   email: "Please enter a valid email address"
							            },
							      phone: {
							                   required: "Please provide a phone",
							                   minlength: "Minimum 10 digit number",
							       maxlength: "Maximum 10 digit number"
							            }

							              },
							    
							  errorPlacement: function(error, element) {
							   if (element.attr("name") == "name" ){
							        error.insertAfter("#name"); 
							  }
							  
							  else if (element.attr("name") == "email" ){
							        error.insertAfter("#email"); 
							  }
							  
							  else if (element.attr("name") == "phone" ){
							        error.insertAfter("#phone"); 
							  }
							  
							}
							      });



					 $( '#getes' ).click(function() {
 						if ($("#myform").valid())  {
					  				var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;
									var serializedData = $('#myform').serialize()+'&action=request_package_orders&action_type=saveinfo';

                          
					                $.ajax({
					                      type: 'POST',
					                      url: ajax_url,
					                      data: serializedData,
					                        action: 'request_package_orders',
					                        beforeSend: function() {
											              $("#loading-image").show();
											           },
					                      
					                      

					                      success: function(data)
					                     		 {

					                                     if(data){
					                                        $( "input[name*='userID']" ).val(data);
					                                        $("#loading-image").hide();
					                                        $('.msg').html('Thanks!!');
					                                        $("#myform").trigger("reset");
					                                    
					                                         $('#myform').each(function(){
					                                         this.reset();
					                                             });

					                                         $('#dialogForm').hide();
					                                         $('.ui-dialog-titlebar .packagetitle').hide();
																$("#dialogForm").dialog("close");
					                                               
					                                        }
					                                          
					                    		  }
					                      
					                    });
					                           
					      }
										 
						 });

							  $( ".packages-page .purchase-btn" ).on( "click", function() {
							  	$("#couponform").trigger("reset");
							  	$('.promo_msg').html('');

								 var packagename= $( this ).parents('.packages-name').find('td:first').text();
								 var packageprice= $( this ).parents('.packages-name').find('td:eq(1) strong').text();
								packageprice= packageprice.replace("$", "")
								 /*alert(packagename+packageprice)*/
								 $('.itemprice').val(packageprice)
								 $('.actualprice').val(packageprice)
								 $('.itemname').val(packagename)
								
								}); 

							   $( ".applypromo" ).on( "click", function() {

								 	if($(".Promo").val() !=''){

										var packageprice= $(".actualprice").val();

								 		var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;
									var serializedData = 'promo='+$(".Promo").val()+'&action=request_package_orders&action_type=check_promo';

                          
					                $.ajax({
					                      type: 'POST',
					                      url: ajax_url,
					                      data: serializedData,
					                        action: 'check_promo',
					                        beforeSend: function() {
											              $("#loading-promoimg").show();
											           },
					                      

					                      success: function(data)
					                     		 {

					                     
					                                     if(data!=''){
					                                     	
					                                     	var discount= (packageprice*data)/100;
														 	var newprice=packageprice-discount;
														 	$('.itemprice').val(newprice)
														 	$('.promo_msg').html('You got ' +data+'% discount. You need to pay for $'+newprice+' now.').css('color','green')
														 	$('#promostatus').val('1');
					                                
					                                               
					                                        }
					                                        else{
					                                        	$('.promo_msg').html('Promocode is invalid or expired.')
					                                        	$('#promostatus').val('0');

					                                        }
					                                        $('#loading-promoimg').hide()

					                                          
					                    		  }
					                      
					                    });

								 		

								 	}
								 	else{
								 		$('.promo_msg').html('Field is empty.').css('color','red')
								 	}
								 	

								 })

	 $(document).on('submit','#payform', function(evt) {
	
	if($('#promostatus').val()=='0' && $('#Promo').val() !=''){
		    evt.preventDefault();
  
	  $( ".applypromo" ).trigger( "click" );
	  setTimeout(function() {
	   if($('#promostatus').val()=='1'){
	  
	 	 $(this).unbind('submit').submit();
			
				  }
			}, 3000);
		   
			
			}
			
});
							  
				});
										 </script>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
 							$ulink=get_the_post_thumbnail_url();
 							?>
		<header id="fancy-header" class="fancy-header titles-off breadcrumbs-off title-center" style="background-color: #222222; background-size: cover; background-repeat: no-repeat; background-image: url(https://www.webguruz.in/wp-content/uploads/2017/09/package.jpg); background-position: center center; min-height: 230px">
					<div class="wf-wrap">
						<div class="wf-table" style="height: 230px;"></div>
					</div>
					</header>
		<?php get_template_part( 'header-main' ); ?>

		<?php if ( presscore_is_content_visible() ): ?>

			<?php //do_action( 'presscore_before_loop' ); ?>

			<!-- !- Content -->
			<div id="content" class="sidebar-none" role="main">
                        
              
			<?php //echo presscore_get_posted_on(); ?>
		<?php   
		$postid=get_the_ID();
		?>

				<div class="text-desc">
				<?php echo get_the_content(); ?>
				</div>

		</div>

			<?php //do_action( 'presscore_after_content' ); ?>

		<?php endif; // content is visible ?>

<?php endwhile; endif; // end of the loop. ?>
<div class="modal fade" id="couponform" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Fill up the form</h4>
        </div>
        <div class="modal-body">


			<form id="payform" action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input name="paypal" type="hidden" value="checkout" />
				<input type="hidden" name="cmd" value="_cart">
  			<input type="hidden" name="business" value="info@webguruz.in">
			<input name="item_name_1" class="itemname" type="hidden" value="" />
			<input name="amount_1" class="itemprice" type="hidden" value="" />
			<input id="actualprice" class="actualprice" type="hidden" value="" />
			<input name="returnurl" class="returnurl" type="hidden" value="https://www.webguruz.in/thank-you/" />
			<input name="cancelurl" class="cancelurl" type="hidden" value="https://www.webguruz.in/cancel/" />
			<input name="userID" class="userID" type="hidden" value="" />
			<input name="businessName" class="businessName" required type="text" placeholder="Business Name" value="" />
			<input name="businessurl" class="businessurl" type="text" placeholder="Business Url" value="" />
			<input name="Promo" class="Promo" id="Promo" type="text" placeholder="Enter Promocode" value="" />
			<input name="quantity_1" class="quantity_1" type="hidden" value="1"               />
			<input name="promostatus" id="promostatus" type="hidden" value="0"               />
			<input type="hidden" name="upload" value="1" />
			<img id="loading-promoimg" class="loadingimg" src="<?php echo bloginfo('template_url'); ?>/giphy.gif" alt="loading" style="display:none;"/>
				<p class="promo_msg"></p>
			<input name="applypromo" class="applypromo" type="button" value="Apply Promocode" />
		
			 
			<input class="purchase-btn" name="submit" type="submit" value="Purchase" /></form>
        </div>
        <div class="modal-footer" style="display:none;">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/custom/js/bootstrap.min.css" >
<script src="<?php bloginfo('template_url'); ?>/custom/js/bootstrap.min.js" ></script>
<?php get_footer(); ?>