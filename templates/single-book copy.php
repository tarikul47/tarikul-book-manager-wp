<?php
if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Get custom meta values
$pdf_url = get_post_meta(get_the_ID(), '_pdf_url', true);
$ebook_url = get_post_meta(get_the_ID(), '_ebook_url', true); // Assuming ebook URL is stored
$publisher = get_post_meta(get_the_ID(), '_publisher', true);
$author = get_post_meta(get_the_ID(), '_author', true);
?>

<div class="single-book-container bm-section">
    <!-- Book Title -->
    <h1 class="single-book-title"><?php the_title(); ?></h1>

    <!-- Book Cover -->
    <div class="single-book-cover">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('medium'); ?>
        <?php else: ?>
            <div class="placeholder-image">No Image</div>
        <?php endif; ?>
    </div>

    <!-- Book Actions -->
    <div class="single-book-actions">
        <?php if ($pdf_url): ?>
            <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" class="button primary">Read</a>
        <?php endif; ?>
    </div>

    <!-- Book Description -->
    <div class="single-book-description">
        <?php the_content(); ?>
    </div>

    <!-- Book Metadata -->
    <div class="single-book-meta">
        <?php if ($publisher): ?>
            <p><strong>Publisher:</strong> <?php echo esc_html($publisher); ?></p>
        <?php endif; ?>
        <?php if ($author): ?>
            <p><strong>Author:</strong> <?php echo esc_html($author); ?></p>
        <?php endif; ?>
    </div>

    <!-- Download Links -->
    <div class="single-book-downloads">
        <?php if ($ebook_url): ?>
            <a href="<?php echo esc_url($ebook_url); ?>" download class="button">Download Ebook</a>
        <?php endif; ?>
        <?php if ($pdf_url): ?>
            <a href="<?php echo esc_url($pdf_url); ?>" download class="button">Download PDF</a>
        <?php endif; ?>
    </div>
</div>

<?php
get_footer();
?>