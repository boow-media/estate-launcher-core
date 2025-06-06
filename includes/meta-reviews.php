<?php
// Zákaz přímého přístupu
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Meta Box pro Recenze
 */
add_filter( 'rwmb_meta_boxes', 'el_meta_recenze' );

function el_meta_recenze( $meta_boxes ) {
	$meta_boxes[] = [
		'id'         => 'el_recenzni_box',
		'title'      => 'Detail recenze',
		'post_types' => [ 'el_recenze' ],
		'context'    => 'normal',
		'priority'   => 'core',
		'fields'     => [
			[
				'name' => 'Jméno klienta',
				'id'   => 'jmeno',
				'type' => 'text',
				'desc' => 'Zobrazí se jako autor recenze (např. Jan Novák)',
			],
			[
				'name'        => 'Platforma recenze',
				'id'          => 'platforma',
				'type'        => 'select',
				'placeholder' => 'Vyberte platformu',
				'options'     => [
					'google'   => 'Google',
					'facebook' => 'Facebook',
					'firmy'    => 'Firmy.cz',
				],
				'desc' => 'Vyberte, kde byla recenze původně zveřejněna.',
			],
			[
				'name' => 'Odkaz na originální recenzi',
				'id'   => 'odkaz',
				'type' => 'url',
				'desc' => 'Volitelné – pokud je dostupný veřejný odkaz na originální recenzi.',
			],
		],
	];

	return $meta_boxes;
}
