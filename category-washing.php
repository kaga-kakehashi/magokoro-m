<?php get_header(); ?>

<div class="results-title center-text">
  <h1 class="section-title">洗濯機・乾燥機の買取実績一覧</h1>
  <p class="result-lead">
    洗濯機・乾燥機の処分や買い替えをご検討中の方へ。<br>
    リサイクルショップ カケハシでは、洗濯機・乾燥機の高価買取を多数行っております。<br>
    年式の新しいモデルはもちろん、搬出作業もすべてお任せください。<br>
    こちらでは、これまでに買取した実績の一部をご紹介しています。
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
        if ($cat->slug !== 'washing'): // 現在のカテゴリを除外
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
  'category' => 'washing',
  'posts_per_page' => 10,
  'paged' => $paged,
  'pagination' => true 
];

set_query_var('loop_args', $args);
get_template_part('parts/results/result-loop');
?>

<?php get_footer(); ?>
