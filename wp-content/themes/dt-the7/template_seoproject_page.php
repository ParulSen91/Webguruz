<?php
/**
 * The template name:Seo project page
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package presscore
 * @since presscore 1.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

$config = Presscore_Config::get_instance();
$config->set('template', 'page');
if (is_front_page())
{

get_header('home');

}
else
{
	


	get_header();

}
?>
<script type="text/javascript">
	jQuery(function($) {
		
		var filterList = {
		
			init: function () {
			
				// MixItUp plugin
				// http://mixitup.io
				$('#portfoliolist').mixItUp({
  				selectors: {
    			  target: '.portfolio',
    			  filter: '.filter'	
    		  },
    		  load: {
      		  filter: '*'  
      		}     
				});								
			
			}

		};
		
		// Run the show!
		filterList.init();
		
		
	});	
	</script>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/custom/css/normalize.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/custom/css/layout.css">


<?php
				 $terms = get_terms("seocategory");
				 $count = count($terms);
				 echo '<ul id="filters" class="clearfix">';
					echo '<li><span class="filter active" data-filter="*">All</span></li>';
				 if ( $count > 0 ){
					
						foreach ( $terms as $term ) {
							
							$termname = strtolower($term->name);
							$termname = str_replace(' ', '-', $termname);
							echo '<li><span class="filter" data-filter=".'.$termname.'">'.$term->name.'</span></li>';
						}
				 }
				 echo "</ul>";
			?>
			<?php 
				$loop = new WP_Query(array('post_type' => 'seoproject', 'posts_per_page' => -1));
				$count =0;
			?>
			<div id="portfolio-wrapper ">
				<div id="portfoliolist">
			
				<?php if ( $loop ) : 
					 
					while ( $loop->have_posts() ) : $loop->the_post(); ?>
					
						<?php
						$terms = get_the_terms( $post->ID, 'seocategory' );
								
						if ( $terms && ! is_wp_error( $terms ) ) : 
							$links = array();

							foreach ( $terms as $term ) 
							{
								$links[] = $term->name;
							}
							$links = str_replace(' ', '-', $links);	
							$tax = join( " ", $links );		
						else :	
							$tax = '';	
						endif;
						?>
						<?php $infos = get_post_custom_values('_url'); ?>
				<div class="forpackagetablemain portfolio <?php echo strtolower($tax); ?>" data-cat="<?php echo strtolower($tax); ?>">
				<div class="portfolio-wrapper">	
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0" >
     <tbody><tr>
       <td align="left" valign="top" bgcolor="#fff" style="border:1px #fff solid; border-bottom:0px; padding:0;"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" style="border-bottom:0; height:380px;">
         <tbody><tr>
           <td  align="center" valign="top" bgcolor="#FFFFFF" style="border-right:1px #cccccc solid; border-bottom:1px solid #fff">
		   <div class="seo-port-thumb"><?php
		the_post_thumbnail();
		?></div></td>
           <td align="left" valign="middle" bgcolor="#FFFFFF" style="border-bottom:1px solid #fff"><p><strong>WebSite Name:</strong><?php echo get_post_meta(get_the_ID(), 'WebSite Name', TRUE); ?></p>
               <p><strong>Target:</strong>  <?php echo get_post_meta(get_the_ID(), 'Target', TRUE); ?></p>
			    <p><strong>Method:</strong> <?php echo get_post_meta(get_the_ID(), 'Method', TRUE); ?></p>
               <?php $content = get_the_excerpt(); ?>
				<p><strong>Success Story:</strong><?php  echo $content; // echo substr($content, 0, 100); ?></h4>
			   </td>
         </tr>
       </tbody></table></td>
     </tr>
     <tr>
       <td align="left" valign="top" bgcolor="#f3eddd" style="padding:0;border: 1px solid #fff;"><table width="100%" border="0" cellspacing="1" cellpadding="1"> 
         <tbody><tr>
           <td width="60%" align="left" valign="top" bgcolor="#FFFFFF" style="background:#fcfaf4; color:#009e96;"><strong>Keywords</strong></td>
           <td width="20%" align="center" valign="top" bgcolor="#FFFFFF" style="background:#fcfaf4; color:#009e96;"> <strong>Baseline Rankings</strong></td>
           <td width="20%" align="center" valign="top" bgcolor="#FFFFFF" style="background:#fcfaf4; color:#009e96;"><strong>Current Ranking</strong></td>
         </tr>
         <tr>
           <td align="left" valign="top" bgcolor="#FFFFFF">IT B Schools</td>
           <td align="center" valign="top" bgcolor="#FFFFFF">1</td>
		    <td align="center" valign="top" bgcolor="#FFFFFF">1</td>
         </tr>
         <tr>
           <td align="left" valign="top" bgcolor="#FFFFFF">Executive MBA Pune</td>
           <td align="center" valign="top" bgcolor="#FFFFFF">3</td>
		   <td align="center" valign="top" bgcolor="#FFFFFF">3</td>
         </tr>
         <tr>
           <td align="left" valign="top" bgcolor="#FFFFFF">MBA in Pune</td>
           <td align="center" valign="top" bgcolor="#FFFFFF">4</td>
		    <td align="center" valign="top" bgcolor="#FFFFFF">4</td>
         </tr>
         <tr>
           <td align="left" valign="top" bgcolor="#FFFFFF">MBA in Symbiosis</td>
           <td align="center" valign="top" bgcolor="#FFFFFF">4</td>
		    <td align="center" valign="top" bgcolor="#FFFFFF">4</td>
         </tr>
         
       </tbody></table></td>
     </tr>
    
   </tbody></table>		
	</div>
	</div>
						
					<?php endwhile; else: ?>
					 
					<div class="error-not-found">Sorry, no portfolio entries for while.</div>
						
				<?php endif; ?>
			

				</div>

				<div class="clearboth"></div>
			
			</div> <!-- end #portfolio-wrapper-->
			
			
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/custom/js/jquery.mixitup.min.js"></script>
	
<?php get_footer(); ?>
