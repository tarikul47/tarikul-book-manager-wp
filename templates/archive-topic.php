<?php
get_header(); // Include the header

?>
<div class="bm-section">
    <?php
    // Check if we're on a taxonomy archive page
    if (is_tax('topic')) {
        $term = get_queried_object(); // Get the current topic object
    
        // Display topic name
        echo '<h1 class="topic-heading">Books under: ' . esc_html($term->name) . '</h1>';

        // Query books under this topic
        $args = [
            'post_type' => 'book',
            'tax_query' => [
                [
                    'taxonomy' => 'topic',
                    'field' => 'slug',
                    'terms' => $term->slug,
                ],
            ],
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            echo '<div class="bm-cards">';
            while ($query->have_posts()) {
                $query->the_post();

                // Get book image or fallback placeholder
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: 'https://via.placeholder.com/150';

                echo '<a href="' . get_permalink() . '" class="bm-card book-card">';
                echo '<div class="book-image">';
                echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . '">';
                echo '</div>';
                echo '<div class="bm-title">' . esc_html(get_the_title()) . '</div>';
                echo '</a>';
            }
            echo '</div>';
        } else {
            echo '<p>No books found for this topic.</p>';
        }

        // Reset post data
        wp_reset_postdata();
    }
    ?>
</div>

<?php
get_footer(); // Include the footer
?>