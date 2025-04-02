<aside class="sidebar-kaitori">
  <h2 class="sidebar-kaitori-title">買取強化商品</h2>
  <ul class="sidebar-kaitori-list">
    <?php
    $item_query = new WP_Query([
      'post_type' => 'item',
      'posts_per_page' => -1,
      'orderby' => 'menu_order',
      'order' => 'ASC',
    ]);

    if ($item_query->have_posts()) :
      while ($item_query->have_posts()) : $item_query->the_post();
        $icon = get_field('item-icon');
        $link = get_permalink();
    ?>
      <li class="kaitori-block">
        <a href="<?php echo esc_url($link); ?>" class="kaitori-block-link">
          <div class="kaitori-block-icon">
            <?php
              if ($icon) {
                if (is_array($icon)) {
                  echo wp_get_attachment_image($icon['ID'], 'thumbnail');
                } elseif (filter_var($icon, FILTER_VALIDATE_URL)) {
                  echo '<img src="' . esc_url($icon) . '" alt="">';
                } else {
                  echo '<span>' . esc_html($icon) . '</span>';
                }
              }
            ?>
          </div>
          <div class="kaitori-block-name"><?php the_title(); ?></div>
        </a>
      </li>
    <?php endwhile; wp_reset_postdata(); endif; ?>
  </ul>
</aside>