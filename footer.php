<?php
/**
 * The main footer file
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Shuffle
 * @since 1.0
 * @version 1.0
 */
?>

<body <?php body_class(); ?>>
    <footer class="footer">
        <nav class="footer__nav"><?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'fallback_cb' => false))?></nav>
        <p class="footer__p footer__p--copyright">&copy; 2017 - shuffle - all rights reserved.</p>
    </footer>
</body>

