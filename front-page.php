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
<body <?php body_class();  ?>>
<main>
    <?php
        $loop = new WP_Query( array( 'post_type' => 'licence', 'ignore_sticky_posts' => 1) );

        if ( $loop->have_posts() ) :
            while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <div class="licence">
                    <h1 class="licence__h1"><?php echo get_the_title(); ?></h1>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
</main>
<?php get_footer(); ?>
</body>
</html>
