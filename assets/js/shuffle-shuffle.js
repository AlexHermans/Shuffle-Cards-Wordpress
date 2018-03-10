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

    let fraction = (100/y);

    // this pre-defines the height of the parent element
    set_parent_height(jQuery('.licence'), jQuery('.licence__a'))

    // We'll hard-code the position of items based on their data-attr
    for (let i = 0; i<$max; i++){
        let x = (jQuery($el_list[i]).data('pos-x'))-1;
        let y = (jQuery($el_list[i]).data('pos-y'))-1;

        jQuery($el_list[i]).css('left', (25*x)+'%');
        jQuery($el_list[i]).css('top', (fraction*y)+'%');
    }
}

(function ($) {
    $(document).ready(function () {
        layout();

        $(window).resize(layout);

        // var $max = $el_list.length
        // var arr = [];
        //
        // // we'll manually give each licence box an 'order' css prop.
        // // at the same time, we'll populate an array with numbers we'll later randomly sort
        //
        // function populate(i, val) {
        //     $($el_list[i]).css('order', val+1);
        // }
        //
        // for (var i = 0; i<$max; i++){
        //     populate(i,i)
        //     arr.push(i+1)
        // }
        //
        // $('.controls-shuffle').click(function (e) {
        //     e.preventDefault();
        //     console.log('clicked')
        //
        //     //the random sort
        //     arr = arr.sort(function (a,b) {return 0.5 - Math.random()})
        //
        //     //repopulate
        //     arr.forEach(function (val,index){
        //         console.log(index, val)
        //         populate(index, val);
        //     });
        // })
    })
})(jQuery)