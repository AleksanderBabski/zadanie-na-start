<?php
// Zabezpieczenie przed bezpośrednim dostępem do pliku
if (!defined('ABSPATH')) {
    exit;
}

function demo_theme_enqueue_styles()
{
    // Podpięcie głównego pliku style.css
    wp_enqueue_style(
        'demo-theme-style',
        get_stylesheet_uri(),
        array(),
        '1.0.0'
    );

    // Podpięcie skryptu do nawigacji mobilnej
    wp_enqueue_script(
        'demo-theme-navigation',
        get_template_directory_uri() . '/js/navigation.js',
        array(),
        '1.0.0',
        true // Załaduj w stopce dla lepszej wydajności
    );
}
// Hook 'wp_enqueue_scripts' to standardowe miejsce do ładowania CSS i JS
add_action('wp_enqueue_scripts', 'demo_theme_enqueue_styles');


/**
 * Rejestracja Custom Post Type: Projekty (Projects)
 * oraz Custom Taxonomy: Technologie (Technologies)
 */
function demo_theme_register_cpt_projects()
{

    // 1. REJESTRACJA TAKSONOMII (Technologie)
    $taxonomy_labels = array(
        'name' => 'Technologie',
        'singular_name' => 'Technologia',
        'search_items' => 'Szukaj Technologii',
        'all_items' => 'Wszystkie Technologie',
        'edit_item' => 'Edytuj Technologię',
        'update_item' => 'Aktualizuj Technologię',
        'add_new_item' => 'Dodaj nową Technologię',
        'new_item_name' => 'Nazwa nowej Technologii',
        'menu_name' => 'Technologie',
    );

    $taxonomy_args = array(
        'hierarchical' => true, // true = działa jak kategorie (z odznaczaniem checklisty), false = działa jak tagi
        'labels' => $taxonomy_labels,
        'show_ui' => true,
        'show_admin_column' => true, // Pokazuje kolumnę z technologiami w usuniętej liście projektów w adminie
        'query_var' => true,
        'rewrite' => array('slug' => 'technologia'),
        'show_in_rest' => true, // KLUCZOWE: włącza obsługę w edytorze Gutenberg!
    );

    register_taxonomy('technology', array('project'), $taxonomy_args);


    // 2. REJESTRACJA CPT (Projekty)
    $cpt_labels = array(
        'name' => 'Projekty',
        'singular_name' => 'Projekt',
        'menu_name' => 'Projekty',
        'name_admin_bar' => 'Projekt',
        'add_new' => 'Dodaj nowy',
        'add_new_item' => 'Dodaj nowy Projekt',
        'new_item' => 'Nowy Projekt',
        'edit_item' => 'Edytuj Projekt',
        'view_item' => 'Zobacz Projekt',
        'all_items' => 'Wszystkie Projekty',
        'search_items' => 'Szukaj Projektów',
        'not_found' => 'Nie znaleziono projektów.',
        'not_found_in_trash' => 'Brak projektów w koszu.',
    );

    $cpt_args = array(
        'labels' => $cpt_labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'projekty'),
        'capability_type' => 'post',
        'has_archive' => true, // Umożliwia stworzenie widoku archiwum pod adresem /projekty/
        'hierarchical' => false,
        'menu_position' => 5, // Miejsce w menu bocznym wp-admin (5 = zaraz pod Wpisami)
        'menu_icon' => 'dashicons-portfolio', // Ikona w menu (Dashicons)
        'show_in_rest' => true, // KLUCZOWE: włącza edytor blokowy Gutenberg dla tego CPT!
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    );

    register_post_type('project', $cpt_args);
}

// Podpinamy naszą funkcję pod akcję 'init'
add_action('init', 'demo_theme_register_cpt_projects');


// 1. Dodanie Meta Boxa w panelu edycji Projektu
function demo_theme_add_project_metabox()
{
    add_meta_box(
        'project_details_mb',
        'Szczegóły Projektu (Custom Fields)',
        'demo_theme_project_metabox_html',
        'project', // CPT slug
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'demo_theme_add_project_metabox');

// 2. HTML formularza w panelu admina
function demo_theme_project_metabox_html($post)
{
    $github_url = get_post_meta($post->ID, '_project_github_url', true);
    $deadline = get_post_meta($post->ID, '_project_deadline', true);
    wp_nonce_field('demo_theme_save_project_meta', 'demo_theme_project_nonce');
    ?>
    <p>
        <label for="project_github_url"><strong>URL Repozytorium GitHub:</strong></label><br>
        <input type="url" id="project_github_url" name="project_github_url" value="<?php echo esc_attr($github_url); ?>"
            style="width: 100%;">
    </p>
    <p>
        <label for="project_deadline"><strong>Termin wykonania:</strong></label><br>
        <input type="text" id="project_deadline" name="project_deadline" value="<?php echo esc_attr($deadline); ?>"
            placeholder="np. Q3 2026 / 2 tygodnie" style="width: 100%;">
    </p>
    <?php
}

// 3. Zapisywanie danych z Meta Boxa
function demo_theme_save_project_meta($post_id)
{
    if (!isset($_POST['demo_theme_project_nonce']) || !wp_verify_nonce($_POST['demo_theme_project_nonce'], 'demo_theme_save_project_meta')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (!current_user_can('edit_post', $post_id))
        return;

    if (isset($_POST['project_github_url'])) {
        update_post_meta($post_id, '_project_github_url', esc_url_raw($_POST['project_github_url']));
    }
    if (isset($_POST['project_deadline'])) {
        update_post_meta($post_id, '_project_deadline', sanitize_text_field($_POST['project_deadline']));
    }
}
add_action('save_post', 'demo_theme_save_project_meta');

// nav

function demo_theme_register_menus()
{
    register_nav_menus(array(
        'primary' => 'Główne Menu Nawigacji',
    ));
}
add_action('after_setup_theme', 'demo_theme_register_menus');