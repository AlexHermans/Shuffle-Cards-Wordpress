<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 2/03/2018
 * Time: 17:00
 */
?>

<html>
<form action="<?php echo home_url( '/' ); ?>" class="form controls-search" role="search" method="get">
    <label for="form-controls__search">Search</label>
    <input id="form-controls__search" class="form-search__input-search" value="<?php get_search_query(); ?>" type="search" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder' ) ?>">
    <input type="submit" value="Search" class="form-search__input-submit">
</form>
</html>
