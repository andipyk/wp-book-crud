<?php
namespace BookCRUD\Controllers;

use BookCRUD\Models\BookModel;
use BookCRUD\Views\BookView;

class BookController {
    private $model;
    private $view;

    public function __construct(BookModel $model, BookView $view) {
        $this->model = $model;
        $this->view = $view;
    }

    public function handle_actions() {
        if (isset($_GET['page']) && $_GET['page'] == 'book-crud') {
            if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
                check_admin_referer('delete_book_' . $_GET['id']);
                $this->model->delete_book($_GET['id']);
                wp_safe_redirect(admin_url('admin.php?page=book-crud&message=deleted'));
                exit;
            }
        }

        if (isset($_GET['page']) && $_GET['page'] == 'book-crud-add') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
                check_admin_referer('book_crud_action', 'book_crud_nonce');
                $data = [
                    'title' => sanitize_text_field($_POST['title']),
                    'author' => sanitize_text_field($_POST['author']),
                    'published_date' => sanitize_text_field($_POST['published_date']),
                ];
                
                $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
                
                if ($id) {
                    $this->model->update_book($id, $data);
                    $message = 'updated';
                } else {
                    $this->model->add_book($data);
                    $message = 'added';
                }
                
                wp_safe_redirect(admin_url('admin.php?page=book-crud&message=' . $message));
                exit;
            }
        }
    }

    public function list_books() {
        $books = $this->model->get_books();
        $message = '';
        if (isset($_GET['message'])) {
            switch ($_GET['message']) {
                case 'deleted':
                    $message = 'Book deleted successfully.';
                    break;
                case 'added':
                    $message = 'Book added successfully.';
                    break;
                case 'updated':
                    $message = 'Book updated successfully.';
                    break;
            }
        }
        $this->view->render_list_page($books, $message);
    }

    public function add_edit_book() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $book = $id ? $this->model->get_book($id) : null;
        $this->view->render_add_edit_page($book);
    }
}