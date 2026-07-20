<?php

namespace Contexis\KidsTeam;

final readonly class Theme {

	public static function init(): void {
		add_action('after_setup_theme', [self::class, 'my_theme_setup']);
		add_action( 'plugins_loaded', [self::class, 'kidsteam_load_textdomain'], 10 );
		add_action('init', [self::class, 'kids_team_mime_types']);
	}

	public static function my_theme_setup(): void {
    	add_theme_support('post-thumbnails');
	}

	public static function kidsteam_load_textdomain(): void {
		load_plugin_textdomain('kids-team', false, dirname( plugin_basename( __FILE__ ) ) . '/../languages' ); 
	}

	public static function kids_team_mime_types(): void {

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
}

