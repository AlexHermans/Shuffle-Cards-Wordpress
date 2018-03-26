<?php
/**
 * This template part generates the image part of a products item
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @since 1.0
 * @version 1.0
 */
global $wpdb;

$product = get_query_var('product');

$query = 'SELECT image.guid 
          FROM shuffleposts AS posts 
          INNER JOIN shufflepostmeta AS postmeta 
          ON posts.ID = postmeta.post_id
          INNER JOIN shuffleposts AS image 
          ON postmeta.meta_value = image.ID 
          WHERE posts.ID = %d AND image.post_type = "attachment"';

$image = $wpdb->get_row($wpdb->prepare($query, $product->ID), 'OBJECT');

?>

<div class="single-product-image">
    <img class="single-product__img" src="<?php echo $image->guid; ?>" alt="">
</div>
