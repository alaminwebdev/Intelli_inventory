<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'SB Inventory',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => '',
	'font_path' => base_path('resources/fonts/'),
	'font_data' => [
		'examplefont' => [
			'R'  => 'kalpurush.ttf',    // regular font
			'B'  => 'kalpurush.ttf',       // optional: bold font
			'I'  => 'kalpurush.ttf',     // optional: italic font
			'BI' => 'kalpurush.ttf', // optional: bold-italic font
			'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
			'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
		]
		// ...add as many as you want.
	],
	// Set margins (in millimeters)
	'margin_top' => 8,
	'margin_right' => 10,
	'margin_bottom' => 10,
	'margin_left' => 10,
];
