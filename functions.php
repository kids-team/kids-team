<?php

$script = require_once(__DIR__ . "/version.php");
add_action('wp_enqueue_scripts', function () use ($script) {
	wp_enqueue_style(
		'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[],
		$script['version']
	);
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
});

add_action('admin_enqueue_scripts', function () use ($script) {
	wp_enqueue_style(
		'child-style',
		get_stylesheet_directory_uri() . '/admin.css',
		[],
		$script['version']
	);
}, 99);

function wps_deregister_styles()
{
	wp_dequeue_style('global-styles');
}
add_action('wp_enqueue_scripts', 'wps_deregister_styles', 100);

add_action('wp_head', function () {
	echo '<link rel="apple-touch-icon" type="image/png" sizes="180x180" href="' . get_stylesheet_directory_uri() . '/favicons/favicon_' . get_locale() . '_180.png" />';
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . get_stylesheet_directory_uri() . '/favicons/favicon_' . get_locale() . '_32.png" />';
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . get_stylesheet_directory_uri() . '/favicons/favicon_' . get_locale() . '_16.png" />';
});


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
		['ctx-blocks/button-group', [], [['events-manager/booking', ['title' => 'Anmeldung']]]]
	];
}

add_action('init', 'add_event_template', 1000);

function slug_page_template() {
	$page_type_object = get_post_type_object( 'page' );
	$page_type_object->template = [
		[ 'ctx-blocks/base' ],
	];
	//$page_type_object->template_lock = ['removal', 'insert'];
}
add_action( 'init', 'slug_page_template', 1000 );

function prefix_default_page_template( $settings ) {
	$settings['defaultBlockTemplate'] = "";
	return $settings;
}
add_filter( 'block_editor_settings_all', 'prefix_default_page_template' );