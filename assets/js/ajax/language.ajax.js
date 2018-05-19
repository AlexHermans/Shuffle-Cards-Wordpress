/**
 * Created by Alex on 17/05/2018.
 *
 * It saves the user
 */

(function ($) {
    $(document).ready(function () {
        // this function saves the user's language choice
        $('#language-selector').click(function () {
            let $lang = $(this).val()

            console.log($('html').attr('lang'))
            console.log($lang);

            if ($lang != $('html').attr('lang')){
                $.ajax({
                    type: 'POST',
                    url: myAjax.ajaxurl,
                    data: {
                        action: 'shuffle_set_language',
                        lang: $lang,
                    },
                    beforeSend: function () {
                        $('.loader').show()
                    },
                    success: function (response) {
                        if (response === 'success'){
                            $.ajax({
                                type: 'POST',
                                url: myAjax.ajaxurl,
                                data: {
                                    action: 'shuffle_set_language_cookie',
                                    lang: $lang
                                },
                                success: function(response){
                                    if (response === 'success'){

                                    } else if(response === 'failure') {
                                        $('#language-selector').after('<p class="error lang-error">Your language could not be changed.</p>')
                                    }
                                },
                            });
                        }
                    }
                })
            }
        })
    })
}(jQuery))