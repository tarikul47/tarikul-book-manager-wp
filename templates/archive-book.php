<?php
get_header(); // Include the header
?>

<!-- Search Form -->
<form role="search" method="get" class="book-search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <input type="text" name="s" placeholder="Search books by title..."
        value="<?php echo esc_attr(get_query_var('s')); ?>" />
    <input type="hidden" name="post_type" value="book" /> <!-- Ensure it only searches books -->
    <button type="submit">Search</button>
</form>

<?php
// Modify the query to display search results or all books
if (have_posts()) {
    echo '<div class="topic-cards">';
    while (have_posts()) {
        the_post();

        // Get book image or fallback placeholder
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: 'https://via.placeholder.com/150';

        echo '<a href="' . get_permalink() . '" class="book-card">';
        echo '<div class="book-image">';
        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . '">';
        echo '</div>';
        echo '<div class="book-title">' . esc_html(get_the_title()) . '</div>';
        echo '</a>';
    }
    echo '</div>';
} else {
    echo '<p>No books found.</p>';
}

// Reset post data (useful for custom queries in future)
wp_reset_postdata();
get_footer(); // Include the footer
?>