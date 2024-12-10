<?php
namespace BookManager\Shortcodes;

class ShortcodeHandler
{
    public function __construct()
    {
        add_shortcode('book_topics', [$this, 'render_topics']);
        add_shortcode('pdf_viewer', [$this, 'render_pdf_viewer']);

    }

    public function render_topics()
    {
        $topics = get_terms(['taxonomy' => 'topic', 'hide_empty' => false]);

        if (!$topics) {
            return '<p>' . __('No topics found.', 'book-manager') . '</p>';
        }

        $output = '<div class="bm-cards">';
        foreach ($topics as $topic) {
            $url = get_term_link($topic);
            $image_url = get_term_meta($topic->term_id, 'topic_image', true);

            // Wrap the entire card with a link
            $output .= "<a href='" . esc_url($url) . "' class='bm-card topic-card'>";

            // Add the image if it exists
            if ($image_url) {
                $output .= "<div class='topic-image'>
                            <img src='" . esc_url($image_url) . "' alt='" . esc_attr($topic->name) . "'>
                        </div>";
            } else {
                // Placeholder if no image is set
                $output .= "<div class='topic-image placeholder'>
                            <div class='placeholder-circle'>?</div>
                        </div>";
            }

            // Add the topic name
            $output .= "<div class='bm-title'>
                        " . esc_html($topic->name) . "
                    </div>";

            $output .= "</a>"; // End of topic card
        }
        $output .= '</div>'; // End of container

        return $output;
    }

    function render_pdf_viewer($atts)
    {
        // Parse shortcode attributes
        $atts = shortcode_atts(
            ['pdf_url' => '', 'title' => ''],
            $atts,
            'pdf_viewer'
        );

        if (empty($atts['pdf_url'])) {
            return '<p>No PDF URL provided.</p>';
        }

        ob_start();
        ?>
        <div id="pdf-viewer-container" style="border: 1px solid #ccc; height: 600px; width: 100%; position: relative;">
            <div id="pdf-controls">
                <button id="prev-page">Previous</button>
                <span>Page: <span id="current-page">1</span> / <span id="total-pages">0</span></span>
                <button id="next-page">Next</button>
            </div>
            <canvas id="pdf-canvas" style="border: 1px solid black; width: 100%; height: auto;"></canvas>
        </div>
        <div id="download-options">
            <a href="<?php echo esc_url($atts['pdf_url']); ?>" download><?php _e('Download PDF', 'book-manager'); ?></a>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const url = '<?php echo esc_url($atts['pdf_url']); ?>';

                const pdfjsLib = window['pdfjs-dist/build/pdf'];
                pdfjsLib.GlobalWorkerOptions.workerSrc = '<?php echo plugin_dir_url(__FILE__) . "assets/pdfjs/pdf.worker.min.js"; ?>';

                let pdfDoc = null;
                let pageNum = 1;
                let pageRendering = false;
                let pageNumPending = null;
                const scale = 1.5;
                const canvas = document.getElementById('pdf-canvas');
                const ctx = canvas.getContext('2d');

                function renderPage(num) {
                    pageRendering = true;
                    pdfDoc.getPage(num).then(function (page) {
                        const viewport = page.getViewport({ scale: scale });
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        const renderContext = {
                            canvasContext: ctx,
                            viewport: viewport
                        };
                        const renderTask = page.render(renderContext);

                        renderTask.promise.then(function () {
                            pageRendering = false;
                            if (pageNumPending !== null) {
                                renderPage(pageNumPending);
                                pageNumPending = null;
                            }
                        });
                    });

                    document.getElementById('current-page').textContent = num;
                }

                function queueRenderPage(num) {
                    if (pageRendering) {
                        pageNumPending = num;
                    } else {
                        renderPage(num);
                    }
                }

                function onPrevPage() {
                    if (pageNum <= 1) {
                        return;
                    }
                    pageNum--;
                    queueRenderPage(pageNum);
                }

                function onNextPage() {
                    if (pageNum >= pdfDoc.numPages) {
                        return;
                    }
                    pageNum++;
                    queueRenderPage(pageNum);
                }

                pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
                    pdfDoc = pdfDoc_;
                    document.getElementById('total-pages').textContent = pdfDoc.numPages;

                    renderPage(pageNum);
                });

                document.getElementById('prev-page').addEventListener('click', onPrevPage);
                document.getElementById('next-page').addEventListener('click', onNextPage);
            });
        </script>
        <?php
        return ob_get_clean();
    }
}
