<?php
namespace BookManager\TemplateHandler;

class TemplateHandler
{

    public function __construct()
    {
        // Hook into WordPress to override templates
        add_filter('template_include', [$this, 'load_template']);
    }

    /**
     * Load the custom template from the plugin directory.
     *
     * @param string $template Path to the current template.
     * @return string Modified template path.
     */
    public function load_template($template)
    {
        if (is_tax('topic')) {
            // Load archive template for topics
            $custom_template = BOOK_MANAGER_PLUGIN_PATH . 'templates/archive-topic.php';
            //  var_dump($custom_template);
            if (file_exists($custom_template)) {
                return $custom_template;
            }
        }

        if (is_singular('book')) {
            // Load single template for books
            $custom_template = BOOK_MANAGER_PLUGIN_PATH . 'templates/single-book.php';
            if (file_exists($custom_template)) {
                return $custom_template;
            }
        }

        if (is_post_type_archive('book')) {
            // Load single template for books
            $custom_template = BOOK_MANAGER_PLUGIN_PATH . 'templates/archive-book.php';
            if (file_exists($custom_template)) {
                return $custom_template;
            }
        }

        // Return default template if no custom template matches
        return $template;
    }
}
