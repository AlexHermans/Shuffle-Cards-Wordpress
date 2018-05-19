/**
 * Created by Alex on 16/05/2018.
 */

(function ($) {
    $(document).ready(function () {
        let $button = $('.categories__li');
        let $content = $('.licence');

        $button.click(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: myAjax.ajaxurl,
                data: {
                    action: 'shuffle_load_results_per_category',
                    cat: $(this).attr('id')
                },
                beforeSend: function(){
                    $content.addClass('loading');
                },
                success: function(response){
                    $content.removeClass('loading');
                    $content.html(response);
                    layout();
                },
            });
        })
    })
}(jQuery));