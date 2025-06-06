<?php
// Zákaz přímého přístupu
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registrace CPT: Nemovitosti
 */
function el_register_post_type_nemovitosti() {

	// Pokud je deaktivováno v nastavení, CPT se neregistruje
	if ( get_option( 'el_enable_nemovitosti', '1' ) !== '1' ) {
		return;
	}

	$labels = [
		'name'                  => _x( 'Nemovitosti', 'Post Type General Name', 'estate-launcher' ),
		'singular_name'         => _x( 'Nemovitost', 'Post Type Singular Name', 'estate-launcher' ),
		'menu_name'             => __( 'Nemovitosti', 'estate-launcher' ),
		'name_admin_bar'        => __( 'Nemovitost', 'estate-launcher' ),
		'add_new'               => __( 'Přidat novou', 'estate-launcher' ),
		'add_new_item'          => __( 'Přidat novou nemovitost', 'estate-launcher' ),
		'edit_item'             => __( 'Upravit nemovitost', 'estate-launcher' ),
		'new_item'              => __( 'Nová nemovitost', 'estate-launcher' ),
		'view_item'             => __( 'Zobrazit nemovitost', 'estate-launcher' ),
		'search_items'          => __( 'Hledat nemovitosti', 'estate-launcher' ),
		'not_found'             => __( 'Nenalezeny žádné nemovitosti', 'estate-launcher' ),
		'not_found_in_trash'    => __( 'V koši nejsou žádné nemovitosti', 'estate-launcher' ),
	];

	$args = [
		'label'                 => __( 'Nemovitosti', 'estate-launcher' ),
		'labels'                => $labels,
		'public'                => true,
		'has_archive'           => true,
		'menu_icon'             => 'dashicons-admin-home',
		'menu_position'         => 20,
		'show_in_rest'          => false, // ← deaktivuje Gutenberg, použije TinyMCE
		'supports'              => [ 'title', 'editor', 'thumbnail' ],
		'rewrite'               => [ 'slug' => 'nemovitosti' ],
		'show_in_menu'          => true,
	];

	register_post_type( 'el_nemovitost', $args );
}
add_action( 'init', 'el_register_post_type_nemovitosti' );