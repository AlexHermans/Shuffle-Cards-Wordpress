/**
 * Created by Alex on 15/03/2018.
 * This js file handles some inputs in the admin screen, so that categories are handled more easy.
 */

(function ($) {
    $(document).ready(function () {
        let $cat_list = $('#categorychecklist');

        $cat_list.find('input').attr('type', 'radio');
        $cat_list.find('input:checked').parent().addClass('selected');

        $cat_list.find('input').click(function () {
            $cat_list.find('input').parent().removeClass('selected')
            $(this).parent().addClass('selected');
        })

    })
})(jQuery)