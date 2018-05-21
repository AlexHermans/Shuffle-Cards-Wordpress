<?php
/**
 * The main footer file
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Layout.js
 * @since 1.0
 * @version 1.0
 */
?>

<body <?php body_class(); ?>>
<footer class="footer">
    <div class="footer__div footer__div-top">
        <figure class="figure header__figure-rounded-corner">
            <div class="figure-rounded-corner__div figure-rounded-corner__div-left"></div>
            <div class="figure-rounded-corner__div figure-rounded-corner__div-middle"></div>
            <div class="figure-rounded-corner__div figure-rounded-corner__div-right"></div>
        </figure>
        <figure class="figure header__figure-swirl-banner">
            <div class="figure-swirl-banner__div figure-swirl-banner__div-orange"></div>
            <div class="figure-swirl-banner__div figure-swirl-banner__div-purple"></div>
            <div class="figure-swirl-banner__div figure-swirl-banner__div-blue"></div>
            <div class="figure-swirl-banner__div figure-swirl-banner__div-red"></div>
            <div class="figure-swirl-banner__div figure-swirl-banner__div-green"></div>
            <div class="figure-swirl-banner__div figure-swirl-banner__div-swirl"></div>
        </figure>
    </div>
    <nav class="footer__nav"><?php wp_nav_menu(array('theme_location' => 'footer-menu', 'fallback_cb' => false)) ?></nav>
    <p class="footer__p footer__p--copyright">&copy; 2017 - shuffle - all rights reserved.</p>
</footer>
</body>

