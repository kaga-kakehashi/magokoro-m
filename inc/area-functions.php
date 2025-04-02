<?php
function get_area_data_fast($post_id) {
    global $wpdb;
    $results = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM wp_areas WHERE post_id = %d", $post_id)
    );
    return $results;
}
?>