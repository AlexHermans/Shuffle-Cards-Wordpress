/**
 * Created by Alex on 15/03/2018.
 * This js file handles some inputs in the admin screen, so that categories are handled more easy.
 */

(function ($) {
    $(document).ready(function () {

        // TODO: Ik zou een laoding screen kunnen toevoegen om deze veranderingen niet te laten zien

        // this handles the checkbox inputs in inserting licences
        let $cat_list = $('#categorychecklist');

        $cat_list.find('input').attr('type', 'radio');
        $cat_list.find('input:checked').parent().addClass('selected');

        $cat_list.find('input').click(function () {
            $cat_list.find('input').parent().removeClass('selected')
            $(this).parent().addClass('selected');
        })

        // This handles the button to clear the choice when inserting products
        $('.clear-choice').click(function () {
            $(this).siblings('input').removeAttr('checked');
        })

        // This does the same thing but with meta links
        $('.clear-meta').click(function () {
            console.log('clicked')
            $(this).prev().val('').removeAttr('value');
        })


        // TODO: Nakijken of error checking nog nodig / nuttig is
        // // This handles the error checking
        //
        // let $allowed_publish = false
        //
        // if(!$allowed_publish){
        //     $('#publish').attr('disabled', 'disabled');
        // }
        //
        // $('form#post').on('change', function (e) {
        //
        //     // check if a cat has been chosen
        //     $.each($('ul#categorychecklist').find('input'), function () {
        //         console.log(this);
        //         if ($(this).attr('checked')){
        //             $allowed_publish = true;
        //         }
        //     })
        //
        //     $.each($)
        //
        //     // at the end, if all checks were good: enable the button
        //     if($allowed_publish){
        //         $('#publish').removeAttribute('disabled');
        //     }
        // })

    })
})(jQuery)