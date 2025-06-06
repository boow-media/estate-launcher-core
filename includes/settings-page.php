<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Registrace nastavení
add_action( 'admin_init', function () {
	register_setting( 'el_core_settings_group', 'el_enable_nemovitosti' );
	register_setting( 'el_core_settings_group', 'el_enable_recenze' );
});

// Vygenerování ID webu
add_action( 'admin_init', function () {
	if ( ! get_option( 'el_core_project_id' ) ) {
		update_option( 'el_core_project_id', 'el-' . wp_generate_password( 10, false, false ) );
	}
});

// Přidání stránky do menu
add_action( 'admin_menu', function () {
	add_menu_page(
		"Estate Launcher Core",
		"Estate Launcher",
		"manage_options",
		"el-core-settings",
		"el_core_settings_page",
		"dashicons-admin-generic",
		80
	);
});

// Uložení údajů o makléři
add_action( 'admin_post_el_save_agent_info', function () {
	if ( ! current_user_can( 'manage_options' ) ) wp_die();
	check_admin_referer( 'el_agent_info_save' );

	$fields = [
		'agent_firstname', 'agent_lastname', 'agent_email', 'agent_phone',
		'agent_address', 'agent_facebook', 'agent_linkedin',
		'agent_instagram', 'agent_youtube', 'agent_tiktok', 'agent_x'
	];

	$data = [];
	foreach ( $fields as $field ) {
		$data[ $field ] = sanitize_text_field( $_POST[ $field ] ?? '' );
	}
	update_option( 'el_agent_info', $data );

	wp_redirect( admin_url( 'admin.php?page=el-core-settings&updated=1' ) );
	exit;
});

// Shortcody pro textové údaje
foreach ([ 'firstname', 'lastname', 'phone', 'email', 'address' ] as $field) {
	add_shortcode("agent_$field", fn() => esc_html(get_option('el_agent_info')["agent_$field"] ?? ''));
}

// Shortcody pro URL odkazy na sítě
foreach ([ 'facebook', 'linkedin', 'instagram', 'youtube', 'tiktok', 'x' ] as $field) {
	add_shortcode("agent_{$field}_url", fn() => esc_url(get_option('el_agent_info')["agent_$field"] ?? ''));
}

