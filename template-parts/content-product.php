<?php
/**
 * This template part generates a single product connected to a licence
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @since 1.0
 * @version 1.0
 */
global $wpdb;

$licence = get_query_var('parent_licence');

$products = $wpdb->get_results($wpdb->prepare('SELECT * FROM shuffleposts AS p INNER JOIN shuffle_licence_product AS slp ON slp.id_product = p.id WHERE p.post_type = "shuffle_product" AND slp.id_licence = %d AND NOT p.post_status = "trash" ', $licence['id']));

$layout_switch = false;
if ($products): ?>
    <?php foreach ($products as $product) : ?>
        <?php set_query_var('product', $product); ?>

        <div class="single-product">
            <div class="category single-product-category <?=$licence['target_audience']?>"><?=get_the_category($product->ID)[0]->name ; ?></div>
            <section class="single-product__section left i18n-multilingual">
                <?php if (!$layout_switch) {__(get_template_part('template-parts/product', 'information'));} else {__(get_template_part('template-parts/product', 'image'));} ?>
            </section>
            <section class="single-product__section right i18n-multilingual">
                <?php if ($layout_switch) {__(get_template_part('template-parts/product', 'information'));} else {__(get_template_part('template-parts/product', 'image'));} ?>
            </section>
        </div>
        <?php $layout_switch = !$layout_switch; ?>
    <?php endforeach; ?>
<?php endif; ?>
