<?php get_header(); ?>

<?php
$pref_slug = get_query_var('custom_area');   // 例: saitama
$city_slug = get_query_var('custom_city');   // 例: warabishi

$city = '';
$pref = '';
$area = null;

global $wpdb;

// 都道府県の post_id を取得
$pref_post = $wpdb->get_row(
  $wpdb->prepare(
    "SELECT ID FROM {$wpdb->posts} WHERE post_name = %s AND post_type = 'area' AND post_status = 'publish'",
    $pref_slug
  )
);

if ($pref_post) {
  $area = $wpdb->get_row(
    $wpdb->prepare(
      "SELECT * FROM wp_areas WHERE post_id = %d AND city_name = %s",
      $pref_post->ID,
      $city_slug
    )
  );

  if ($area) {
    $city = $area->city ?? '';
    $pref = get_the_title($pref_post->ID);
  }
}
?>
<?php
$pref_slug = get_query_var('custom_area'); // ex: tokyo
$city_slug = get_query_var('custom_city'); // ex: adachiku

$city_name = '';
$pref_name = '';

if ($city_slug) {
  $city_term = get_term_by('slug', $city_slug, 'city');
  $city_name = $city_term ? $city_term->name : '';
}

if ($pref_slug) {
  $pref_term = get_term_by('slug', $pref_slug, 'area');
  $pref_name = $pref_term ? $pref_term->name : '';
}
?>
<title>出張買取 リサイクルショップ カケハシ | <?php echo esc_html($city_name); ?>で高価買取・無料査定</title>
<meta name="description" content="<?php echo esc_html($city_name); ?>で家電や家具の出張買取ならリサイクルショップ カケハシへ。冷蔵庫・洗濯機・テレビなどを高価買取中！査定無料・即日対応可能。">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "出張買取 リサイクルショップ カケハシ",
  "image": "https://kakehashi-m.com/wp-content/uploads/2025/04/リサイクルショップ-カケハシ.png",
  "url": "<?php echo esc_url(get_permalink()); ?>",
  "telephone": "+81-90-xxxx-xxxx",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "<?php echo esc_html($city_name); ?>",
    "addressRegion": "<?php echo esc_html($pref_name); ?>",
    "addressCountry": "JP"
  },
  "priceRange": "¥",
  "areaServed": "<?php echo esc_html($city_name); ?>",
  "description": "<?php echo esc_html($city_name); ?>で冷蔵庫・洗濯機などを出張買取。即日対応・高価買取のカケハシです。"
}
</script>




<main class="city-box">
  <div class="city-container">
    <h1><?php echo esc_html($city); ?><br>出張買取 リサイクルショップ カケハシ</h1>
    <p>ご不要になったその家電、ぜひカケハシでお売りください！</p>
    <p><?php echo esc_html($pref); ?><?php echo esc_html($city); ?>で引っ越しや買い替えなどにより不要になった家電・家具の処分をお考えの方へ。<br>
    当店では、出張買取サービスを通じて大型家具から生活家電まで幅広く査定・買取を行っております。<br>
    引っ越し前に不用品をまとめて片付けたい方や、なるべく早く買取してほしい方でも安心してご利用いただけます。<br>
    お気軽にお問い合わせください。</p>

    <h2><?php echo esc_html($city); ?>の買取実績</h2>

    <?php
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;

    // ▼ 統合テンプレートで買取実績を表示
    set_query_var('loop_args', [
      'city' => $city_slug,
      'posts_per_page' => 9,
      'paged' => $paged,
    ]);
    get_template_part('parts/results/result-loop');
    ?>
  
    <?php
    // ▼ ページネーション（投稿数に合わせて）
    $total = new WP_Query([
      'post_type' => 'post',
      'posts_per_page' => 9,
      'paged' => $paged,
      'tax_query' => [
        [
          'taxonomy' => 'city',
          'field' => 'slug',
          'terms' => $city_slug,
          'include_children' => false 
        ]
      ]
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
  <?php
$faq_context = 'area';
  get_template_part('/parts/faq');
?>
</main>

<?php get_footer(); ?>
