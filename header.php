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
        <nav class="header__nav"><?php wp_nav_menu(array ( 'theme_location' => 'header-menu'));?></nav>
        <h1 class="header__h1">Shuffle</h1>
    </header>
</body>
</html>