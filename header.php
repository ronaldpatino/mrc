<?php date_default_timezone_set('America/Guayaquil'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/favicon.png/">
    <title>
        <?php
        global $page, $paged;
        wp_title('|', true, 'right');
        bloginfo('name');
        $site_description = get_bloginfo('description', 'display');

        if ($site_description && (is_home() || is_front_page())) {
            echo " | $site_description";
        }

        if ($paged >= 2 || $page >= 2) {
            echo ' | ' . sprintf(__('Page %s'), max($paged, $page));
        }
        ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?php bloginfo('template_url'); ?>/assets/css/elmercurio.css.php" rel="stylesheet">
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/scripts/elmercurio.js.php"></script>
    <?php wp_head(); ?>

</head>
<body>