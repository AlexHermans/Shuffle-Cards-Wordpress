/**
 * Created by Alex on 26/02/2018.
 */

(function($) {
    $(document).ready(function(){
        var $items = $('.section-carousel__div');
        var $container = $('.carousel-front-page');
        var $current = $($items[0]);
        var $next = $($items[1]);
        var $counter = 0;

        $items.not($current).css('opacity', 0);

        setInterval(function () {
            if ($counter < 4){
                $counter += 1;
                $current.animate({
                    left: '-2%'
                })
                $next.css('opacity', 1);
                $current = $current.next();
                $next = $next.next();
                console.log($current)

            } else {
                $counter = 0;
                $current = $($items[0]);
                $current.css('opacity', 1);
                console.log($current)
                $next = $current.next();
                $items.not($current).css('opacity', 0);
                $items.css('left', 0);
            }
        }, 3000)
    });
}(jQuery));
