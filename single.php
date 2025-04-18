<?php get_header(); ?>

<?php
$product_name = get_the_title();
$product_image = get_the_post_thumbnail_url() ?: get_template_directory_uri() . '/images/noimage.jpg';
$price = get_field('buy_price');
$model_year = get_field('model-year');
$model_number = get_field('model-number');
$brand = get_field('maker') ?: '不明';
$description = wp_strip_all_tags(get_the_excerpt(), true);

// priceValidUntil：1年後の日付を生成
$priceValidUntil = (new DateTime())->modify('+1 year')->format('Y-m-d');
?>

<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Product",
  "name": "<?php echo esc_js($product_name); ?>",
  "image": "<?php echo esc_url($product_image); ?>",
  "description": "<?php echo esc_js($description); ?>",
  "sku": "<?php echo esc_js($model_number); ?>",
  "brand": {
    "@type": "Brand",
    "name": "<?php echo esc_js($brand); ?>"
  },
  "releaseDate": "<?php echo esc_js($model_year); ?>",
  "itemCondition": "https://schema.org/UsedCondition",
  "offers": {
    "@type": "Offer",
    "priceCurrency": "JPY",
    "price": "<?php echo esc_js($price); ?>",
    "priceValidUntil": "<?php echo $priceValidUntil; ?>",
    "availability": "https://schema.org/InStock",
    "url": "<?php echo esc_url(get_permalink()); ?>"
  }
}
</script>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="result-layout">
  <!-- ▪メインエリア -->
  <div class="result-main">
    <div class="result-detail-wrapper">
      <h1 class="result-title"><?php the_title(); ?></h1>

      <div class="result-top">
        <div class="result-info">
          <div class="result-inner">

            <!-- 左：商品情報 -->
            <div class="result-text">
              <table>
                <tr><th>商品名</th><td><?php the_field('result-name'); ?></td></tr>
                <tr><th>メーカー</th><td><?php the_field('maker'); ?></td></tr>
                <tr><th>型番</th><td><?php the_field('model-number'); ?></td></tr>
                <tr><th>年式</th><td><?php the_field('model-year'); ?></td></tr>
                <tr><th>商品カテゴリ</th><td><?php the_category(', '); ?></td></tr>
                <tr><th>買取地域</th><td>
                  <?php
                  $pref_terms = get_the_terms(get_the_ID(), 'area');
                  $city_terms = get_the_terms(get_the_ID(), 'city');

                  if (!empty($pref_terms) && !is_wp_error($pref_terms) && !empty($city_terms) && !is_wp_error($city_terms)) {
                    $pref = $pref_terms[0];
                    $city = $city_terms[0];
                    echo '<a href="' . esc_url(home_url("/area/" . $pref->slug)) . '">' . esc_html($pref->name) . '</a> ';
                    echo '<a href="' . esc_url(home_url("/area/" . $pref->slug . '/' . $city->slug)) . '">' . esc_html($city->name) . '</a>';
                  } else {
                    echo '未設定';
                  }
                  ?>
                </td></tr>
                <tr><th>商品状態</th><td><?php the_field('condition'); ?></td></tr>
                <tr><th>鉱定日</th><td><?php the_time('Y年n月j日'); ?></td></tr>
                <tr>
                  <th>買取価格</th>
                  <td><span class="price-highlight"><?php the_field('buy_price'); ?> 円</span></td>
                </tr>
              </table>
            </div>

            <!-- 右：画像スライダー -->
            <div class="result-gallery">
              <div class="swiper main-swiper">
                <div class="swiper-wrapper">
                  <?php if (has_post_thumbnail()) : ?>
                    <div class="swiper-slide"><?php the_post_thumbnail('large'); ?></div>
                  <?php endif; ?>
                  <?php
                  $images = ['result-img', 'result-img2', 'result-img3'];
                  foreach ($images as $field) {
                    $img = get_field($field);
                    if ($img) {
                      echo '<div class="swiper-slide"><img src="' . esc_url($img['url']) . '" alt=""></div>';
                    }
                  }
                  ?>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
              </div>

              <div class="swiper thumb-swiper">
                <div class="swiper-wrapper">
                  <?php if (has_post_thumbnail()) : ?>
                    <div class="swiper-slide"><?php the_post_thumbnail('thumbnail'); ?></div>
                  <?php endif; ?>
                  <?php
                  foreach ($images as $field) {
                    $img = get_field($field);
                    if ($img) {
                      echo '<div class="swiper-slide"><img src="' . esc_url($img['url']) . '" alt=""></div>';
                    }
                  }
                  ?>
                </div>
              </div>
            </div>

          </div><!-- .result-inner -->
        </div><!-- .result-info -->
      </div><!-- .result-top -->
    </div><!-- .result-detail-wrapper -->
  </div><!-- .result-main -->
</div><!-- .result-layout -->

<!-- 文本読み込みとサイドバー -->
<div class="result-bottom">
  <div class="result-bottom-inner">
    <div class="result-bottom-content">
      <?php the_content(); ?>
    </div>
    <div class="result-bottom-sidebar">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>

<?php endwhile; endif; ?>

<!-- Swiper連携 -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const thumbSwiper = new Swiper('.thumb-swiper', {
    spaceBetween: 10,
    slidesPerView: 4,
    watchSlidesProgress: true,
  });

  const mainSwiper = new Swiper('.main-swiper', {
    loop: true,
    spaceBetween: 10,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    thumbs: {
      swiper: thumbSwiper,
    },
  });
});
</script>

<?php get_footer(); ?>
