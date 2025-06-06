<?php
// Zákaz přímého přístupu
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Registrace nastavení (bez project_id – to se nemá přepisovat)
add_action( 'admin_init', 'el_core_register_settings' );
function el_core_register_settings() {
	register_setting( 'el_core_settings_group', 'el_enable_nemovitosti' );
	register_setting( 'el_core_settings_group', 'el_enable_recenze' );
	// register_setting( 'el_core_settings_group', 'el_core_project_id' ); ← odstraněno záměrně
}

// Automatické vygenerování project ID, pokud není definováno
add_action( 'admin_init', function () {
	if ( ! get_option( 'el_core_project_id' ) ) {
		$new_id = 'EL-' . wp_generate_password( 12, false, false );
		update_option( 'el_core_project_id', $new_id );
	}
} );

// Přidání stránky do admin menu
add_action( 'admin_menu', function () {
	add_menu_page(
		'Estate Launcher Core',     // Titulek stránky
		'Estate Launcher',          // Název v levém menu
		'manage_options',           // Oprávnění
		'el-core-settings',         // Slug URL
		'el_core_settings_page',    // Callback funkce
		'dashicons-admin-generic',  // Ikona
		80                          // Pozice v menu
	);
} );

// Výpis administrační stránky
function el_core_settings_page() {
	$project_id           = get_option( 'el_core_project_id', '—' );
	$enabled_nemovitosti = get_option( 'el_enable_nemovitosti', '1' );
	$enabled_recenze     = get_option( 'el_enable_recenze', '1' );
	?>
	<div class="wrap">
		<h1>Estate Launcher Core</h1>

		<table class="form-table" role="presentation">
			<tr>
				<th scope="row">ID webu</th>
				<td>
					<input type="text" value="<?php echo esc_attr( $project_id ); ?>" readonly style="width: 350px;">
					<p class="description">Toto ID slouží k interní identifikaci webu, na kterém je nasazen realitní systém <strong>Estate Launcher Core</strong>.</p>
				</td>
			</tr>
		</table>

		<hr>
		<h2>Nastavení</h2>

		<form method="post" action="options.php">
			<?php settings_fields( 'el_core_settings_group' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">Zobrazit CPT „Nemovitosti“</th>
					<td>
						<input type="checkbox" name="el_enable_nemovitosti" value="1" <?php checked( $enabled_nemovitosti, '1' ); ?>>
					</td>
				</tr>
				<tr>
					<th scope="row">Zobrazit CPT „Recenze“</th>
					<td>
						<input type="checkbox" name="el_enable_recenze" value="1" <?php checked( $enabled_recenze, '1' ); ?>>
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
