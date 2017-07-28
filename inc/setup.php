<?php

// ========= Set the content width based on the theme's design and stylesheet ========
if (!isset($content_width)) {
    $content_width = 980; /* pixels */
}

// ======== Assign the Foxtail version to a var =========

$theme = wp_get_theme('vifonic');
$vifonic_version = $theme['Version'];

// ========= Set up =========
add_action( 'after_setup_theme', 'vifonic_setup' );
if (!function_exists('vifonic_setup'))
{
    function vifonic_setup()
    {
        load_theme_textdomain('vifonic', trailingslashit(WP_LANG_DIR) . 'themes/');

        load_theme_textdomain('vifonic', get_stylesheet_directory() . '/languages');

        load_theme_textdomain('vifonic', get_template_directory() . '/languages');

        // =========== Add default posts and comments RSS feed links to head ========
        add_theme_support('automatic-feed-links');

        // ========== Enable support for Post Thumbnails on posts and pages ========
        add_theme_support('post-thumbnails');

        // ========== Register menu location ========
        register_nav_menus(array(
            'main-nav' => __('Main Nav', 'vifonic')
        ));

        // ========= Switch default core markup for search form, comment form, comments, galleries, captions and widgets to output valid HTML5
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'widgets',
        ));

        // ============ Declare support for title theme feature ======
        add_theme_support('title-tag');

        // ========== add image size =========
//        set_post_thumbnail_size( 200, 125, true );
//        add_image_size( 'small', 60, 45, true );
//        add_image_size( 'big-thumb', 535, 250, true );
	    add_image_size( 'course-thumbnail', 261, 161, true );
	    add_image_size( 'slider-size', 1350, 300, true );
    }
}
// ===== end function vifonic_setup =====


// ============ Create custom taxonomy and custom post type ============
add_action('init', 'vifonic_create_custom_taxonomies');
add_action('init', 'vifonic_create_custom_post_types');

function vifonic_create_custom_taxonomies()
{

    $args = array(
        'labels' => array(
            'name' => __('Course Categories', 'vifonic'),
            'singular' => __('Course Category', 'vifonic'),
            'menu_name' => __('Course Categories', 'vifonic')
        ),
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'rewrite' => array('slug' => 'danh-muc')
    );

    register_taxonomy('course_category', 'course', $args);
}

function vifonic_create_custom_post_types()
{
    register_post_type('course', array(
        'labels' => array(
            'name' => __('Courses', 'vifonic'),
            'singular_name' => __('Course', 'vifonic')
        ),
        'description' => __('Courses', 'vifonic'),
        'supports' => array(
            'title', 'editor', 'excerpt', 'thumbnail'
        ),

        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 7,
        'menu_icon' => 'dashicons-images-alt2',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'rewrite'            => array( 'slug' => 'khoa-hoc' ),
    ));

    //Slider
	register_post_type('vifonic-slider', array(
		'labels' => array(
			'name' => __('Vifonic Slider', 'vifonic'),
			'singular_name' => __('Vifonic Slider', 'vifonic')
		),
		'description' => __('Vifonic Slider', 'vifonic'),
		'supports' => array(
			'title', 'editor', 'excerpt', 'thumbnail'
		),

		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'menu_position' => 7,
		'menu_icon' => 'dashicons-images-alt2',
		'can_export' => true,
		'has_archive' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'capability_type' => 'post',
		'rewrite'            => array( 'slug' => 'vslider' ),
	));
}

// =========== Register widget area =========
add_action('widgets_init', 'vifonic_widgets_init');

function vifonic_widgets_init()
{
    register_sidebar(array(
        'name' => __('Main Sidebar', 'vifonic'),
        'id' => 'sidebar-main',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Page Sidebar', 'vifonic'),
        'id' => 'sidebar-page',
        'description' => '',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Top Left Sidebar', 'vifonic'),
        'id' => 'sidebar-top-left',
        'description' => '',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));

    register_sidebar(array(
        'name' => __('Top Right Sidebar', 'vifonic'),
        'id' => 'sidebar-top-right',
        'description' => '',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));

    register_sidebar(array(
        'name' => __('Footer Sidebar 1', 'vifonic'),
        'id' => 'sidebar-footer-1',
        'description' => '',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Sidebar 2', 'vifonic'),
        'id' => 'sidebar-footer-2',
        'description' => '',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Sidebar 3', 'vifonic'),
        'id' => 'sidebar-footer-3',
        'description' => '',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));

    register_sidebar(array(
        'name' => __('Footer Sidebar 4', 'vifonic'),
        'id' => 'sidebar-footer-4',
        'description' => '',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}

/**
 * Enqueue scripts
 */
add_action( 'wp_enqueue_scripts', 'vifonic_enqueue_styles', 10 );

function vifonic_enqueue_styles()
{
    global $vifonic_version;

    wp_enqueue_style('vifonic-css', get_stylesheet_uri());
    wp_enqueue_style('font-awesome-css', get_template_directory_uri() . '/css/font-awesome.min.css');
    wp_enqueue_style('carousel-css', get_template_directory_uri() . '/css/owl.carousel.min.css');
    wp_enqueue_style('carousel-default-theme-css', get_template_directory_uri() . '/css/owl.theme.default.min.css');
    wp_enqueue_style('custom-css', get_template_directory_uri() . '/css/custom.css');

    if (!is_front_page() && (is_page() || is_single())) {
        wp_enqueue_style('single-page-style', get_template_directory_uri() . '/css/single-page.css');
    }
}

add_action( 'wp_enqueue_scripts', 'vifonic_enqueue_scripts', 10 );

function vifonic_enqueue_scripts()
{
    global $vifonic_version;
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), $vifonic_version, true);
    wp_enqueue_script('owl-carousel-js', get_template_directory_uri() . '/js/owl.carousel.min.js', array(), $vifonic_version, true);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/js/main.js', array(), $vifonic_version, true);
}

// ============ Change archive title ===========
add_filter( 'get_the_archive_title', function ($title)
{
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    }
    elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    }
    elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>' ;
    }
    return $title;
});

add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more( $more ) {
    return ' ...';
}

// ============ add defer to javascript loader ==========
add_filter( 'script_loader_tag', function ( $tag, $handle ) {

    if ( 'jquery' !== $handle ) return $tag;

    return str_replace( ' src', ' defer="defer" src', $tag );
}, 10, 2 );

// ========== add editor style in admin - to change font
add_editor_style();