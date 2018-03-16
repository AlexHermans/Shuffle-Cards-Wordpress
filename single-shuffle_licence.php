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
<?php global $post?>
<?php $term = get_the_terms($post->ID, 'target_audience')[0]->slug;?>
<header class="licence-single__header" style="background-image: url(<?php echo get_template_directory_uri();?>/assets/img/licences/<?php echo $post->post_title?>/header_background.jpg);">
    <h1 class="licence-single__logo licence-logo" style="background-image: url(<?php echo get_template_directory_uri();?>/assets/img/licences/<?php echo $post->post_title?>/header_logo.png);"><?php echo $post->post_title; ?></h1>
</header>
<section class="section-licence-title <?php echo $term; ?>">
    <figure class="figure licence__figure-rounded-corner">
        <div class="figure-rounded-corner__div figure-rounded-corner__div-left transparent"></div>
        <div class="figure-rounded-corner__div figure-rounded-corner__div-middle"></div>
        <div class="figure-rounded-corner__div figure-rounded-corner__div-right <?php echo $term; ?>"></div>
    </figure>
    <h2 class="licence-single__h2 h2-secondary-title"><?php echo get_the_title();?></h2>
</section>
<section class="section-products <?php echo $term; ?>">
    <?php
        set_query_var('args', array(
                'post_type' => 'shuffle_product',
                'ignore_sticky_posts' => 1,
                'orderby' => 'post_title',
                'order' => 'ASC'
        ));
        set_query_var('parent_licence', $post->ID);
        get_template_part('template-parts/content', 'product')
    ?>
</section>
<?php get_footer(); ?>
</body>
</html>
