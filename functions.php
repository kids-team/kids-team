<?php



function enqueue_scripts() {

	$script = require_once(__DIR__ . "/build/admin.asset.php");

	if (!file_exists(__DIR__ . "/build/admin.asset.php")) {
		return;
	}

	wp_enqueue_script(
		'theme-scripts',
		get_stylesheet_directory_uri() . '/build/theme.js',
		[],
		$script['version'],
		true
	);

	wp_enqueue_style(
		'theme-styles',
		get_stylesheet_directory_uri() . '/build/style-theme.css',
		[],
		$script['version']
	);

}

function enqueue_admin_scripts() {

	$script = require_once(__DIR__ . "/build/admin.asset.php");

	if (!file_exists(__DIR__ . "/build/admin.asset.php")) {
		return;
	}

	wp_enqueue_script(
		'admin-scripts',
		get_stylesheet_directory_uri() . '/build/admin.js',
		$script['dependencies'],
		$script['version'],
		true
	);

	wp_enqueue_style(
		'admin-styles',
		get_stylesheet_directory_uri() . '/build/admin.css',
		[],
		$script['version']
	);

}

function kids_team_mime_types() {

	$new_mimes = [
		'webm' => 'video/webm',
		'svg' => 'image/svg+xml',
		'pdf' => 'application/pdf'
	];

	$mimes = wp_get_mime_types();

	foreach($new_mimes as $key => $value) {
		$mimes[$key] = $value;
	}

	add_filter('mime_types', function() use (&$mimes){
		return $mimes;
	});
}


add_action('init', 'kids_team_mime_types');
add_action('wp_enqueue_scripts', 'enqueue_scripts');
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');

require_once(__DIR__ . "/lib/Color.php");