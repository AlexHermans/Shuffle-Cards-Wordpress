<?php
/**
 * Specific page template for the page "Where To Buy"
 *
 * This page displays all the stores that are kept as custom post types
 * and orders them by the country taxonomy. In this page, all of the information
 * is querried at once -- since it isn't very large -- and the filtering happens with
 * jQuery (optimized to reduce reflow stress on browser).
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Layout.js
 * @since 1.0
 * @version 1.0
 */

$loop = new WP_Query(array('post_type' => 'shuffle_store'));

$countries = get_terms(array('taxonomy' => 'countries', 'hide_empty' => 0));
?>

<!DOCTYPE html>
<html>
<?php get_header(); ?>
<body <?php body_class(); ?>>
<main>
    <form action="#">
        <label for="country-select"></label>
        <select name="country-select" id="country-select" class="country-select">
            <?php foreach($countries as $country): ?>
                <option value="<?= $country->slug; ?>"><?= $country->name; ?></option>
            <?php endforeach; ?>
        </select>
    </form>
    <section class="stores">
        <?php set_query_var('args', 'none'); ?>
        <?php get_template_part('template-parts/content', 'stores'); ?>
    </section>
</main>
<?php get_footer(); ?>
</body>
</html>

