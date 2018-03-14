/**
 * Created by Alex on 8/03/2018.
 */

function set_position_attr(el, pX, pY) {
    jQuery(el).attr('data-pos-x', pX)
    jQuery(el).attr('data-pos-y', pY)
};

function set_parent_height(parent_el, example_el){
    let height_el = jQuery(example_el).outerHeight();

    parent_el.css('height', Math.ceil(example_el.length/4)*height_el);
};

function arrange_items($el, $rand){
    let c = 0;
    let x = 1;
    let y = 1;
    let $arr = []
    // populate multi dimensional array
    for (let i = 0; i<$el.length; i++) {
        c = c + 1;
        x = c;

        if (x > 4) {y += 1;c = 1;x = 1;}

        $arr.push([x,y])
    }

    if ($rand){
        // if needed, randomize the array
        $arr = $arr.sort(function (a,b) {return 0.5 - Math.random()})
    }

    let $fraction = (100/y);

    for (let i = 0; i<$el.length; i++){
        let el = $el[i];

        set_position_attr(jQuery($el[i]), $arr[i][0], $arr[i][1])

        let vector_x = $arr[i][0]-1;
        let vector_y = $arr[i][1]-1;

        jQuery(el).animate({
            left : (25*vector_x) + '%'
        }, 'fast');
        jQuery(el).animate({
            top: ($fraction*vector_y) + '%'
        }, 'fast');
    }
}

function layout() {
    let $el_list = jQuery('.licence__a');
    let $max = $el_list.length;
    let x = 1;
    let y = 1;
    let c = 0;

    // We'll assign each item to a matrix
    for (let i = 0; i<$max; i++){
        c = c+1;
        x = c;

        if (x>4){y+=1;c=1;x=1;}
        set_position_attr($el_list[i], x, y);
    }

    // this pre-defines the height of the parent element
    set_parent_height(jQuery('.licence'), $el_list)

    // We'll hard-code the position of items based on their data-attr
    arrange_items($el_list, false);
}

(function ($) {
    $(document).ready(function () {
        $(window).resize(layout);

        let logo_colours = [
            '/assets/img/logo/logo_blue.png)',
            '/assets/img/logo/logo_green.png)',
            '/assets/img/logo/logo_orange.png)',
            '/assets/img/logo/logo_purple.png)',
            '/assets/img/logo/logo_red.png)',
        ];
        let counter = 0

        $('.controls-shuffle').click(function (e) {
            e.preventDefault();
            arrange_items($('.licence__a'), true);
            if(counter < logo_colours.length-1){
                counter += 1;
            } else { counter = 0 }
            $(this).css('background-image' , 'url('+js_obj.theme_dir+logo_colours[counter])
        })
    })
})(jQuery)