<?php

namespace Contexis\KidsTeam;

final class Assets {

	public static function init(): void {
		add_action('wp_enqueue_scripts', [self::class, 'enqueue_scripts']);
		add_action('admin_enqueue_scripts', [self::class, 'enqueue_admin_scripts']);
	}

	public static function enqueue_scripts(): void {

		$script = require_once(__DIR__ . "/../build/admin.asset.php");

		if (!file_exists(__DIR__ . "/../build/admin.asset.php")) {
			return;
		}

		wp_enqueue_script(
			'theme-scripts',
			get_stylesheet_directory_uri() . '/build/theme.js',
			$script['dependencies'],
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

	public static function enqueue_admin_scripts(): void {

		$script = require_once(__DIR__ . "/../build/admin.asset.php");

		if (!file_exists(__DIR__ . "/../build/admin.asset.php")) {
			return;
		}

		wp_enqueue_style('material-symbols-outlined', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200');

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

		wp_set_script_translations( 'admin-scripts', 'kids-team', dirname( plugin_basename( __DIR__ ) ) . '/../languages' );
	}
}