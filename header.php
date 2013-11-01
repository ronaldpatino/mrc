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
    <link href="<?php bloginfo('template_url'); ?>/assets/css/bootstrap.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/assets/css/custom.css" rel="stylesheet">
    <link href="<?php bloginfo('template_url'); ?>/assets/css/font.css" rel="stylesheet">

    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/scripts/jquery-1.9.0.js"></script>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/assets/scripts/bootstrap.js"></script>
    <?php wp_head(); ?>

</head>
<body>