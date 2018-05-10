<?php
/**
 * Blog standard post format content part
 *
 * @package vogue
 * @since 1.0.0
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

?>
	<?php
	if ( presscore_get_config()->get( 'show_excerpts' ) ) {
		presscore_the_excerpt();
               //the_excerpt();
	}
	?>
