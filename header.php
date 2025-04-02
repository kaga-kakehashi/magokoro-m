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
        <?php wp_head(); ?>
        <!-- Swiper CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    </head>
<body>
    <!-- ヘッダー -->
    <header>
        <div class="header-top">
            <div class="header-rogo">
                <a href="<?php echo home_url(); ?>"><img src="\wordpress\wp-content\uploads\2025\03\リサイクルショップ カケハシ.png" width="200px"></a>
            </div>
            <div class="header-util">
                <a>受付時間 10:00～18:00</a>
            </div>
            <div class="header-util">
                <a href="https://page.line.me/685frver"><img src="\wordpress\wp-content\uploads\2025\03\段落テキスト.png" width="150px"  ></a>
            </div>
            <div class="header-util">
            <a href="<?php echo site_url('/contact'); ?>"><img src="\wordpress\wp-content\uploads\2025\03\メールで査定する.png" width="150px"  ></a>
            </div>
        </div>
        <div class="nav-top">
            <nav>
                <div class="nav-container">
                    <ul id="top-menu">
                        <div>
                            <a href="<?php echo home_url(); ?>">ホーム</a>
                        </div>
                        <div>
                            <a href="<?php echo home_url('/item'); ?>">買取商品</a>
                        </div>
                        <div>
                            <a href="<?php echo home_url('/category/results/'); ?>">買取実績</a>
                        </div>
                        <div>
                            <a href="<?php echo site_url('/area'); ?>">出張買取対応エリア</a>
                        </div>
                        <div>
                            <a href="<?php echo home_url('/faq'); ?>">よくある質問</a>
                        </div>
                    </ul>                
                </div>
            </nav>
        </div>
        <?php if (function_exists('bcn_display')): ?>
            <nav class="breadcrumb">
                <?php bcn_display(); ?>
            </nav>
        <?php endif; ?>
    </header>
</body>

