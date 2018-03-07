<?php
/**
 * The the front-page file
 *
 * This is the only page users should land on.
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
<body <?php body_class(); ?>>
<main class="main-front-page">
    <section class="section-carousel carousel-front-page">
        <?php get_template_part('template-parts/content', 'carousel') ?>
    </section>
    <section class="section-controls">
        <ul class="controls-categories">
            <li class="categories__li categories-go">go</li>
            <li class="categories__li categories-fun">fun</li>
            <li class="categories__li categories-aqua">aqua</li>
        </ul>
        <div class="form-controls">
            <form action="#" class="form controls-sort">
                <select name="alfabetical" id="alfabetical">
                    <option value="asc">A-Z</option>
                    <option value="desc">Z-A</option>
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
    $loop = new WP_Query(array('post_type' => 'shuffle_licence', 'ignore_sticky_posts' => 1));

    if ($loop->have_posts()) :
        while ($loop->have_posts()) : $loop->the_post(); ?>
            <a href="<?php echo get_permalink()?>" class="licence__a a-<?php echo get_the_title(); ?>">
                <div class="licence__div <?php echo get_the_terms($post->ID, 'target_audience')[0]->slug; ?>">
                    <h1 class="licence__h1"><?php echo get_the_title(); ?></h1>
                </div>
            </a>
        <?php endwhile; ?>
    <?php endif; ?>
    </section>
</main>
<?php get_footer(); ?>
</body>
</html>
