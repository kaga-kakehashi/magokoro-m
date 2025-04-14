<section class="items-section">
  <h2 class="item-category">買取商品</h2>
  <ul class="item-list">
    <?php
    $item_query = new WP_Query([
      'post_type' => 'item',
      'posts_per_page' => -1,
      'orderby' => 'menu_order',
      'order' => 'ASC',
    ]);

    if ($item_query->have_posts()) :
      while ($item_query->have_posts()) : $item_query->the_post();
        $icon_field = get_field('item-icon'); // 画像 or 絵文字
    ?>
        <li class="item">
          <a href="<?php the_permalink(); ?>">
            <span class="item-icon">
              <?php
              if ($icon_field) {
                if (is_array($icon_field)) {
                  // ACF画像（返り値が画像IDまたは配列）
                  echo wp_get_attachment_image($icon_field['ID'] ?? $icon_field, 'thumbnail');
                } elseif (filter_var($icon_field, FILTER_VALIDATE_URL)) {
                  // URL形式なら直接出力
                  echo '<img src="' . esc_url($icon_field) . '" alt="">';
                } else {
                  // 絵文字などのテキスト
                  echo esc_html($icon_field);
                }
              } else {
                echo '📦'; // デフォルト
              }
              ?>
            </span>
            <span class="item-name"><?php the_title(); ?></span>
          </a>
        </li>
    <?php
      endwhile;
      wp_reset_postdata();
    endif;
    ?>
  </ul>
</section>

<?php if (!is_singular('item')) : ?>
  <!-- この中に メーカー一覧 のHTMLを入れる -->
  <section class="manufacturer-container">
    <!-- メーカー一覧のHTML -->
    <div class="manufacturer-box">
      <div class="manufacturer-title">主要メーカー一覧</div>
        <div class="manufacturer-text">    
          <p>Panasonic(パナソニック)</p>
          <p>SHARP(シャープ)</p>
          <p>TOSHIBA(東芝)</p>
          <p>HITACHI(日立)</p>
          <p>MITSUBISHI(三菱)</p>
          <p>SONY(ソニー)</p>
          <p>Apple(アップル)</p>
          <p>上記メーカー以外も買取いたします。</p>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>