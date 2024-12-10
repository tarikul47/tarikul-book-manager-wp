<?php
namespace BookManager\MetaFields;

class BookMetaFields
{
    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_meta_box']);
        add_action('save_post', [$this, 'save_meta_box']);
    }

    public function add_meta_box()
    {
        add_meta_box('book_details', __('Book Details', 'book-manager'), [$this, 'render_meta_box'], 'book', 'normal', 'high');
    }

    public function render_meta_box($post)
    {
        // Retrieve existing values
        $pdf_url = get_post_meta($post->ID, '_pdf_url', true);
        $publisher = get_post_meta($post->ID, '_publisher', true);
        $author = get_post_meta($post->ID, '_author', true);

        // Render the fields
        echo '<label for="pdf_url">' . __('PDF URL:', 'book-manager') . '</label>';
        echo '<input type="url" name="pdf_url" id="pdf_url" value="' . esc_url($pdf_url) . '" style="width: 100%; margin-bottom: 15px;">';

        echo '<label for="publisher">' . __('Publisher:', 'book-manager') . '</label>';
        echo '<input type="text" name="publisher" id="publisher" value="' . esc_attr($publisher) . '" style="width: 100%; margin-bottom: 15px;">';

        echo '<label for="author">' . __('Author:', 'book-manager') . '</label>';
        echo '<input type="text" name="author" id="author" value="' . esc_attr($author) . '" style="width: 100%;">';
    }

    public function save_meta_box($post_id)
    {
        // Save PDF URL
        if (isset($_POST['pdf_url'])) {
            update_post_meta($post_id, '_pdf_url', sanitize_text_field($_POST['pdf_url']));
        }

        // Save Publisher
        if (isset($_POST['publisher'])) {
            update_post_meta($post_id, '_publisher', sanitize_text_field($_POST['publisher']));
        }

        // Save Author
        if (isset($_POST['author'])) {
            update_post_meta($post_id, '_author', sanitize_text_field($_POST['author']));
        }
    }
}
