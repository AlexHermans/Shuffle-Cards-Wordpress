<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 25/05/2018
 * Time: 15:25
 */

$args = get_query_var('args');

if($args != 'none'){ $loop = new WP_Query($args);}

if(isset($loop)): ?>
    <?php if($loop->have_posts()): ?>
        <?php while($loop->have_posts()): $loop->the_post(); ?>
            <img src="<?= get_the_post_thumbnail_url(); ?>" alt="">
        <?php endwhile;?>
    <?php endif; ?>
<?php endif;
