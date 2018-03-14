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
<header class="licence-single__header" style="background-image: url(<?php echo get_template_directory_uri();?>/assets/img/licences/<?php echo $post->post_title?>/header_background.jpg);">
    <h1 class="licence-single__logo licence-logo" style="background-image: url(<?php echo get_template_directory_uri();?>/assets/img/licences/<?php echo $post->post_title?>/header_logo.png);"><?php echo $post->post_title; ?></h1>
</header>
<section class="section-products">
</section>
<?php get_footer(); ?>
</body>
</html>
