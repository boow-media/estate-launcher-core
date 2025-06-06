<?php
// Zákaz přímého přístupu
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registrace CPT: Recenze
 */
function el_register_post_type_recenze() {

	// Pokud je deaktivováno v nastavení, CPT se neregistruje
	if ( get_option( 'el_enable_recenze', '1' ) !== '1' ) {
		return;
	}

	$labels = [
		'name'                  => _x( 'Recenze', 'Post Type General Name', 'estate-launcher' ),
		'singular_name'         => _x( 'Recenze', 'Post Type Singular Name', 'estate-launcher' ),
		'menu_name'             => __( 'Recenze', 'estate-launcher' ),
		'name_admin_bar'        => __( 'Recenze', 'estate-launcher' ),
		'add_new'               => __( 'Přidat novou', 'estate-launcher' ),
		'add_new_item'          => __( 'Přidat novou recenzi', 'estate-launcher' ),
		'edit_item'             => __( 'Upravit recenzi', 'estate-launcher' ),
		'new_item'              => __( 'Nová recenze', 'estate-launcher' ),
		'view_item'             => __( 'Zobrazit recenzi', 'estate-launcher' ),
		'search_items'          => __( 'Hledat recenze', 'estate-launcher' ),
		'not_found'             => __( 'Nenalezeny žádné recenze', 'estate-launcher' ),
		'not_found_in_trash'    => __( 'V koši nejsou žádné recenze', 'estate-launcher' ),
	];

	$args = [
		'label'                 => __( 'Recenze', 'estate-launcher' ),
		'labels'                => $labels,
		'public'                => true,
		'has_archive'           => false,
		'menu_icon'             => 'dashicons-testimonial',
		'menu_position'         => 21,
		'show_in_rest'          => false, // ← zakáže Gutenberg
		'supports'              => [ 'title', 'editor' ],
		'rewrite'               => [ 'slug' => 'recenze' ],
		'show_in_menu'          => true,
	];

	register_post_type( 'el_recenze', $args );
}
add_action( 'init', 'el_register_post_type_recenze' );

/**
 * Vypnutí Gutenberg editoru pro recenze
 */
add_filter( 'use_block_editor_for_post_type', function ( $use_block_editor, $post_type ) {
	return $post_type === 'el_recenze' ? false : $use_block_editor;
}, 10, 2 );