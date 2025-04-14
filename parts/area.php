<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>出張買取対応エリア</title>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
</head>
<body>

<main class="area-indexbody">
  <section class="area-section">
    <h2 class="area-title">出張買取対応エリア</h2>
    <div class="area-lead-box">
      <p><strong>出張買取は埼玉・東京・千葉エリアを中心に拡大中！</strong></p>
      <p>冷蔵庫・洗濯機などの家電やベッド・ソファなどの家具、遺品整理や法人様の大量買取にも対応。</p>
      <p>ご自宅・事務所への訪問査定から運び出しまで、すべてお任せください。</p>
    </div>
    <div class="area-indexbox">
        <h3 class="area-subtitle">関東</h3>
        <ul class="area-list">
            <?php
                global $wpdb;

                $area_query = new WP_Query([
                    'post_type'      => 'area',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                    'post_status'    => 'publish'
                ]);

                if ($area_query->have_posts()) {
                    while ($area_query->have_posts()) {
                        $area_query->the_post();
                        $post_id = get_the_ID();
                        $title = get_the_title();
                        $city_count = $wpdb->get_var(
                            $wpdb->prepare("SELECT COUNT(*) FROM wp_areas WHERE post_id = %d", $post_id)
                        );

                        if ($city_count > 0) {
                            echo '<li><a class="area-item" href="' . get_permalink() . '">' . esc_html($title) . '</a></li>';
                        } else {
                            echo '<li><span class="area-item disabled">' . esc_html($title) . '（準備中）</span></li>';
                        }
                    }
                    wp_reset_postdata();
                } else {
                    echo '<li>エリア情報がありません。</li>';
                }
            ?>
        </ul>
    </div>
  </section>
</main>

</body>
</html>
