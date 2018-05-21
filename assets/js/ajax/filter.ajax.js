/**
 * Created by Alex on 16/05/2018.
 */

(function ($) {
    $(document).ready(function () {
        let $button = $('.categories__li');
        let $content = $('.licence');
        let colours = [
            'rgb(245, 155, 0)',
            'rgb(146, 58, 128)',
            'rgb(0, 138, 210)',
            'rgb(226, 38, 27)',
            'rgb(100, 179, 43)',
        ];
        let counter = 0

        $button.click(function (e) {
            e.preventDefault();
            $button.css('background-color', '#7f8184')
            $active_button = $(this);

            $.ajax({
                type: 'POST',
                url: myAjax.ajaxurl,
                data: {
                    action: 'shuffle_load_results_per_category',
                    cat: $active_button.attr('id')
                },
                beforeSend: function(){
                    $content.addClass('loading');
                },
                success: function(response){
                    $content.removeClass('loading');
                    if(counter < colours.length-1){
                        counter += 1;
                    } else { counter = 0 }
                    $active_button.css('background-color' , colours[counter])
                    $content.html(response);
                    layout();
                },
            });
        })
    })
}(jQuery));