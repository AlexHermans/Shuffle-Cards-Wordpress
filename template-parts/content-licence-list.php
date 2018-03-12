<?php
/**
 * This template part generates a list of licences.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Layout.js
 * @since 1.0
 * @version 1.0
 */

$args = get_query_var('args');

$loop = new WP_Query($args);


if ($loop->have_posts()) : ?>
    <?php while ($loop->have_posts()) : $loop->the_post();?>
        <a href="<?php echo get_permalink()?>" class="licence__a a-<?php echo get_the_title(); ?>">
            <div class="licence__div <?php echo get_the_terms($post->ID, 'target_audience')[0]->slug; ?>">
                <h1 class="licence__h1"><?php echo get_the_title(); ?></h1>
                <button href="#" class="hide">Hide</button>
            </div>
        </a>
    <?php endwhile; ?>
    <?php else : ?>
        <div class="error">
            <h1 class="error-no-posts">No licences were found.</h1>
        </div>
<?php endif; ?>