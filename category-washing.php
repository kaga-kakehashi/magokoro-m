<?php get_header(); ?>

<h1>洗濯機の買取実績</h1>
<p>洗濯機に関する買取実績を一覧でご紹介します。</p>

<?php
// ▼ ページ番号の取得
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

// ▼ クエリ設定
$args = [
  'post_type' => 'post',
  'posts_per_page' => 10,
  'category_name' => 'washing', // ← 洗濯機カテゴリのスラッグ
  'paged' => $paged
];

$custom_query = new WP_Query($args);
?>

<div class="result-grid">
<?php
if ($custom_query->have_posts()) :
  while ($custom_query->have_posts()) : $custom_query->the_post();
?>
  <div class="result-card horizontal-card">
    <a href="<?php the_permalink(); ?>">
      <div class="result-thumb">
        <?php if (has_post_thumbnail()) : ?>
          <?php the_post_thumbnail('medium'); ?>
        <?php else : ?>
          <img src="<?php echo get_template_directory_uri(); ?>/images/noimage.jpg" alt="No Image">
        <?php endif; ?>
      </div>
      <div class="result-info">
        <p class="result-date"><?php the_time('Y年m月d日'); ?></p>
        <h3 class="result-title"><?php the_title(); ?></h3>
        <p class="result-meta">
          年式：<?php the_field('model-year'); ?><br>
          型番：<?php the_field('model-number'); ?><br>
          買取価格：<?php the_field('buy_price'); ?>円
        </p>
      </div>
    </a>
  </div>
<?php
  endwhile;
else :
  echo '<p>まだ投稿がありません。</p>';
endif;
?>
</div>


<?php
// ▼ ページ送り（ページネーション）
if ($custom_query->max_num_pages > 1) :
  echo '<div class="pagination">';
  echo paginate_links([
    'total' => $custom_query->max_num_pages,
    'current' => $paged,
    'mid_size' => 1,
    'prev_text' => '« 前へ',
    'next_text' => '次へ »',
  ]);
  echo '</div>';
endif;

wp_reset_postdata();
?>

<?php get_footer(); ?>
