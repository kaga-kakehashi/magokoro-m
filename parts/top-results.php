<?php
/**
 * Top Page Results Section
 * Template part: top-results.php
 */

$display_categories = [
  'refrigerator' => '冷蔵庫',
  'washing' => '洗濯機・乾燥機',
  'rice-cooker' => '炊飯器',
  'microwave' => 'レンジ',
  'tv' => 'テレビ',
  'smartphone' => 'スマホ',
  'vacuum' => '掃除機',
  'pc' => 'PC',
  'audio' => 'オーディオ',
  'aircon' => 'エアコン',
  'game' => 'ゲーム機',
  'camera' => 'カメラ'
];
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  new Swiper('.topresults-swiper', {
    loop: false,
    slidesPerView: 1.1,
    spaceBetween: 16,
    breakpoints: {
      640: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 24,
      }
    },
    pagination: {
      el: '.topresults-swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.topresults-swiper-next',
      prevEl: '.topresults-swiper-prev',
    },
  });
});
</script>

<section class="topresults-section">
  <div class="topresults-inner">
    <h2>最新の買取実績</h2>
    <div class="swiper topresults-swiper">
      <div class="swiper-wrapper">
        <?php foreach ($display_categories as $slug => $label) :
          $category = get_category_by_slug($slug);
          if (!$category) continue;

          $query = new WP_Query([
            'cat' => $category->term_id,
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
          ]);

          if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();

              $area_term = get_the_terms(get_the_ID(), 'area')[0] ?? null;
              $city_term = get_the_terms(get_the_ID(), 'city')[0] ?? null;
              $area_name = $area_term->name ?? '';
              $area_slug = $area_term->slug ?? '';
              $city_name = $city_term->name ?? '';
              $city_slug = $city_term->slug ?? '';

              $area_link = !empty($area_slug) ? home_url('/area/' . $area_slug) : '';
              $city_link = (!empty($area_slug) && !empty($city_slug)) ? home_url('/area/' . $area_slug . '/' . $city_slug) : '';
        ?>

            <div class="swiper-slide topresults-slide">
              <div class="topresults-card" onclick="location.href='<?php the_permalink(); ?>'">
                <div class="topresults-card-thumb">
                  <?php if (has_post_thumbnail()) {
                    the_post_thumbnail('medium');
                  } else { ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/noimage.jpg" alt="No Image">
                  <?php } ?>
                </div>

                <p class="topresults-card-date"><?php the_time('Y年m月d日'); ?></p>
                <div class="topresults-card-meta">
                  商品名：<?php the_field('result-name'); ?><br>
                  メーカー：<?php the_field('maker'); ?><br>
                  年式：<?php the_field('model-year'); ?><br>
                  型番：<?php the_field('model-number'); ?><br>
                  出張買取地域：
                  <?php if (!empty($area_link)) : ?>
                    <a href="<?php echo esc_url($area_link); ?>"><?php echo esc_html($area_name); ?></a>
                  <?php endif; ?>
                  <?php if (!empty($city_link)) : ?>
                    <a href="<?php echo esc_url($city_link); ?>"> <?php echo esc_html($city_name); ?></a>
                  <?php endif; ?><br>
                  買取価格：<?php the_field('buy_price'); ?>円
                </div>
              </div>
            </div>
        <?php endwhile; endif; wp_reset_postdata(); endforeach; ?>
      </div>
      <div class="topresults-swiper-pagination swiper-pagination"></div>
      <div class="topresults-swiper-prev swiper-button-prev"></div>
      <div class="topresults-swiper-next swiper-button-next"></div>
    </div>

    <div class="topresults-more-link">
      <a href="<?php echo esc_url(home_url('/category/results/')); ?>" class="btn">もっと買取実績を見る</a>
    </div>
  </div>
</section>