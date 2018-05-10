<?php 

/*
Plugin Name: Portfolio Ultimate Carousel
Plugin URI: http://portfolio.com/
Description: Display your posts or custom-posts contents in your desire places like into posts, widgets,templates in carousel view by using this carousel plugin.
Author: portfolio Team
Version: 1.0
Author URI: http://www.portfolio.com
*/


add_action('wp_footer', 'wpf_carousel_script');
function wpf_carousel_script(){
	
	wp_enqueue_script('jquery');  
	
	// scripts
	wp_register_script( 'carousel_js', plugins_url( '/js/slick.min.js', __FILE__ ), array('jquery'), null, false);  
	wp_enqueue_script( 'carousel_js' );
	
	// styles
	wp_register_style( 'carousel_css', plugins_url( '/css/slick.css', __FILE__ ),'all' );
	wp_register_style( 'carousel_style', plugins_url( '/css/style.css', __FILE__ ),'all' );
	wp_enqueue_style( 'carousel_css' );
	wp_enqueue_style( 'carousel_style' );

}


// image sizes
if( ! current_theme_supports( 'post-thumbnails' ) ){
	add_theme_support( 'post-thumbnails' );
}

add_image_size( 'wpf-carousel-image', 150, 100, true );
add_image_size( 'wpf-carousel-image-big', 500, 350, true );



//shortcode

function wpf_ultimate_carousel_shortcode($atts){
	extract( shortcode_atts( array(
		'post_type' => 'dt_portfolio', 
		'category' => '',	
		'count' => '-1', 
		'taxonomy' => 'dt_portfolio_category',	
		'name' => 'carousel',	
		'slides' => '1',	
		'scroll' => '1',	
		'autoplay' => 'true',	
		'speed' => '2000',	
		'title_color' => '#000000',	
		'title_bg_color' => '',	
		'link_color' => '#fff',
		'title' => 'Portfolio'	
	), $atts, 'wpf_carousel' ) );
	
		
	
global $post;
$args = array( 'posts_per_page' => $count, 'post_type' => $post_type, $taxonomy => $category);
$myposts = get_posts( $args );

$list = '
	
		<script type="text/javascript">

			jQuery(document).ready(function(){

				jQuery("#wpf_'.$name.'").slick({
				  slidesToShow: '.$slides.',
				  slidesToScroll: '.$scroll.',
				  autoplay: '.$autoplay.',
				  autoplaySpeed: '.$speed.',
				});
			
			});

		</script>

		<div class="wpf_carousel_container" style="width:90%;margin:0 auto;">
		
			<!--h2 style="color:'.$title_color.';background:'.$title_bg_color.';">'.$title.'</h2-->
		<div id="wpf_'.$name.'">';


foreach( $myposts as $post ) : setup_postdata($post);
	
	$post_thumbnail= get_the_post_thumbnail( $post->ID, 'full',array('alt' => get_the_title(),'title' => get_the_title())); 
    $list .= '
		
		
		<div class="wpf_slides">
			<div class="wpb_column vc_column_container vc_col-sm-8 slidephoto">'.$post_thumbnail.'</div>
			<div class="wpb_column vc_column_container vc_col-sm-4 slidecontent" ><h2 style="color:'.$link_color.'">'.get_the_title().'</h2><p>'.get_the_excerpt().'</p></div>
		</div>
				

	';  
	
endforeach;	
	


$list.= '</div></div>';
wp_reset_query();
return $list;
}
add_shortcode('wpf_carousel', 'wpf_ultimate_carousel_shortcode');


// title shortner

function ShortenText($text) { // Function name ShortenText
  $chars_limit = 30; // Character length
  $chars_text = strlen($text);
  $text = $text." ";
  $text = substr($text,0,$chars_limit);
  $text = substr($text,0,strrpos($text,' '));

  if ($chars_text > $chars_limit)
     { $text = $text.".."; } // Ellipsis
     return $text;
}
add_shortcode('shortentitle', 'ShortenText'); 


//=========== code blog post by categories in services page before get started form==//

function wpf_post_carousel_shortcode($atts){
	extract( shortcode_atts( array(
		'post_type' => 'post', 
		'category' => '',	
		'count' => '-1', 
		'taxonomy' => 'category_name',	
		'name' => 'carousel',	
		'slides' => '3',	
		'scroll' => '1',	
		'autoplay' => 'true',	
		'speed' => '2000',	
		'title_color' => '#000000',	
		'title_bg_color' => '',	
		'link_color' => '#222222',
		'title' => 'Blog'	
	), $atts, 'post_carousel' ) );
	
		
	
global $post;
$args = array( 'posts_per_page' => $count, 'post_type' => $post_type, $taxonomy => $category);
$myposts = get_posts( $args );

$list = '
	
		<script type="text/javascript">

			jQuery(document).ready(function(){

				jQuery("#wpf_'.$name.'").slick({
				  slidesToShow: '.$slides.',
				  slidesToScroll: '.$scroll.',
				  autoplay: '.$autoplay.',
				  autoplaySpeed: '.$speed.',
				});
			
			});

		</script>

		<div class="wpf_carousel_container" style="width:90%;margin:0 auto;">
		
			<!--h2 style="color:'.$title_color.';background:'.$title_bg_color.';">'.$title.'</h2-->
		<div id="wpf_'.$name.'">';


foreach( $myposts as $post ) : setup_postdata($post);
	
	$post_thumbnail= get_the_post_thumbnail( $post->ID, 'Medium',array('alt' => get_the_title(),'title' => get_the_title())); 
    $list .= '
		
		
		<div class="wpf_slides_blog">
			<div class="wpb_column vc_column_container postslidecontent" ><div class="postslidephoto">'.$post_thumbnail.'</div><h2><a style="color:'.$link_color.'" href="'.get_permalink().'">'.get_the_title().'</a></h2><p style="color:#333">'.substr(get_the_excerpt(), 0,60).'...</p>
               <a class="btn-readmore" href="'.get_permalink().'">Read More</a>
               </div>
		</div>
				

	';  
	
endforeach;	
	


$list.= '</div></div>';
wp_reset_query();
return $list;
}
add_shortcode('post_carousel', 'wpf_post_carousel_shortcode');



//===end===//
?>
