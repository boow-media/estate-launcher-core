<?php
// includes/admin-columns.php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ====== Vlastní CSS pro badge ======
add_action( 'admin_enqueue_scripts', function ( $hook ) {
	if ( $hook === 'edit.php' || $hook === 'post.php' ) {
		$screen = get_current_screen();
		if ( $screen && $screen->post_type === 'el_nemovitost' ) {
			wp_enqueue_style( 'el-admin-badge', EL_CORE_URL . 'assets/css/admin.css', [], EL_CORE_VERSION );
		}
	}
} );
