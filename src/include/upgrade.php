<?php

defined('ICMS_ROOT_PATH') or exit();

/**
 * Removes files that were dropped from the module, so that leftovers of an
 * older version are not loaded after an upgrade.
 *
 * @return array<int, string>
 */
function iforum_removeObsoleteFiles(): array
{
	$moduleDir = dirname(__DIR__);

	$obsoleteFiles = [
		'blocks/iforum_block_tag.php',
		'class/compat/kernel/index.html',
		'class/compat/kernel/rank.php',
		'class/forumhandler.php',
		'include/plugin.tag.php',
		'polls.php',
		'templates/blocks/iforum_tag_block_cloud.html',
		'templates/blocks/iforum_tag_block_top.html',
		'templates/iforum_poll_results.html',
		'templates/iforum_poll_view.html',
		'view.tag.php',
		'votepolls.php',
	];

	$obsoleteDirectories = [
		'class/compat/kernel',
	];

	$failed = [];

	foreach ($obsoleteFiles as $file) {
		$path = "{$moduleDir}/{$file}";

		if (! is_file($path)) {
			continue;
		}

		if (! @unlink($path)) {
			$failed[] = $file;
		}
	}

	foreach ($obsoleteDirectories as $directory) {
		$path = "{$moduleDir}/{$directory}";

		if (! is_dir($path)) {
			continue;
		}

		if (! @rmdir($path)) {
			$failed[] = $directory;
		}
	}

	return $failed;
}
