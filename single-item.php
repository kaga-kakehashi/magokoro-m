<?php get_header(); ?>

<main class="item-single">
  <div class="container">
    
    <!-- 商品画像＋説明 -->
    <div class="item-head">
      <?php if (has_post_thumbnail()) : ?>
        <div class="item-image">
          <?php the_post_thumbnail('medium'); ?>
        </div>
      <?php elseif (get_field('icon')) : ?>
        <div class="item-image">
          <img src="<?php echo esc_url(get_field('icon')); ?>" alt="<?php the_title(); ?>">
        </div>
      <?php endif; ?>

      <div class="item-description">
        <?php the_content(); ?>
      </div>
    </div>

    <!-- アイテムごとのコンテンツ読み込み -->
    <?php
    $post_slug = get_post_field('post_name', get_the_ID());
    if ($post_slug === 'kaden') :
        get_template_part('parts/items/item-content', 'kaden');
    elseif ($post_slug === 'refrigerator') :
        get_template_part('parts/items/item-content', 'refrigerator');
    elseif ($post_slug === 'washing') :
        get_template_part('parts/items/item-content', 'washing');
    else :
        echo '<p>条件に一致しませんでした</p>';
    endif;
    ?>

    <hr>

    <!-- 関連買取実績 -->
  <!-- 関連買取実績 -->
<section class="related-records from-item-page">
  <div class="section-header">
    <h2><?php the_title(); ?>の買取実績</h2>
    <p><?php the_title(); ?>に関する買取実績をご紹介します。</p>
  </div>

  <?php
  // 投稿のスラッグ（kaden, refrigeratorなど）をカテゴリ名として使用
  $item_slug = get_post_field('post_name', get_the_ID());

  // ページ番号取得（ページネーション対応）
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;

  // 共通ループテンプレートを呼び出し
  get_template_part('parts/results/result-loop', null, [
    'category' => $item_slug,
    'posts_per_page' => 6,
    'paged' => $paged,
  ]);
  ?>

  <?php
  // ▼ ページネーション（ループと同じ条件で）
  $total = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 6,
    'paged' => $paged,
    'category_name' => $item_slug
  ]);

  if ($total->max_num_pages > 1) :
    echo '<div class="pagination">';
    echo paginate_links([
      'total' => $total->max_num_pages,
      'current' => $paged,
      'mid_size' => 1,
      'prev_text' => '« 前へ',
      'next_text' => '次へ »',
    ]);
    echo '</div>';
  endif;

  wp_reset_postdata();
  ?>
</section>

</div>

  <!-- 他の買取商品リンクなど -->
  <?php get_template_part('parts/items/items'); ?>
</main>

<?php get_footer(); ?>
