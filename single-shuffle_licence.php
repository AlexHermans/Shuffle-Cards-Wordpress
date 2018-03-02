<?php
/**
 * The page for licences which displays it's associated products.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Shuffle
 * @since 1.0
 * @version 1.0
 */
?>

<!DOCTYPE html>
<html>
<?php get_header(); ?>
<body>
<section class="product">
    <?php
    $loop = new WP_Query(array('post_type' => 'shuffle_product', 'ignore_sticky_posts' => 1));

    if ($loop->have_posts()) :
        while ($loop->have_posts()) : $loop->the_post(); ?>
            <a href="<?php echo get_permalink()?>" class="product__a a-<?php echo get_the_title(); ?>">
                <div class="product__div">
                    <h1 class="licence__h1"><?php echo get_the_title(); ?></h1>
                </div>
            </a>
        <?php endwhile; ?>
    <?php endif; ?>
</section>

<!--<section class="test">-->
<!--    --><?php
//        global $wpdb;
//        $result = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'posts', 'ARRAY_N');
//        var_dump($result)
//    ?>
<!--</section>-->
<?php get_footer(); ?>
</body>
</html>
