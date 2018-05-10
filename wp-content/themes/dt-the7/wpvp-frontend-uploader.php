<form id="wpvp-upload-video" enctype="multipart/form-data" name="wpvp-upload-video" class="wpvp-processing-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<h2 class="vc_custom_heading" style="font-size: 53px;color: #35bcb4;text-align: center">Client Testimonials</h2>
	<div class="wpvp_block">
		<label><?php _e('Your Name');?><span>*</span></label>
		<input type="text" name="wpvp_title" class="wpvp_require" value="" />
		<div class="wpvp_title_error wpvp_error"></div>
	</div>
        <div class="wpvp_block">
		<label><?php _e('Your Position');?><span>*</span></label>
		<input type="text" name="wpvp_position" class="wpvp_require" value="" />
		<div class="wpvp_position_error wpvp_error"></div>
	</div>
        <div class="wpvp_block">
		<label><?php _e('Your Company Name');?><span>*</span></label>
		<input type="text" name="wpvp_company" class="wpvp_require" value="" />
		<div class="wpvp_position_error wpvp_error"></div>
	</div>
        <div class="wpvp_block">
		<label><?php _e('Email');?><span>*</span></label>
		<input type="text" name="wpvp_email" class="wpvp_require email" value="" />
		<div class="wpvp_email_error wpvp_error"></div>
	</div>
	<div class="wpvp_block">
	<?php $desc_status = (int)get_option('wpvp_uploader_desc',false);?>
		<label><?php _e('Description');?><?php if(!$desc_status):?><span>*</span><?php endif;?></label>
		<span><textarea onkeyup="countChar()" maxlength="500" id="desc" name="wpvp_desc" <?php if(!$desc_status):?>class="wpvp_require"<?php endif;?>></textarea></span><p id="charNum"></p>
		<div class="wpvp_desc_error wpvp_error"></div>
	</div>
        <div class="wpvp_block">
        <div class="wpvp_cat" style="float:left;width:50%;">
			<label><?php _e('Choose Service');?></label>
			<?php WPVP_Helper::wpvp_clint_categories_dropdown();?>
		</div>
        </div>
        <div class="wpvp_block upload_img">
		<label>Upload Your Image<span>*</span></label>
		<input type="file" id="async-image" name="async-image" class="wpvp_require" value="" />
		<div class="wpvp_image_error wpvp_error"></div>
		 <div class="wpvp_block img_bar">
        <progress id="progress" value="0" style="display:none;"></progress><a id="closebar" class="closebar" style="display:none;">Close</a>
        <!--div class="wpvp_tempImg_progress"></div-->
      </div>
	</div>
        
        <div class="wpvp_block upload_video">
		<label>Upload Video Testimonial<span></span></label>
		<input type="file" id="async-upload" name="async-upload" class="" value="" />
		<div class="wpvp_file_error wpvp_error"></div>
		<a id="close_v" class="close_v" style="display:none;">Close</a>
		<div class="wpvp_block video_bar">
<progress id="progress_v" value="0" style="display:none;"></progress><a id="closebar_v" class="closebar_v" style="display:none;">Close</a>
        <!--div class="wpvp_tempvideo_progress"></div-->
      </div>	
	</div>
       
        <div class="wpvp_block">
<progress id="progress_upload" value="0" style="display:none;"></progress><span id="display" style="display:none;"></span>
        <!--div class="wpvp_upload_progress" style="display:none;">
           <?php _e('Please, wait while your testimonial is being uploaded.');?>
		</div-->
      </div>
	<!--div class="wpvp_block">
		<div class="wpvp_cat" style="float:left;width:50%;">
			<label><?php _e('Choose category');?></label>
			<?php WPVP_Helper::wpvp_upload_categories_dropdown();?>
		</div>
		<?php   
		$hide_tags = get_option('wpvp_uploader_tags','');
		if($hide_tags==''){ ?>
		<div class="wpvp_tag" style="float:right;width:50%;text-align:right;">
			<label><?php _e('Tags (comma separated)');?></label>
			<input type="text" name="wpvp_tags" value="" />
		</div>
		<?php   
		} 
		?>
		
	</div-->
           <div class="wpvp_mess"></div>
         <?php wp_nonce_field('wpvp_file_upload','wpvp_file_upload_field',true,true);?>
	<input type="hidden" name="wpvp_action" value="wpvp_upload" />
	<p class="wpvp_submit_block">
		<input type="submit" action="create" class="wpvp-submit" name="wpvp-upload" value="Upload" />
	</p>

</form>
<div class="modal fade requstpopup">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Thank you for taking the time to provide us with your valuable feedback!</h4>
      </div>
      <div class="modal-body">
        <p>We strive to provide our clients with excellent care and we take your comments to heart.</p>
        <div style="color:#f2a803; padding-top:15px;">Cheers!!<br/>
Team Webguruz</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
 <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/custom/js/bootstrap.min.css" >
<script src="<?php bloginfo('template_url'); ?>/custom/js/bootstrap.min.js" ></script>
<script type="text/javascript">
  function countChar() {
                         /*alert();*/
                          var val = document.getElementById("desc");
                          var len = val.value.length;
                          if (len <= 500) {
                          jQuery('#charNum').text(500 - len+' characters remaining.').css('color','#EDA100');
                          }
                          else{
                          val.value = val.value.substring(0, 500);
                          jQuery('#charNum').text('Maximum characters limit of 500 is over').css('color','red');
                           }
                        };

                        </script>