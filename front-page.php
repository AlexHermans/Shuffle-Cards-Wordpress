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
        <form action="#" class="form form-controls">
            <select name="alfabetical" id="alfabetical">
                <option value="asc">A-Z</option>
                <option value="desc">Z-A</option>
            </select>
            <button type="button" class="controls-shuffle">Shuffle</button>
            <label for="form-controls__search">Search</label>
            <input id="form-controls__search" class="form-controls__search" type="search" placeholder="search">
        </form>
    </section>
    <?php
    $loop = new WP_Query(array('post_type' => 'licence', 'ignore_sticky_posts' => 1));

    if ($loop->have_posts()) :
        while ($loop->have_posts()) : $loop->the_post(); ?>
            <section class="licence">
                <h1 class="licence__h1"><?php echo get_the_title(); ?></h1>
            </section>
        <?php endwhile; ?>
    <?php endif; ?>
</main>
<?php get_footer(); ?>
</body>
</html>
