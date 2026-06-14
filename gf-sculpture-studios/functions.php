<?php
/**
 * G.F. Sculpture Studios — functions.php
 * Theme setup, enqueue, CPT, ACF fields, WooCommerce support.
 */

defined('ABSPATH') || exit;

/* ─────────────────────────────────────────────
   THEME SETUP
───────────────────────────────────────────── */
function gfs_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ]);
    add_theme_support('woocommerce', [
        'thumbnail_image_width'         => 600,
        'gallery_thumbnail_image_width' => 120,
        'single_image_width'            => 900,
    ]);
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menus([
        'primary' => __('Primary Navigation', 'gf-sculpture'),
        'footer'  => __('Footer Navigation', 'gf-sculpture'),
    ]);

    // Image sizes
    add_image_size('artwork-full',  1200, 1500, false);
    add_image_size('artwork-card',  700,  700,  true);
    add_image_size('artwork-thumb', 140,  140,  true);
    add_image_size('hero-full',     1920, 1080, false);
    add_image_size('portrait',      900,  1100, false);
    add_image_size('product-card',  600,  600,  true);
}
add_action('after_setup_theme', 'gfs_setup');

/* ─────────────────────────────────────────────
   ENQUEUE ASSETS
───────────────────────────────────────────── */
function gfs_enqueue_assets() {
    $ver = '1.0.0';
    $uri = get_template_directory_uri();

    // Google Fonts — async via preconnect + link
    wp_enqueue_style(
        'gfs-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap',
        [],
        null
    );

    // CSS
    wp_enqueue_style('gfs-main',        $uri . '/assets/css/main.css',        ['gfs-fonts'], $ver);
    wp_enqueue_style('gfs-animations',  $uri . '/assets/css/animations.css',  ['gfs-main'],  $ver);

    // GSAP (free tier) + ScrollTrigger + Observer via CDN
    // NOTE: SplitText requires GreenSock Club membership — see README.md for alternatives.
    wp_enqueue_script('gsap',              'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',              [], '3.12.5', true);
    wp_enqueue_script('gsap-st',           'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js',     ['gsap'], '3.12.5', true);
    wp_enqueue_script('gsap-observer',     'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/Observer.min.js',          ['gsap'], '3.12.5', true);

    // Lenis smooth scroll
    wp_enqueue_script('lenis', 'https://cdn.jsdelivr.net/npm/lenis@1.1.14/dist/lenis.min.js', [], '1.1.14', true);

    // Theme JS — defer handled by type="module" attribute via filter
    wp_enqueue_script('gfs-main',       $uri . '/assets/js/main.js',       ['gsap', 'gsap-st', 'lenis'], $ver, true);
    wp_enqueue_script('gfs-animations', $uri . '/assets/js/animations.js', ['gfs-main'],                  $ver, true);
    wp_enqueue_script('gfs-cursor',     $uri . '/assets/js/cursor.js',     ['gfs-main'],                  $ver, true);
    wp_enqueue_script('gfs-nav',        $uri . '/assets/js/nav.js',        ['gfs-main'],                  $ver, true);
    wp_enqueue_script('gfs-filter',     $uri . '/assets/js/filter.js',     ['gfs-main'],                  $ver, true);

    wp_localize_script('gfs-main', 'gfsData', [
        'themeUrl'   => $uri,
        'ajaxUrl'    => admin_url('admin-ajax.php'),
        'nonce'      => wp_create_nonce('gfs_nonce'),
        'isRtl'      => is_rtl(),
        'archiveUrl' => get_post_type_archive_link('artwork'),
    ]);

    // WooCommerce custom styles (WC default styles are removed below)
    if (class_exists('WooCommerce')) {
        wp_enqueue_style('gfs-woocommerce', $uri . '/assets/css/woocommerce.css', ['gfs-main'], $ver);
    }
}
add_action('wp_enqueue_scripts', 'gfs_enqueue_assets');

// Preconnect for Google Fonts
function gfs_preconnect_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}
add_action('wp_head', 'gfs_preconnect_fonts', 1);

// Remove WooCommerce default styles (we style from scratch)
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/* ─────────────────────────────────────────────
   CUSTOM POST TYPE — ARTWORK
───────────────────────────────────────────── */
function gfs_register_artwork_cpt() {
    $labels = [
        'name'               => _x('Artworks', 'post type general name', 'gf-sculpture'),
        'singular_name'      => _x('Artwork', 'post type singular name', 'gf-sculpture'),
        'add_new'            => __('Add New Artwork', 'gf-sculpture'),
        'add_new_item'       => __('Add New Artwork', 'gf-sculpture'),
        'edit_item'          => __('Edit Artwork', 'gf-sculpture'),
        'view_item'          => __('View Artwork', 'gf-sculpture'),
        'search_items'       => __('Search Artworks', 'gf-sculpture'),
        'not_found'          => __('No artworks found.', 'gf-sculpture'),
        'not_found_in_trash' => __('No artworks found in trash.', 'gf-sculpture'),
        'menu_name'          => __('Artworks', 'gf-sculpture'),
    ];

    register_post_type('artwork', [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'portfolio', 'with_front' => false],
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'],
        'menu_icon'          => 'dashicons-art',
        'show_in_rest'       => true,
        'menu_position'      => 5,
        'capability_type'    => 'post',
    ]);
}
add_action('init', 'gfs_register_artwork_cpt');

