<?php
/**
 * The template for displaying Tag pages
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
  * @package vogue
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
/*
$config = presscore_get_config();
$config->set( 'template', 'archive' );
$config->set( 'layout', 'list' );
$config->set( 'template.layout.type', 'list' );
*/
get_header();
?>

	
			<!-- Content -->
			<div id="content" class="content" role="main">

				<?php
$wpq = array ( 
    'post_type' => 'post',
    'post_status' => 'published',
    'tag__in'=> 'post_tag'
);
				$the_query = new WP_Query($wpq);

if ( $the_query->have_posts() ) {
    echo '<ul>';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        echo '<li>' . get_the_title() . '</li>';
    }
    echo '</ul>';
} else {
    // no posts found
}
/* Restore original Post Data */
wp_reset_postdata();
				?>

			</div><!-- #content -->

			<?php //do_action('presscore_after_content'); ?>

<?php get_footer(); ?>