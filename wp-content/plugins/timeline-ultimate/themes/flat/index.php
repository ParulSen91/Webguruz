<?php

function timeline_um_body_flat($post_id)
	{

	           //$my_excerpt = get_the_excerpt($post_id);
		$timeline_um_bg_img = get_post_meta( $post_id, 'timeline_um_bg_img', true );
		$timeline_um_themes = get_post_meta( $post_id, 'timeline_um_themes', true );
		$timeline_um_total_items = get_post_meta( $post_id, 'timeline_um_total_items', true );		
		
		$timeline_um_content_source = get_post_meta( $post_id, 'timeline_um_content_source', true );
		$timeline_um_content_year = get_post_meta( $post_id, 'timeline_um_content_year', true );
		$timeline_um_content_month = get_post_meta( $post_id, 'timeline_um_content_month', true );
		$timeline_um_content_month_year = get_post_meta( $post_id, 'timeline_um_content_month_year', true );
		
		$timeline_um_post_content = get_post_meta( $post_id, 'timeline_um_post_content', true );			
		$timeline_um_posttype = get_post_meta( $post_id, 'timeline_um_posttype', true );			
		$timeline_um_taxonomy = get_post_meta( $post_id, 'timeline_um_taxonomy', true );		
		$timeline_um_taxonomy_category = get_post_meta( $post_id, 'timeline_um_taxonomy_category', true );	
			
		$timeline_um_post_ids = get_post_meta( $post_id, 'timeline_um_post_ids', true );


		$timeline_um_middle_line_bg = get_post_meta( $post_id, 'timeline_um_middle_line_bg', true );
		$timeline_um_middle_circle_bg = get_post_meta( $post_id, 'timeline_um_middle_circle_bg', true );		
		

		$timeline_um_items_title_color = get_post_meta( $post_id, 'timeline_um_items_title_color', true );			
		$timeline_um_items_title_font_size = get_post_meta( $post_id, 'timeline_um_items_title_font_size', true );		

		$timeline_um_items_content_color = get_post_meta( $post_id, 'timeline_um_items_content_color', true );
		$timeline_um_items_content_font_size = get_post_meta( $post_id, 'timeline_um_items_content_font_size', true );

		
		$timeline_um_items_thumb_size = get_post_meta( $post_id, 'timeline_um_items_thumb_size', true );
		$timeline_um_items_thumb_max_hieght = get_post_meta( $post_id, 'timeline_um_items_thumb_max_hieght', true );
			
		
		$timeline_um_items_date = get_post_meta( $post_id, 'timeline_um_items_date', true );		
		$timeline_um_items_author = get_post_meta( $post_id, 'timeline_um_items_author', true );	
		$timeline_um_items_categories = get_post_meta( $post_id, 'timeline_um_items_categories', true );	
		
		
		$timeline_um_body = '';
		
		
		
		$timeline_um_body .= '
		<div  class="timeline_um-container" style="background-image:url('.$timeline_um_bg_img.')">
		<div style="background:'.$timeline_um_middle_line_bg.'" class="middle-line"></div>
		<ul  class="timeline_um-items timeline_um-'.$post_id.' timeline_um-'.$timeline_um_themes.'">';
		
		global $wp_query;
		


		
		if(($timeline_um_content_source=="latest"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,
						'orderby' => 'date',
						'order' => 'DESC',
						'posts_per_page' => $timeline_um_total_items,
						
						) );
			
			
			}		
		
		elseif(($timeline_um_content_source=="older"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,
						'orderby' => 'date',
						'order' => 'ASC',
						'posts_per_page' => $timeline_um_total_items,
						
						) );

			}		

		elseif(($timeline_um_content_source=="featured"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,
						'meta_query' => array(
							array(
								'key' => '_featured',
								'value' => 'yes',
								)),
						'posts_per_page' => $timeline_um_total_items,
						
						) );

			}	


		elseif(($timeline_um_content_source=="year"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,
						'year' => $timeline_um_content_year,
						'posts_per_page' => $timeline_um_total_items,
						) );

			}

		elseif(($timeline_um_content_source=="month"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,
						'year' => $timeline_um_content_month_year,
						'monthnum' => $timeline_um_content_month,
						'posts_per_page' => $timeline_um_total_items,
						
						) );

			}

		elseif($timeline_um_content_source="taxonomy")
			{
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,							
						'posts_per_page' => $timeline_um_total_items,
						
						'tax_query' => array(
							array(
								   'taxonomy' => $timeline_um_taxonomy,
								   'field' => 'id',
								   'terms' => $timeline_um_taxonomy_category,
							)
						)
						
						) );
			}


		
		elseif(($timeline_um_content_source=="post_id"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post__in' => $timeline_um_post_ids,
						'post_type' => $timeline_um_posttype,
						
						
						) );
			
			
			}

			

								
		
		if ( $wp_query->have_posts() ) :
		
		
		
		$i=0;
		
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
		
		$timeline_um_featured = get_post_meta( get_the_ID(), '_featured', true );
		$timeline_um_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $timeline_um_items_thumb_size );
		$timeline_um_thumb_url = $timeline_um_thumb['0'];
		$timeline_um_thumb_alt = get_the_title(get_post_thumbnail_id(get_the_ID()));
		
		
		
		
		
		if($i%2==0)
			{
				$even_odd = "even";
			}
		else
			{
				$even_odd = "odd";
			}
			
			
		
		$timeline_um_body.= '<li oddeven="'.$even_odd.'" class="timeline_um-item '.$even_odd.'" >';
		$timeline_um_body.= '<div style="background:'.$timeline_um_middle_circle_bg.'" class="timeline_um-button"></div>';
		$timeline_um_body.= '<div class="timeline_um-post">';		
		$timeline_um_body.= '<div class="timeline_um-arrow"></div>';

		
			
		if($timeline_um_featured=="yes")
			{
			$timeline_um_body.= '<div class="timeline_um-featured"></div>';
			}
		
		if(!empty($timeline_um_thumb_url))
			{
					$timeline_um_body.= '<div style="max-height:'.$timeline_um_items_thumb_max_hieght.';" class="timeline_um-thumb">
					<a href="'.get_permalink().'"><img src="'.$timeline_um_thumb_url.'" alt="'.$timeline_um_thumb_alt.'" /></a>
					</div>';
			}
				
		$timeline_um_body.= '<div class="timeline_um-title" style="color:'.$timeline_um_items_title_color.';font-size:'.$timeline_um_items_title_font_size.'">'.get_the_title().'
			</div>';
			
			
