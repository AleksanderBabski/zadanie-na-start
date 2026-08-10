<?php
// Zabezpieczenie przed bezpośrednim dostępem do pliku
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function demo_theme_enqueue_styles() {
    // Podpięcie głównego pliku style.css
    wp_enqueue_style( 
        'demo-theme-style', 
        get_stylesheet_uri(), 
        array(), 
        '1.0.0' 
    );
}
// Hook 'wp_enqueue_scripts' to standardowe miejsce do ładowania CSS i JS
add_action( 'wp_enqueue_scripts', 'demo_theme_enqueue_styles' );