// Výpis admin stránky
function el_core_settings_page() {
	$project_id           = get_option( 'el_core_project_id', '---' );
	$enabled_nemovitosti = get_option( 'el_enable_nemovitosti', '1' );
	$enabled_recenze     = get_option( 'el_enable_recenze', '1' );
	$agent                = get_option( 'el_agent_info', [] );
	$updated              = isset($_GET['updated']);
	?>

	<div class="wrap" style="max-width: 700px;">
		<h1 style="margin-bottom: 8px;">Estate Launcher Core</h1>
		<p style="margin-bottom: 24px; color: #666;">Základní nastavení realitního systému <strong>Estate Launcher Core</strong>.</p>

		<?php if ( $updated ) : ?>
			<div class="notice notice-success is-dismissible"><p><strong>Data byla úspěšně uložena.</strong></p></div>
		<?php endif; ?>

		<!-- ID webu -->
		<div style="background: #fff; border: 1px solid #ccd0d4; padding: 20px; margin-bottom: 30px;">
			<h2>ID webu</h2>
			<p>Toto ID slouží k interní identifikaci webu.</p>
			<div style="display: flex; gap: 8px; align-items: center; max-width: 400px;">
				<input type="text" readonly value="<?php echo esc_attr( $project_id ); ?>" id="el-project-id" style="width: 100%;" />
				<button type="button" class="button" onclick="copyToClipboard()">Zkopírovat ID</button>
			</div>
		</div>

		<!-- Moduly -->
		<form method="post" action="options.php">
			<?php settings_fields( 'el_core_settings_group' ); ?>
			<div style="background: #fff; border: 1px solid #ccd0d4; padding: 20px; margin-bottom: 30px;">
				<h2>Nastavení modulů</h2>
				<label><input type="checkbox" name="el_enable_nemovitosti" value="1" <?php checked( $enabled_nemovitosti, '1' ); ?> /> Modul Nemovitosti</label><br>
				<label><input type="checkbox" name="el_enable_recenze" value="1" <?php checked( $enabled_recenze, '1' ); ?> /> Modul Recenze</label>
				<?php submit_button(); ?>
			</div>
		</form>

		<!-- Údaje o makléři -->
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="el_save_agent_info">
			<?php wp_nonce_field( 'el_agent_info_save' ); ?>
			<div style="background: #fff; border: 1px solid #ccd0d4; padding: 20px;">
				<h2>Údaje o makléři</h2>
				<?php
				function el_field($label, $name, $value = '', $type = 'text') {
					printf(
						'<p><label><strong>%s</strong><br><input type="%s" name="%s" value="%s" style="width:100%%;"></label></p>',
						esc_html($label), esc_attr($type), esc_attr($name), esc_attr($value)
					);
				}

				el_field('Jméno makléře', 'agent_firstname', $agent['agent_firstname'] ?? '');
				el_field('Příjmení makléře', 'agent_lastname', $agent['agent_lastname'] ?? '');
				el_field('Telefon', 'agent_phone', $agent['agent_phone'] ?? '');
				el_field('E-mail', 'agent_email', $agent['agent_email'] ?? '', 'email');
				el_field('Adresa', 'agent_address', $agent['agent_address'] ?? '');
				el_field('Facebook', 'agent_facebook', $agent['agent_facebook'] ?? '', 'url');
				el_field('LinkedIn', 'agent_linkedin', $agent['agent_linkedin'] ?? '', 'url');
				el_field('Instagram', 'agent_instagram', $agent['agent_instagram'] ?? '', 'url');
				el_field('YouTube', 'agent_youtube', $agent['agent_youtube'] ?? '', 'url');
				el_field('TikTok', 'agent_tiktok', $agent['agent_tiktok'] ?? '', 'url');
				el_field('X (Twitter)', 'agent_x', $agent['agent_x'] ?? '', 'url');
				?>
				<?php submit_button( 'Uložit údaje o makléři' ); ?>
			</div>
		</form>

		<!-- Shortcody -->
		<div style="background: #fff; border: 1px solid #ccd0d4; padding: 20px; margin-top: 30px;">
			<h2>Shortcody pro vložení údajů makléře</h2>
			<p>Vložte je do prvků přes „Dynamická data → Shortcode“ nebo použijte Breakdance formát:</p>
			<table class="widefat striped">
				<thead><tr><th>Údaj</th><th>Shortcode</th><th>Breakdance kód</th></tr></thead>
				<tbody>
					<?php
					$shortcodes = [
						'Jméno' => 'agent_firstname',
						'Příjmení' => 'agent_lastname',
						'Telefon' => 'agent_phone',
						'E-mail' => 'agent_email',
						'Adresa' => 'agent_address',
						'Facebook URL' => 'agent_facebook_url',
						'LinkedIn URL' => 'agent_linkedin_url',
						'Instagram URL' => 'agent_instagram_url',
						'YouTube URL' => 'agent_youtube_url',
						'TikTok URL' => 'agent_tiktok_url',
						'X URL' => 'agent_x_url',
					];
					foreach ( $shortcodes as $label => $code ) {
						$basic = "[$code]";
						$bd = "[breakdance_dynamic field='shortcode' params='{\"shortcode\":\"$basic\"}']";
						echo '<tr>';
						echo '<td>' . esc_html($label) . '</td>';
						echo '<td><input type="text" value="' . esc_attr($basic) . '" readonly class="el-copy-input"></td>';
						echo '<td><input type="text" value="' . esc_attr($bd) . '" readonly class="el-copy-input" style="font-size:12px;"></td>';
						echo '</tr>';
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

	<script>
	function copyToClipboard() {
		const input = document.getElementById("el-project-id");
		input.select();
		document.execCommand('copy');
		alert("ID bylo zkopírováno do schránky.");
	}

	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.el-copy-input').forEach(input => {
			input.addEventListener('click', function () {
				const original = this.value;
				this.select();
				document.execCommand('copy');
				this.value = 'Zkopírováno!';
				this.classList.add('copied');
				setTimeout(() => {
					this.value = original;
					this.classList.remove('copied');
				}, 1000);
			});
		});
	});
	</script>
<?php }
