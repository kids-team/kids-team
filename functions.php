<?php

$script = require_once(__DIR__ . "/version.php");

add_action('wp_enqueue_scripts', function () use ($script) {
	wp_enqueue_style(
		'child-style',
		get_stylesheet_directory_uri() . '/assets/css/style.css',
		[],
		$script['version']
	);
}, 100);

add_action('admin_enqueue_scripts', function () use ($script) {
	wp_enqueue_style(
		'child-style',
		"https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200",
		[],
		"1.0.0"
	);

	wp_enqueue_style(
		'admin-style',
		get_stylesheet_directory_uri() . '/assets/css/admin.css',
		[],
		$script['version']
	);
}, 99);




/**
 * Since we need dynamic favicons - we include them in the header here
 * 
 * @return void
 */
add_action('wp_head', function () {
	echo '<link rel="apple-touch-icon" type="image/png" sizes="180x180" href="' . get_stylesheet_directory_uri() . '/favicons/favicon_' . get_locale() . '_180.png" />';
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . get_stylesheet_directory_uri() . '/favicons/favicon_' . get_locale() . '_32.png" />';
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . get_stylesheet_directory_uri() . '/favicons/favicon_' . get_locale() . '_16.png" />';
}, 100);

/**
 * Add template for events. Can we move this into HTML?
 *
 * @return void
 */
function add_event_template()
{
	if (!post_type_exists('event')) return;
	$page_type_object = get_post_type_object('event');
	$page_type_object->template = [
		['ctx-blocks/grid-row', [], [
			['ctx-blocks/grid-column', ['widthLarge' => 2], [['core/paragraph', ['placeholder' => 'Event-Beschreibung']],]],
			['ctx-blocks/grid-column', ['widthLarge' => 1], [
				['events-manager/details', []],
			]]
		]],
		['core/separator'],
		['core/group', ['type' => 'flex', 'flexWrap' => 'nowrap'], [['events-manager/booking', ['title' => 'Anmeldung']]]]
	];
}

add_action('init', 'add_event_template', 1000);
