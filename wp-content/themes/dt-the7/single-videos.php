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
<?php   
$postid=get_the_ID();
$position = get_post_meta($postid,'wpvp_position',true);
$company = get_post_meta($postid,'wpvp_company',true);
$email = get_post_meta($postid,'wpvp_email',true);
$videou = get_post_meta($postid,'video_url',true);
$img = get_post_meta($postid,'image_url',true);
//echo $url = wp_get_attachment_url( get_post_thumbnail_id($postid), 'thumbnail' );
?>
<?php if($videou){ ?>
<div class="testimonial-video">
<video width="265" height="225" data-setup="{}" preload="none" controls="" class="video-js vjs-default-skin" id="wpvp_videojs_1482469171">
<source type="video/mp4" src="<?php echo $videou; ?>"></source></video>
</div>
<?php } ?>
<div class="testimonial-image">
<img src="<?php echo $img; ?>"  width="265" height="225" >
</div>
<div class="text-desc">
<?php echo get_the_content(); ?>
</div>
<div class="">
<ul>
<li>Position: <?php echo $position; ?></li>
<li>Company: <?php echo $company; ?></li>
<li>Email: <?php echo $email; ?></li>
</ul>
</div>
<?php //get_template_part( 'content-single', str_replace( 'dt_', '', get_post_type() ) ); ?>

				

			</div><!-- #content .wf-cell -->



			

			<?php do_action( 'presscore_after_content' ); ?>

		<?php endif; // content is visible ?>

<?php endwhile; endif; // end of the loop. ?>

<?php get_footer(); ?>
