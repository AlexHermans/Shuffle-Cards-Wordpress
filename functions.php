<?php
/**
 * The main functions file
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Shuffle
 * @since 1.0
 * @version 1.0
 */

define('THEME_DIR', get_template_directory_uri());
remove_action('wp_head', 'wp_generator');

// SITE SPECIFIC SETTINGS
@ini_set('upload_max_size', '64M');
@ini_set('post_max_size', '64M');
@ini_set('max_execution_time', '300');

// AJAX-LOAD SEARCH RESULTS
function load_search_results()
{
    $q = $_REQUEST['query'];

    $args = array(
        'post_type' => 'shuffle_licence',
        'post_status' => 'publish',
        's' => $q,
    );

    set_query_var('args', $args);
    get_template_part('template-parts/content', 'licence-list');

    die();
}

add_action('wp_ajax_load_search_results', 'load_search_results');
add_action('wp_ajax_nopriv_load_search_results', 'load_search_results');

// ENQUEUE STYLES
function enqueue_styles()
{
    wp_register_style('reset-css', THEME_DIR . '/assets/css/reset.css', array(), '1.0', 'all');
    wp_enqueue_style('reset-css');

    wp_register_style('main-style', THEME_DIR . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('main-style');
}

add_action('wp_enqueue_scripts', 'enqueue_styles');

// ENQUEUE SCRIPTS

wp_enqueue_scripts('jquery');

function enqueue_scripts()
{
    wp_register_script('html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array('jquery'), '1.0', false);
    wp_enqueue_script('html5-shim');

    wp_register_script('shuffle-carousel', THEME_DIR . '/assets/js/shuffle-carousel.js', array('jquery'), '1.0', false);
    wp_enqueue_script('shuffle-carousel');

    wp_register_script('shuffle-carousel', THEME_DIR . '/assets/js/shuffle-shuffle.js', array('jquery'), '1.0', false);
    wp_enqueue_script('shuffle-carousel');

    wp_register_script('ajax-search', THEME_DIR . '/assets/js/ajax/search.ajax.js', array('jquery'), '1.0', false);
    wp_enqueue_script('ajax-search');
    wp_localize_script('ajax-search', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'enqueue_scripts');


// REGISTER MENU'S
function register_menus()
{
    register_nav_menus(
        array(
            'header-menu' => __('Header Menu'),
            'footer-menu' => __('Footer Menu'),
        )
    );
}

add_action('init', 'register_menus');


// CONNECT PRODUCTS TO LICENCES UPON CREATION

function shuffle_connect_product_to_licence($post_id, $post, $update)
{
    error_log($post_id);
    error_log($post->post_type);
    error_log($update);

    $licence_meta = get_post_meta($post_id, 'related_products');

    foreach ($licence_meta[0] as $key => $value){
        error_log($value);
    }

    global $wpdb;


}

add_action('wp_insert_post', 'shuffle_connect_product_to_licence', 10, 3);

?>
