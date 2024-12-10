<?php
namespace BookManager\PostTypes;

class BookPostType
{
    public function __construct()
    {
        add_action('init', [$this, 'register_post_type']);
    }

    public function register_post_type()
    {
        /**
         * Post Type: Books.
         */
        $labels = [
            "name" => esc_html__("Books", "oceanwp"),
            "singular_name" => esc_html__("Book", "oceanwp"),
            "menu_name" => esc_html__("My Books", "oceanwp"),
            "all_items" => esc_html__("All Books", "oceanwp"),
            "add_new" => esc_html__("Add new", "oceanwp"),
            "add_new_item" => esc_html__("Add new Book", "oceanwp"),
            "edit_item" => esc_html__("Edit Book", "oceanwp"),
            "new_item" => esc_html__("New Book", "oceanwp"),
            "view_item" => esc_html__("View Book", "oceanwp"),
            "view_items" => esc_html__("View Books", "oceanwp"),
            "search_items" => esc_html__("Search Books", "oceanwp"),
            "not_found" => esc_html__("No Books found", "oceanwp"),
            "not_found_in_trash" => esc_html__("No Books found in trash", "oceanwp"),
            "parent" => esc_html__("Parent Book:", "oceanwp"),
            "featured_image" => esc_html__("Featured image for this Book", "oceanwp"),
            "set_featured_image" => esc_html__("Set featured image for this Book", "oceanwp"),
            "remove_featured_image" => esc_html__("Remove featured image for this Book", "oceanwp"),
            "use_featured_image" => esc_html__("Use as featured image for this Book", "oceanwp"),
            "archives" => esc_html__("Book archives", "oceanwp"),
            "insert_into_item" => esc_html__("Insert into Book", "oceanwp"),
            "uploaded_to_this_item" => esc_html__("Upload to this Book", "oceanwp"),
            "filter_items_list" => esc_html__("Filter Books list", "oceanwp"),
            "items_list_navigation" => esc_html__("Books list navigation", "oceanwp"),
            "items_list" => esc_html__("Books list", "oceanwp"),
            "attributes" => esc_html__("Books attributes", "oceanwp"),
            "name_admin_bar" => esc_html__("Book", "oceanwp"),
            "item_published" => esc_html__("Book published", "oceanwp"),
            "item_published_privately" => esc_html__("Book published privately.", "oceanwp"),
            "item_reverted_to_draft" => esc_html__("Book reverted to draft.", "oceanwp"),
            "item_trashed" => esc_html__("Book trashed.", "oceanwp"),
            "item_scheduled" => esc_html__("Book scheduled", "oceanwp"),
            "item_updated" => esc_html__("Book updated.", "oceanwp"),
            "parent_item_colon" => esc_html__("Parent Book:", "oceanwp"),
        ];

        $args = [
            "label" => esc_html__("Books", "oceanwp"),
            "labels" => $labels,
            "description" => "Book Showcase ",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "rest_namespace" => "wp/v2",
            "has_archive" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "can_export" => false,
            "rewrite" => ["slug" => "books", "with_front" => false],
            "query_var" => true,
            "menu_position" => 5,
            "supports" => ["title", "editor", "thumbnail"],
            "show_in_graphql" => false,
        ];

        register_post_type("book", $args);
    }
}