/* ─────────────────────────────────────────────
   TAXONOMY — MATERIAL
───────────────────────────────────────────── */
function gfs_register_taxonomies() {
    register_taxonomy('material', ['artwork'], [
        'labels' => [
            'name'          => __('Materials', 'gf-sculpture'),
            'singular_name' => __('Material', 'gf-sculpture'),
            'all_items'     => __('All Materials', 'gf-sculpture'),
            'edit_item'     => __('Edit Material', 'gf-sculpture'),
            'add_new_item'  => __('Add New Material', 'gf-sculpture'),
        ],
        'hierarchical' => true,
        'public'       => true,
        'rewrite'      => ['slug' => 'material'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'gfs_register_taxonomies');

/* ─────────────────────────────────────────────
   ACF FIELD GROUPS (programmatic fallback)
   ACF JSON is the primary sync method — see /acf-json/
───────────────────────────────────────────── */
function gfs_register_acf_fields() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key'      => 'group_artwork_meta',
        'title'    => 'Artwork Details',
        'fields'   => [
            [
                'key'           => 'field_artwork_year',
                'label'         => 'Year',
                'name'          => 'artwork_year',
                'type'          => 'text',
                'instructions'  => 'Year the work was created (e.g. 2024)',
                'placeholder'   => '2024',
            ],
            [
                'key'           => 'field_artwork_material',
                'label'         => 'Material',
                'name'          => 'artwork_material',
                'type'          => 'text',
                'instructions'  => 'Primary material (e.g. Bronze, Portland Stone)',
                'placeholder'   => 'Bronze',
            ],
            [
                'key'           => 'field_artwork_dimensions',
                'label'         => 'Dimensions',
                'name'          => 'artwork_dimensions',
                'type'          => 'text',
                'instructions'  => 'H × W × D in cm or inches',
                'placeholder'   => '45 × 30 × 20 cm',
            ],
            [
                'key'           => 'field_artwork_edition',
                'label'         => 'Edition',
                'name'          => 'artwork_edition',
                'type'          => 'text',
                'instructions'  => 'Edition info if applicable (e.g. Edition of 5, 2/5)',
                'placeholder'   => 'Unique / Edition of 5',
            ],
            [
                'key'           => 'field_artwork_statement',
                'label'         => 'Artist Statement',
                'name'          => 'artwork_statement',
                'type'          => 'textarea',
                'instructions'  => "Geoff's personal note about this piece.",
                'rows'          => 5,
            ],
            [
                'key'           => 'field_artwork_images',
                'label'         => 'Additional Images',
                'name'          => 'artwork_images',
                'type'          => 'gallery',
                'instructions'  => 'Additional images of this work (shown as thumbnails, lightbox on click).',
                'return_format' => 'array',
                'preview_size'  => 'artwork-thumb',
                'library'       => 'all',
            ],
            [
                'key'           => 'field_artwork_enquiry_only',
                'label'         => 'Enquire Only (hide Add to Cart)',
                'name'          => 'artwork_enquiry_only',
                'type'          => 'true_false',
                'instructions'  => 'Enable to replace Add to Cart with an Enquire button.',
                'default_value' => 0,
                'ui'            => 1,
            ],
            [
                'key'           => 'field_artwork_availability',
                'label'         => 'Availability',
                'name'          => 'artwork_availability',
                'type'          => 'select',
                'instructions'  => 'Current availability of this work.',
                'choices'       => [
                    'available' => 'Available',
                    'sold'      => 'Sold',
                    'reserved'  => 'Reserved',
                ],
                'default_value' => 'available',
                'return_format' => 'value',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'artwork',
                ],
            ],
        ],
        'menu_order'          => 0,
        'position'            => 'normal',
        'style'               => 'default',
        'label_placement'     => 'top',
        'instruction_placement' => 'label',
        'active'              => true,
    ]);

    // ACF fields for homepage customisation
    acf_add_local_field_group([
        'key'   => 'group_homepage_options',
        'title' => 'Homepage Options',
        'fields' => [
            [
                'key'          => 'field_hp_intro_statement',
                'label'        => 'Intro Statement',
                'name'         => 'hp_intro_statement',
                'type'         => 'textarea',
                'rows'         => 2,
                'instructions' => 'Large centred sentence displayed below the hero.',
                'default_value' => 'Form discovered through material, patience, and the hand.',
            ],
            [
                'key'          => 'field_hp_hero_image',
                'label'        => 'Hero Image',
                'name'         => 'hp_hero_image',
                'type'         => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ],
            [
                'key'          => 'field_hp_statement_heading',
                'label'        => 'Statement Piece Heading',
                'name'         => 'hp_statement_heading',
                'type'         => 'text',
                'default_value' => 'Statement Works',
            ],
            [
                'key'          => 'field_hp_statement_text',
                'label'        => 'Statement Piece Text',
                'name'         => 'hp_statement_text',
                'type'         => 'textarea',
                'rows'         => 4,
                'default_value' => '[PLACEHOLDER: Short paragraph about Geoff\'s approach to large-scale and statement work.]',
            ],
            [
                'key'          => 'field_hp_featured_works',
                'label'        => 'Featured Works (Horizontal Scroll)',
                'name'         => 'hp_featured_works',
                'type'         => 'relationship',
                'instructions' => 'Choose 3–5 artworks for the horizontal scroll section.',
                'post_type'    => ['artwork'],
                'min'          => 0,
                'max'          => 5,
                'return_format' => 'object',
            ],
        ],
        'location' => [
            [
                [
                    'param'    => 'page_type',
                    'operator' => '==',
                    'value'    => 'front_page',
                ],
            ],
        ],
        'active' => true,
    ]);
}
add_action('acf/init', 'gfs_register_acf_fields');

