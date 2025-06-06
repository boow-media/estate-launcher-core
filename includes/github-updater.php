<?php

class Estate_Launcher_Updater {
	private $plugin_file;
	private $plugin_slug = 'estate-launcher-core/estate-launcher-core.php';
	private $github_user = 'boow-media';
	private $github_repo = 'estate-launcher-core';
	private $github_zip_name = 'estate-launcher-core.zip';

	public function __construct($plugin_file) {
		$this->plugin_file = $plugin_file;

		add_filter('pre_set_site_transient_update_plugins', [$this, 'check_for_updates']);
		add_filter('plugins_api', [$this, 'plugin_info'], 10, 3);
		add_action('admin_init', [$this, 'force_check']);
	}

	public function check_for_updates($transient) {
		if (empty($transient->checked)) return $transient;

		$request = wp_remote_get("https://api.github.com/repos/{$this->github_user}/{$this->github_repo}/releases/latest", [
			'headers' => ['User-Agent' => 'WordPress']
		]);

		if (is_wp_error($request)) return $transient;

		$release = json_decode(wp_remote_retrieve_body($request));
		if (empty($release->tag_name)) return $transient;

		$current_version = get_plugin_data($this->plugin_file)['Version'];
		$latest_version = ltrim($release->tag_name, 'v');

		if (version_compare($current_version, $latest_version, '<')) {
			$zip_url = "https://github.com/{$this->github_user}/{$this->github_repo}/releases/download/{$release->tag_name}/{$this->github_zip_name}";

			$transient->response[$this->plugin_slug] = (object) [
				'slug'        => 'estate-launcher-core',
				'new_version' => $latest_version,
				'package'     => $zip_url,
				'url'         => $release->html_url
			];
		}

		return $transient;
	}

	public function plugin_info($false, $action, $args) {
		if ($action !== 'plugin_information' || $args->slug !== 'estate-launcher-core') return $false;

		$request = wp_remote_get("https://api.github.com/repos/{$this->github_user}/{$this->github_repo}/releases/latest", [
			'headers' => ['User-Agent' => 'WordPress']
		]);

		if (is_wp_error($request)) return $false;

		$release = json_decode(wp_remote_retrieve_body($request));
		if (empty($release->tag_name)) return $false;

		return (object) [
			'name'          => 'Estate Launcher Core',
			'slug'          => 'estate-launcher-core',
			'version'       => ltrim($release->tag_name, 'v'),
			'author'        => 'Boow Media',
			'download_link' => "https://github.com/{$this->github_user}/{$this->github_repo}/releases/download/{$release->tag_name}/{$this->github_zip_name}",
			'sections'      => [
				'description' => 'Základní plugin pro správu nemovitostí a recenzí. Obsahuje vlastní post typy, pole a nástroje pro makléřské weby.',
				'changelog'   => "== Verze {$release->tag_name} ==\n\n* Přidání údajů makléře\n* Shortcody\n* Vylepšené UI"
			]
		];
	}

	public function force_check() {
		delete_site_transient('update_plugins');
		wp_update_plugins();
	}
}

// ✅ Spuštění updateru (důležité: hlavní soubor, ne __FILE__ z includes/)
new Estate_Launcher_Updater(plugin_dir_path(__DIR__) . 'estate-launcher-core.php');

// ✅ Reset při aktivaci
register_activation_hook(__FILE__, function () {
	delete_site_transient('update_plugins');
	wp_update_plugins();
});
