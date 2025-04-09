<?php
/**
 * Color Management Class
 * 
 * @since 1.6.0
 */

namespace Contexis\Core;

class Color {

    public $post_types = ['post', 'page', 'event'];

    public static function init() : self {
        $instance = new self;
		add_action('rest_api_init', array($instance, 'register_meta') );
		add_action('admin_head', [$instance, 'add_color_css'], 100);
		add_action('wp_head', [$instance, 'add_color_css'], 100);
        return $instance;
    }

	/**
	 * Add color settings to the page Head.
	 * 
	 * @return void
	 */
	function add_color_css() : void {
		$primary = $this->get_page_color();
		echo "<style>body {";
			echo "--primary:" . $primary . ";";
			echo "--white: #fff;";
			echo "--black: #000;";
			echo "--primary-contrast: #ffffff;";
			echo "--primary-transparent: " . $primary . "aa;";
			echo "--gray-100: #f4f4f4;";
			echo "--gray-200: #eaeaea;";
			echo "--gray-300: #d1d1d1;";
			echo "--gray-400: #b7b7b7;";
			echo "--gray-500: #9d9d9d;";
			echo "--gray-600: #838383;";
			echo "--gray-700: #696969;";
			echo "--gray-800: #4f4f4f;";
			echo "--gray-900: #353535;";
		echo "} </style>";
	}


	public function register_meta() : void {
		
		foreach($this->post_types as $post_type) {
			
			register_meta( $post_type, 'page_colors', [
				'type' => 'object',
				'show_in_rest' => ['schema' => [
					'type'  => 'object',
					'properties' => [
						'primary_color' => ['type' => 'string'],
					]
				]],
				'single'       => true,
				'auth_callback' => function() {
					return current_user_can( 'edit_posts' );
				}
			]);
		}
		
    }

	public function get_page_color() : string {
        
        global $post;

        if(!$post) {
            return "#ffffff";
        }

        $color_meta = get_post_meta( $post->ID, 'page_colors', true );
        if(isset($color_meta['primary_color'])) {
            return $color_meta['primary_color'];
        }

		return "var(--wp--preset--color--primary)";
    }

}

Color::init();