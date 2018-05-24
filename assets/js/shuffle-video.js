/**
 * Created by Alex on 24/05/2018.
 *
 * This JS file plays the video if present on the product page.
 */
(function ($) {

    $(document).ready(function () {
        $('.video-link').click(function (e) {
            e.preventDefault();
            $overlay = $('.video-overlay');
            $wrapper = $('.video-wrapper');
            $link = $(this).attr('href');

            // lock scrolling
            $('body').css('overflow', 'hidden');

            function calcHeight() {
                return $wrapper.innerHeight()+'px'
            }

            function calcWidth() {
                return $wrapper.innerWidth()+'px'
            }

            $overlay.fadeIn(200, function () {
                $wrapper.children('video')[0].currentTime = 0;
                $wrapper.children('video')
                    .attr('height', calcHeight())
                    .attr('width', calcWidth())
                    .append('<source src="'+$link+'">')
                $wrapper.children('video')[0].play()

            });

            $('.close-video').click(function (e) {
                e.preventDefault()
                $wrapper.children('video')[0].pause()
                $overlay.fadeOut(200, function () {
                    $wrapper
                        .find('source').remove();
                })
            })
        })
    })

}(jQuery))