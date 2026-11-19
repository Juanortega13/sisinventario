<?php
/**
 * FERROSTOCK - Entry Point
 */

// Define absolute paths
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH . 'app' . DIRECTORY_SEPARATOR);

// Define Base URL automatically
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$baseUrl = $protocol . "://" . $host . rtrim(dirname($script), '/\\') . '/';
define('BASE_URL', $baseUrl);

// Include routes
require_once ROOT_PATH . "routes" . DIRECTORY_SEPARATOR . "web.php";
