<?php
// Zákaz přímého přístupu
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta Boxy pro Nemovitosti
 */
add_filter( 'rwmb_meta_boxes', 'el_meta_nemovitosti' );

function el_meta_nemovitosti( $meta_boxes ) {

	// 1. Základní informace
	$meta_boxes[] = [
		'id'         => 'el_zakladni_info',
		'title'      => 'Základní informace',
		'post_types' => [ 'el_nemovitost' ],
		'context'    => 'normal',
		'priority'   => 'high',
		'fields'     => [
			[ 'name' => 'ID nabídky', 'id' => 'id_nabidky', 'type' => 'text' ],
			[
				'name'    => 'Stav nabídky',
				'id'      => 'stav_nabidky',
				'type'    => 'select',
				'options' => [
					'Aktivní'   => 'Aktivní',
					'Rezervace' => 'Rezervace',
					'Prodáno'   => 'Prodáno',
				],
			],
			[ 'name' => 'Typ nabídky', 'id' => 'typ_nabidky', 'type' => 'select', 'options' => [
				'Prodej' => 'Prodej',
				'Pronájem' => 'Pronájem',
				'Dražba' => 'Dražba',
				'Aukce' => 'Aukce',
				'Soutěž' => 'Soutěž',
			]],
			[ 'name' => 'Cena', 'id' => 'cena', 'type' => 'text', 'sanitize_callback' => false ],
			[ 'name' => 'Poznámka k ceně', 'id' => 'pozn_cena', 'type' => 'text' ],
			[ 'name' => 'Adresa', 'id' => 'adresa', 'type' => 'text' ],
			[ 'name' => 'Dispozice', 'id' => 'dispozice', 'type' => 'text' ],
			[ 'name' => 'Druh vlastnictví', 'id' => 'vlastnictvi', 'type' => 'select', 'options' => [
				'Osobní' => 'Osobní',
				'Družstevní' => 'Družstevní',
				'Společné jmění manželů' => 'Společné jmění manželů',
				'Podílové' => 'Podílové',
				'Veřejné' => 'Veřejné',
			]],
		],
	];

	// 2. Detailní informace
	$meta_boxes[] = [
		'id'         => 'el_detailni_info',
		'title'      => 'Detailní informace',
		'post_types' => [ 'el_nemovitost' ],
		'fields'     => [
			[ 'name' => 'Celková plocha', 'id' => 'plocha_celkova', 'type' => 'text', 'sanitize_callback' => false ],
			[ 'name' => 'Zastavěná plocha', 'id' => 'zastavena_plocha', 'type' => 'text', 'sanitize_callback' => false ],
			[ 'name' => 'Obytná plocha', 'id' => 'plocha_obytná', 'type' => 'text', 'sanitize_callback' => false ],
			[ 'name' => 'Plocha pozemku', 'id' => 'plocha_pozemku', 'type' => 'text', 'sanitize_callback' => false ],
			[ 'name' => 'Podlaží', 'id' => 'podlazi', 'type' => 'text' ],
			[ 'name' => 'Stav nemovitosti', 'id' => 'stav_nemovitosti', 'type' => 'select', 'options' => [
				'Novostavba' => 'Novostavba',
				'Velmi dobrý' => 'Velmi dobrý',
				'Po rekonstrukci' => 'Po rekonstrukci',
				'Před rekonstrukcí' => 'Před rekonstrukcí',
			]],
			[ 'name' => 'Umístění', 'id' => 'umisteni', 'type' => 'select', 'options' => [
				'Centrum obce' => 'Centrum obce',
				'Klidná část obce' => 'Klidná část obce',
				'Rušná část obce' => 'Rušná část obce',
				'Okraj obce' => 'Okraj obce',
				'Sídliště' => 'Sídliště',
				'Polosamota' => 'Polosamota',
				'Samota' => 'Samota',
			]],
			[ 'name' => 'Konstrukce budovy', 'id' => 'konstrukce', 'type' => 'select', 'options' => [
				'Cihlová' => 'Cihlová',
				'Dřevěná' => 'Dřevěná',
				'Panelová' => 'Panelová',
				'Kamenná' => 'Kamenná',
				'Montovaná' => 'Montovaná',
				'Skeletová' => 'Skeletová',
				'Smíšená' => 'Smíšená',
			]],
			[ 'name' => 'Typ nemovitosti', 'id' => 'typ_nemovitosti', 'type' => 'select', 'options' => [
				'Domy a vily' => 'Domy a vily',
				'Byty' => 'Byty',
				'Chaty a rekreační objekty' => 'Chaty a rekreační objekty',
				'Pozemky' => 'Pozemky',
				'Komerční objekty' => 'Komerční objekty',
				'Malé objekty a garáže' => 'Malé objekty a garáže',
				'Nájemní domy (činžovní domy)' => 'Nájemní domy (činžovní domy)',
				'Historické objekty' => 'Historické objekty',
				'Hotely, penziony a restaurace' => 'Hotely, penziony a restaurace',
				'Komerční prostory' => 'Komerční prostory',
				'Zemědělské objekty' => 'Zemědělské objekty',
			]],
			[ 'name' => 'Energetická třída', 'id' => 'energeticka_trida', 'type' => 'select', 'options' => [
				'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G',
			], 'std' => 'A' ],
		],
	];

	// 3. Média
	$meta_boxes[] = [
		'id'         => 'el_media',
		'title'      => 'Média',
		'post_types' => [ 'el_nemovitost' ],
		'fields'     => [
			[ 'name' => 'Virtuální prohlídka (URL)', 'id' => 'virtualni_prohlidka', 'type' => 'url' ],
			[ 'name' => 'Půdorys', 'id' => 'pudorys', 'type' => 'image_advanced' ],
			[ 'name' => 'Galerie obrázků', 'id' => 'galerie', 'type' => 'image_advanced' ],
			[ 'name' => 'List vlastnictví (obrázek)', 'id' => 'list_vlastnictvi', 'type' => 'image_advanced', 'max_file_uploads' => 1 ],
		],
	];

	// 4. Inženýrské sítě
	$meta_boxes[] = [
		'id'         => 'el_site',
		'title'      => 'Inženýrské sítě',
		'post_types' => [ 'el_nemovitost' ],
		'fields'     => [
			[ 'name' => 'Elektřina', 'id' => 'elektrina', 'type' => 'radio', 'options' => [ 'Ano' => 'Ano', 'Ne' => 'Ne' ] ],
			[ 'name' => 'Veřejný vodovod', 'id' => 'vodovod', 'type' => 'radio', 'options' => [ 'Ano' => 'Ano', 'Ne' => 'Ne' ] ],
			[ 'name' => 'Kanalizace', 'id' => 'kanalizace', 'type' => 'radio', 'options' => [ 'Ano' => 'Ano', 'Ne' => 'Ne' ] ],
			[ 'name' => 'Plyn', 'id' => 'plyn', 'type' => 'radio', 'options' => [ 'Ano' => 'Ano', 'Ne' => 'Ne' ] ],
			[ 'name' => 'Internet', 'id' => 'internet', 'type' => 'radio', 'options' => [ 'Ano' => 'Ano', 'Ne' => 'Ne' ] ],
		],
	];

	return $meta_boxes;
}
