<?php

namespace Contexis\Theme;

class Check {

	public static function init() {
		if (defined('SKIP_INTEGRITY_CHECK')) {
			return;
		}
	
		add_action('admin_init', [self::class, 'integrity']);
	}

	public static function integrity() {	
	
		$integrity_file = get_template_directory() . '/checksum.txt';
	
		if (!file_exists($integrity_file)) {
			
			if (is_admin() && current_user_can('manage_options')) {
				add_action('admin_notices', [self::class, 'missing_notice']);
			}
			return;
		}
	
		$expected = trim(file_get_contents($integrity_file));
		$actual = hash_file('sha256', __FILE__);
	
		if ($expected !== $actual) {
			error_log("❌ Integrity Check Failed: Expected $expected, got $actual");
			wp_die('<h1>Integrity check failed<h1><p>The integrity of the theme has been compromised. Please contact support.</p>', 'Integrity Check Failed', ['response' => 403]);
		}
	}

	public static function missing_notice() {
		echo '<div class="notice notice-warning"><p><strong>' . 
			__('Warning:', 'kids-team') . 
			'</strong> ' . 
			__('The checksum file <code>checksum.txt</code> is missing in the theme directory. Please contact support.', 'kids-team') . 
			'</p></div>';
	}
}