<?php
// Zákaz přímého přístupu
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Vykreslení SVG loga platformy na základě ID (např. 'google', 'facebook')
 *
 * @param string $platform_id
 * @return string
 */
function el_render_platform_logo( $platform_id ) {
	if ( ! $platform_id ) {
		return '';
	}

	$platform_id = sanitize_file_name( $platform_id ); // Bezpečnostní úprava

	$path = EL_CORE_PATH . 'assets/svg/' . $platform_id . '.svg';
	$url  = EL_CORE_URL . 'assets/svg/' . $platform_id . '.svg';

	// Pokud soubor existuje, vlož SVG inline
	if ( file_exists( $path ) ) {
		$svg = file_get_contents( $path );
		if ( $svg ) {
			return '<span class="el-platform-logo el-' . esc_attr( $platform_id ) . '">' . $svg . '</span>';
		}
	}

	// Fallback – odkaz na soubor
	return '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( ucfirst( $platform_id ) ) . ' logo" class="el-platform-logo">';
}

/**
 * Shortcode pro zobrazení loga platformy v recenzi
 *
 * Použití: [el_platform_logo]
 */
add_shortcode( 'el_platform_logo', function () {
	if ( ! is_singular( 'el_recenze' ) ) {
		return '';
	}

	$platform = get_post_meta( get_the_ID(), 'platforma', true );
	return el_render_platform_logo( $platform );
} );

/**
 * Vložení meta tagů do <head>
 */
add_action( 'wp_head', function () {
	$project_id = get_option( 'el_core_project_id' );

	echo '<meta name="author" content="Boow Media">' . PHP_EOL;

	if ( $project_id ) {
		echo '<meta name="estate-launcher-id" content="' . esc_attr( $project_id ) . '">' . PHP_EOL;
	}
} );