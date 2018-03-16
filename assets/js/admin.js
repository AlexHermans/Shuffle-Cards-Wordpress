/**
 * Created by Alex on 15/03/2018.
 * This js file handles some inputs in the admin screen, so that categories are handled more easy.
 */

(function ($) {
    $(document).ready(function () {

        // this handles the checkbox inputs in inserting licences
        let $cat_list = $('#categorychecklist');

        $cat_list.find('input').attr('type', 'radio');
        $cat_list.find('input:checked').parent().addClass('selected');

        $cat_list.find('input').click(function () {
            $cat_list.find('input').parent().removeClass('selected')
            $(this).parent().addClass('selected');
        })

        // This handles the button to clear the choice when inserting products
        $('.clear-choice').click(function (e) {
            $(this).siblings('input').removeAttr('checked');
        })

    })
})(jQuery)