/* ─────────────────────────────────────────────
   HELPER: ACF GET (graceful fallback)
───────────────────────────────────────────── */
function gfs_field($field, $post_id = false, $default = '') {
    if (!function_exists('get_field')) {
        return $default;
    }
    $val = get_field($field, $post_id);
    return ($val !== null && $val !== false && $val !== '') ? $val : $default;
}

/* ─────────────────────────────────────────────
   WOOCOMMERCE — REMOVE WRAPPERS / HOOKS
───────────────────────────────────────────── */
if (class_exists('WooCommerce')) {
    // Remove default breadcrumb (we add our own)
    add_action('init', function () {
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10);
        remove_action('woocommerce_sidebar',             'woocommerce_get_sidebar', 10);
    });

    // Adjust archive products per page
    add_filter('loop_shop_per_page', fn() => 12, 20);

    // Remove default WC product image placeholder style
    add_filter('woocommerce_placeholder_img', function ($html) {
        return '<div class="product-img-placeholder" aria-hidden="true"></div>';
    });
}

/* ─────────────────────────────────────────────
   NAVIGATION WALKER
───────────────────────────────────────────── */
class GFS_Nav_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes   = empty($item->classes) ? [] : (array) $item->classes;
        $class_str = implode(' ', array_filter($classes));
        $is_current = in_array('current-menu-item', $classes);

        $output .= '<li class="nav-item' . ($is_current ? ' is-active' : '') . '">';
        $output .= '<a href="' . esc_url($item->url) . '"'
            . ' class="nav-link"'
            . ($is_current ? ' aria-current="page"' : '')
            . '>'
            . esc_html($item->title)
            . '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</li>';
    }
}

/* ─────────────────────────────────────────────
   UTILITY: PLACEHOLDER IMAGE
───────────────────────────────────────────── */
function gfs_placeholder_img($class = '', $label = '') {
    $label = $label ?: __('Artwork', 'gf-sculpture');
    return sprintf(
        '<div class="img-placeholder %s" aria-label="%s" role="img"></div>',
        esc_attr($class),
        esc_attr($label)
    );
}

/* ─────────────────────────────────────────────
   UTILITY: ARTWORK CARD QUERY
───────────────────────────────────────────── */
function gfs_get_artworks($args = []) {
    $defaults = [
        'post_type'      => 'artwork',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order date',
        'order'          => 'ASC',
    ];
    return new WP_Query(array_merge($defaults, $args));
}

/* ─────────────────────────────────────────────
   BODY CLASSES
───────────────────────────────────────────── */
add_filter('body_class', function ($classes) {
    if (is_front_page()) {
        $classes[] = 'is-homepage';
    }
    if (is_singular('artwork')) {
        $classes[] = 'is-single-artwork';
    }
    return $classes;
});

/* ─────────────────────────────────────────────
   TITLE TAG
───────────────────────────────────────────── */
add_filter('document_title_separator', fn() => '·');
add_filter('document_title_parts', function ($parts) {
    $parts['tagline'] = '';
    return $parts;
});