$categories = get_the_category();
$separator = ', ';
$category_output = '';
if($categories){
	foreach($categories as $category) {
		$category_output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
	}

}
			
			
		$timeline_um_body.= '<div class="timeline_um-meta" style="color:'.$timeline_um_items_content_color.';">
			';
		if($timeline_um_items_date == 'yes')
		$timeline_um_body.= 'Date: '.get_the_date();
		
		if($timeline_um_items_author == 'yes')
		$timeline_um_body.= ' By: '.get_the_author();
		
		if($timeline_um_items_categories == 'yes')
		$timeline_um_body.= ' Category: '.trim($category_output, $separator);
			
		$timeline_um_body.= '</div>';	
		
		
				
		$timeline_um_body.= '<div class="timeline_um-share" >
			<span class="fb">
				<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='.get_permalink().'"> </a>
			</span>
			<span class="twitter">
				<a target="_blank" href="https://twitter.com/intent/tweet?url='.get_permalink().'&text='.get_the_title().'"></a>
			</span>
			<span class="gplus">
				<a target="_blank" href="https://plus.google.com/share?url='.get_permalink().'"></a>
			</span>
			</div>';
			
			
			
			$timeline_um_body.= '<div class="timeline_um-content" style="color:'.$timeline_um_items_content_color.';font-size:'.$timeline_um_items_content_font_size.'">'.substr(get_the_excerpt(), 0,120).'...
                       <a class="read-more" href="'.get_permalink().'"> Read More</a>
			</div>';		
			
			$timeline_um_body.= '</div>

		</li>';
		
		
		$i++;
		
		endwhile;
		
		wp_reset_query();
		endif;
		

			
		$timeline_um_body .= '</ul>';
		
		
		
		$timeline_um_body .= '<div timeline_id="'.$post_id.'" themes="'.$timeline_um_themes.'" offset="'.$timeline_um_total_items.'" per_page="'.$timeline_um_total_items.'" class="load-more"><span>Load More</span></div>';
		
		
		$timeline_um_body .= '</div>';
		
		
		return $timeline_um_body;

	}
	
	
