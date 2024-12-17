<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get custom meta values
$pdf_url = get_post_meta(get_the_ID(), '_pdf_url', true);
$publisher = get_post_meta(get_the_ID(), '_publisher', true);
$author = get_post_meta(get_the_ID(), '_author', true);

// Get the current book category (taxonomy: 'book_category')
$terms = get_the_terms(get_the_ID(), 'topic'); // Replace 'book_category' with your taxonomy slug
$category_url = '';

if (!empty($terms) && !is_wp_error($terms)) {
    $category = $terms[0]; // Use the first category
    $category_url = get_term_link($category); // Generate category URL
}
?>
<!-- ---------------------------- -->
<div class="single-book-container bm-section">
    <!-- Book Title -->
    <div class="title">
        <h1 class="single-book-title"><?php the_title(); ?></h1>
        <?php if ($category_url): ?>
            <!-- Set dynamic category URL -->
            <a href="<?php echo esc_url($category_url); ?>" class="nav close ml-auto order-2 w-[54px] h-[54px]" aria-label="close"></a>
        <?php endif; ?>
    </div>
    
    <?php
    // Get the Shortcode Meta Value
    $book_shortcode = get_post_meta(get_the_ID(), '_book_shortcode', true);

    // Display the Shortcode if it exists
    if (!empty($book_shortcode)) {
        echo '<div class="book-shortcode-content">';
        echo do_shortcode($book_shortcode); // Execute the shortcode
        echo '</div>';
    }
    ?>
    
    <!-- Download Links -->
    <div class="single-book-downloads">
        <?php if ($pdf_url): ?>
            <a href="<?php echo esc_url($pdf_url); ?>" download class="button">Download PDF</a>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
?>
