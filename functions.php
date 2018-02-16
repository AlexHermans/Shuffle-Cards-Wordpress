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
function enqueue_scripts()
{
    wp_register_script('html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js', array('jquery'), '1', false);
    wp_enqueue_script('html5-shim');
}

add_action('wp_enqueue_scripts', 'enqueue_scripts');


// REGISTER MENU'S
function register_my_menus()
{
    register_nav_menus(
        array(
            'header-menu' => __('Header Menu'),
            'extra-menu' => __('Extra Menu'),
            'footer-menu' => __('Footer Menu'),
        )
    );
}

add_action('init', 'register_my_menus');

?>
