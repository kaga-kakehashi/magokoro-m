<?php
function create_area_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . "areas";

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            post_id mediumint(9) NOT NULL,
            city varchar(100) NOT NULL,
            available tinyint(1) NOT NULL DEFAULT 1,
            description text NOT NULL,
            PRIMARY KEY  (id),
            INDEX (post_id),
            INDEX (city)
        ) $charset_collate;";
        
        require_once(ABSPATH . "wp-admin/includes/upgrade.php");
        dbDelta($sql);
    }
}
add_action("after_setup_theme", "create_area_table");
?>