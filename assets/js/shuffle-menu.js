/**
 * Created by Alex on 31/05/2018.
 *
 * This JS file handles the hamburger menu on the front end.
 */

(function ($) {
    $(document).ready(function () {
        $('.button-nav').click(function (e) {
            e.preventDefault();

            $('.menu-main-menu-container').slideToggle();
        })
    })
}(jQuery))