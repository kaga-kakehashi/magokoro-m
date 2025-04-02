<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?> | <?php wp_title(); ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">
</head>
<body>
    <footer>
        <p>古物商許可番号：第431020065947号 埼玉県公安委員会</p>
        <p foootere>&copy; <?php echo date('Y'); ?> リサイクルショップ All Rights Reserved.</p>
    </footer>
<?php wp_footer(); ?>
</body>
