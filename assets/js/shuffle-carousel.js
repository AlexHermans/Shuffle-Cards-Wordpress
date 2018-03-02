/**
 * Created by Alex on 26/02/2018.
 */

(function($) {
    $(document).ready(function(){
        var items = $('.section-carousel__div');
        var container = $('.carousel-front-page');
        var current = $(items[0]);
        var next = $(items[1]);
        var counter = 0;

        setInterval(function () {
            if (counter < 400){
                counter += 100;

                container.animate({
                    left: '-' + counter + '%',
                })

                current.removeClass('current');
                current = next.addClass('current');
                next = next.next();

            } else {
                current.removeClass('current')
                counter = 0;
                container.css('left', '0');
                current = $(items[0]);
                current.addClass('current')
                next = current.next();
            }
        }, 3000)
    });
}(jQuery));
