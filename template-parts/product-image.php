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

$video_link = get_post_meta($product->ID, 'video_link', true)

?>

<div class="single-product-image">
            <div class="single-product__div-image" style="background-image: url(<?php echo $image->guid; ?>)" >
                <?php if (!empty($video_link)): ?>
                    <a href="<?= $video_link?>" class="video-link"></a>
                <?php endif;?>
            </div>
</div>
