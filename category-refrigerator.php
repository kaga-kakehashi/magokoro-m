<?php get_header(); ?>

<div class="results-title center-text">
  <h1 class="section-title">冷蔵庫の買取実績一覧</h1>
  <p class="result-lead">
    リサイクルショップ カケハシでは、冷蔵庫・洗濯機をはじめとした家電製品の買取実績が多数ございます。<br>
    高年式モデルは高価買取、搬出作業もすべてお任せください。<br>
    こちらのページでは、実際に買取した商品の一部をご紹介しております。
  </p>
</div>

<!-- カテゴリリンク（他のカテゴリへのナビ） -->
<div class="category-button-list center-text">
  <div class="category-buttons">
    <?php
      $categories = get_categories([
        'parent' => get_category_by_slug('results')->term_id,
        'hide_empty' => true,
      ]);
      foreach ($categories as $cat):
        if ($cat->slug !== 'refrigerator'): // 現在のカテゴリを除外
    ?>
      <a href="<?php echo get_category_link($cat->term_id); ?>" class="btn">
        <?php echo esc_html($cat->name); ?>の実績
      </a>
    <?php endif; endforeach; ?>
  </div>
</div>

<hr>

<!-- 最新の買取実績 -->
<h2 class="results-title">最新の買取実績</h2>
<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$args = [
  'category' => 'refrigerator',
  'posts_per_page' => 10,
  'paged' => $paged,
  'pagination' => true 
];

set_query_var('loop_args', $args);
get_template_part('parts/results/result-loop');
?>

<?php get_footer(); ?>
