<?php get_header(); ?>

<main class="results-archive">
  <div class="container">
    <h1>買取実績一覧</h1>

    <!-- カテゴリリンク -->
    <div class="category-buttons">
      <a href="<?php echo get_category_link(get_cat_ID('冷蔵庫')); ?>" class="btn">冷蔵庫の実績</a>
      <a href="<?php echo get_category_link(get_cat_ID('洗濯機')); ?>" class="btn">洗濯機の実績</a>
    </div>

    <hr>

    <?php
    // 現在のページ番号（ページネーション用）
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    // 実績ループテンプレートを呼び出し
    get_template_part('parts/results/result-loop', null, [
      'category' => 'results',       // ←ここは必要に応じて使う（使わないならOK）
      'posts_per_page' => 9,
      'paged' => $paged
    ]);

    // ▼ ページネーション表示
    $total = new WP_Query([
      'post_type' => 'post',
      'posts_per_page' => 9,
      'paged' => $paged,
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
  </div>
</main>

<?php get_footer(); ?>
