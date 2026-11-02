<?php

/*
 * Builds build/iforum-<version>.zip with the module in an "iforum" folder.
 * Usage: php bin/build-release.php [version]
 * Without a version, it is read from src/icms_version.php.
 */

declare(strict_types=1);

const MODULE_NAME = 'iforum';

function fail(string $message): never
{
    fwrite(STDERR, "{$message}\n");

    exit(1);
}

function readVersionFromModule(string $versionFile): string
{
    $contents = file_get_contents($versionFile);

    if ($contents === false) {
        fail("Could not read {$versionFile}");
    }

    if (! preg_match('/\$modversion\[\'version\'\]\s*=\s*["\']([^"\']*)["\']/', $contents, $matches)) {
        return '';
    }

    return str_replace(' ', '-', strtolower($matches[1]));
}

function removePath(string $path): void
{
    if (is_file($path) || is_link($path)) {
        unlink($path);

        return;
    }

    if (! is_dir($path)) {
        return;
    }

    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($items as $item) {
        $item->isDir() && ! $item->isLink()
            ? rmdir($item->getPathname())
            : unlink($item->getPathname());
    }

    rmdir($path);
}

function copyDirectory(string $source, string $target): void
{
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($items as $item) {
        $destination = $target . DIRECTORY_SEPARATOR . $items->getSubPathname();

        if ($item->isDir()) {
            if (! is_dir($destination)) {
                mkdir($destination, 0777, true);
            }

            continue;
        }

        copy($item->getPathname(), $destination);
    }
}

function createZip(string $packageDir, string $zipFile): void
{
    $zip = new ZipArchive();

    if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        fail("Could not create {$zipFile}");
    }

    $zip->addEmptyDir(MODULE_NAME);

    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($packageDir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($items as $item) {
        $entryName = MODULE_NAME . '/' . str_replace(DIRECTORY_SEPARATOR, '/', $items->getSubPathname());

        $item->isDir()
            ? $zip->addEmptyDir($entryName)
            : $zip->addFile($item->getPathname(), $entryName);
    }

    if (! $zip->close()) {
        fail("Could not write {$zipFile}");
    }
}

if (! extension_loaded('zip')) {
    fail('The PHP zip extension is required to create the package');
}

$rootDir = dirname(__DIR__);
$sourceDir = $rootDir . DIRECTORY_SEPARATOR . 'src';
$buildDir = $rootDir . DIRECTORY_SEPARATOR . 'build';

$version = $argv[1] ?? '';

if ($version === '') {
    $version = readVersionFromModule($sourceDir . DIRECTORY_SEPARATOR . 'icms_version.php');
}

$version = preg_replace('/^v/', '', $version);

if ($version === '') {
    fail('Could not determine the version');
}

$packageDir = $buildDir . DIRECTORY_SEPARATOR . MODULE_NAME;
$zipFile = $buildDir . DIRECTORY_SEPARATOR . MODULE_NAME . "-{$version}.zip";

removePath($packageDir);
removePath($zipFile);

mkdir($packageDir, 0777, true);

copyDirectory($sourceDir, $packageDir);
file_put_contents($packageDir . DIRECTORY_SEPARATOR . 'VERSION', "{$version}\n");

createZip($packageDir, $zipFile);

echo "Created {$zipFile}\n";
