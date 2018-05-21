<?php
/**
 * This template part generates the information part of a single product
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @since 1.0
 * @version 1.0
 */

$product = get_query_var('product');

$post_meta = get_post_meta($product->ID);
$link_meta = [];
$link_types = ['buy_link', 'game_guide_link', 'app_store_link', 'play_store_link', 'video_link'];

foreach ($post_meta as $meta_key => $meta_value){
    if (in_array($meta_key, $link_types) ){
        $link_meta[$meta_key] = $meta_value[0];
    }
}

$query = $wpdb->get_results($wpdb->prepare('SELECT t.name, t.slug, tt.taxonomy FROM shuffleterms AS t RIGHT JOIN shuffleterm_relationships AS tr ON tr.term_taxonomy_id = t.term_id LEFT JOIN shuffleterm_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tr.object_id = %d AND NOT tt.taxonomy = "category"', $product->ID));
?>

<div class="single-product-information">
    <section class="product-information__section gameplay-icons">
        <?php if (!empty($link_meta['buy_link'])): ?>
            <a href="<?php echo $link_meta['buy_link']; ?>" class="buy-link"></a>
        <?php endif; ?>
        <?php foreach ($query as $meta): ?>
            <div class="gameplay-icon__div single-gp <?= $meta->taxonomy ?> <?= $meta->slug; ?>">
                <p class="single-gp__p"><?= $meta->name; ?></p>
            </div>
        <?php endforeach; ?>
    </section>
    <h2 class="single-product__h2 product-title"><?= $product->post_title; ?></h2>
    <div class="single-product__div product-description">
        <?= apply_filters('the_content', $product->post_content); ?>
    </div>
    <?php if (!empty($link_meta['game_guide_link'])): ?>
        <a href="<?= $link_meta['game_guide_link']; ?>" class="game-guide-link">game guide</a>
    <?php endif; ?>
    <div class="app-links">
        <?php if(!empty($link_meta['app_store_link'])): ?>
            <a href="<?= $link_meta['app_store_link']; ?>" class="app-store-link">Download on the App Store</a>
        <?php endif; ?>
        <?php if(!empty($link_meta['play_store_link'])): ?>
            <a href="<?= $link_meta['play_store_link']; ?>" class="play-store-link">Get it on Google Play</a>
        <?php endif; ?>
    </div>
</div>
