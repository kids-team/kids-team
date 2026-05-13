<?php
/**
 * Rewrite the menu block output to match the theme's menu structure.
 */

namespace Contexis\Theme;

final class Menu {

	public static function init() {
		add_filter( 'render_block', [__CLASS__, 'renderMenu'], 10, 3 );
	}

	public static function renderMenu( $block_content, $block, $instance ) {

		switch ( $block['blockName'] ) {
			case 'core/navigation':
				$block_content = self::renderNavigation( $block_content, $block, $instance );
				break;
			case 'core/navigation-link':
				$block_content = self::renderNavItem( $block_content, $block, $instance );
				break;
			case 'core/navigation-submenu':
				$block_content = self::renderSubMenu( $block_content, $block, $instance );
				break;
		}

		return $block_content;
	}

	public static function renderSubMenu( $block_content, $block, $instance ) {
		
		$block_content = "<li  class='ctx-menu__item ctx-menu__item--has-children'>";
		$block_content .= "<span>";
		$block_content .= key_exists('title', $block['attrs']) ? "<i class='ctx-menu__item-icon material-icons'>" . $block['attrs']['title'] . "</i>" : "<i class='ctx-menu__item-icon'></i>";
      $block_content .= "<a href='" . $block['attrs']['url'] . "'>" . $block['attrs']['label'] . "</a>";
      $block_content .= '<button tabindex="0" class="ctx-menu__item-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M19.29,5.14a.16.16,0,0,0-.12,0l-4.31,0-1.39,0c-2,0-5.43-.1-8.45,0H5c-1.24.06-4.15,0-4.18,0a.54.54,0,0,0-.46.28.49.49,0,0,0,0,.53s3,3.89,4,5.45c1.23,1.91,5,6.45,5.19,6.64a.46.46,0,0,0,.38.18h0a.52.52,0,0,0,.38-.17c.11-.13,2.79-3.2,3.36-4,1.59-2.32,5.38-7.53,5.77-8a.55.55,0,0,0,.16-.31A.49.49,0,0,0,19.29,5.14Z"/></svg></button></span>';
		
		if ( ! empty( $block['innerBlocks'] ) ) {
			$block_content .= "<ul class='ctx-menu__submenu'>";
			foreach ( $block['innerBlocks'] as $inner_block ) {
				
				$block_content .= "<li class='ctx-menu__submenu-item'>";
				$block_content .= "<a tabindex='0' href='" . $inner_block['attrs']['url'] . "'>" . $inner_block['attrs']['label'] . "</a>";
				$block_content .= "</li>";
			}
			$block_content .= "</ul>";
		}

		$block_content .= "</li>";

		return $block_content;
	}
	
	public static function renderNavItem( $block_content, $block, $instance ) {
			
		$block_content = "<li class='ctx-menu__item'><span>";
		$block_content .= key_exists('title', $block['attrs']) ? "<i class='ctx-menu__item-icon material-icons'>" . $block['attrs']['title'] . "</i>" : "<i class='ctx-menu__item-icon'></i>";
		$block_content .= "<a href='" . $block['attrs']['url'] . "'>" . $block['attrs']['label'] . "</a>";
		$block_content .= "</span></li>";
	
		return $block_content;
	}
	
	
	public static function renderNavigation( $block_content, $block, $instance ) {
		$pos = strpos($block_content, 'class="');
		if ($pos !== false) {
		    $block_content = substr_replace($block_content, 'class="ctx-menu ', $pos, strlen('class="'));
		}
		return $block_content;
	}
	
}


Menu::init();
