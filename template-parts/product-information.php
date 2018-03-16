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

?>

<div class="single-product-information">
    <h2 class="single-product__h2 product-title"><?php echo $product->post_title; ?></h2>
</div>
