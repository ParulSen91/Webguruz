<?php
/**
 * Archive pages.
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$config = presscore_get_config();
$config->set( 'template', 'archive' );
$config->set( 'layout', 'list' );
$config->set( 'template.layout.type', 'list' );

get_header(); ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/jquery.social-buttons.css">

			<!-- Content -->
			<div id="content" class="content author authormain" role="main">
                          <!--header class="page-header">
                    <h1 class="page-title author"><?php printf( __( 'Author : %s', 'twentyeleven' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1>
                </header-->
 <?php   $author_id = get_the_author_meta( "ID" );
                // If a user has filled out their description, show a bio on their entries.
                if ( get_the_author_meta( 'description' ) ) : ?>
                <div id="author-info">
                    <div id="author-description">
                        <h2><?php printf( __( 'About %s', 'twentyeleven' ), get_the_author() ); ?></h2>
                         <div id="author-avatar-img">
                        <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 150 ) ); ?>
                    </div><!-- #author-avatar -->
                        <div class="author_information"><?php the_author_meta( 'description' ); ?>
              
                    </div>
                        <?php $ezine=get_the_author_meta( 'url' );
                        if($ezine){ ?>
                          <a class="ezineprofile" target="_blank" href="<?php echo get_the_author_meta( 'url' ); ?>">Read More</a>
                          <?php } ?>
                    </div><!-- #author-description -->
                    <div style="clear:both;"></div>
                </div><!-- #entry-author-info -->
                  <div style="clear:both;"></div>
                <?php endif; ?>
<h2 style="margin-top:20px; color:#34afad;"><?php printf( __( 'Blog Written By %s', 'twentyeleven' ), get_the_author() ); ?></h2>
<?php $args = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => 'date',
	'order'            => 'DESC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'author'	   => $author_id,
	'author_name'	   => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
); ?>
				<?php



query_posts( $args );
				if ( have_posts() ) :

						$config_backup = $config->get();
						while ( have_posts() ) : the_post();

							presscore_get_template_part( 'theme', 'blog/list/blog-list-post' );
							$config->reset( $config_backup );
                                                      ?>


             <?php

						endwhile;

					// masonry container close
					//echo '</div>';

					//dt_paginator();

					//do_action( 'presscore_after_loop' );

				else :

					get_template_part( 'no-results', 'search' );

				endif;
				?>

			</div><!-- #content -->

			<?php do_action('presscore_after_content'); ?>



<?php get_footer(); ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.social-buttons.js"></script>
	    <script type="text/javascript">
	        jQuery( document ).ready(function($) {
	        var slink='<?php the_permalink(); ?>'
	       /* alert(slink);*/
			        $(function () {
			            $('[data-social]').socialButtons({
			               
			            });
			        
			       	 });

			       
	        });
	    </script>