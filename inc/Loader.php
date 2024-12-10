<?php
namespace BookManager;

class Loader
{
    public function init()
    {
        // Load all components
        $this->load_dependencies();

        // Initialize classes
        $this->initialize_classes();

        // Hook into WordPress
        add_action('plugins_loaded', [$this, 'on_plugins_loaded']);
    }

    private function load_dependencies()
    {
        // Add any additional dependency loading logic here, if necessary
    }

    private function initialize_classes()
    {
        // Initialize plugin components
        new PostTypes\BookPostType();
        new Taxonomies\TopicTaxonomy();
        new MetaFields\BookMetaFields();
        new Shortcodes\ShortcodeHandler();
        new Assets\AssetsManager();
        new TemplateHandler\TemplateHandler();
    }

    public function on_plugins_loaded()
    {
        // Run any code that depends on other plugins or loaded systems
        load_plugin_textdomain('book-manager', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }
}
