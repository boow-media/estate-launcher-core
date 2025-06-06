<?php
// Zákaz přímého přístupu
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Načtení TGM knihovny
require_once EL_CORE_PATH . 'vendor/tgm-plugin-activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'el_register_required_plugins' );

/**
 * Registrace požadovaných pluginů pomocí TGM
 */
function el_register_required_plugins() {
	$plugins = [
		[
			'name'     => 'Meta Box',
			'slug'     => 'meta-box',
			'required' => true,
		],
	];

	$config = [
		'id'           => 'estate-launcher',
		'default_path' => '',
		'menu'         => 'install-required-plugins',
		'parent_slug'  => 'plugins.php',
		'capability'   => 'manage_options',
		'has_notices'  => true,
		'dismissable'  => false,
		'is_automatic' => true,
	];

	tgmpa( $plugins, $config );
}
