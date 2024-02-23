<?php
/**
 * Color Management Class
 * 
 * @since 1.6.0
 */

namespace Contexis\Core;

class Color {

    public $post_types = ['post', 'page', 'event'];

    /**
     * Create an instance. This is the static constructor method.
     *
     * @return Contexis\Core\Color
     *
     */
    public static function init() {
        $instance = new self;
		add_action('rest_api_init', array($instance, 'register_meta') );
		add_action('wp_head', [$instance, 'add_color_css']);
		add_action('admin_head', [$instance, 'add_color_css'], 100);
        return $instance;
    }

	/**
	 * Add color settings to the page Head.
	 * 
	 * @return void
	 */
	function add_color_css() {

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

	/**
	 * Register page color as Meta Data
	 * for backwards compatibility, we need to store it as an object
	 *
	 * @return void
	 */
	public function register_meta() {
		
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


	/**
	 * Get page color from metadata or return default
	 *
	 * @return void
	 * @TODO How to handle default color?
	 */
	public function get_page_color() {
        
        global $post;

        if(!$post) {
            return "#fff";
        }

        $color_meta = get_post_meta( $post->ID, 'page_colors', true );
        if(isset($color_meta['primary_color'])) {
            return $color_meta['primary_color'];
        }

		return "var(--wp--preset--color--primary)";
    }

}

Color::init();