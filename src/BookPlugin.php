<?php
namespace BookCRUD;

use BookCRUD\Controllers\BookController;

class BookPlugin {
    private $book_controller;

    public function __construct(BookController $book_controller) {
        $this->book_controller = $book_controller;
    }

    public function init() {
        add_action('admin_menu', [$this, 'add_menu_pages']);
        add_action('admin_init', [$this->book_controller, 'handle_actions']);
    }

    public function add_menu_pages() {
        add_menu_page('Book CRUD', 'Book CRUD', 'manage_options', 'book-crud', [$this->book_controller, 'list_books']);
        add_submenu_page('book-crud', 'Add New Book', 'Add New', 'manage_options', 'book-crud-add', [$this->book_controller, 'add_edit_book']);
    }
}