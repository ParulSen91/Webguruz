<?php
/**
 * The Template for displaying all single posts.
 *
 * @package The7
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header( 'single' ); ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery.social-buttons.css">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'header-main' ); ?>

		<?php if ( presscore_is_content_visible() ): ?>

			<?php do_action( 'presscore_before_loop' ); ?>

			<!-- !- Content -->
			<div id="content" class="content mainblog " role="main">
                        
              <header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
	
	<?php echo presscore_get_posted_on(); ?>
            <div class="view-count">
			<?php 
			$postid=get_the_ID();
			echo do_shortcode("[hit_count $postid]");?>
            
				<div class="blogshare">
	
						<div class="social">
										
									
<?php $featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full'); ?>
<div class="social-sharing is-large" data-permalink="<?php the_permalink(); ?>">
<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" class="share-facebook social__item">
<span class="fa fa-facebook" aria-hidden="true"></span></a>
<a target="_blank" href="http://twitter.com/share?url=<?php the_permalink(); ?>&amp;text=<?php echo get_the_title(); ?>&amp;" class="share-twitter social__item">
 <span class="fa fa-twitter" aria-hidden="true"></span> </a>
<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php echo get_the_title(); ?>" class="share-linkedin social__item">
<span class="fa fa-linkedin" aria-hidden="true"></span> </a>
<a target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo $featured_img_url; ?>&amp;description=<?php echo get_the_title(); ?>" class="share-pinterest social__item">
<span class="fa fa-pinterest" aria-hidden="true"></span></a>
</div>
						</div> 
  
				</div>
				</div>


				<?php get_template_part( 'content-single', str_replace( 'dt_', '', get_post_type() ) ); ?>
				

				

			</div><!-- #content .wf-cell -->
				
					<?php do_action( 'presscore_after_content' ); ?>
						<aside id="sidebar" class="sidebar" style="margin-top:15px;">
				<div class="sidebarcontent sidebarbottom">

					<?php

					$guide_post=get_post_meta($postid, 'userguide', 'true');
					 $ppt_link=get_post_meta($postid, 'pptlink', 'true');
						
			
			
		/*	print_r($ppt_arr);*/
					if($guide_post){
						$guide_arr=get_post($guide_post);
						 ?>
                        <div class="user-guide">
						 <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/10/imgpsh_fullsize.png" />
						 <button type="button" class="btn btn-info btn-lg user_guide"  data-toggle="modal" data-target="#myModal">Download User Guide</button>
                             </div>

					<?php } 
					if($ppt_link){
						$ppt_arr=get_post($ppt_link); ?>
						<div class="user-guide">
						 <img src="<?php echo home_url(); ?>/wp-content/uploads/2017/10/ppt.png" />
						  <button type="button" class="btn btn-info btn-lg ppt_link" data-toggle="modal" data-target="#myModal">Download PPT</button>
						</div>
						  <?php } ?>

<!-- Modal -->
						<div id="myModal" class="modal fade" role="dialog">
						  <div class="modal-dialog">

						    <!-- Modal content-->
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal">&times;</button>
						        <h4 class="modal-title">Fill the form and you will get pdf link in your email.</h4>
						      </div>
						      <div class="modal-body">
						      <form id="guideform" method="post" class="package-form">
			       
							        <input id="name" name="name" placeholder="Name" type="text"/><br/>
							      
							      <input id="pptemail" name="email" placeholder="Email" type="email"/>
							     
							        <input  id="phone" name="phone" placeholder="Phone" type="text"/><br/>
							        <input  name="pdf_link" id="pdf_link" type="hidden" value="<?php 
		    echo $guide_arr->guid; ?>" />
							        <input  name="post_name" type="hidden" value="<?php echo get_the_title(); ?>" />
							        <button type="button" id="getes" class="package-submit"> Submit </button>
			    				</form>
			   				 <p class="msgs"></p>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						      </div>
						    </div>

						  </div>
						</div>
						<?php dynamic_sidebar( 'singleblogform' ); ?>
						
						</div>
						
					
					</aside>
			

<!-- Modal -->

		<?php endif; // content is visible ?>

<?php endwhile; endif; // end of the loop. ?>

<?php get_footer(); ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css">
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
<script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
	    <script type="text/javascript">
	        jQuery( document ).ready(function($) {
	        var slink='<?php the_permalink(); ?>'
	       /* alert(slink);*/
			        
			      /*  
			       	 });*/
			        $( ".user_guide" ).click(function() {
			        	$('#pdf_link').val('<?php echo $guide_arr->guid; ?>')
				/*	  alert('<?php echo $guide_arr->guid; ?>')*/
					});
					$( ".ppt_link" ).click(function() {
						$('#pdf_link').val('<?php echo $ppt_arr->guid; ?>')
						 /*alert('<?php echo $ppt_arr->guid; ?>')*/
					 
					});

			        

			       
	        });

		jQuery(document).ready(function($){  

					
					    $.validator.addMethod("loginRegex", function(value, element) {
					        return this.optional(element) || /^[a-z0-9\- . @\s]+$/i.test(value);
					    }, "Please enter only letters, numbers, or (@ , . , -) only.");
					   	
					   	$("#guideform").validate({
       
    
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
							  
							        error.insertAfter("#pptemail"); 
							  }
							  
							  else if (element.attr("name") == "phone" ){
							  		
							        error.insertAfter("#phone"); 
							  }
							  
							}
							      });



					 $( '#getes' ).click(function() {
					 	
 						if ($("#guideform").valid())  {



					  				var ajax_url = timeline_um_ajax.timeline_um_ajaxurl;
									var serializedData = $('#guideform').serialize()+'&action=user_guide_code';

                          
					                $.ajax({
					                      type: 'POST',
					                      url: ajax_url,
					                      data: serializedData,
					                        action: 'user_guide_code',
					                      

					                      success: function(data)
					                     		 {

					                     
					                                         $('.msgs').html('Thanks!!');
					                                       /* $("#guideform").trigger("reset");
					                                    
					                                         $('#guideform').each(function(){
					                                         this.reset();*/
					                                             /*});*/
					                                     /*  window.setTimeout(function(){location.reload()},2000) */
					                                      
					                                          
					                    		  }
					                      
					                    });
					                           
					      }
										 
						 });
				});
	    </script>
