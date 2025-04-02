<!DOCTYPE html>
<html lang="ja">
<body>
  <div class="area-body">
    <section>
      <div>
        <h1>出張買取対応エリア</h1>
      </div>

      <div class="area-box">
        <h2>関東</h2>
        <ul>
            <?php
            global $wpdb;

            $area_query = new WP_Query(array(
                'post_type'      => 'area',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
                'post_status'    => 'publish'
            ));

            if ($area_query->have_posts()) {
                while ($area_query->have_posts()) {
                    $area_query->the_post();
                    $post_id = get_the_ID();
                    $title = get_the_title();

                    // wp_areas テーブルからこの都道府県に紐づく市区町村数を取得
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
                echo '<p>エリア情報がありません。</p>';
            }
            ?>
        </ul>
    </div>
    </section>
  </div>
</body>
</html>
