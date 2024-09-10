<?php
namespace BookCRUD\Models;

use BookCRUD\Database\DatabaseManager;

class BookModel {
    private $db;

    public function __construct(DatabaseManager $db) {
        $this->db = $db;
    }

    public function get_books() {
        return $this->db->get_books();
    }

    public function get_book($id) {
        return $this->db->get_book($id);
    }

    public function add_book($data) {
        return $this->db->add_book($data);
    }

    public function update_book($id, $data) {
        return $this->db->update_book($id, $data);
    }

    public function delete_book($id) {
        return $this->db->delete_book($id);
    }
}