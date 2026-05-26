<?php

if (!class_exists('icms')) {
    class icms
    {
        public static $module;

        public static function handler($name)
        {
            return new class {
                public function getByDirname($dirname)
                {
                    return null;
                }
            };
        }
    }
}

if (!function_exists('icms_getmodulehandler')) {
    function icms_getmodulehandler($name, $dirname, $module = '')
    {
        return null;
    }
}
