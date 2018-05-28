/**
 * Created by Alex on 25/05/2018.
 */

(function ($) {
    $(document).ready(function () {
        $container = $('.stores')
        $('#country-select').change(function (e) {
            e.preventDefault();

            $country = $(this).val();
            $.ajax({
                    type: 'POST',
                    url: myAjax.ajaxurl,
                    data: {
                        action: 'shuffle_stores_per_country',
                        country: $(this).val()
                    },
                    success: function (response) {
                        $container.html(response)
                    }
            });
        });
    });
}(jQuery))