<?php
namespace BookCRUD\Database;

class DatabaseManager {
    private $wpdb;
    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $this->wpdb->prefix . 'books';
    }

    public function create_table() {
        $charset_collate = $this->wpdb->get_charset_collate();
        $sql = "CREATE TABLE {$this->table_name} (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            author varchar(255) NOT NULL,
            published_date date,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public function get_books() {
        return $this->wpdb->get_results("SELECT * FROM {$this->table_name}");
    }

    public function get_book($id) {
        return $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM {$this->table_name} WHERE id = %d", $id));
    }

    public function add_book($data) {
        return $this->wpdb->insert($this->table_name, $data);
    }

    public function update_book($id, $data) {
        return $this->wpdb->update($this->table_name, $data, ['id' => $id]);
    }

    public function delete_book($id) {
        return $this->wpdb->delete($this->table_name, ['id' => $id]);
    }
}