function timeline_um_body_ajax_flat()
	{
		$post_id = (int)$_POST['timeline_id'];
		$offset = (int)$_POST['offset'];		
		$oddeven = $_POST['oddeven'];		

		$timeline_um_themes = get_post_meta( $post_id, 'timeline_um_themes', true );		
		$timeline_um_bg_img = get_post_meta( $post_id, 'timeline_um_bg_img', true );
		$timeline_um_total_items = get_post_meta( $post_id, 'timeline_um_total_items', true );		
		
		$timeline_um_content_source = get_post_meta( $post_id, 'timeline_um_content_source', true );
		$timeline_um_content_year = get_post_meta( $post_id, 'timeline_um_content_year', true );
		$timeline_um_content_month = get_post_meta( $post_id, 'timeline_um_content_month', true );
		$timeline_um_content_month_year = get_post_meta( $post_id, 'timeline_um_content_month_year', true );
		
		$timeline_um_post_content = get_post_meta( $post_id, 'timeline_um_post_content', true );			
		$timeline_um_posttype = get_post_meta( $post_id, 'timeline_um_posttype', true );			
		$timeline_um_taxonomy = get_post_meta( $post_id, 'timeline_um_taxonomy', true );		
		$timeline_um_taxonomy_category = get_post_meta( $post_id, 'timeline_um_taxonomy_category', true );	
			
		$timeline_um_post_ids = get_post_meta( $post_id, 'timeline_um_post_ids', true );


		$timeline_um_middle_line_bg = get_post_meta( $post_id, 'timeline_um_middle_line_bg', true );
		$timeline_um_middle_circle_bg = get_post_meta( $post_id, 'timeline_um_middle_circle_bg', true );		
		

		$timeline_um_items_title_color = get_post_meta( $post_id, 'timeline_um_items_title_color', true );			
		$timeline_um_items_title_font_size = get_post_meta( $post_id, 'timeline_um_items_title_font_size', true );		

		$timeline_um_items_content_color = get_post_meta( $post_id, 'timeline_um_items_content_color', true );
		$timeline_um_items_content_font_size = get_post_meta( $post_id, 'timeline_um_items_content_font_size', true );

		
		$timeline_um_items_thumb_size = get_post_meta( $post_id, 'timeline_um_items_thumb_size', true );
		$timeline_um_items_thumb_max_hieght = get_post_meta( $post_id, 'timeline_um_items_thumb_max_hieght', true );
			
		
		$timeline_um_items_date = get_post_meta( $post_id, 'timeline_um_items_date', true );		
		$timeline_um_items_author = get_post_meta( $post_id, 'timeline_um_items_author', true );	
		$timeline_um_items_categories = get_post_meta( $post_id, 'timeline_um_items_categories', true );	
		
		
		$timeline_um_body = '';
		

		global $wp_query;

		if(($timeline_um_content_source=="latest"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,
						'orderby' => 'date',
						'order' => 'DESC',
						'posts_per_page' => $timeline_um_total_items,
						'offset' => $offset,
						
						) );
			
			
			}		
		
		elseif(($timeline_um_content_source=="older"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,
						'orderby' => 'date',
						'order' => 'ASC',
						'posts_per_page' => $timeline_um_total_items,
						'offset' => $offset,
						
						) );

			}		

		elseif(($timeline_um_content_source=="featured"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,
						'meta_query' => array(
							array(
								'key' => '_featured',
								'value' => 'yes',
								)),
						'posts_per_page' => $timeline_um_total_items,
						'offset' => $offset,
						
						) );

			}	


		elseif(($timeline_um_content_source=="year"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,
						'year' => $timeline_um_content_year,
						'posts_per_page' => $timeline_um_total_items,
						'offset' => $offset,
						) );

			}

		elseif(($timeline_um_content_source=="month"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,
						'year' => $timeline_um_content_month_year,
						'monthnum' => $timeline_um_content_month,
						'posts_per_page' => $timeline_um_total_items,
						'offset' => $offset,
						
						) );

			}

		elseif($timeline_um_content_source="taxonomy")
			{
				$wp_query = new WP_Query(
					array (
						'post_type' => $timeline_um_posttype,							
						'posts_per_page' => $timeline_um_total_items,
						'offset' => $offset,
						'tax_query' => array(
							array(
								   'taxonomy' => $timeline_um_taxonomy,
								   'field' => 'id',
								   'terms' => $timeline_um_taxonomy_category,
							)
						)
						
						) );
			}


		
		elseif(($timeline_um_content_source=="post_id"))
			{
			
				$wp_query = new WP_Query(
					array (
						'post__in' => $timeline_um_post_ids,
						'post_type' => $timeline_um_posttype,
						'posts_per_page' => $timeline_um_total_items,
						'offset' => $offset,
						
						) );
			
			
			}

			

								
		
		if ( $wp_query->have_posts() ) :
		
		
		if($oddeven == 'odd')
			{
				$i=0;
			}
		else
			{
				$i=1;
			}
		
		
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
		
		$timeline_um_featured = get_post_meta( get_the_ID(), '_featured', true );
		$timeline_um_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), $timeline_um_items_thumb_size );
		$timeline_um_thumb_url = $timeline_um_thumb['0'];
		
		
		
		
		if($i%2==0)
			{
				$even_odd = "even";
			}
		else
			{
				$even_odd = "odd";
			}
			
			
		
		$timeline_um_body.= '<li oddeven="'.$even_odd.'" class="timeline_um-item '.$even_odd.'" >';
		$timeline_um_body.= '<div style="background:'.$timeline_um_middle_circle_bg.'" class="timeline_um-button"></div>';
		$timeline_um_body.= '<div class="timeline_um-post">';		
		$timeline_um_body.= '<div class="timeline_um-arrow"></div>';

		
			
		if($timeline_um_featured=="yes")
			{
			$timeline_um_body.= '<div class="timeline_um-featured"></div>';
			}
		
		if(!empty($timeline_um_thumb_url))
			{
					$timeline_um_body.= '<div style="max-height:'.$timeline_um_items_thumb_max_hieght.';" class="timeline_um-thumb">
					<a href="'.get_permalink().'"><img src="'.$timeline_um_thumb_url.'" /></a>
					</div>';
			}
				
		$timeline_um_body.= '<div class="timeline_um-title" style="color:'.$timeline_um_items_title_color.';font-size:'.$timeline_um_items_title_font_size.'">'.get_the_title().'
			</div>';
			
			
