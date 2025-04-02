<?php get_header(); ?>

<h1><?php the_title(); ?>の出張エリア</h1>

<?php
$post_id = get_the_ID();
$areas = get_area_data_fast($post_id);

if (!empty($areas)) {
    setlocale(LC_COLLATE, 'ja_JP.UTF-8');

    usort($areas, function($a, $b) {
        $a_kana = $a->kana ?? '';
        $b_kana = $b->kana ?? '';
        return strcmp($a_kana, $b_kana);
    });

    $pref_slug = get_post_field('post_name', $post_id);

    echo "<ul class='city-list'>";
    foreach ($areas as $area) {
        $city = esc_html($area->city);
        $city_slug = esc_attr($area->city_name);

        if ($area->has_page) {
            $link = home_url("/area/{$pref_slug}/{$city_slug}/");
            echo "<li><a class='city-item' href='{$link}'>{$city}</a></li>";
        } else {
            echo "<li><span class='city-item disabled'>{$city}（準備中）</span></li>";
        }
    }
    echo "</ul>";
} else {
    echo "<p>対応エリアの情報がありません。</p>";
}
?>

<?php get_footer(); ?>
