<?php
function theme_enqueue_styles() {
  wp_enqueue_style('theme-style', get_stylesheet_uri(), [], filemtime(get_stylesheet_directory()));
  wp_enqueue_style('header-style', get_template_directory_uri() . '/assets/css/header.css', [], filemtime(get_template_directory() . '/assets/css/header.css'));
  wp_enqueue_style('hero-style', get_template_directory_uri() . '/assets/css/hero.css', [], filemtime(get_template_directory() . '/assets/css/hero.css'));
  wp_enqueue_style('items-style', get_template_directory_uri() . '/assets/css/items.css', [], filemtime(get_template_directory() . '/assets/css/items.css'));
  wp_enqueue_style('results-style', get_template_directory_uri() . '/assets/css/results.css', [], filemtime(get_template_directory() . '/assets/css/results.css'));
  wp_enqueue_style('results-single-style', get_template_directory_uri() . '/assets/css/results-single.css', [], filemtime(get_template_directory() . '/assets/css/results-single.css'));
  wp_enqueue_style('results-list-style', get_template_directory_uri() . '/assets/css/results-list.css', [], filemtime(get_template_directory() . '/assets/css/results-list.css'));
  wp_enqueue_style('faq-style', get_template_directory_uri() . '/assets/css/faq.css', [], filemtime(get_template_directory() . '/assets/css/faq.css'));
  wp_enqueue_style('area-style', get_template_directory_uri() . '/assets/css/area.css', [], filemtime(get_template_directory() . '/assets/css/area.css'));
  wp_enqueue_style('city-single-style', get_template_directory_uri() . '/assets/css/city-single.css', [], filemtime(get_template_directory() . '/assets/css/city-single.css'));
  wp_enqueue_style('flow-style', get_template_directory_uri() . '/assets/css/flow.css', [], filemtime(get_template_directory() . '/assets/css/flow.css'));
  wp_enqueue_style('strong-style', get_template_directory_uri() . '/assets/css/strong.css', [], filemtime(get_template_directory() . '/assets/css/strong.css'));
  wp_enqueue_style('voice-style', get_template_directory_uri() . '/assets/css/voice.css', [], filemtime(get_template_directory() . '/assets/css/voice.css'));
  wp_enqueue_style('contact-style', get_template_directory_uri() . '/assets/css/contact.css', [], filemtime(get_template_directory() . '/assets/css/contact.css'));
  wp_enqueue_style('single-item-style', get_template_directory_uri() . '/assets/css/single-item.css', [], filemtime(get_template_directory() . '/assets/css/single-item.css'));
  wp_enqueue_style('cta-style', get_template_directory_uri() . '/assets/css/cta.css', [], filemtime(get_template_directory() . '/assets/css/cta.css'));
  wp_enqueue_style('top-results-style', get_template_directory_uri() . '/assets/css/top-results.css', [], filemtime(get_template_directory() . '/assets/css/top-results.css'));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

// JSON-LD構造化データをhead内に追加
function add_json_ld_organization_schema() {
  echo '<script type="application/ld+json">{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "出張買取 リサイクルショップ カケハシ",
    "url": "https://kakehashi-m.com/",
    "logo": "https://kakehashi-m.com/wp-content/uploads/your-logo.png",
    "description": "出張買取・リサイクルを行う関東のリサイクルショップ カケハシ。冷蔵庫・洗濯機・電子レンジなど家電を高価買取。",
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "+81-90-xxxx-xxxx",
      "contactType": "customer service",
      "areaServed": "JP",
      "availableLanguage": ["Japanese"]
    },
    "sameAs": [
      "https://www.instagram.com/youraccount",
      "https://www.facebook.com/youraccount",
      "https://www.tiktok.com/@youraccount"
    ]
  }</script>';
}
add_action('wp_head', 'add_json_ld_organization_schema');

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

  add_action('admin_post_send_contact_form', 'handle_contact_form');
add_action('admin_post_nopriv_send_contact_form', 'handle_contact_form');

