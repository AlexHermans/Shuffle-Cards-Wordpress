<?php
/**
 * The the front-page file
 *
 * This is the only page users should land on.
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
<body <?php body_class(); ?>>
<main class="main-front-page">
    <nav class="social-menu">
        <?php wp_nav_menu(array('theme_location' => 'social-menu', 'fallback_cb' => false)); ?>
    </nav>
    <section class="section-carousel carousel-front-page">
        <?php get_template_part('template-parts/content', 'carousel') ?>
    </section>

    <section class="section-controls">
        <ul class="controls-categories">
            <li class="category categories__li categories-go" id="go">go</li>
            <li class="category categories__li categories-fun" id="fun">fun</li>
            <li class="category categories__li categories-aqua" id="aqua">aqua</li>
        </ul>
        <div class="form-controls">
            <form action="#" class="form controls-sort">
                <select name="alfabetical" id="alfabetical">
                    <option value="asc">Sort by A-Z</option>
                    <option value="desc">Sort by Z-A</option>
                </select>
            </form>
            <form action="#" class="form controls-shuffle">
                <button type="button" class="form__button button-shuffle">Shuffle</button>
            </form>
            <?php get_search_form(); ?>
        </div>
    </section>
    <section class="licence">
        <?php
            set_query_var('args', array('post_type' => 'shuffle_licence', 'ignore_sticky_posts' => 1, 'orderby' => 'post_title', 'order' => 'ASC'));
            get_template_part('template-parts/content', 'licences')
        ?>
    </section>
</main>
<?php get_footer(); ?>
</body>
</html>
