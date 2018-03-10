<?php
/**
 * The page for licences which displays it's associated products.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Layout.js
 * @since 1.0
 * @version 1.0
 */
?>

<!DOCTYPE html>
<html>
<?php get_header(); ?>
<body>
<section class="section-products">
    <h1 class="section-title"><?php echo $post->post_title; ?></h1>
    <?php
        // We gaan zoeken of er producten zijn die gekoppeld zijn aan deze licentie

        $loop = get_field('related_licences');
    ?>
    <?php
        // We gaan zoeken naar de gerelateerde producten

        $loop = get_field('related_products');

        var_dump($loop);

        foreach ($loop as $key => $product): ?>

            <div class="product">
                <h1 class="product__h1 h1-product-title"><?php echo $product->post_title; ?></h1>
                <p class="product__p p-product-description"><?php echo $product->post_content; ?></p>
            </div>

        <?php endforeach; ?>
</section>
<?php get_footer(); ?>
</body>
</html>
