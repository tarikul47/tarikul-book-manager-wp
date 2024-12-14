<?php
namespace BookManager\Taxonomies;

class TopicTaxonomy
{
    public function __construct()
    {
        add_action('init', [$this, 'register_taxonomy']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_taxonomy_scripts']);

        add_action('topic_add_form_fields', [$this, 'add_topic_image_field']);
        add_action('topic_edit_form_fields', [$this, 'edit_topic_image_field']);

        add_action('created_topic', [$this, 'save_topic_image']);
        add_action('edited_topic', [$this, 'save_topic_image']);

        add_filter('manage_edit-topic_columns', [$this, 'add_topic_image_column']);
        add_action('manage_topic_custom_column', [$this, 'populate_topic_image_column'], 10, 3);
        add_filter('manage_edit-topic_sortable_columns', [$this, 'sortable_columns']);

        add_action('pre_get_posts', [$this, 'exclude_book_category_from_archive']);


    }

    public function register_taxonomy()
    {
        /**
         * Taxonomy: Topics.
         */

        $labels = [
            "name" => esc_html__("Topics", "oceanwp"),
            "singular_name" => esc_html__("Topic", "oceanwp"),
            "menu_name" => esc_html__("Topics", "oceanwp"),
            "all_items" => esc_html__("All Topics", "oceanwp"),
            "edit_item" => esc_html__("Edit Topic", "oceanwp"),
            "view_item" => esc_html__("View Topic", "oceanwp"),
            "update_item" => esc_html__("Update Topic name", "oceanwp"),
            "add_new_item" => esc_html__("Add new Topic", "oceanwp"),
            "new_item_name" => esc_html__("New Topic name", "oceanwp"),
            "parent_item" => esc_html__("Parent Topic", "oceanwp"),
            "parent_item_colon" => esc_html__("Parent Topic:", "oceanwp"),
            "search_items" => esc_html__("Search Topics", "oceanwp"),
            "popular_items" => esc_html__("Popular Topics", "oceanwp"),
            "separate_items_with_commas" => esc_html__("Separate Topics with commas", "oceanwp"),
            "add_or_remove_items" => esc_html__("Add or remove Topics", "oceanwp"),
            "choose_from_most_used" => esc_html__("Choose from the most used Topics", "oceanwp"),
            "not_found" => esc_html__("No Topics found", "oceanwp"),
            "no_terms" => esc_html__("No Topics", "oceanwp"),
            "items_list_navigation" => esc_html__("Topics list navigation", "oceanwp"),
            "items_list" => esc_html__("Topics list", "oceanwp"),
            "back_to_items" => esc_html__("Back to Topics", "oceanwp"),
            "name_field_description" => esc_html__("The name is how it appears on your site.", "oceanwp"),
            "parent_field_description" => esc_html__("Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "oceanwp"),
            "slug_field_description" => esc_html__("The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.", "oceanwp"),
            "desc_field_description" => esc_html__("The description is not prominent by default; however, some themes may show it.", "oceanwp"),
        ];


        $args = [
            "label" => esc_html__("Topics", "oceanwp"),
            "labels" => $labels,
            "public" => true,
            "publicly_queryable" => true,
            "hierarchical" => true,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => ['slug' => 'topic', 'with_front' => false, 'hierarchical' => true,],
            "show_admin_column" => true,
            "show_in_rest" => true,
            "show_tagcloud" => false,
            "rest_base" => "topic",
            "rest_controller_class" => "WP_REST_Terms_Controller",
            "rest_namespace" => "wp/v2",
            "show_in_quick_edit" => false,
            "sort" => false,
            "show_in_graphql" => false,
        ];

        register_taxonomy("topic", ["book"], $args);

    }

    public function add_topic_image_field($taxonomy)
    {
        ?>
        <div class="form-field">
            <label for="topic_image"><?php _e('Topic Image', 'book-manager'); ?></label>
            <div id="topic-image-wrapper">
                <img src="" style="max-width: 100px; display: none;" id="topic-image-preview" alt="">
            </div>
            <input type="hidden" id="topic_image" name="topic_image" value="">
            <button type="button" class="upload-image-button button"><?php _e('Upload Image', 'book-manager'); ?></button>
            <button type="button" class="remove-image-button button"
                style="display: none;"><?php _e('Remove Image', 'book-manager'); ?></button>
        </div>
        <?php
    }

    public function edit_topic_image_field($term)
    {
        $image_url = get_term_meta($term->term_id, 'topic_image', true);
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="topic_image"><?php _e('Topic Image', 'book-manager'); ?></label>
            </th>
            <td>
                <div id="topic-image-wrapper">
                    <?php if ($image_url): ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="" style="max-width: 150px; display: block;"
                            id="topic-image-preview">
                    <?php else: ?>
                        <img src="" style="max-width: 150px; display: none;" id="topic-image-preview" alt="">
                    <?php endif; ?>
                </div>
                <input type="hidden" id="topic_image" name="topic_image" value="<?php echo esc_url($image_url); ?>">
                <button type="button" class="upload-image-button button"><?php _e('Upload Image', 'book-manager'); ?></button>
                <button type="button" class="remove-image-button button"
                    style="<?php echo $image_url ? '' : 'display: none;'; ?>">
                    <?php _e('Remove Image', 'book-manager'); ?>
                </button>
            </td>
        </tr>
        <?php
    }
    public function save_topic_image($term_id)
    {
        if (isset($_POST['topic_image'])) {
            update_term_meta($term_id, 'topic_image', esc_url_raw($_POST['topic_image']));
        }
    }

    public function add_topic_image_column($columns)
    {
        $columns['topic_image'] = __('Image', 'book-manager');
        return $columns;
    }

    public function populate_topic_image_column($content, $column_name, $term_id)
    {
        if ($column_name === 'topic_image') {
            $image_url = get_term_meta($term_id, 'topic_image', true);
            if ($image_url) {
                $content = '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_term($term_id)->name) . '" style="max-width: 50px; height: auto;">';
            } else {
                $content = __('No image', 'book-manager');
            }
        }
        return $content;
    }

    public function sortable_columns($sortable_columns)
    {
        unset($sortable_columns['topic_image']);
        return $sortable_columns;
    }

    public function enqueue_taxonomy_scripts($hook)
    {
        // Check if we're on a taxonomy admin page
        if ('edit-tags.php' === $hook || 'term.php' === $hook) {
            wp_enqueue_media(); // Load WordPress media uploader
            wp_enqueue_script(
                'taxonomy-topic-script',
                BOOK_MANAGER_PLUGIN_URL . 'assets/js/taxonomy-topic-image-upload.js',
                ['jquery'],
                '1.0.0',
                true
            );
        }
    }

    public function exclude_book_category_from_archive($query)
    {
        if (!is_admin() && $query->is_main_query() && is_post_type_archive('book')) {
            $query->set('tax_query', [
                [
                    'taxonomy' => 'topic', // Replace with your taxonomy name
                    'field' => 'slug',
                    'terms' => 'script', // Replace with the slug of the category you want to exclude
                    'operator' => 'NOT IN', // Exclude the category
                ],
            ]);
        }
    }

}
