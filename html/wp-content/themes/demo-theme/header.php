<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
    $seo_description = get_bloginfo('description');
    if (is_single() || is_page()) {
        $seo_description = wp_strip_all_tags(get_the_excerpt(), true);
        if (empty($seo_description)) {
            $seo_description = get_bloginfo('description');
        }
    }
    ?>
    <meta name="description" content="<?php echo esc_attr($seo_description); ?>">

    <!-- Open Graph Protocol (Meta dane dla social media) -->
    <meta property="og:title" content="<?php wp_title('|', true, 'right'); ?>">
    <meta property="og:description" content="<?php echo esc_attr($seo_description); ?>">
    <meta property="og:type" content="<?php echo is_single() ? 'article' : 'website'; ?>">
    <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <header class="site-header">
        <div class="header-container">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="home-link" aria-label="Strona główna">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                </svg>
            </a>
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="screen-reader-text">Menu</span>
                <span class="hamburger-bar"></span>
                <span class="hamburger-bar"></span>
                <span class="hamburger-bar"></span>
            </button>

            <nav id="primary-menu" class="main-nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'menu-list'
                ));
                ?>
            </nav>
        </div>
    </header>
    <main class="site-main">