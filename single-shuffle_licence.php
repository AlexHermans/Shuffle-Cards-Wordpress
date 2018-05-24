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
<?php $target_audience = get_the_terms($post->ID, 'target_audience')[0]->slug;?>
<header class="licence-single__header" style="background-image: url(<?php echo get_template_directory_uri();?>/assets/img/licences/<?php echo $post->post_title?>/header_background.jpg);">
    <h1 class="licence-single__logo licence-logo" style="background-image: url(<?php echo get_template_directory_uri();?>/assets/img/licences/<?php echo $post->post_title?>/header_logo.png);"><?php echo $post->post_title; ?></h1>
</header>
<section class="section-licence-title <?php echo $target_audience; ?>">
    <figure class="figure licence__figure-rounded-corner">
        <div class="figure-rounded-corner__div figure-rounded-corner__div-left transparent"></div>
        <div class="figure-rounded-corner__div figure-rounded-corner__div-middle"></div>
        <div class="figure-rounded-corner__div figure-rounded-corner__div-right <?php echo $target_audience; ?>"></div>
    </figure>
    <h2 class="licence-single__h2 h2-secondary-title"><?php echo get_the_title();?></h2>
</section>
<section class="section-products <?php echo $target_audience; ?>">
    <?php
        set_query_var('parent_licence', array(
                'id' => $post->ID,
                'target_audience' => $target_audience,
        ));
        get_template_part('template-parts/content', 'product')
    ?>
</section>
<div class="video-overlay">
    <div class="video-wrapper">
        <video autoplay controls>
            <!-- Video file is placed here by shuffle-video. !-->
        </video>
        <button type="button" class="close-video">X</button>
    </div>
</div>
<?php get_footer(); ?>
</body>
</html>
