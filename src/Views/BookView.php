<?php
namespace BookCRUD\Views;

class BookView {
    public function render_list_page($books, $message = '') {
        ?>
        <div class="wrap">
            <h1>Books</h1>
            <?php
            if ($message) {
                echo '<div class="updated"><p>' . esc_html($message) . '</p></div>';
            }
            ?>
            <a href="<?php echo esc_url(admin_url('admin.php?page=book-crud-add')); ?>" class="button button-primary">Add New Book</a>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Published Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?php echo esc_html($book->title); ?></td>
                            <td><?php echo esc_html($book->author); ?></td>
                            <td><?php echo esc_html($book->published_date); ?></td>
                            <td>
                                <a href="<?php echo esc_url(admin_url('admin.php?page=book-crud-add&action=edit&id=' . $book->id)); ?>">Edit</a> |
                                <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=book-crud&action=delete&id=' . $book->id), 'delete_book_' . $book->id); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function render_add_edit_page($book = null) {
        $id = $book ? $book->id : 0;
        ?>
        <div class="wrap">
            <h1><?php echo $id ? 'Edit Book' : 'Add New Book'; ?></h1>
            <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=book-crud-add')); ?>">
                <?php wp_nonce_field('book_crud_action', 'book_crud_nonce'); ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <table class="form-table">
                    <tr>
                        <th><label for="title">Title</label></th>
                        <td><input type="text" name="title" id="title" value="<?php echo esc_attr($book->title ?? ''); ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="author">Author</label></th>
                        <td><input type="text" name="author" id="author" value="<?php echo esc_attr($book->author ?? ''); ?>" required></td>
                    </tr>
                    <tr>
                        <th><label for="published_date">Published Date</label></th>
                        <td><input type="date" name="published_date" id="published_date" value="<?php echo esc_attr($book->published_date ?? ''); ?>" required></td>
                    </tr>
                </table>
                <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Book"></p>
            </form>
        </div>
        <?php
    }
}