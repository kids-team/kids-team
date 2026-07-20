<?php

namespace Contexis\KidsTeam;

final class Icons {

	public static function init() {
		add_filter( 'init', [__CLASS__, 'registerCollection'], 10, 3 );
	}

	public static function registerCollection(): void {
		if(!function_exists('wp_register_icon_collection') || !function_exists('wp_register_icon')) {
			return;
		}

		wp_register_icon_collection(
			'ctx-icons',
			[
				'label' => __( 'kids-team Icons', 'ctx-kids-team' ),
				'description' => __( 'Sketchy Icons', 'ctx-kids-team' )
			]
		);

		wp_register_icon( 'ctx-icons/cart', array(
			'label'   => 'Cart',
			'file_path' => get_template_directory() . '/assets/icons/add_shopping_cart.svg',
		) );

		wp_register_icon( 'ctx-icons/add', array(
			'label'   => 'Add',
			'file_path' => get_template_directory() . '/assets/icons/add.svg',
		) );
	}
}