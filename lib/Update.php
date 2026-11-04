<?php

declare(strict_types=1);

namespace Contexis\KidsTeam;

use Contexis\WpGitHubUpdater\GitHubReleaseProvider;
use Contexis\WpGitHubUpdater\GitHubRepository;

final class Update
{
	private function __construct(
		private readonly GitHubRepository $repository,
		private readonly GitHubReleaseProvider $releaseProvider,
	) {
	}

	public static function init(string $owner, string $repositoryName): self
	{
		$repository = GitHubRepository::from($owner, $repositoryName);
		$theme = wp_get_theme();
		$instance = new self(
			$repository,
			new GitHubReleaseProvider($repository, $theme->get('Version')),
		);

		if ((defined('WP_DEBUG') && WP_DEBUG) && !defined('PLUGINTOOLS_FORCE_UPDATES')) {
			return $instance;
		}

		add_filter('site_transient_update_themes', [$instance, 'checkForUpdate']);
		add_filter('pre_set_site_transient_update_themes', [$instance, 'checkForUpdate']);
		add_action('load-themes.php', [$instance, 'refreshUpdatesOnThemesPage']);

		return $instance;
	}

	public function refreshUpdatesOnThemesPage(): void
	{
		if (!current_user_can('update_themes')) {
			return;
		}

		$this->releaseProvider->refreshLatestRelease();
		delete_site_transient('update_themes');
		wp_update_themes();
	}

	public function checkForUpdate(mixed $transient): mixed
	{
		if (!is_object($transient) || !isset($transient->checked) || !is_array($transient->checked)) {
			return $transient;
		}

		$stylesheet = get_stylesheet();
		if (!array_key_exists($stylesheet, $transient->checked)) {
			return $transient;
		}

		$release = $this->releaseProvider->getLatestRelease();
		$currentVersion = (string) $transient->checked[$stylesheet];
		$transient->response ??= [];

		if (!version_compare($release->version, $currentVersion, '>')) {
			unset($transient->response[$stylesheet]);
			return $transient;
		}

		$transient->response[$stylesheet] = [
			'theme' => $stylesheet,
			'new_version' => $release->version,
			'url' => $this->repository->releasesUrl(),
			'package' => $this->repository->downloadPackageUrl($release->tag, $this->repository->name),
		];

		return $transient;
	}
}
