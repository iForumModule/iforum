<?php

/**
 * iForum - shared bootstrap helpers.
 *
 * @package iForum
 */

defined('ICMS_ROOT_PATH') or exit();

if (defined('IFORUM_BOOTSTRAP')) {
    return;
}

define('IFORUM_BOOTSTRAP', 1);

function iforum_get_module_dirname()
{
    static $moduleDirname;

    if (!isset($moduleDirname)) {
        $moduleDirname = basename(dirname(__FILE__, 2));
    }

    return $moduleDirname;
}

function iforum_get_module_path($path = '')
{
    $modulePath = ICMS_ROOT_PATH . '/modules/' . iforum_get_module_dirname();

    if ($path === '') {
        return $modulePath;
    }

    return $modulePath . '/' . ltrim($path, '/');
}

function &iforum_get_module()
{
    static $module;

    if (isset($module)) {
        return $module;
    }

    if (
        isset(icms::$module)
        && is_object(icms::$module)
        && icms::$module->getVar('dirname', 'n') === iforum_get_module_dirname()
    ) {
        $module = icms::$module;

        return $module;
    }

    $moduleHandler = icms::handler('icms_module');
    $module = $moduleHandler->getByDirname(iforum_get_module_dirname());

    return $module;
}

function &iforum_get_handler($handlerName)
{
    $handler = icms_getmodulehandler($handlerName, iforum_get_module_dirname(), 'iforum');

    return $handler;
}

function iforum_load_art_functions_ini()
{
    if (defined('FRAMEWORKS_ART_FUNCTIONS_INI')) {
        return true;
    }

    return include_once iforum_get_module_path('class/art/functions.ini.php') !== false;
}

function iforum_load_art_functions($group = '')
{
    if (!iforum_load_art_functions_ini()) {
        return false;
    }

    if ($group === '') {
        return (bool) include_once iforum_get_module_path('class/art/functions.php');
    }

    if (!function_exists('load_functions')) {
        return false;
    }

    return load_functions($group);
}

function iforum_load_art_object()
{
    if (!iforum_load_art_functions_ini() || !function_exists('load_object')) {
        return false;
    }

    return load_object();
}
