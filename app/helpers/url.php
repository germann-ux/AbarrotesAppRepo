<?php
// URL helper functions for building paths relative to the app root

if (!defined('BASE_PATH')) {
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
    $scriptDir = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
    if ($scriptDir === '/' || $scriptDir === '.') {
        $scriptDir = '';
    }
    define('BASE_PATH', $scriptDir);
}

if (!function_exists('url_for')) {
    function url_for(string $path = ''): string {
        $normalized = ltrim($path, '/');
        $prefix = BASE_PATH === '' ? '/' : BASE_PATH . '/';
        return $prefix . $normalized;
    }
}

if (!function_exists('redirect_to')) {
    function redirect_to(string $path = ''): void {
        header('Location: ' . url_for($path));
        exit;
    }
}
