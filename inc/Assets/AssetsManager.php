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
        wp_enqueue_script('pdfjs-lib', 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js', [], null, true);
        wp_enqueue_script('pdfjs-worker', 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js', [], null, true);

        // Add an external stylesheet for styling
        wp_enqueue_style('book-manager-topic-style', BOOK_MANAGER_PLUGIN_URL . 'assets/css/topic-style.css');
        //   wp_enqueue_script('book-manager-script', BOOK_MANAGER_PLUGIN_URL . 'assets/js/script.js', ['jquery'], null, true);
        wp_enqueue_style('book-manager-style', BOOK_MANAGER_PLUGIN_URL . 'assets/css/style.css');
    }
}
