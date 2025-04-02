<?php
$args = [
  'post_type'      => 'post',
  'posts_per_page' => $args['posts_per_page'] ?? 10,
  'post_status'    => 'publish',
  'orderby'        => 'date',
  'order'          => 'DESC',
  'paged'          => $args['paged'] ?? 1,
];

// カテゴリ指定
if (!empty($args['category'])) {
  $args['category_name'] = $args['category'];
}

// タクソノミー：市区町村
if (!empty($args['city'])) {
  $args['tax_query'][] = [
    'taxonomy' => 'city',
    'field'    => 'slug',
    'terms'    => $args['city'],
  ];
}

// タクソノミー：都道府県
if (!empty($args['area'])) {
  $args['tax_query'][] = [
    'taxonomy' => 'area',
    'field'    => 'slug',
    'terms'    => $args['area'],
  ];
}

$loop = new WP_Query($args);
?>

<div class="result-grid">
<?php if ($loop->have_posts()) : ?>
  <?php while ($loop->have_posts()) : $loop->the_post(); ?>
    <div class="result-card item-horizontal-card">
      <a href="<?php the_permalink(); ?>">
        <div class="result-thumb">
          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium'); ?>
          <?php else : ?>
            <img src="<?php echo get_template_directory_uri(); ?>/images/noimage.jpg" alt="No Image">
          <?php endif; ?>
        </div>
        <div class="item-related-infoh highlight-box">
          <p class="result-date"><?php the_time('Y年m月d日'); ?></p>
          <h3 class="result-title"><?php the_title(); ?></h3>
          <p class="result-meta">
            商品名：<?php the_field('result-name'); ?><br>
            メーカー：<?php the_field('maker'); ?><br>
            年式：<?php the_field('model-year'); ?><br>
            型番：<?php the_field('model-number'); ?><br>
            買取価格：<?php the_field('buy_price'); ?>円
          </p>
        </div>
      </a>
    </div>
  <?php endwhile; ?>
<?php else : ?>
  <p>まだ投稿がありません。</p>
<?php endif; ?>
</div>

<?php if (!empty($args['pagination']) && $loop->max_num_pages > 1) : ?>
  <div class="pagination">
    <?php echo paginate_links([
      'total' => $loop->max_num_pages,
      'current' => $args['paged'] ?? 1,
      'mid_size' => 1,
      'prev_text' => '« 前へ',
      'next_text' => '次へ »',
    ]); ?>
  </div>
<?php endif; ?>

<?php wp_reset_postdata(); ?>
