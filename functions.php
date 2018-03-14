<?php
/**
 * The main functions file
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Layout.js
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
function shuffle_load_search_results()
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

add_action('wp_ajax_shuffle_load_search_results', 'shuffle_load_search_results');
add_action('wp_ajax_nopriv_shuffle_load_search_results', 'shuffle_load_search_results');

function shuffle_load_all_results(){
    $order = $_REQUEST['order'];

    $args = array(
        'post_type' => 'shuffle_licence',
        'post_status' => 'publish',
        'orderby' => 'post_title',
        'order' => $order
    );

    set_query_var('args', $args);
    get_template_part('template-parts/content', 'licence-list');

    die();
}

add_action('wp_ajax_shuffle_load_all_results', 'shuffle_load_all_results');
add_action('wp_ajax_nopriv_shuffle_load_all_results', 'shuffle_load_all_results');

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

    wp_register_script('shuffle-shuffle', THEME_DIR . '/assets/js/shuffle-shuffle.js', array('jquery'), '1.0', false);
    wp_enqueue_script('shuffle-shuffle');
    wp_localize_script('shuffle-shuffle', 'js_obj', array('theme_dir' => get_template_directory_uri()));

    wp_register_script('ajax-search', THEME_DIR . '/assets/js/ajax/search.ajax.js', array('jquery'), '1.0', false);
    wp_enqueue_script('ajax-search');
    wp_localize_script('ajax-search', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

    wp_register_script('ajax-results', THEME_DIR . '/assets/js/ajax/results.ajax.js', array('jquery'), '1.0', false);
    wp_enqueue_script('ajax-results');
    wp_localize_script('ajax-results', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
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

// PURE DEBUG FUNCTION
// TODO: Delete this function before going live.
function actions($post_id, $post, $update){
    error_log('action occured.');
    error_log('id: '.$post_id);
    error_log('post_type: '.$post->post_type);
    error_log('post_status: '.$post->post_status);
    error_log('update: '.$update);
    error_log('====== end of action ======');
}

add_action('wp_insert_post', 'actions', 10, 3);

// CONNECT PRODUCTS TO LICENCES UPON CREATION

function shuffle_actions_licence($post_id, $post)
{
    error_log('actions event fired');

    if ($post->post_type === 'shuffle_licence' && $post->post_status === 'publish'){

        error_log('Licence is being created or updated');
        shuffle_insert_licence($post_id, $post);

    } elseif ($post->post_type === 'shuffle_licence' && $post->post_status === 'trash'){

        error_log('Licence is being deleted');
        shuffle_delete_licence($post_id, $post);

    }
}

add_action('wp_insert_post', 'shuffle_actions_licence', 10, 2);

// DELETE REFERENCES WHEN DELETING LICENCES
function shuffle_insert_licence($post_id, $post_obj){
    global $wpdb;

    $existing_meta = $wpdb->get_results($wpdb->prepare('SELECT * FROM shuffle_licence_product WHERE id_licence = %d', $post_id));
    $new_meta = get_post_meta($post_id, 'related_products')[0];

    if (!$existing_meta){
        error_log('inserting '.$post_id. ' into DB');

        foreach ($new_meta as $val){
            $succes = $wpdb->insert('shuffle_licence_product', array(
                'id' => '',
                'id_licence' => $post_id,
                'id_product' => $val
            ));
            if($succes){error_log('Licence created: '.$post_obj->post_title.' was created in DB');}
        }
    } elseif ($existing_meta) {
        error_log('this licence exists');

        foreach ($existing_meta as $row_key => $row_value) {
            error_log('product_id_existing = ' . $row_value->id_product);
            foreach ($new_meta as $meta_key => $meta_value) {
                error_log('product_id_new = ' . $meta_value);
                if ($row_value->id_product === $meta_value) {
                    error_log('match');
                    error_log('deleting key: ' . $meta_key . ' and value ' . $meta_value);
                    unset($new_meta[$meta_key]);
                    unset($existing_meta[$row_key]);
                    foreach ($existing_meta as $row_test) {
                        error_log('exists');
                    }
                }
            }
        }

        // delete old references from db
        foreach ($existing_meta as $row) {
            $succes = $wpdb->delete('shuffle_licence_product', array(
                'id_product' => $row->id_product
            ));
            if ($succes) {
                error_log('Product was de-coupled from licence');
            }
        }

        //insert new references into db
        foreach ($new_meta as $row) {
            $succes = $wpdb->insert('shuffle_licence_product', array(
                'id' => '',
                'id_licence' => $post_id,
                'id_product' => $row
            ));
            if ($succes) {
                error_log('Licence created: ' . $post_obj->post_title . ' was created in DB');
            }
        }
    }
}

function shuffle_delete_licence($post_id, $post_obj){
    //TODO: figure out this functionality
}
