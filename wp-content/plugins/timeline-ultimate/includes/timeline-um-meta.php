<?php


function timeline_um_posttype_register() {
 
        $labels = array(
                'name' => _x('Timeline Ultimate', 'timeline_um'),
                'singular_name' => _x('Timeline Ultimate', 'timeline_um'),
                'add_new' => _x('New Timeline Ultimate', 'timeline_um'),
                'add_new_item' => __('New Timeline Ultimate'),
                'edit_item' => __('Edit Timeline Ultimate'),
                'new_item' => __('New Timeline Ultimate'),
                'view_item' => __('View Timeline Ultimate'),
                'search_items' => __('Search Timeline Ultimate'),
                'not_found' =>  __('Nothing found'),
                'not_found_in_trash' => __('Nothing found in Trash'),
                'parent_item_colon' => ''
        );
 
        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => null,
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title'),
				'menu_icon' => 'dashicons-media-spreadsheet',
				
          );
 
        register_post_type( 'timeline_um' , $args );

}

add_action('init', 'timeline_um_posttype_register');





/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_timeline_um()
	{
		$screens = array( 'timeline_um' );
		foreach ( $screens as $screen )
			{
				add_meta_box('timeline_um_metabox',__( 'Timeline Ultimate Options','timeline_um' ),'meta_boxes_timeline_um_input', $screen);
			}
	}
add_action( 'add_meta_boxes', 'meta_boxes_timeline_um' );


