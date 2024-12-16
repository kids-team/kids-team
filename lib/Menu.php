<?php
/**
 * Rewrite the menu block output to match the theme's menu structure.
 */
function ctx_sub_menu( $block_content, $block, $instance ) {

    if ( 'core/navigation-submenu' === $block['blockName'] ) {
		
        $block_content = "<li  class='ctx-menu__item ctx-menu__item--has-children'>";
		$block_content .= "<span>";
		$block_content .= $block['attrs']['title'] ? "<i class='ctx-menu__item-icon material-icons'>" . $block['attrs']['title'] . "</i>" : "<i class='ctx-menu__item-icon'></i>";
		$block_content .= "<a href='" . $block['attrs']['url'] . "'>" . $block['attrs']['label'] . "</a><button tabindex='0' class='ctx-menu__item-arrow'><i class='material-icons'>keyboard_arrow_down</i></button></span>";
		
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
		
    }

    return $block_content;
}
add_filter( 'render_block', 'ctx_sub_menu', 10, 3 );

function ctx_nav_item( $block_content, $block, $instance ) {

	if ( 'core/navigation-link' === $block['blockName'] ) {
		
		$block_content = "<li class='ctx-menu__item'><span>";
		$block_content .= key_exists('title', $block['attrs']) ? "<i class='ctx-menu__item-icon material-icons'>" . $block['attrs']['title'] . "</i>" : "<i class='ctx-menu__item-icon'></i>";
		$block_content .= "<a href='" . $block['attrs']['url'] . "'>" . $block['attrs']['label'] . "</a>";
		$block_content .= "</span></li>";
	}

	return $block_content;
}
add_filter( 'render_block', 'ctx_nav_item', 10, 3 );

