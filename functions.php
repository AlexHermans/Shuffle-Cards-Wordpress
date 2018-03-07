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

// ENQUEUE STYLES
function enqueue_styles()
{
    wp_register_style('reset-css', THEME_DIR . '/assets/css/reset.css', array(), '1', 'all');
    wp_enqueue_style('reset-css');

    wp_register_style('main-style', THEME_DIR . '/style.css', array(), '1', 'all');
    wp_enqueue_style('main-style');
}

add_action('wp_enqueue_scripts', 'enqueue_styles');

// ENQUEUE SCRIPTS

wp_enqueue_scripts('jquery');

function enqueue_scripts()
{
    wp_register_script('html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array('jquery'), '1', false);
    wp_enqueue_script('html5-shim');

    wp_register_script('shuffle-carousel', THEME_DIR . '/assets/js/shuffle-carousel.js', array('jquery'), '1', false);
    wp_enqueue_script('shuffle-carousel');
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

function shuffle_connect_product_to_licence($post_ID, $post, $update)
{
//    error_log($post_ID);
//    error_log($post->post_type);
//    error_log($post->post_status);
//    error_log($update);
//
//    global $wpdb;
//
//    if ($post->post_type === 'shuffle_licence' && $post->post_status === 'publish' ) {
//        $wpdb->insert(
//            $wpdb->prefix . '_licence_product',
//            array(
//                'id' => '',
//                'id_licence' => $post_ID,
//                'id_product' => 1
//            ),
//            array(
//                '%d',
//                '%d',
//                '%d'
//            )
//        );
//    } else {
////        $wpdb->insert(
////            $wpdb->prefix . '_licence_product',
////            array(
////                'id' => '',
////                'id_licence' => 2,
////                'id_product' => 2
////            ),
////            array(
////                '%d',
////                '%d',
////                '%d'
////            )
////        );
//    }
}

add_action('wp_insert_post', 'shuffle_connect_product_to_licence', 10, 3);

?>
