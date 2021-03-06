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
    get_template_part('template-parts/content', 'licences');

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
    get_template_part('template-parts/content', 'licences');

    die();
}

add_action('wp_ajax_shuffle_load_all_results', 'shuffle_load_all_results');
add_action('wp_ajax_nopriv_shuffle_load_all_results', 'shuffle_load_all_results');

function shuffle_load_results_per_category(){
    $cat = $_REQUEST['cat'];
    $product_ids= [];
    $ids = [];

    global $wpdb;

    $query = $wpdb->get_results($wpdb->prepare('
        SELECT SP.ID FROM shuffleposts as SP 
        INNER JOIN shuffleterm_relationships AS STR 
        ON SP.ID = STR.object_id 
        INNER JOIN shuffleterms AS ST 
        ON STR.term_taxonomy_id = ST.term_id 
        INNER JOIN shuffleterm_taxonomy AS STT 
        ON ST.term_id = STT.term_id
          WHERE SP.post_type = "shuffle_product" 
          AND SP.post_status = "publish" 
          AND STT.taxonomy = "category" 
          AND ST.slug = %s', $cat), 'ARRAY_N');

    foreach ($query as $key => $value){
        foreach ($value as $row_value){
            $product_ids[] = $row_value;
        }
    }

    $product_ids_placeholders = implode(', ', array_fill(0, count($product_ids), '%s'));

    $filtered_licences = $wpdb->get_results($wpdb->prepare('
        SELECT SP_licence.id FROM shuffleposts as SP_licence
        INNER JOIN shuffle_licence_product AS SLP
        ON SP_licence.ID = SLP.id_licence
        INNER JOIN shuffleposts AS SP_product
        ON SLP.id_product = SP_product.ID
        WHERE SP_product.ID IN ( '.$product_ids_placeholders.' )
        GROUP BY SLP.id_licence', $product_ids), 'ARRAY_N');

    foreach ($filtered_licences as $row){
        $ids[] = $row[0];
    }

    $args = array(
        'post__in' => $ids,
        'post_type' => 'shuffle_licence',
        'post_status' => 'publish',
    );

    set_query_var('args', $args);
    get_template_part('template-parts/content', 'licences');

    die();
}

add_action('wp_ajax_shuffle_load_results_per_category', 'shuffle_load_results_per_category');
add_action('wp_ajax_nopriv_shuffle_load_results_per_category', 'shuffle_load_results_per_category');

function shuffle_stores_per_country(){
    $filter = $_REQUEST['country'];

    $args = array(
        'post_type' => 'shuffle_store',
        'tax_query' => array(
                array(
                        'taxonomy' => 'countries',
                        'field' => 'slug',
                        'terms' => $filter
                )
        )
    );

    set_query_var('args', $args);
    get_template_part('template-parts/content', 'stores');

    die();
}

add_action('wp_ajax_shuffle_stores_per_country', 'shuffle_stores_per_country');
add_action('wp_ajax_nopriv_shuffle_stores_per_country', 'shuffle_stores_per_country');

// ENQUEUE STYLES
function enqueue_styles()
{
    if (get_post_type() == 'shuffle_licence'){
        wp_register_style('product-css', THEME_DIR . '/assets/css/product.css', array(), '1.0', 'all');
        wp_enqueue_style('product-css');
    }

    if (is_page('faq')){
        wp_register_style('faq-css', THEME_DIR . '/assets/css/faq.css', array(), '1.0', 'all');
        wp_enqueue_style('faq-css');
    }

    wp_register_style('reset-css', THEME_DIR . '/assets/css/reset.css', array(), '1.0', 'all');
    wp_enqueue_style('reset-css');

    wp_register_style('main-style', THEME_DIR . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('main-style');
}

add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_admin_styles(){
    wp_register_style('admin-css', THEME_DIR . '/assets/css/admin.css', array(), '1.0', 'all');
    wp_enqueue_style('admin-css');
}

add_action('admin_enqueue_scripts', 'enqueue_admin_styles');

// ENQUEUE SCRIPTS

wp_enqueue_scripts('jquery');

function enqueue_scripts()
{

    if(is_front_page()){
        wp_register_script('shuffle-carousel', THEME_DIR . '/assets/js/shuffle-carousel.js', array('jquery'), '1.0', false);
        wp_enqueue_script('shuffle-carousel');

        wp_register_script('shuffle-shuffle', THEME_DIR . '/assets/js/shuffle-shuffle.js', array('jquery'), '1.0', false);
        wp_enqueue_script('shuffle-shuffle');
        wp_localize_script('shuffle-shuffle', 'js_obj', array('theme_dir' => get_template_directory_uri()));

        wp_register_script('ajax-search', THEME_DIR . '/assets/js/ajax/search.ajax.js', array('jquery'), '1.0', false);
        wp_enqueue_script('ajax-search');
        wp_localize_script('ajax-search', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

        wp_register_script('ajax-filter-licences', THEME_DIR . '/assets/js/ajax/filter-licences.ajax.js', array('jquery'), '1.0', false);
        wp_enqueue_script('ajax-filter-licences');
        wp_localize_script('ajax-filter-licences', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

        wp_register_script('ajax-results', THEME_DIR . '/assets/js/ajax/results.ajax.js', array('jquery'), '1.0', false);
        wp_enqueue_script('ajax-results');
        wp_localize_script('ajax-results', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
    }

    if(get_post_type() === 'shuffle_licence'){
        wp_register_script('shuffle-video', THEME_DIR . '/assets/js/shuffle-video.js', array('jquery'), '1.0', false);
        wp_enqueue_script('shuffle-video');
    }

    if(is_page('faq')){
        wp_register_script('shuffle-faq', THEME_DIR . '/assets/js/shuffle-faq.js', array('jquery'), '1.0', false);
        wp_enqueue_script('shuffle-faq');
    }

    if(is_page('where-to-buy')){
        wp_register_script('ajax-filter-stores', THEME_DIR . '/assets/js/ajax/filter-stores.ajax.js', array('jquery'), '1.0', false);
        wp_enqueue_script('ajax-filter-stores');
        wp_localize_script('ajax-filter-stores', 'myAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
    }

    // This is a global script
    wp_register_script('shuffle-menu', THEME_DIR . '/assets/js/shuffle-menu.js', array('jquery'), '1.0', false);
    wp_enqueue_script('shuffle-menu');


}

add_action('wp_enqueue_scripts', 'enqueue_scripts');

function enqueue_admin_scripts(){
    wp_register_script('admin-js', THEME_DIR . '/assets/js/admin.js', array('jquery'), '1.0', false);
    wp_enqueue_script('admin-js');
}

add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');

// REGISTER MENU'S
function register_menus()
{
    register_nav_menus(
        array(
            'header-menu' => __('Header Menu'),
            'footer-menu' => __('Footer Menu'),
            'social-menu' => __('Social Menu'),
            'language-menu' => __('Language Menu')
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

    } elseif ($post->post_type === 'shuffle_product' && $post->post_status === 'publish'){

        error_log('Product is being created or updated');
        shuffle_insert_product($post_id, $post);

    } elseif ($post->post_type === 'shuffle_product' && $post->post_status === 'trash'){

        error_log('Product is being deleted');
        shuffle_delete_product($post_id, $post);

    } elseif ($post->post_type === 'shuffle_store' && $post->post_status === 'publish'){

        error_log('Store is being updated');
        shuffle_update_store($post_id, $post);

    }
}

add_action('wp_insert_post', 'shuffle_actions_licence', 10, 2);

// DELETE REFERENCES WHEN DELETING LICENCES
 function shuffle_insert_licence($post_id, $post_obj){

    // first checking all nonces
    if (
                !check_admin_referer('target_audience_nonce_action', 'target_audience_nonce_field')
            ||  !check_admin_referer('connected_product_nonce_action', 'connected_product_nonce_field')
    ) {return false;}


    global $wpdb;

    // getting the target audience
    $term = $_POST['licence_target_audience'];
    wp_set_object_terms($post_id, $term, 'target_audience');

    $existing_meta = $wpdb->get_results($wpdb->prepare('SELECT * FROM shuffle_licence_product WHERE id_licence = %d', $post_id));
    $new_meta = $_POST['connected_products'];

    if (!$existing_meta){
        error_log('inserting '.$post_id. ' into DB');

        foreach ($new_meta as $val){
            $success = $wpdb->insert('shuffle_licence_product', array(
                'id' => '',
                'id_licence' => $post_id,
                'id_product' => $val
            ));
            if($success){error_log('Licence created: '.$post_obj->post_title.' was created in DB');}
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
            $success = $wpdb->delete('shuffle_licence_product', array(
                'id_product' => $row->id_product
            ));
            if ($success) {
                error_log('Product was de-coupled from licence');
            }
        }

        //insert new references into db
        foreach ($new_meta as $row) {
            $success = $wpdb->insert('shuffle_licence_product', array(
                'id' => '',
                'id_licence' => $post_id,
                'id_product' => $row
            ));
            if ($success) {
                error_log('Licence created: ' . $post_obj->post_title . ' was created in DB');
            }
        }
    }
}

function shuffle_delete_licence($post_id, $post_obj){
    global $wpdb;

    $success = $wpdb->delete('shuffle_licence_product', array(
        'id_licence' => $post_id,
    ));
    if ($success) {
        error_log('Licence deleted: ' . $post_obj->post_title . ' was deleted from DB');
    }
}

function shuffle_insert_product($post_id, $post_obj){

    global $wpdb;

    // checking nonces
    if(
            !check_admin_referer('connected_licence_nonce_action', 'connected_licence_nonce_field') ||
            !check_admin_referer('gp_nonce_action', 'gp_nonce_field')
    ){return false;}

    // checking to see whether the product already exists in DB and getting the connected licence if so
    $old_licence = $wpdb->get_results($wpdb->prepare('SELECT * FROM shuffle_licence_product WHERE id_product = %d', $post_id));

    if(isset($_POST['connected_licence'])){
        $new_licence = $_POST['connected_licence'];
    }

    //adding, updating or deleting link meta
    $link_types = ['buy_link', 'game_guide_link', 'app_store_link', 'play_store_link', 'video_link'];

    foreach ($link_types as $type) {
        if (!empty($_REQUEST[$type])) {
            error_log($_REQUEST[$type]);
            if (!add_post_meta($post_id, $type, $_REQUEST[$type], true)) {
                update_post_meta($post_id, $type, $_REQUEST[$type]);
            }
        } elseif (empty($_REQUEST[$type])) {
            error_log('meta is being deleted');
            delete_post_meta($post_id, $type);
        }
    };

    // are there old meta connected to this product?
    $old_gp_meta = $wpdb->get_results($wpdb->prepare('SELECT term_taxonomy_id FROM shuffleterm_relationships WHERE object_id = %d', $post_id), 'ARRAY_N');
    $new_gp_meta = [];

    if (isset($_POST['term_group_age']) && isset($_POST['term_group_nop']) && isset($_POST['term_group_dur']) && isset($_POST['term_group_dur'])){
        $new_gp_meta['age'] = $_POST['term_group_age'];
        $new_gp_meta['nop'] = $_POST['term_group_nop'];
        $new_gp_meta['dur'] = $_POST['term_group_dur'];
        $new_gp_meta['cat'] = $_POST['post_category'][1];
    }

    error_log($new_gp_meta['cat']);

    error_log('There are new licences to add');
    if(!empty($old_licence)){
        error_log('There are old licences');
        // updating the licence instead of inserting
        $wpdb->update('shuffle_licence_product', array('id_licence' => $new_licence), array('id_product' => $post_id), array('%d'), array('%d'));

        // after updating the product, let's also update the gameplay icon terms
        function deleteElement($element, &$array){
            $index = array_search($element, $array);
            if($index !== false){
                unset($array[$index]);
            }
        }

        foreach ($new_gp_meta as $new_meta_key => $new_meta_value){
            foreach ($old_gp_meta as $old_meta_key => $old_meta_value){
                if ($new_meta_value == $old_meta_value[0]) {
                    deleteElement($new_meta_value, $new_gp_meta);
                    deleteElement($old_meta_value, $old_gp_meta);
                }
            }
        };

        foreach ($new_gp_meta as $new_meta_key => $new_meta_value){error_log('NM : '.$new_meta_value);};
        foreach ($old_gp_meta as $old_meta_key => $old_meta_value){error_log('OM : '.$old_meta_value[0]);};

        foreach ($old_gp_meta as $old_meta_key => $old_meta_value){
            foreach ($new_gp_meta as $new_meta_key => $new_meta_value){
                $wpdb->update('shuffleterm_relationships', array('term_taxonomy_id' => $new_meta_value), array('object_id' => $post_id, 'term_taxonomy_id' => $old_meta_value[0]), array('%d'), array('%d'));
            }
        }

        error_log('Product updated: '.$post_obj->post_title.' was updated in DB');

    } else {
        // inserting the licence
        error_log('There are no old licences');
        $success = $wpdb->insert('shuffle_licence_product', array(
            'id' => '',
            'id_licence' => $new_licence,
            'id_product' => $post_id
        ));

        //product has been made, inserting gameplayicon rows into term_relationships table
        foreach ($new_gp_meta as $meta_key => $meta_value){
            $success = $wpdb->insert('shuffleterm_relationships', array(
                    'object_id' => $post_id,
                    'term_taxonomy_id' => $meta_value,
                    'term_order' => '0'
            ));

            if($success){error_log('GP meta added: '.$meta_key.' was added.');}
        }

        if($success){error_log('Product created: '.$post_obj->post_title.' was created in DB');}
    }
}

function shuffle_delete_product($post_id, $post_obj){
    global $wpdb;

    $success = $wpdb->delete('shuffle_licence_product', array(
        'id_product' => $post_id,
    ));

    // Deleting references to gameplay meta
    $wpdb->delete('shuffleterm_relationships', array(
            'object_id' => $post_id,
    ));

    if ($success) {
        error_log('Product deleted: ' . $post_obj->post_title . ' was deleted from DB');
    }
}

function shuffle_update_store($post_id, $post_object){
    if (!check_admin_referer('wtb_nonce_action', 'wtb_nonce_field')){return false;}

    if (!empty($_REQUEST['wtb_link'])) {
        if (!add_post_meta($post_id, 'wtb_link', esc_url($_REQUEST['wtb_link']), true)) {
            update_post_meta($post_id, 'wtb_link', esc_url($_REQUEST['wtb_link']));
        }
    } elseif (empty($_REQUEST['wtb_link'])) {
        error_log('meta is being deleted');
        delete_post_meta($post_id, 'wtb_link');
    }
}

function shuffle_add_admin_menus(){
    if (!is_admin()){
        return;
    }
    add_action('admin_menu', 'shuffle_add_meta_box');
}

shuffle_add_admin_menus();

function shuffle_add_meta_box(){
    add_meta_box('shuffle_ta_box', 'Target Audiences', 'shuffle_ta_styling_function', 'shuffle_licence', 'side', 'core');
    add_meta_box('shuffle_con_prod_box', 'Connect products to this licence', 'shuffle_cp_styling_function', 'shuffle_licence', 'side', 'core');
    add_meta_box('shuffle_ml_box', 'Add links to this product', 'shuffle_ml_styling_function', 'shuffle_product', 'side', 'core');
    add_meta_box('shuffle_wtb_box', 'Link to store website', 'shuffle_wtb_styling_function', 'shuffle_store', 'normal', 'core');
}

// STYLING FUNCTION FOR TARGET AUDIENCE METABOX
function shuffle_ta_styling_function($post){
    wp_nonce_field('target_audience_nonce_action', 'target_audience_nonce_field');

    $target_audiences = get_terms('target_audience', 'hide_empty=0');

    ?>
        <select name="licence_target_audience" id="licence_target_audience">
            <?php $names = wp_get_object_terms($post->ID, 'target_audience'); ?>
            <option class='target_audience-option' value=''
                <?php if (!count($names)) echo "selected";?>>None</option>
            <?php
        foreach ($target_audiences as $ta) {
            if (!is_wp_error($names) && !empty($names) && !strcmp($ta->slug, $names[0]->slug))
                echo "<option class='theme-option' value='" . $ta->slug . "' selected>" . $ta->name . "</option>\n";
            else
                echo "<option class='theme-option' value='" . $ta->slug . "'>" . $ta->name . "</option>\n";
        }
        ?>
        </select>
        <?php
}

// STYLING FUNCTION FOR CONNECTED LICENCE METABOX
function shuffle_cl_styling_function($post){
    wp_nonce_field('connected_licence_nonce_action', 'connected_licence_nonce_field');

    global $wpdb;

    $current_licence = $wpdb->get_results($wpdb->prepare('SELECT * FROM shuffle_licence_product WHERE id_product = %d', $post->ID));
    $all_licences = $wpdb->get_results('SELECT ID, post_title FROM shuffleposts WHERE post_type = "shuffle_licence" AND NOT post_title = "Auto Draft" AND NOT post_status = "trash"');

    $has_results = false;

    ?>
        <?php if(!empty($current_licence)):?>

        <label class="connected_licence label-container">
            <?php foreach ($current_licence as $c_licence):?>
                <?php foreach ($all_licences as $a_licence):?>
                    <?php if($c_licence->id_licence === $a_licence->ID):?>
                        <input id="product-<?php echo $a_licence->ID; ?>" type="radio" name="connected_licence" value="<?php echo $a_licence->ID; ?>" checked>
                        <label for="product-<?php echo $a_licence->ID; ?>"><?php echo $a_licence->post_title; ?></label><br>
                        <?php $has_results = true; ?>
                    <?php else:?>
                        <input id="product-<?php echo $a_licence->ID; ?>" type="radio" name="connected_licence" value="<?php echo $a_licence->ID; ?>">
                        <label for="product-<?php echo $a_licence->ID; ?>"><?php echo $a_licence->post_title; ?></label><br>
                        <?php $has_results = true; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach;?>
            <?php if (!$has_results){echo 'No available licences were found.';} ?>
            <hr class="clear-choice">
            <button type="button" class="clear-choice button">Clear choice</button>
        </label>

        <?php else: ?>

        <label class="connected_licence label-container">
            <?php foreach ($all_licences as $a_licence):?>
                    <input id="product-<?php echo $a_licence->ID; ?>" type="radio" name="connected_licence" value="<?php echo $a_licence->ID; ?>">
                    <label for="product-<?php echo $a_licence->ID; ?>"><?php echo $a_licence->post_title; ?></label><br>
                    <?php $has_results = true; ?>
            <?php endforeach; ?>
            <?php if (!$has_results){echo 'No available licences were found.';} ?>
            <hr class="clear-choice">
            <button type="button" class="clear-choice button">Clear choice</button>
        </label>

        <?php endif;?>

        <?php
}

// STYLING FUNCTION FOR CONNECTED PRODUCTS METABOX
function shuffle_cp_styling_function($post){
    wp_nonce_field('connected_product_nonce_action', 'connected_product_nonce_field');

    global $wpdb;

    $query = 'SELECT * FROM shuffleposts AS p LEFT JOIN shuffle_licence_product AS slp ON slp.id_product = p.id WHERE p.post_type = "shuffle_product" AND NOT p.post_title = "Auto Draft" AND NOT p.post_status = "trash" ';
    $products = $wpdb->get_results($query);
    $has_results = false;
    ?>

    <label class="connected_products label-container">
        <?php // first show the already coupled products
        foreach ($products as $product): ?>
            <?php if ($product->id_licence === $post->ID): ?>
                <input id="product-<?php echo $product->ID; ?>" type="checkbox" name="connected_products[]" value="<?php echo $product->ID; ?>" checked>
                <label for="product-<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></label><br>
                <?php $has_results = true;

            // show the available products
            elseif(empty($product->id_licence)): ?>
                <input id="product-<?php echo $product->ID; ?>" type="checkbox" name="connected_products[]" value="<?php echo $product->ID; ?>">
                <label for="product-<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></label><br>
                <?php $has_results = true;

            endif;
        endforeach;

        if (!$has_results){echo 'No available products were found.';} ?>
    </label>

    <?php
}

// STYLING FUNCTION FOR GAMEPLAY ICON METABOX
function shuffle_gp_styling_function($post){
    wp_nonce_field('gp_nonce_action', 'gp_nonce_field');

    global $wpdb;

    $all_gp_terms =  $wpdb->get_results('SELECT st.name, st. slug, st.term_id FROM shuffleterms as st INNER JOIN shuffletermmeta as stm on st.term_id = stm.term_id WHERE meta_value = "gameplay_icon"');

    $active_terms = $wpdb->get_results($wpdb->prepare('SELECT t.name, t.slug, t.term_id FROM shuffleterm_relationships AS tr LEFT JOIN shuffleterms AS t ON tr.term_taxonomy_id = t.term_id RIGHT JOIN shuffletermmeta AS stm ON t.term_id = stm.term_id WHERE tr.object_id = %d AND stm.meta_value = "gameplay_icon" ', $post->ID));

    $term_group_age = [];
    $term_group_nop = [];
    $term_group_dur = [];
    $skip = false;

    foreach ($all_gp_terms as $term) {
        $term_group = substr($term->slug, 0, strpos($term->slug, '-'));

        if ($term_group === 'age') {
            $term_group_age[$term->term_id] = $term->name;
        } elseif ($term_group === 'nop') {
            $term_group_nop[$term->term_id] = $term->name;
        } elseif ($term_group === 'duration') {
            $term_group_dur[$term->term_id] = $term->name;
        }
    }

    ?>

    <label for="term_group_age">Age</label>
    <select name="term_group_age">
        <?php foreach ($term_group_age as $term_id => $term_name): ?>
            <?php foreach ($active_terms as $a_term): ?>
                <?php if ($a_term->term_id == $term_id): ?>
                    <option selected value="<?= $term_id?>"><?= $term_name?> </option>
                    <?php $skip = true; ?>
                <?php endif; ?>
            <?php endforeach;?>
            <?php if (!$skip): ?>
                <option value="<?= $term_id?>"><?= $term_name?> </option>
            <?php endif; ?>
            <?php $skip = false;?>
        <?php endforeach;?>
    </select>

    <label for="term_group_nop">Number of players</label>
    <select name="term_group_nop">
        <?php foreach ($term_group_nop as $term_id => $term_name): ?>
            <?php foreach ($active_terms as $a_term): ?>
                <?php if ($a_term->term_id == $term_id): ?>
                    <option selected value="<?= $term_id?>"><?= $term_name?> </option>
                    <?php $skip = true; ?>
                <?php endif; ?>
            <?php endforeach;?>
            <?php if (!$skip): ?>
                <option value="<?= $term_id?>"><?= $term_name?> </option>
            <?php endif; ?>
            <?php $skip = false;?>
        <?php endforeach;?>
    </select>

    <label for="term_group_dur">Duration</label>
    <select name="term_group_dur">
        <?php foreach ($term_group_dur as $term_id => $term_name): ?>
            <?php foreach ($active_terms as $a_term): ?>
                <?php if ($a_term->term_id == $term_id): ?>
                    <option selected value="<?= $term_id?>"><?= $term_name?> </option>
                    <?php $skip = true; ?>
                <?php endif; ?>
            <?php endforeach;?>
            <?php if (!$skip): ?>
                <option value="<?= $term_id?>"><?= $term_name?> </option>
            <?php endif; ?>
            <?php $skip = false;?>
        <?php endforeach;?>
    </select>

    <?php
}

// STYLING FUNCTION FOR META LINK METABOX
function shuffle_ml_styling_function($post){
    wp_nonce_field('ml_nonce_action', 'ml_nonce_field');

    function is_type_set($type){
        if(isset($type[0])){
            echo $type[0];
        } else {
            echo '';
        }
    };

    ?>

    <label for="buy_link_input">Buy Link</label>
    <input type="url" id='buy_link_input' name="buy_link" class="shuffle_translatable" placeholder="Example: http://www.example.com/" value="<?php is_type_set( get_post_meta($post->ID, 'buy_link')); ?>">
    <button type="button" class="clear-meta button"> Clear </button>
    <label for="game_guide_link_input">Game Guide Link</label>
    <input type="url" id='game_guide_link_input' name="game_guide_link" class="shuffle_translatable" placeholder="Example: http://www.example.com/" value="<?php is_type_set( get_post_meta($post->ID, 'game_guide_link')); ?>">
    <button type="button" class="clear-meta button"> Clear </button>
    <label for="app_store_link_input">App Store Link</label>
    <input type="url" id='app_store_link_input' name="app_store_link" class="shuffle_translatable" placeholder="Example: http://www.example.com/" value="<?php  is_type_set( get_post_meta($post->ID, 'app_store_link')); ?>">
    <button type="button" class="clear-meta button"> Clear </button>
    <label for="play_store_link_input">Google Play Store</label>
    <input type="url" id='play_store_link_input' name="play_store_link" class="shuffle_translatable" placeholder="Example: http://www.example.com/" value="<?php  is_type_set( get_post_meta($post->ID, 'play_store_link')); ?>">
    <button type="button" class="clear-meta button"> Clear </button>
    <label for="video_link_input">Video Link</label>
    <input type="url" id='video_link_input' name="video_link" class="shuffle_translatable" placeholder="Example: http://www.example.com/" value="<?php  is_type_set( get_post_meta($post->ID, 'video_link')); ?>">
    <button type="button" class="clear-meta button"> Clear </button>

<?php 
}

// STYLING FUNCTION FOR WHERE TO BUY METABOX
function shuffle_wtb_styling_function($post){
    wp_nonce_field('wtb_nonce_action', 'wtb_nonce_field');

    function is_link_set($link){
        if(isset($link[0])){
            echo $link[0];
        } else {
            echo '';
        }
    };

    ?>

    <label for="wtb_link"></label>
    <input type="url" id="wtb_link" name="wtb_link" placeholder="Example: http://www.example.com/" value="<?php is_link_set(get_post_meta($post->ID, 'wtb_link')); ?>">
    <button type="button" class="clear-meta button"> Clear </button>

<?php
}

// REMOVING DUPLICATE OR UNNECESSARY META BOXES
function shuffle_remove_dup_meta_boxes(){
    remove_meta_box('tagsdiv-target_audience', 'shuffle_licence', 'side');
    remove_meta_box('tagsdiv-age_group', 'shuffle_product', 'side');
    remove_meta_box('tagsdiv-number_of_players', 'shuffle_product', 'side');
    remove_meta_box('tagsdiv-durations', 'shuffle_product', 'side');
    remove_meta_box('qtranxs-meta-box-lsb', 'shuffle_product', 'normal');
    remove_meta_box('qtranxs-meta-box-lsb', 'shuffle_licence', 'normal');
}

add_action('add_meta_boxes', 'shuffle_remove_dup_meta_boxes');

// MOVING METABOXES TO FIT IN A SINGLE SCREEN
function shuffle_move_meta_boxes(){

    //removing them
    remove_meta_box('revisionsdiv', 'shuffle_product', 'normal');
    remove_meta_box('shuffle_con_licence', 'shuffle_product', 'side');
    remove_meta_box('shuffle_product_gameplay_icons', 'shuffle_product', 'side');

    //moving them
    add_meta_box('shuffle_con_licence', 'Connect this product to a licence', 'shuffle_cl_styling_function', 'shuffle_product', 'normal', 'high');
    add_meta_box('shuffle_product_gameplay_icons', 'Gameplay Icons', 'shuffle_gp_styling_function', 'shuffle_product', 'normal', 'high');
//    add_meta_box('categorydiv', 'shuffle_product', 'normal');
}

add_action('add_meta_boxes', 'shuffle_move_meta_boxes');

