<?php
namespace BookManager\Assets;

class AssetsManager
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets()
    {
      
        wp_enqueue_script('pdfjs', 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js', [], null, true);

        wp_enqueue_script('custom-pdf-reader', BOOK_MANAGER_PLUGIN_URL . 'assets/js/custom-pdf-reader.js', ['jquery', 'pdfjs'], null, true);

        wp_enqueue_style('custom-pdf-reader-style', BOOK_MANAGER_PLUGIN_URL . 'assets/css/custom-pdf-reader.css', [], null);

        // Add an external stylesheet for styling
        wp_enqueue_style('book-manager-topic-style', BOOK_MANAGER_PLUGIN_URL . 'assets/css/topic-style.css');
        //   wp_enqueue_script('book-manager-script', BOOK_MANAGER_PLUGIN_URL . 'assets/js/script.js', ['jquery'], null, true);
        wp_enqueue_style('book-manager-style', BOOK_MANAGER_PLUGIN_URL . 'assets/css/style.css');
    }

}
