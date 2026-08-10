<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- wp_head() jest wymagane! Ładuje style, skrypty i meta dane SEO -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header class="site-header">
        <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
        <p><?php bloginfo( 'description' ); ?></p>
        
        <!-- Tu w przyszłości wstawisz nawigację -->
         <nav class="main-nav">
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary', // Zakładamy nazwę menu 'primary'
            'container' => false,          // Nie chcemy dodatkowego DIVa
            'menu_class' => 'menu-list'    // Klasa do stylizacji listy ul
        ));
        ?>
    </nav>
    </header>
    <main class="site-main">