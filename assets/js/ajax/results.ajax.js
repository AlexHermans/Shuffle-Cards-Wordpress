/**
 * Created by Alex on 13/03/2018.
 */
var $sort = 'ASC'

function ajax_call($container,$sort){
    jQuery.ajax({
        type: 'post',
        url: myAjax.ajaxurl,
        data: {
            action: 'shuffle_load_all_results',
            order: $sort
        },
        success: function (response) {
            $container.html(response);
            layout();
        }
    })
}

(function($){

    $(document).ready(function(){
        let $container = $('.licence');

        ajax_call($container, $sort);

        $('.controls-sort').on('mousedown', function (e) {
            var el = $(this).children('select');
            e.preventDefault();
            this.blur();
            window.focus()
            $sort = $sort === 'asc' ? 'desc' : 'asc';

            ajax_call($container, $sort);
            
            $(el).children('option').each(function (index) {
                $(this).removeAttr('selected');
                if($(this).val() === $sort){
                    $(this).attr('selected', 'selected')
                }
            })

            if (!el.hasClass('sort-desc') && !el.hasClass('sort-asc')){
                el.toggleClass('sort-desc');
            } else {
                el.toggleClass('sort-desc').toggleClass('sort-asc');
            }
        })
    })
})(jQuery)