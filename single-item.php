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
  <section class="related-records from-item-page">
  <h2 class="results-title"><?php the_title(); ?>の買取実績</h2>
  <?php
  $item_slug = get_post_field('post_name', get_the_ID());
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;

  $args = [
    'category' => $item_slug,
    'posts_per_page' => 6,
    'paged' => $paged
  ];

  set_query_var('loop_args', $args);
  get_template_part('parts/results/result-loop');
  ?>
</section>
</div>

  <!-- 他の買取商品リンクなど -->
  <?php get_template_part('parts/items/items'); ?>
</main>

<?php get_footer(); ?>
