<?php
/**
 * The main header file
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Shuffle
 * @since 1.0
 * @version 1.0
 */
?>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>

    <!--=== META TAGS ===-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="description" content="Welcome to a new generation of card games. If you love great card games but you're looking for something a little bit different then Shuffle is for you. Because Shuffle really does have something for everyone: fun, skill and excitement.">
    <meta name="author" content="Cartamundi Digital">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="shuffle,cardgame,card,cards,cartamundi,battleship,boggle slam,cluedo,guess who,littlest pet shop,monopoly,deal,my little pony,nerf,pictureka,playdoh,transformers,trivial pursuit"
    <meta name="HandheldFriendly" content="true">
    <meta name="MobileOptimized" content="width">

    <!--=== LINK TAGS ===-->
    <link rel="shortcut icon" href="<?php echo THEME_DIR; ?>/assets/img/icon_shuffle.png" />
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS2 Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <!--=== TITLE ===-->
    <title><?php wp_title(); ?> - <?php bloginfo( 'name' ); ?></title>

    <!--=== WP_HEAD() ===-->
    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
    <header class="header">
        <div class="header__div header__div-top">
            <nav class="nav header__nav"><?php wp_nav_menu(array('theme_location' => 'header-menu')); ?></nav>
            <a href="<?php echo get_home_url(); ?>" class="a header__a header__a-logo">
                <h1 class="h1 a-logo__h1">Shuffle</h1>
            </a>
        </div>
        <div class="header__div header__div-bottom">
            <figure class="figure header__figure-swirl-banner">
                <div class="figure-swirl-banner__div figure-swirl-banner__div-orange"></div>
                <div class="figure-swirl-banner__div figure-swirl-banner__div-purple"></div>
                <div class="figure-swirl-banner__div figure-swirl-banner__div-blue"></div>
                <div class="figure-swirl-banner__div figure-swirl-banner__div-red"></div>
                <div class="figure-swirl-banner__div figure-swirl-banner__div-green"></div>
                <div class="figure-swirl-banner__div figure-swirl-banner__div-swirl"></div>
            </figure>
            <figure class="figure header__figure-rounded-corner">
                <div class="figure-rounded-corner__div figure-rounded-corner__div-left"></div>
                <div class="figure-rounded-corner__div figure-rounded-corner__div-middle"></div>
                <div class="figure-rounded-corner__div figure-rounded-corner__div-right"></div>
            </figure>
        </div>
    </header>
</body>
</html>