<?php
if (get_query_var('custom_area') && get_query_var('custom_city')) {
    global $wpdb;
    $area = sanitize_text_field(get_query_var('custom_area'));
    $city = sanitize_text_field(get_query_var('custom_city'));

    $result = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}areas WHERE prefecture = %s AND city = %s",
        $area, $city
    ));

    if ($result && !$result->available) {
        echo '<meta name="robots" content="noindex, nofollow">';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?> | <?php wp_title(); ?></title>
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <?php wp_head(); ?>
</head>
<body>

<header>
  <div class="header-top">
    <div class="header-rogo">
      <a href="<?php echo home_url(); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/リサイクルショップ カケハシ.png" alt="ロゴ" width="200px">
      </a>
    </div>
    <div class="header-util">
      <a>受付時間 10:00～18:00</a>
    </div>
    <div class="header-util">
      <a href="https://page.line.me/685frver">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/LINE.png" alt="LINE" width="150px">
      </a>
    </div>
    <div class="header-util">
      <a href="<?php echo site_url('/contact'); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/メール.png" alt="メール" width="150px">
      </a>
    </div>
    <button class="menu-toggle" aria-label="メニューを開く">
      <span class="menu-icon"></span>
      <span class="menu-label">menu</span>
    </button>
  </div>

  <div class="nav-top">
    <nav>
      <div class="nav-container">
        <ul id="top-menu">
          <li><a href="<?php echo home_url(); ?>">ホーム</a></li>
          <li><a href="<?php echo site_url('/item'); ?>">買取商品</a></li>
          <li><a href="<?php echo site_url('/category/results/'); ?>">買取実績</a></li>
          <li><a href="<?php echo site_url('/area'); ?>">出張買取対応エリア</a></li>
          <li><a href="<?php echo site_url('/faq'); ?>">よくある質問</a></li>
          <li><a href="<?php echo site_url('/contact'); ?>">お問い合わせ</a></li>
        </ul>
      </div>
    </nav>
  </div>

  <div class="nav-drawer" id="navDrawer">
    <button class="close-btn" id="closeDrawer" aria-label="閉じる">×</button>
    <nav>
      <ul>
        <li><a href="<?php echo home_url(); ?>">ホーム</a></li>
        <li><a href="<?php echo home_url('/item'); ?>">買取商品</a></li>
        <li><a href="<?php echo home_url('/category/results/'); ?>">買取実績</a></li>
        <li><a href="<?php echo site_url('/area'); ?>">出張買取対応エリア</a></li>
        <li><a href="<?php echo home_url('/faq'); ?>">よくある質問</a></li>
        <li><a href="<?php echo site_url('/contact'); ?>">お問い合わせ</a></li>
      </ul>
    </nav>
  </div>

  <?php if (function_exists('bcn_display')): ?>
    <nav class="breadcrumb">
      <?php bcn_display(); ?>
    </nav>
  <?php endif; ?>
</header>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.querySelector('.menu-toggle');
    const drawer = document.getElementById('navDrawer');
    const closeBtn = document.getElementById('closeDrawer');

    if (toggle && drawer && closeBtn) {
      toggle.addEventListener('click', function () {
        drawer.classList.add('active');
        document.body.classList.add('drawer-open');
      });

      closeBtn.addEventListener('click', function () {
        drawer.classList.remove('active');
        document.body.classList.remove('drawer-open');
      });
    } else {
      console.log('⚠️ 要素が見つからなかったよ');
    }
  });
</script>


</body>
</html>
