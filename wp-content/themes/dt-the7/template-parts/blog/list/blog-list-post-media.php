<?php
/**
 * Blog post content media template
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<h3 class="entry-title">
		<a href="<?php the_permalink(); ?>" title="<?php echo the_title_attribute( 'echo=0' ); ?>" rel="bookmark"><?php the_title(); ?></a>
	</h3>
		<?php echo presscore_get_posted_on(); ?>
		    <div class="view-count">
		<?php echo do_shortcode("[hit_count]");?>
		
		<div class="social-icons">
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
			</div>
<?php
// check show or not media content
if ( presscore_show_post_media() ): ?>

	<div class="blog-media wf-td" <?php echo presscore_get_post_content_style_for_blog_list( 'media' ); ?>>

	<?php
	/////////////////
	// fancy date //
	/////////////////

	echo presscore_get_blog_post_fancy_date();

	/////////////////////
	// media template //
	/////////////////////

	 presscore_get_template_part( 'theme', "blog/list/blog-list-post-media-content", get_post_format() );
	?>

	</div>

<?php endif; ?>
