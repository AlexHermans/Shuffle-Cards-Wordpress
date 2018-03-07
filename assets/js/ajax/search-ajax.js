/**
 * Created by Alex on 7/03/2018.
 */
(function($) {

    $(document).on('submit', '.controls-search', function(){
        var $form = $(this);
        var $input = $form.find('input[name="s"]');
        var query = $input.val();
        var $content = $('.licence');

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
            },
            success: function(response){
                $input.prop('disabled', false);
                $content.removeClass('loading');
                $content.html(response);
            },
        });

        return false;

    });

}(jQuery))