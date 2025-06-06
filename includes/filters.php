<?php
// Zákaz přímého přístupu
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ===== Přidání Kč k poli "cena" =====
add_filter('rwmb_cena_value', function ($value) {
	$value = trim(str_replace('Kč', '', $value));
	return $value !== '' ? $value . ' Kč' : '';
});

// ===== Přidání m² k vybraným plochám =====
$plochy = ['plocha_celkova', 'zastavena_plocha', 'plocha_obytná', 'plocha_pozemku', 'plocha_zahrady', 'plocha_terasy', 'plocha_balkonu'];

foreach ($plochy as $id) {
	add_filter("rwmb_{$id}_value", function ($value) {
		$value = trim(str_replace('m²', '', $value));
		return $value !== '' ? $value . ' m²' : '';
	});
}

// ===== Render štítku pro "Stav nabídky" =====
function el_render_stav_badge($stav) {
	if (!$stav) return '<span class="el-badge el-default">&nbsp;</span>';
	$slug = strtolower(sanitize_title($stav));
	return '<span class="el-badge el-' . esc_attr($slug) . '">' . esc_html($stav) . '</span>';
}

// ===== Přepsání sloupců v adminu =====
add_filter('manage_el_nemovitost_posts_columns', function ($columns) {
	unset($columns['stav_nabidky']);
	$date = $columns['date'];
	unset($columns['date']);
	$columns['stav_nabidky'] = 'Stav nabídky';
	$columns['date'] = $date;
	return $columns;
});

// ===== Výpis badge do sloupce =====
add_action('manage_el_nemovitost_posts_custom_column', function ($column, $post_id) {
	if ($column === 'stav_nabidky') {
		$stav = get_post_meta($post_id, 'stav_nabidky', true);
		echo el_render_stav_badge($stav);
	}
}, 10, 2);

// ===== Badge pod názvem nemovitosti =====
add_action('edit_form_after_title', function () {
	global $post;
	if ($post->post_type !== 'el_nemovitost') return;
	$stav = get_post_meta($post->ID, 'stav_nabidky', true);
	echo '<div style="margin: 8px 0;">' . el_render_stav_badge($stav) . '</div>';
});
