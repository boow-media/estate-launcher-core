<?php
/**
 * Plugin Name:       Estate Launcher Core
 * Plugin URI:        https://github.com/boowmedia/estate-launcher-core
 * Description:       Modulární systém pro realitní weby, který zajišťuje správu nemovitostí i recenzí a tvoří stabilní základ pro další rozvoj a automatizaci.
 * Version:           1.3.0
 * Author:            Boow Media
 * Author URI:        https://www.boow.cz/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       estate-launcher
 *
 * GitHub Plugin URI: https://github.com/boowmedia/estate-launcher-core
 * GitHub Branch:     main
 */

// Zákaz přímého přístupu
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Definice konstant
define( 'EL_CORE_VERSION', '1.3.0' );
define( 'EL_CORE_PLUGIN_FILE', __FILE__ );
define( 'EL_CORE_PATH', plugin_dir_path( __FILE__ ) );
define( 'EL_CORE_URL', plugin_dir_url( __FILE__ ) );

// Načítání souborů pluginu (EN názvy)
require_once EL_CORE_PATH . 'includes/cpt-properties.php';
require_once EL_CORE_PATH . 'includes/cpt-reviews.php';
require_once EL_CORE_PATH . 'includes/meta-properties.php';
require_once EL_CORE_PATH . 'includes/meta-reviews.php';
require_once EL_CORE_PATH . 'includes/admin-columns.php';
require_once EL_CORE_PATH . 'includes/settings-page.php';
require_once EL_CORE_PATH . 'includes/helpers.php';
require_once EL_CORE_PATH . 'includes/filters.php';
require_once EL_CORE_PATH . 'includes/tgm-init.php';
require_once EL_CORE_PATH . 'includes/github-updater.php';

// Aktivace pluginu – generování unikátního ID webu
register_activation_hook( __FILE__, function () {
	$existing_id = get_option( 'el_core_project_id' );
	if ( ! $existing_id ) {
		$new_id = 'el-' . wp_generate_password( 8, false, false );
		update_option( 'el_core_project_id', $new_id );
	}
});
