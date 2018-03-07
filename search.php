<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 7/03/2018
 * Time: 10:20
 */

?>

<html>
<?php get_header(); ?>
<body <?php get_body_class();?>>
    <section class="section-search-results">
        <?php
            $search_params = get_search_query();
            $args = array(
                's' => $search_params,
                'post_type' => 'shuffle_licence'
            );

            $the_query = new WP_Query($args);

        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) : $the_query->the_post(); ?>
                <div class="search_result">
                    <h1 class="result__title"><?php the_title();?></h1>
                </div>
            <?php endwhile; ?>
        <?php else :
            //TODO: serieuze no results page schrijven
            echo 'Geen results';
        endif; ?>
    </section>
</body>
</html>
