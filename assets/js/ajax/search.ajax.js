/**
 * Created by Alex on 7/03/2018.
 */
(function($) {
    $(document).ready(function () {
        var $input = $('#form-controls__search')
        var $content = $('.licence');
        var $submit = $('#form-search__input-submit');
        var timer = 0;

        function search() {
            var query = $input.val();

            $.ajax({
                type: 'POST',
                url: myAjax.ajaxurl,
                data: {
                    action: 'load_search_results',
                    query: query
                },
                beforeSend: function(){
                    $input.prop('disabled', true);
                    $content.addClass('loading')
                    $submit.addClass('loading-gif');
                },
                success: function(response){
                    $input.prop('disabled', false).focus();
                    $content.removeClass('loading');
                    $content.html(response);
                    $submit.removeClass('loading-gif');
                },
            });
        }

        // we wait a couple of seconds to let the user finish a thought before sending the request.
        // research will have to show whether to make this time longer or shorter.
        $input.on('keyup', function(){
            if (timer){
                clearTimeout(timer);
            }
            timer = setTimeout(search, 500)
        });
    });
}(jQuery))