<?php
/**
 * Top Page Results Section
 * Template part: top-results.php
 */

$display_categories = [
  'refrigerator',
  'washing',
  'rice-cooker',
  'microwave',
  'tv',
  'smartphone',
  'vacuum',
  'pc',
  'audio',
  'aircon',
  'game',
  'camera'
];

foreach ($display_categories as $slug) {
  $category = get_category_by_slug($slug);
  if (!$category) continue;

  $post_count = (int) $category->count;

  if ($post_count >= 3) {
    echo '<section class="top-result-category">
            <h2 class="results-title">' . esc_html($category->name) . 'の買取実績</h2>';

    set_query_var('loop_args', [
      'category' => $slug,
      'posts_per_page' => 3,
    ]);
    get_template_part('template-parts/result', 'loop');

    echo '<div class="result-more-link" style="text-align:center; margin-top: 1em;">
            <a href="' . esc_url(get_category_link($category->term_id)) . '" class="btn">' . esc_html($category->name) . 'の買取実績をもっと見る</a>
          </div>
          </section>';
  }
}
?>
