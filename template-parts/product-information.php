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

$query = $wpdb->get_results($wpdb->prepare('SELECT t.name, t.slug, tt.taxonomy FROM shuffleterms AS t RIGHT JOIN shuffleterm_relationships AS tr ON tr.term_taxonomy_id = t.term_id LEFT JOIN shuffleterm_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id WHERE tr.object_id = %d AND NOT tt.taxonomy = "category"', $product->ID));
?>

<div class="single-product-information">
    <section class="product-information__section gameplay-icons">
        <?php foreach ($query as $meta): ?>
            <div class="gameplay-icon__div single-gp <?= $meta->taxonomy ?> <?= $meta->slug; ?>">
                <p class="single-gp__p"><?= $meta->name; ?></p>
            </div>
        <?php endforeach; ?>
    </section>
    <h2 class="single-product__h2 product-title"><?php echo $product->post_title; ?></h2>
    <p class="single-product__p product-description"></p>
    <a href="" class="single-product__a"></a>
</div>
