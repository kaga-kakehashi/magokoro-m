<?php get_header(); ?>

<div class="area-body">
  <h1><?php the_title(); ?>の出張エリア</h1>
  <p><?php the_title(); ?>の幅広いエリアで出張買取を行っております。<br>
  お引越しなどでご不要になった家電や家具はぜひリサイクルショップ カケハシにご依頼ください。</p>

  <hr>
  <?php
  $pref_slug = get_post_field('post_name', get_the_ID());
  
  $areas = get_area_data_fast(get_the_ID());

  if (!empty($areas)) {
    setlocale(LC_COLLATE, 'ja_JP.UTF-8');
    usort($areas, function($a, $b) {
      return strcmp($a->kana ?? '', $b->kana ?? '');
    });

    $groups = [
      'あ行' => [], 'か行' => [], 'さ行' => [], 'た行' => [], 'な行' => [],
      'は行' => [], 'ま行' => [], 'や行' => [], 'ら行' => [], 'わ行' => [],
    ];

    foreach ($areas as $area) {
      $kana = $area->kana ?? '';
      $initial = mb_substr($kana, 0, 1);
      $group = '';

      if (preg_match('/[あいうえお]/u', $initial)) $group = 'ア行';
      elseif (preg_match('/[かがきぎくぐけげこご]/u', $initial)) $group = 'カ行';
      elseif (preg_match('/[さざしじすずせぜそぞ]/u', $initial)) $group = 'サ行';
      elseif (preg_match('/[ただちぢつづてでとど]/u', $initial)) $group = 'タ行';
      elseif (preg_match('/[なにぬねの]/u', $initial)) $group = 'ナ行';
      elseif (preg_match('/[はばぱひびぴふぶぷへべぺほぼぽ]/u', $initial)) $group = 'ハ行';
      elseif (preg_match('/[まみむめも]/u', $initial)) $group = 'マ行';
      elseif (preg_match('/[やゃゆゅよょ]/u', $initial)) $group = 'ヤ行';
      elseif (preg_match('/[らりるれろ]/u', $initial)) $group = 'ラ行';
      elseif (preg_match('/[わをん]/u', $initial)) $group = 'ワ行';
      else $group = 'その他';

      $groups[$group][] = $area;
    }

    echo '<div class="area-box">';
    foreach ($groups as $row => $cities) {
      if (empty($cities)) continue;
      echo '<div class="area-group">';
      echo '<h2>' . esc_html($row) . '</h2>';
      echo '<ul class="city-list">';
      foreach ($cities as $area) {
        $city = esc_html($area->city);
        $city_slug = esc_attr($area->city_name);
        $link = home_url("/area/{$pref_slug}/{$city_slug}/");
        if ($area->has_page) {
          echo "<li><a class='city-item' href='{$link}'>{$city}</a></li>";
        } else {
          echo "<li><span class='city-item disabled'>{$city}（準備中）</span></li>";
        }
      }
      echo '</ul>';
      echo '</div>';
    }
    echo '</div>';

  } else {
    echo '<p>対応エリアの情報がありません。</p>';
  }
  ?>
</div>
<?php get_template_part('parts/strong'); ?>
<?php get_template_part('parts/cta'); ?>
<?php get_template_part('parts/faq'); ?>
<?php get_footer(); ?>
