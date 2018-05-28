<?php
/**
 * Specific page template for the page "faq"
 *
 * This page displays the FAQ for different languages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Layout.js
 * @since 1.0
 * @version 1.0
 */

    global $post;

?>

<!DOCTYPE html>
<html>
<?php get_header(); ?>
<body <?php body_class(); ?>>
<section class="page-header">
    <h1><?php the_title(); ?></h1>
</section>
<section class="faq-filters">
    <form class="form-faq" action="#">
        <label for="faq-cards" class="faq-button checked">cards Shuffle Go</label>
        <input type="radio" checked value="faq-cards" id="faq-cards">
        <label for="faq-apps" class="faq-button">apps</label>
        <input type="radio" value="faq-apps" id="faq-apps">
    </form>
</section>
<main>
        <?= apply_filters('the_content', $post->post_content);?>
</main>
<?php get_footer() ;?>
</body>
</html>
