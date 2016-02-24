<?php
/**
 * Twenty Sixteen back compat functionality
 *
 * Prevents Twenty Sixteen from running on WordPress versions prior to 4.3,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.3.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/**
 * Prevent switching to Twenty Sixteen on unsupported versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'twentysixteen_upgrade_notice' );
}
add_action( 'after_switch_theme', 'twentysixteen_switch_theme' );

/**
 * Add message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Twenty Sixteen on unsupported versions of WordPress.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_upgrade_notice() {
	printf( '<div class="error"><p>%s</p></div>', twentysixteen_minimum_required_version_message() );
}

/**
 * Prevents the Customizer from being loaded on unsupported versions of WordPress.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_customize() {
	wp_die( twentysixteen_minimum_required_version_message(), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'twentysixteen_customize' );

/**
 * Prevents the Theme Preview from being loaded on unsupported versions of WordPress.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( twentysixteen_minimum_required_version_message() );
	}
}
add_action( 'template_redirect', 'twentysixteen_preview' );

/**
 * Minimum required WordPress version message.
 *
 * @since Twenty Fifteen 1.2
 *
 * @global string $wp_version WordPress version.
 * @return string
 */
function twentysixteen_minimum_required_version_message() {
	$message = sprintf(
		/* translators: %s: WordPress version */
		__( 'Twenty Sixteen requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'twentysixteen' ),
		$GLOBALS['wp_version']
	);
	return $message;
}
