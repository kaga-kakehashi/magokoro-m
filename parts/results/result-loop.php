<?php
$args = get_query_var('loop_args');

// カテゴリスラッグからID取得（指定があるときだけ）
if (!empty($args['category'])) {
  $category = get_category_by_slug($args['category']);
  if ($category) {
    $args['cat'] = $category->term_id;
  }
}

// WP_Query用の引数
$query_args = [
  'post_type'      => 'post',
  'posts_per_page' => $args['posts_per_page'] ?? 10,
  'post_status'    => 'publish',
  'orderby'        => 'date',
  'order'          => 'DESC',
  'paged'          => $args['paged'] ?? 1,
];

// カテゴリが指定されていれば追加
if (!empty($args['cat'])) {
  $query_args['cat'] = $args['cat'];
}

// タクソノミー：市区町村
if (!empty($args['city'])) {
  $query_args['tax_query'][] = [
    'taxonomy' => 'city',
    'field'    => 'slug',
    'terms'    => $args['city'],
    'include_children' => false,
  ];
}

// タクソノミー：都道府県
if (!empty($args['area'])) {
  $query_args['tax_query'][] = [
    'taxonomy' => 'area',
    'field'    => 'slug',
    'terms'    => $args['area'],
  ];
}

$loop = new WP_Query($query_args);
?>

<div class="result-grid">
  <?php if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post(); ?>

  <?php
    $area_term = get_the_terms(get_the_ID(), 'area')[0] ?? null;
    $city_term = get_the_terms(get_the_ID(), 'city')[0] ?? null;
    $categories = get_the_category();
    $area_name = $area_term->name ?? '';
    $area_slug = $area_term->slug ?? '';
    $city_name = $city_term->name ?? '';
    $city_slug = $city_term->slug ?? '';
    $category_name = $categories[0]->name ?? '';
    $category_link = get_category_link($categories[0]->term_id ?? '');
    $post_url = get_permalink();
  ?>

  <div class="result-card item-horizontal-card" itemscope itemtype="https://schema.org/Product" onclick="location.href='<?php echo esc_url($post_url); ?>'" style="cursor: pointer;">
    <div class="result-thumb">
      <?php if (has_post_thumbnail()) : the_post_thumbnail('medium', ['itemprop' => 'image']);
      else : ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/noimage.jpg" alt="No Image" itemprop="image">
      <?php endif; ?>
    </div>

    <div class="item-related-infoh highlight-box">
      <!-- タグリンク -->
      <?php if ($category_name && $category_link): ?>
        <a href="<?php echo esc_url($category_link); ?>" class="result-tag-link" onclick="event.stopPropagation();" style="text-decoration: none;">#<?php echo esc_html($category_name); ?></a>
      <?php endif; ?>

      <p class="result-date">
        <time datetime="<?php the_time('c'); ?>" itemprop="releaseDate"><?php the_time('Y年m月d日'); ?></time>
      </p>

      <!-- タイトル -->
      <?php
        if ($area_term && $city_term) {
          echo '<div class="result-location">';
          echo '<a class="location-link" href="' . esc_url(home_url('/area/' . $area_slug)) . '" onclick="event.stopPropagation();" style="text-decoration: none;">' . esc_html($area_name) . '</a> ';
          echo '<a class="location-link" href="' . esc_url(home_url('/area/' . $area_slug . '/' . $city_slug)) . '" onclick="event.stopPropagation();" style="text-decoration: none;">' . esc_html($city_name) . '</a>';
          echo '</div>';
        } else {
          echo '<div class="result-location">地域未設定</div>';
        }
      ?>

      <!-- 詳細情報 -->
      <p class="result-meta" itemprop="description">
        商品名：<?php the_field('result-name'); ?><br>
        メーカー：<?php the_field('maker'); ?><br>
        年式：<?php the_field('model-year'); ?><br>
        型番：<?php the_field('model-number'); ?><br>
        買取価格：
        <span itemprop="offers" itemscope itemtype="https://schema.org/Offer">
          <meta itemprop="priceCurrency" content="JPY" />
          <span itemprop="price"><?php the_field('buy_price'); ?></span>円
        </span>
      </p>
    </div>
  </div>

  <?php endwhile; else : ?>
    <p>まだ投稿がありません。</p>
  <?php endif; ?>
</div>

<?php
// ▼ ページネーション
if (!empty($args['pagination']) && $loop->max_num_pages > 1) :
  echo '<div class="pagination">';
  echo paginate_links([
    'total' => $loop->max_num_pages,
    'current' => $args['paged'] ?? 1,
    'mid_size' => 1,
    'prev_text' => '« 前へ',
    'next_text' => '次へ »',
  ]);
  echo '</div>';
endif;

wp_reset_postdata();
?>