function meta_boxes_timeline_um_input( $post ) {
	
	global $post;
	wp_nonce_field( 'meta_boxes_timeline_um_input', 'meta_boxes_timeline_um_input_nonce' );
	
	
	$timeline_um_bg_img = get_post_meta( $post->ID, 'timeline_um_bg_img', true );
	$timeline_um_themes = get_post_meta( $post->ID, 'timeline_um_themes', true );
	$timeline_um_total_items = get_post_meta( $post->ID, 'timeline_um_total_items', true );	
		
	
	$timeline_um_post_content = get_post_meta( $post->ID, 'timeline_um_post_content', true );	
	$timeline_um_post_excerpt_count = get_post_meta( $post->ID, 'timeline_um_post_excerpt_count', true );	
	$timeline_um_post_excerpt_text = get_post_meta( $post->ID, 'timeline_um_post_excerpt_text', true );		
	
	$timeline_um_content_source = get_post_meta( $post->ID, 'timeline_um_content_source', true );
	$timeline_um_content_year = get_post_meta( $post->ID, 'timeline_um_content_year', true );
	$timeline_um_content_month = get_post_meta( $post->ID, 'timeline_um_content_month', true );
	$timeline_um_content_month_year = get_post_meta( $post->ID, 'timeline_um_content_month_year', true );	

	$timeline_um_posttype = get_post_meta( $post->ID, 'timeline_um_posttype', true );
	$timeline_um_taxonomy = get_post_meta( $post->ID, 'timeline_um_taxonomy', true );
	$timeline_um_taxonomy_category = get_post_meta( $post->ID, 'timeline_um_taxonomy_category', true );
	
	$timeline_um_post_ids = get_post_meta( $post->ID, 'timeline_um_post_ids', true );	

	
	$timeline_um_middle_line_bg = get_post_meta( $post->ID, 'timeline_um_middle_line_bg', true );		
	$timeline_um_middle_circle_bg = get_post_meta( $post->ID, 'timeline_um_middle_circle_bg', true );		
	
	$timeline_um_items_title_color = get_post_meta( $post->ID, 'timeline_um_items_title_color', true );	
	$timeline_um_items_title_font_size = get_post_meta( $post->ID, 'timeline_um_items_title_font_size', true );
	
	$timeline_um_items_content_color = get_post_meta( $post->ID, 'timeline_um_items_content_color', true );	
	$timeline_um_items_content_font_size = get_post_meta( $post->ID, 'timeline_um_items_content_font_size', true );		
	
	
	$timeline_um_items_thumb_size = get_post_meta( $post->ID, 'timeline_um_items_thumb_size', true );	
	$timeline_um_items_thumb_max_hieght = get_post_meta( $post->ID, 'timeline_um_items_thumb_max_hieght', true );	
	
	$timeline_um_items_date = get_post_meta( $post->ID, 'timeline_um_items_date', true );		
	$timeline_um_items_author = get_post_meta( $post->ID, 'timeline_um_items_author', true );	
	$timeline_um_items_categories = get_post_meta( $post->ID, 'timeline_um_items_categories', true );	
	
	
 






		$timeline_um_customer_type = get_option('timeline_um_customer_type');

		if($timeline_um_customer_type=="free")
			{
				echo '<script>
					jQuery(document).ready(function()
						{
							jQuery("").attr("title","Only For Premium Version")
							jQuery("").attr("disabled","disabled")
						
						})
	 				</script>';
      
			}
		elseif($timeline_um_customer_type=="pro")
			{
				//premium customer support.
			}

?>







    <div class="para-settings">
        <div class="option-box">
            <p class="option-title">Shortcode</p>
            <p class="option-info">Copy this shortcode and paste on page or post where you want to display timeline, <br />Use PHP code to your themes file to display timeline.</p>
            <textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" >[timeline_um <?php echo 'id="'.$post->ID.'"';?>]</textarea>
<br /><br />
            PHP Code:<br />
            <textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();" ><?php echo '<?php echo do_shortcode("[timeline_um id='; echo "'".$post->ID."']"; echo '"); ?>'; ?></textarea>  
        </div>
                
                
        <ul class="tab-nav"> 
            <li nav="1" class="nav1 active">Options</li>
            <li nav="2" class="nav2">Style</li>
            <li nav="3" class="nav3">Content</li>
            <li nav="4" class="nav4">Help & Upgrade</li>      
        </ul> <!-- tab-nav end -->
                
		<ul class="box">
            
            <li style="display: block;" class="box1 tab-box active">
				<div class="option-box">
                    <p class="option-title">Number of post to display.</p>
                    <p class="option-info"></p>
                    <input type="text" placeholder="ex:5 - Number Only"   name="timeline_um_total_items" value="<?php if(!empty($timeline_um_total_items))echo $timeline_um_total_items; else echo 5; ?>" />
                </div>
				<div class="option-box">
                    <p class="option-title">Thumbnail Size</p>
                    <p class="option-info"></p>
                    <select name="timeline_um_items_thumb_size" >
                    <option value="none" <?php if($timeline_um_items_thumb_size=="none")echo "selected"; ?>>None</option>
                    <option value="thumbnail" <?php if($timeline_um_items_thumb_size=="thumbnail")echo "selected"; ?>>Thumbnail</option>
                    <option value="medium" <?php if($timeline_um_items_thumb_size=="medium")echo "selected"; ?>>Medium</option>
                    <option value="large" <?php if($timeline_um_items_thumb_size=="large")echo "selected"; ?>>Large</option>                               
                    <option value="full" <?php if($timeline_um_items_thumb_size=="full")echo "selected"; ?>>Full</option>   

                    </select>
                </div>
				<div class="option-box">
                    <p class="option-title">Thumbnail max hieght(px)</p>
                    <p class="option-info"></p>
                    <input type="text" name="timeline_um_items_thumb_max_hieght" placeholder="ex:150px number with px" id="timeline_um_items_thumb_max_hieght" value="<?php if(!empty($timeline_um_items_thumb_max_hieght)) echo $timeline_um_items_thumb_max_hieght; else echo ""; ?>" />
                </div>
				
				<div class="option-box">
                    <p class="option-title">Display Date ?</p>
                    <p class="option-info"></p>
                    <select name="timeline_um_items_date" >
                    	<option value="no" <?php if($timeline_um_items_date=="no")echo "selected"; ?>>No</option>
                   		<option value="yes" <?php if($timeline_um_items_date=="yes")echo "selected"; ?>>Yes</option>
                    </select>
                </div>				
				
				<div class="option-box">
                    <p class="option-title">Display Author ?</p>
                    <p class="option-info"></p>
                    <select name="timeline_um_items_author" >
                    	<option value="no" <?php if($timeline_um_items_author=="no") echo "selected"; ?>>No</option>
                   		<option value="yes" <?php if($timeline_um_items_author=="yes") echo "selected"; ?>>Yes</option>
                    </select>
                </div>   
                
				<div class="option-box">
                    <p class="option-title">Display Categories ?</p>
                    <p class="option-info"></p>
                    <select name="timeline_um_items_categories" >
                    	<option value="no" <?php if($timeline_um_items_categories=="no") echo "selected"; ?>>No</option>
                   		<option value="yes" <?php if($timeline_um_items_categories=="yes") echo "selected"; ?>>Yes</option>
                    </select>
                </div>                
                
                
                
                
                             
                
            </li>
            <li style="display: none;" class="box2 tab-box">
				<div class="option-box">
                    <p class="option-title">Themes</p>
                    <p class="option-info"></p>
                    <select name="timeline_um_themes"  >
                    	<option class="timeline_um_themes_flat" value="flat" <?php if($timeline_um_themes=="flat")echo "selected"; ?>>Flat</option>
                    </select>
                </div>
				<div class="option-box">
                    <p class="option-title">Background Image</p>
                    <p class="option-info"></p>
					<script>
                    jQuery(document).ready(function(jQuery)
                        {
                                jQuery(".timeline_um_bg_img_list li").click(function()
                                    { 	
                                        jQuery('.timeline_um_bg_img_list li.bg-selected').removeClass('bg-selected');
                                        jQuery(this).addClass('bg-selected');
                                        
                                        var timeline_um_bg_img = jQuery(this).attr('data-url');
                    
                                        jQuery('#timeline_um_bg_img').val(timeline_um_bg_img);
                                        
                                    })	
                    
                                        
                        })
                    
                    </script>
                    <?php

						$dir_path = timeline_um_plugin_dir."css/bg/";
						$filenames=glob($dir_path."*.png*");
					
					
						$timeline_um_bg_img = get_post_meta( $post->ID, 'timeline_um_bg_img', true );
						
						if(empty($timeline_um_bg_img))
							{
							$timeline_um_bg_img = "";
							}
					
					
						$count=count($filenames);
						
					
						$i=0;
						echo "<ul class='timeline_um_bg_img_list' >";
					
						while($i<$count)
							{
								$filelink= str_replace($dir_path,"",$filenames[$i]);
								
								$filelink= timeline_um_plugin_url."css/bg/".$filelink;
								
								
								if($timeline_um_bg_img==$filelink)
									{
										echo '<li  class="bg-selected" data-url="'.$filelink.'">';
									}
								else
									{
										echo '<li   data-url="'.$filelink.'">';
									}
								
								
								echo "<img  width='70px' height='50px' src='".$filelink."' />";
								echo "</li>";
								$i++;
							}
							
						echo "</ul>";
						
						echo "<input style='width:100%;' value='".$timeline_um_bg_img."'    placeholder='Please select image or left blank' id='timeline_um_bg_img' name='timeline_um_bg_img'  type='text' />";
					
					
            
            		?>
                   
                </div>
                
				<div class="option-box">
                    <p class="option-title">Middle Circle Background Color</p>
                    <p class="option-info"></p>
                    <input type="text" name="timeline_um_middle_circle_bg" id="timeline_um_middle_circle_bg" value="<?php if(!empty($timeline_um_middle_circle_bg)) echo $timeline_um_middle_circle_bg; else echo "#28c8a8"; ?>" />
                </div>
				<div class="option-box">
                    <p class="option-title">Middle Line Background Color</p>
                    <p class="option-info"></p>
                    <input type="text" name="timeline_um_middle_line_bg" id="timeline_um_middle_line_bg" value="<?php if(!empty($timeline_um_middle_line_bg)) echo $timeline_um_middle_line_bg; else echo "#28c8a8"; ?>" />
                </div>
                
                
				<div class="option-box">
                    <p class="option-title">Post Title Color</p>
                    <p class="option-info"></p>
                    <input type="text" name="timeline_um_items_title_color" id="timeline_um_items_title_color" value="<?php if(!empty($timeline_um_items_title_color)) echo $timeline_um_items_title_color; else echo "#28c8a8"; ?>" />
                </div>
				<div class="option-box">
                    <p class="option-title">Post Title Font Size</p>
                    <p class="option-info"></p>
                    <input type="text" name="timeline_um_items_title_font_size" placeholder="ex:14px number with px" id="timeline_um_items_title_font_size" value="<?php if(!empty($timeline_um_items_title_font_size)) echo $timeline_um_items_title_font_size; else echo "14px"; ?>" />
                </div>
                
				<div class="option-box">
                    <p class="option-title">Post Content Color</p>
                    <p class="option-info"></p>
                    <input type="text" name="timeline_um_items_content_color" id="timeline_um_items_content_color" value="<?php if(!empty($timeline_um_items_content_color)) echo $timeline_um_items_content_color; else echo "#fff"; ?>" />
                </div>                
				<div class="option-box">
                    <p class="option-title">Post Content font size</p>
                    <p class="option-info"></p>
                    <input type="text" name="timeline_um_items_content_font_size" id="timeline_um_items_content_font_size" value="<?php if(!empty($timeline_um_items_content_font_size)) echo $timeline_um_items_content_font_size; else echo "13px"; ?>" />
                </div>  

                  
                
            </li>
            <li style="display: none;" class="box3 tab-box">
				<div class="option-box">
                    <p class="option-title">Post Content Display</p>
                    <p class="option-info"></p>
                    <ul class="content_source_area" >

                        <li>
                        	<input class="timeline_um_content_source" name="timeline_um_post_content" id="timeline_um_post_content" type="radio" value="full" <?php if($timeline_um_post_content=="full")  echo "checked";?> /> 
                            <label for="timeline_um_post_content">Display full content</label>
                            <div class="timeline_um_post_content content-source-box">
                            Timeline Content will display from full content.
                            </div>
                        </li>
                        
                        
                        <li>
                        	<input class="timeline_um_content_source" name="timeline_um_post_content" id="timeline_um_post_excerpt" type="radio" value="excerpt" <?php if($timeline_um_post_content=="excerpt")  echo "checked";?> /> 
                            <label for="timeline_um_post_excerpt">Display excerpt</label>
                            <div class="timeline_um_post_excerpt content-source-box">
                            Timeline Content will display from excerpt.<br />
                            Excrept Length:
                            <input type="text" placeholder="25" size="4" name="timeline_um_post_excerpt_count" value="<?php if(!empty($timeline_um_post_excerpt_count))  echo $timeline_um_post_excerpt_count; ?>" />
                            <br />
                            Read More Text: 
                            <input type="text" placeholder="Read More..." size="10" name="timeline_um_post_excerpt_text" value="<?php if(!empty($timeline_um_post_excerpt_text))  echo $timeline_um_post_excerpt_text; ?>" />
                            
                            </div>
                        </li>                        

					</ul>
                </div>      
                
				<div class="option-box">
                    <p class="option-title">Timeline Content Posttype</p>
                    <p class="option-info"></p>
                    <?php
						
						$post_types = get_post_types( '', 'names' ); 
						
						foreach ( $post_types as $post_type ) {
						
							if($post_type=='post')
								{
								   echo '<label for="timeline_um_posttype['.$post_type.']"><input class="timeline_um_posttype" type="checkbox" name="timeline_um_posttype['.$post_type.']" id="timeline_um_posttype['.$post_type.']"  value ="'.$post_type.'" ' ?> 
								   <?php if ( isset( $timeline_um_posttype[$post_type] ) ) echo "checked"; ?>
								   <?php echo' >'. $post_type.'</label><br />' ;
							   
								}
						
							else
								{
								   echo '<label for="timeline_um-posttype['.$post_type.']"><input type="checkbox" name="timeline_um_posttype['.$post_type.']" class="timeline_um_posttype" id="timeline_um-posttype['.$post_type.']"  value ="'.$post_type.'" ' ?> 
								   <?php if ( isset( $timeline_um_posttype[$post_type] ) ) echo "checked"; ?>
								   <?php echo' >'. $post_type.'</label><br />' ;
						   
								}
						
						}
						?>
                </div>
                
				<div class="option-box">
                    <p class="option-title">Filter Content</p>
                    <p class="option-info"></p>
                    <ul class="content_source_area" >
                        <li><input class="timeline_um_content_source" name="timeline_um_content_source" id="timeline_um_content_source_latest" type="radio" value="latest" <?php if($timeline_um_content_source=="latest")  echo "checked";?> /> <label for="timeline_um_content_source_latest">Display from Latest Published</label>
                        <div class="timeline_um_content_source_latest content-source-box">Slider items will query from latest published post.</div>
                        </li>
                        
                        <li><input class="timeline_um_content_source" name="timeline_um_content_source" id="timeline_um_content_source_older" type="radio" value="older" <?php if($timeline_um_content_source=="older")  echo "checked";?> /> <label for="timeline_um_content_source_older">Display from Older Published</label>
                        <div class="timeline_um_content_source_older content-source-box">Slider items will query from older published post.</div>
                        </li>            
                        
                        <li><input class="timeline_um_content_source" name="timeline_um_content_source" id="timeline_um_content_source_featured" type="radio" value="featured" <?php if($timeline_um_content_source=="featured")  echo "checked";?> /> <label for="timeline_um_content_source_featured">Display from Featured Post</label>
                        
                        <div class="timeline_um_content_source_featured content-source-box">Slider items will query from featured marked post.</div>
                        </li>
                        
                        <li><input class="timeline_um_content_source" name="timeline_um_content_source" id="timeline_um_content_source_year" type="radio" value="year" <?php if($timeline_um_content_source=="year")  echo "checked";?> /> <label for="timeline_um_content_source_year">Display from Only Year</label>
                        
                        <div class="timeline_um_content_source_year content-source-box">Slider items will query from a year.
                        <input type="text" size="7" class="timeline_um_content_year" name="timeline_um_content_year" value="<?php if(!empty($timeline_um_content_year))  echo $timeline_um_content_year;?>" placeholder="2014" />
                        </div>
                        </li>
                        
                        
                        <li><input class="timeline_um_content_source" name="timeline_um_content_source" id="timeline_um_content_source_month" type="radio" value="month" <?php if($timeline_um_content_source=="month")  echo "checked";?> /> <label for="timeline_um_content_source_month">Display from Month</label>
                        
                        <div class="timeline_um_content_source_month content-source-box">Slider items will query from Month of a year.		<br />
                        <input type="text" size="7" class="timeline_um_content_month_year" name="timeline_um_content_month_year" value="<?php if(!empty($timeline_um_content_month_year))  echo $timeline_um_content_month_year;?>" placeholder="2014" />            
                        <input type="text" size="7" class="timeline_um_content_month" name="timeline_um_content_month" value="<?php if(!empty($timeline_um_content_month))  echo $timeline_um_content_month;?>" placeholder="06" />
                        </div>
                        </li>            

                        </ul>
                </div>                
                
                
                
            </li>
            <li style="display: none;" class="box4 tab-box">
				<div class="option-box">
                    <p class="option-title">Have any issue ?</p>
                    <p class="option-info">Feel free to Contact with any issue for this plugin <a href="<?php echo timeline_um_conatct_url; ?>"><?php echo timeline_um_conatct_url; ?></a></p>
                    
					<?php
                    
                    $timeline_um_customer_type = get_option('timeline_um_customer_type');
                    $timeline_um_version = get_option('timeline_um_version');
                    
                    
                    ?>
                    <?php
                    if($timeline_um_customer_type=="free")
                        {
                            echo '<p>You are using <strong> '.$timeline_um_customer_type.' version  '.$timeline_um_version.'</strong> of <strong>'.timeline_um_plugin_name.'</strong>, To get more feature you could try our premium version. ';
                            
                            echo '<a href="'.timeline_um_pro_url.'">'.timeline_um_pro_url.'</a></p>';
                            
                            
                        }
                    elseif($timeline_um_customer_type=="pro")
                        {
                    
                            echo '<p>Thanks for using <strong> '.$timeline_um_customer_type.' version  '.$timeline_um_version.'</strong> of <strong>'.timeline_um_plugin_name.'</strong> </p>';
                            
                            
                        }
                    
                     ?>
                </div>
                
                
				<div class="option-box">
                    <p class="option-title">Please share this plugin with your friends.</p>
                    <p class="option-info"></p>
                    <?php echo timeline_um_share_plugin(); ?>
                </div>
                
                
                
                
                 
            </li>
        </ul>     
                
                
                
                
                
    </div>




<?php


	
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function meta_boxes_timeline_um_save( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['meta_boxes_timeline_um_input_nonce'] ) )
    return $post_id;

  $nonce = $_POST['meta_boxes_timeline_um_input_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'meta_boxes_timeline_um_input' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;



  /* OK, its safe for us to save the data now. */

  // Sanitize user input.
	$timeline_um_bg_img = sanitize_text_field( $_POST['timeline_um_bg_img'] );	
	$timeline_um_themes = sanitize_text_field( $_POST['timeline_um_themes'] );
	$timeline_um_total_items = sanitize_text_field( $_POST['timeline_um_total_items'] );		
	
	
	$timeline_um_post_content = sanitize_text_field( $_POST['timeline_um_post_content'] );
	$timeline_um_post_excerpt_count = sanitize_text_field( $_POST['timeline_um_post_excerpt_count'] );	
	$timeline_um_post_excerpt_text = sanitize_text_field( $_POST['timeline_um_post_excerpt_text'] );


	$timeline_um_content_source = sanitize_text_field( $_POST['timeline_um_content_source'] );
	$timeline_um_content_year = sanitize_text_field( $_POST['timeline_um_content_year'] );
	$timeline_um_content_month = sanitize_text_field( $_POST['timeline_um_content_month'] );
	$timeline_um_content_month_year = sanitize_text_field( $_POST['timeline_um_content_month_year'] );	

	$timeline_um_posttype = stripslashes_deep( $_POST['timeline_um_posttype'] );
	$timeline_um_taxonomy = sanitize_text_field( $_POST['timeline_um_taxonomy'] );
	$timeline_um_taxonomy_category = stripslashes_deep( $_POST['timeline_um_taxonomy_category'] );
	
	$timeline_um_post_ids = stripslashes_deep( $_POST['timeline_um_post_ids'] );	


	$timeline_um_middle_line_bg = sanitize_text_field( $_POST['timeline_um_middle_line_bg'] );
	$timeline_um_middle_circle_bg = sanitize_text_field( $_POST['timeline_um_middle_circle_bg'] );
	
	$timeline_um_items_title_color = sanitize_text_field( $_POST['timeline_um_items_title_color'] );	
	$timeline_um_items_title_font_size = sanitize_text_field( $_POST['timeline_um_items_title_font_size'] );	

	$timeline_um_items_content_color = sanitize_text_field( $_POST['timeline_um_items_content_color'] );	
	$timeline_um_items_content_font_size = sanitize_text_field( $_POST['timeline_um_items_content_font_size'] );	

	$timeline_um_items_thumb_size = sanitize_text_field( $_POST['timeline_um_items_thumb_size'] );
	$timeline_um_items_thumb_max_hieght = sanitize_text_field( $_POST['timeline_um_items_thumb_max_hieght'] );	
	
	$timeline_um_items_date = sanitize_text_field( $_POST['timeline_um_items_date'] );	
	$timeline_um_items_author = sanitize_text_field( $_POST['timeline_um_items_author'] );	
	$timeline_um_items_categories = sanitize_text_field( $_POST['timeline_um_items_categories'] );			


  // Update the meta field in the database.
	update_post_meta( $post_id, 'timeline_um_bg_img', $timeline_um_bg_img );	
	update_post_meta( $post_id, 'timeline_um_themes', $timeline_um_themes );
	update_post_meta( $post_id, 'timeline_um_total_items', $timeline_um_total_items );	
	
	update_post_meta( $post_id, 'timeline_um_post_content', $timeline_um_post_content );
	update_post_meta( $post_id, 'timeline_um_post_excerpt_count', $timeline_um_post_excerpt_count );	
	update_post_meta( $post_id, 'timeline_um_post_excerpt_text', $timeline_um_post_excerpt_text );	
	
	update_post_meta( $post_id, 'timeline_um_content_source', $timeline_um_content_source );
	update_post_meta( $post_id, 'timeline_um_content_year', $timeline_um_content_year );
	update_post_meta( $post_id, 'timeline_um_content_month', $timeline_um_content_month );
	update_post_meta( $post_id, 'timeline_um_content_month_year', $timeline_um_content_month_year );	

	update_post_meta( $post_id, 'timeline_um_posttype', $timeline_um_posttype );
	update_post_meta( $post_id, 'timeline_um_taxonomy', $timeline_um_taxonomy );
	update_post_meta( $post_id, 'timeline_um_taxonomy_category', $timeline_um_taxonomy_category );

	update_post_meta( $post_id, 'timeline_um_post_ids', $timeline_um_post_ids );	

	update_post_meta( $post_id, 'timeline_um_middle_line_bg', $timeline_um_middle_line_bg );
	update_post_meta( $post_id, 'timeline_um_middle_circle_bg', $timeline_um_middle_circle_bg );	

	update_post_meta( $post_id, 'timeline_um_items_title_color', $timeline_um_items_title_color );
	update_post_meta( $post_id, 'timeline_um_items_title_font_size', $timeline_um_items_title_font_size );

	update_post_meta( $post_id, 'timeline_um_items_content_color', $timeline_um_items_content_color );
	update_post_meta( $post_id, 'timeline_um_items_content_font_size', $timeline_um_items_content_font_size );


	update_post_meta( $post_id, 'timeline_um_items_thumb_size', $timeline_um_items_thumb_size );	
	update_post_meta( $post_id, 'timeline_um_items_thumb_max_hieght', $timeline_um_items_thumb_max_hieght );
	
	update_post_meta( $post_id, 'timeline_um_items_date', $timeline_um_items_date );
	update_post_meta( $post_id, 'timeline_um_items_author', $timeline_um_items_author );
	update_post_meta( $post_id, 'timeline_um_items_categories', $timeline_um_items_categories );		

}
add_action( 'save_post', 'meta_boxes_timeline_um_save' );


























?>