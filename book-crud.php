<?php
/*
Plugin Name: Simple Book CRUD
Description: A simple CRUD plugin for managing books
Version: 1.0
Author: Your Name
*/



// Autoloader function
spl_autoload_register(function ($class) {
    $prefix = 'BookCRUD\\';
    $base_dir = plugin_dir_path(__FILE__) . 'src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use BookCRUD\BookPlugin;
use BookCRUD\Database\DatabaseManager;
use BookCRUD\Controllers\BookController;
use BookCRUD\Views\BookView;
use BookCRUD\Models\BookModel;

// Initialize the plugin
function initialize_book_crud_plugin() {
    $database_manager = new DatabaseManager();
    $book_model = new BookModel($database_manager);
    $book_view = new BookView();
    $book_controller = new BookController($book_model, $book_view);
    $plugin = new BookPlugin($book_controller);
    $plugin->init();
}

add_action('plugins_loaded', 'initialize_book_crud_plugin');

// Activation hook
register_activation_hook(__FILE__, function() {
    $database_manager = new DatabaseManager();
    $database_manager->create_table();
});