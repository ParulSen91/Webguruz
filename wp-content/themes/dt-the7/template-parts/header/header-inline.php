<?php
/**
 * Inline header.
 *
 * @package the7
 * @since 3.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<div <?php presscore_header_class( 'masthead inline-header' ); presscore_header_inline_style(); ?> role="banner">

	<?php presscore_get_template_part( 'theme', 'header/top-bar' ); ?>

	<header class="header-bar">
<div class="phonetop">+1-844-885-0010 or <span> <a href="<?php echo home_url(); ?>/schedule-call/">(Schedule a call)</a></span></div>
		<?php presscore_get_template_part( 'theme', 'header/branding' ); ?>

		<?php presscore_get_template_part( 'theme', 'header/primary-menu' ); ?>

		<?php presscore_render_header_elements( 'near_menu_right' ); ?>

	</header>

</div>
