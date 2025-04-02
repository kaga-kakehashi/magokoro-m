<?php
// メニューを有効化
add_theme_support('menus');

// 買取エリア（カスタム投稿タイプ）の登録
function register_area_post_type() {
    register_post_type('area', array(
        'labels' => array(
            'name' => '買取エリア',
            'singular_name' => '買取エリア',
            'menu_name' => '買取エリア',
            'add_new' => '新規追加',
            'add_new_item' => '新しい買取エリアを追加',
            'edit_item' => '買取エリアを編集',
            'new_item' => '新しい買取エリア',
            'view_item' => '買取エリアを表示',
            'search_items' => '買取エリアを検索',
            'not_found' => '買取エリアが見つかりません',
            'not_found_in_trash' => 'ゴミ箱に買取エリアはありません'
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'area'),
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_position' => 5,
        'menu_icon' => 'dashicons-location'
    ));
}
add_action('init', 'register_area_post_type');

// 買取エリア（都道府県＋市区町村）の URL を設定
function custom_area_rewrite_rules() {
    add_rewrite_rule(
        '^area/([^/]+)/([^/]+)/?$',
        'index.php?custom_area=$matches[1]&custom_city=$matches[2]',
        'top'
    );
}
add_action('init', 'custom_area_rewrite_rules');    

// クエリパラメータを追加（都道府県・市区町村）
function custom_area_query_vars($vars) {
    $vars[] = 'custom_area';
    $vars[] = 'custom_city';
    return $vars;
}
add_filter('query_vars', 'custom_area_query_vars');

// カスタム関数を読み込む（area-functions.php の読み込み）
require_once get_template_directory() . '/inc/area-functions.php';

function set_city_template($template) {
    if (get_query_var('custom_city')) {
        return get_template_directory() . '/single-city.php';
    }
    return $template;
}
add_filter('single_template', 'set_city_template');

add_filter('query_vars', function ($vars) {
    $vars[] = 'custom_area';
    $vars[] = 'custom_city';
    return $vars;
});

add_action('init', function () {
    add_rewrite_rule(
        '^area/([^/]+)/([^/]+)/?$',
        'index.php?custom_area=$matches[1]&custom_city=$matches[2]',
        'top'
    );
});

add_filter('template_include', function ($template) {
    if (get_query_var('custom_area') && get_query_var('custom_city')) {
        $custom_template = get_template_directory() . '/single-city.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    return $template;
});

// /items というURLで items.php を読み込む
function add_items_endpoint() {
    add_rewrite_rule('^items/?$', 'index.php?custom_items=1', 'top');
    add_rewrite_tag('%custom_items%', '1');
}
add_action('init', 'add_items_endpoint');

function load_items_template($template) {
    if (get_query_var('custom_items') == 1) {
        return get_template_directory() . '/items.php';
    }
    return $template;
}
add_filter('template_include', 'load_items_template');

function register_item_post_type() {
    register_post_type('item', [
      'labels' => [
        'name' => '買取商品',
        'singular_name' => '買取商品',
      ],
      'public' => true,
      'has_archive' => true,
      'rewrite' => ['slug' => 'item'],
      'supports' => ['title', 'editor', 'thumbnail'],
      'menu_position' => 5,
      'menu_icon' => 'dashicons-cart',
    ]);
  }
  add_action('init', 'register_item_post_type');

  //投稿数を数える
  function change_result_posts_per_page($query) {
    if (is_post_type_archive('result') && $query->is_main_query() && !is_admin()) {
      $query->set('posts_per_page', 10);
    }
  }
  add_action('pre_get_posts', 'change_result_posts_per_page');

  add_theme_support('post-thumbnails');

  //買取エリアと投稿記事を一致
  function register_area_taxonomy() {
    register_taxonomy(
      'area',
      'post', // 投稿に紐づける
      [
        'label' => '都道府県',
        'hierarchical' => true, // trueで親子関係（例：都道府県→市区町村）が作れる
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true, // ブロックエディタ用
        'show_admin_column' => true,
        'rewrite' => ['slug' => 'area'],
      ]
    );
  }
  add_action('init', 'register_area_taxonomy');
  
  function register_city_taxonomy() {
    register_taxonomy(
      'city', // タクソノミー名
      'post', // 投稿に紐づける
      [
        'label' => '市区町村',
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_rest' => true, // ← ★これ重要！！
        'show_admin_column' => true,
        'rewrite' => ['slug' => 'city'],
      ]
    );
  }
  add_action('init', 'register_city_taxonomy');    
?>




