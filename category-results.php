<?php get_header(); ?>

<main class="results-archive">
  <div class="results-title center-text">
    <h1 class="section-title">家電の買取実績が豊富なリサイクルショップです</h1>
    <p class="result-lead">
    冷蔵庫や洗濯機など大型家電の処分にお困りではありませんか？<br>
    リサイクルショップ カケハシでは、ご自宅まで伺って丁寧に査定・搬出まで対応します。<br>
    高年式モデルの高価買取も多数実績あり！ぜひ一度ご相談ください。
    </p>
     <!-- カテゴリリンク -->
     <?php
      $categories = get_categories([
      'parent' => get_category_by_slug('results')->term_id,
      'hide_empty' => true,
      ]);
    ?>
  </div>
  <div class="category-button-list">
    <div class="category-buttons">
      <?php foreach ($categories as $cat): ?>
        <a href="<?php echo get_category_link($cat->term_id); ?>" class="btn">
          <?php echo esc_html($cat->name); ?>の実績
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <hr>
  <h2 class="results-title">買取実績</h2>
  <?php
  // ▼ ページ番号の取得
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

  // ▼ ループ用引数
    $args = [
      'category' => 'results',
      'posts_per_page' => 10,
      'paged' => $paged
    ];

// ▼ 引数を渡してテンプレ呼び出し
set_query_var('loop_args', $args);
get_template_part('parts/results/result-loop');
?>
  </div>
</main>

<?php get_template_part('parts/faq');?>
<?php get_footer(); ?>
