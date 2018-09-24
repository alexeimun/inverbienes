<?php
if(!function_exists('config_path')) {
    /**
     * Return the path to config files
     * @param null $path
     * @return string
     */
    function config_path($path = null) {
        return app()->getConfigurationPath(rtrim($path, ".php"));
    }
}
if(!function_exists('public_path')) {
    /**
     * Return the path to public dir
     * @param null $path
     * @return string
     */
    function public_path($path = null) {
        return rtrim(app()->basePath('public/' . $path), '/');
    }
}
if(!function_exists('storage_path')) {
    /**
     * Return the path to storage dir
     * @param null $path
     * @return string
     */
    function storage_path($path = null) {
        return app()->storagePath($path);
    }
}

if(!function_exists('resource_path')) {
    /**
     * Return the path to resource dir
     * @param null $path
     * @return string
     */
    function resource_path($path = null) {
        return app()->resourcePath($path);
    }
}
if(!function_exists('lang_path')) {
    /**
     * Return the path to lang dir
     * @param null $path
     * @return string
     */
    function lang_path($path = null) {
        return resource_path() . DIRECTORY_SEPARATOR . 'lang' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
if(!function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string $path
     * @param  bool $secure
     * @return string
     */
    function asset($path, $secure = null) {
        return app('url')->asset($path, $secure);
    }
}

if(!function_exists('bcrypt')) {
    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array $options
     * @return string
     */
    function bcrypt($value, $options = []) {
        return app('hash')->make($value, $options);
    }
}