//問い合わせ
function handle_contact_form() {
  $to = 'info@kakehashi-m.com';
  $subject = '【カケハシ】お問い合わせがありました';

  $body = "【お名前】" . sanitize_text_field($_POST['name']) . "\n";
  $body .= "【フリガナ】" . sanitize_text_field($_POST['kana']) . "\n";
  $body .= "【住所】" . sanitize_text_field($_POST['address']) . "\n";
  $body .= "【電話番号】" . sanitize_text_field($_POST['phone']) . "\n";
  $body .= "【メール】" . sanitize_email($_POST['email']) . "\n";
  $body .= "【種別】" . sanitize_text_field($_POST['type']) . "\n";
  $body .= "【内容】\n" . sanitize_textarea_field($_POST['message']);

  $headers = ['From: カケハシ <info@kakehashi-m.com>'];

  // 添付ファイル処理
  $attachments = [];
  if (!empty($_FILES['images']['name'][0])) {
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
      if (is_uploaded_file($tmp_name)) {
        $upload_dir = wp_upload_dir();
        $filename = basename($_FILES['images']['name'][$key]);
        $target = $upload_dir['path'] . '/' . $filename;
        move_uploaded_file($tmp_name, $target);
        $attachments[] = $target;
      }
    }
  }

  wp_mail($to, $subject, $body, $headers, $attachments);

  wp_redirect(home_url('/thanks'));
  exit;
}


//差出人アドレスを維持同追加
add_filter('wp_mail_from', 'custom_wp_mail_from');
function custom_wp_mail_from($original_email_address) {
    return 'no-reply@kakehashi-m.com'; // 差出人メールアドレスを固定
}

add_filter('wp_mail_from_name', 'custom_wp_mail_from_name');
function custom_wp_mail_from_name($original_email_from) {
    return 'リサイクルショップ カケハシ'; // 差出人名を固定
}

add_action('phpmailer_init', function($phpmailer) {
  $phpmailer->SMTPDebug = 2;
  $phpmailer->Debugoutput = function($str, $level) {
    error_log("SMTP DEBUG: " . $str);
  };
});

//市区町村のファイルマップ
add_action('init', function() {
  add_rewrite_rule('^custom-sitemap\.xml$', 'index.php?custom_sitemap=1', 'top');
  add_rewrite_tag('%custom_sitemap%', '1');
});

add_action('template_redirect', function () {
  if (get_query_var('custom_sitemap')) {
    header('Content-Type: application/xml; charset=utf-8');
    echo generate_custom_city_sitemap();
    exit;
  }
});

function generate_custom_city_sitemap() {
  global $wpdb;
  $rows = $wpdb->get_results("SELECT a.city_name, p.post_name AS pref_slug FROM wp_areas a JOIN wp_posts p ON a.post_id = p.ID");

  $items = '';
  foreach ($rows as $row) {
    $url = home_url("/area/{$row->pref_slug}/{$row->city_name}/");
    $items .= "
<url>
  <loc>{$url}</loc>
  <lastmod>" . date('Y-m-d') . "</lastmod>
</url>";
  }

  return '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . 
'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . $items . "\n</urlset>";
}

add_action('init', function () {
  if (strpos($_SERVER['REQUEST_URI'], '/custom-sitemap.xml') !== false) {
    header('Content-Type: application/xml; charset=utf-8');

    global $wpdb;
    $results = $wpdb->get_results("
  SELECT a.city_name AS city_slug, p.post_name AS pref_slug
  FROM wp_areas a
  INNER JOIN {$wpdb->posts} p ON a.post_id = p.ID
  WHERE a.has_page = 1 AND p.post_status = 'publish'
");
    
    header('Content-Type: application/xml; charset=utf-8');
    print '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($results as $row) {
      $url = home_url("/area/{$row->pref_slug}/{$row->city_slug}/");
      echo '<url>';
      echo '<loc>' . esc_url($url) . '</loc>';
      echo '<lastmod>' . date('Y-m-d') . '</lastmod>';
      echo '</url>';
    }

    echo '</urlset>';
    exit;
  }
});