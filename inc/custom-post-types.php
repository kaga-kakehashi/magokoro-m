<?php
function register_area_post_type() {
    register_post_type('area', array(
        'labels' => array(
            'name' => '買取エリア',
            'singular_name' => '買取エリア'
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

?>