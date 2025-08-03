<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <haed>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name= "viewport" content="width=device-width, initial-scale=1">
        <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?> </title>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <header>
            <h1><a href="<?php echo esc_url(home_url()); ?>"><?php bloginfo('name'); ?> </a></h1>
            <nav class="main-nav">
                <?php 
                wp_nav_menu([
                    'theme_location' => 'main-menu',
                    'menu_class' => 'nav-menu', 
                    'container' => false,

                ])
                ?>
                </nav>
                </header>
