<?php
/**
 * Plugin Name: Book Manager
 * Description: A plugin to manage books with custom post types, taxonomies, and meta fields.
 * Author: Tarikul Islam
 * Version: 1.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Autoloader function for including classes dynamically
spl_autoload_register(function ($class) {
    $prefix = 'BookManager\\';
    $base_dir = __DIR__ . '/inc/';

    // Only process if the class uses the namespace prefix
    if (strpos($class, $prefix) !== 0) {
        return;
    }

    // Replace the namespace prefix with the base directory and replace namespace separators with directory separators
    $relative_class = str_replace($prefix, '', $class);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // Include the file if it exists
    if (file_exists($file)) {
        require $file;
    }
});

define('BOOK_MANAGER_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('BOOK_MANAGER_PLUGIN_URL', plugin_dir_url(__FILE__));

// Initialize the plugin
if (class_exists('BookManager\\Loader')) {
    $book_manager = new BookManager\Loader();
    $book_manager->init();
}
