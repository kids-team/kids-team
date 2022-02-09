<?php

$script = require_once(__DIR__ . "/version.php");
add_action( 'wp_enqueue_scripts', function() use($script) {
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' , [],
		$script['version']
	);
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
} );


