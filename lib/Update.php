<?php
namespace Contexis\Theme;

class Update {

    private $repo_owner;
    private $repo_name;

	public static function init($repo_owner = null, $repo_name = null) {
		
		if ((defined('WP_DEBUG') && WP_DEBUG) && !defined('PLUGINTOOLS_FORCE_UPDATES')) {
            return; 
        }
		$instance = new self;
		$instance->repo_owner = $repo_owner;
        $instance->repo_name = $repo_name;
		add_filter('pre_set_site_transient_update_themes', [$instance, 'check_for_update']);
		
		return new self($repo_owner, $repo_name);
	}

	private function get_latest_version() : string {
        $cache_key = 'ghup_' . md5($this->repo_owner . '/' . $this->repo_name);
        $cached = get_transient($cache_key);
		
		if (is_admin() && strpos($_SERVER['REQUEST_URI'], 'themes.php')) {
			delete_transient($cache_key);
			$cached = false;
		}
		if ($cached) return $cached;
		
        $response = wp_remote_get("https://github.com/$this->repo_owner/$this->repo_name/releases/latest", [
			'redirection' => 0,
			'timeout'     => 5,
		]);

		if (is_wp_error($response) || !isset($response['headers']['location'])) {
            return wp_get_theme()->get('Version'); 
        }
		$location = $response['headers']['location'];
		if (preg_match('~/tag/(v?\d+\.\d+\.\d+)~', $location, $matches)) {
			$latest_version = ltrim($matches[1], 'v');
		}
        set_transient($cache_key, $latest_version, HOUR_IN_SECONDS);
		
        return $latest_version;
    }


    function check_for_update($data) {
		
		$theme   = get_stylesheet(); 
		$current = wp_get_theme()->get('Version'); 
		
		$version = $this->get_latest_version();
		
		if($version === $current) {
			return $data;
		}

		$data->response[$theme] = array(
			'theme'       => $theme,
			'new_version' => $version,
			'url'         => "https://github.com/{$this->repo_owner}/{$this->repo_name}/",
			'package'     => "https://github.com/{$this->repo_owner}/{$this->repo_name}/releases/download/v{$version}/{$this->repo_name}.zip",
		);

		return $data;
	  }
}

Update::init('kids-team', 'kids-team');