$categories = get_the_category();
$separator = ', ';
$category_output = '';
if($categories){
	foreach($categories as $category) {
		$category_output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>'.$separator;
	}

}
			
			
		$timeline_um_body.= '<div class="timeline_um-meta" style="color:'.$timeline_um_items_content_color.';">
			';
		if($timeline_um_items_date == 'yes')
		$timeline_um_body.= 'Date: '.get_the_date();
		
		if($timeline_um_items_author == 'yes')
		$timeline_um_body.= ' By: '.get_the_author();
		
		if($timeline_um_items_categories == 'yes')
		$timeline_um_body.= ' Category: '.trim($category_output, $separator);
			
		$timeline_um_body.= '</div>';	
		
		
				
		$timeline_um_body.= '<div class="timeline_um-share" >
			<span class="fb">
				<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='.get_permalink().'"> </a>
			</span>
			<span class="twitter">
				<a target="_blank" href="https://twitter.com/intent/tweet?url='.get_permalink().'&text='.get_the_title().'"></a>
			</span>
			<span class="gplus">
				<a target="_blank" href="https://plus.google.com/share?url='.get_permalink().'"></a>
			</span>
			</div>';
			
			
			
			$timeline_um_body .= '<div class="timeline_um-content" style="color:'.$timeline_um_items_content_color.';font-size:'.$timeline_um_items_content_font_size.'">'.timeline_um_get_content($timeline_um_post_content, get_the_ID(), $post_id ).'
			</div>';		
			
			$timeline_um_body.= '</div>

		</li>';
		
		
		$i++;
		
		endwhile;
		
		wp_reset_query();
		
		else:
		
		$timeline_um_body.= '<script>
		jQuery(document).ready(function($)
			{
				$(".load-more").html("<span>No Post</span>");
				$(".load-more").attr("disabled", "disabled").off("click");
				$(".load-more span").css("cursor", "not-allowed");
				
				})
		
		
		</script>';
		
		
		endif;
		

		
		
		echo $timeline_um_body;
		
		die();
	}
	
add_action('wp_ajax_timeline_um_body_ajax_flat', 'timeline_um_body_ajax_flat');
add_action('wp_ajax_nopriv_timeline_um_body_ajax_flat', 'timeline_um_body_ajax_flat');
	
	
	
	
	
	
