/**
 * Created by Alex on 27/05/2018.
 *
 * This JS file reads out the FAQ page and searches for the page break tag
 * to divide the content into parts. This way end users can easily add questions and/or
 * answers to the faq without breaking the layout. It also enables the opening and
 * closing of the accordion. If this JS file should not be activated, the content
 * should display as a single post with all content readable.
 *
 */


(function ($) {
    $(document).ready(function () {
        let $buttons = $('.faq-button');

        // CB function for the find method
        function check_dom_element(el){
           if (el.innerHTML === '<!--nextpage-->' ){
               return el;
           }
        }

        // let's get all the content inside of the main tag
        let $content = $('main').children().toArray();

        // let's divide the content based on the " <!--nextpage--> " tag
        let $first_part = $content.slice(0, $content.indexOf($content.find(check_dom_element)));
        let $second_part = $content.slice($content.indexOf($content.find(check_dom_element)));

        // now, let's wrap these seperated elements with divs to hide and show them by clicking the buttons above.
        $($first_part).wrapAll(document.createElement('div'))
        $($second_part).wrapAll(document.createElement('div'));

        $first_part_div = $('main div:nth-of-type(1)');
        $second_part_div = $('main div:nth-of-type(2)');

        // let's hide the second part of the content
        $second_part_div.hide();

        // this handles the showing and hiding of the respective parts
        $buttons.click(function (e) {
            e.preventDefault();
            $buttons.removeClass('checked');
            $(this).addClass('checked');

            let $mode = $(this).attr('for')

            if ($mode === 'faq-cards'){
                $first_part_div.show();
                $second_part_div.hide();
            } else if ($mode === 'faq-apps' ){
                $first_part_div.hide();
                $second_part_div.show();
            }
        })

        // first we will hide all the elements between 2 h2's
        $('h2').nextAll().not('h2').hide();


        // then we handle the showing and hiding of the sub elements
        $('h2').click(function (e) {
            e.preventDefault()

            // since we want to make it as easy as possible for the end user, we will
            // have to make sure that they only need to add paragraphs or headers and
            // that the JS does the rest.

            // we find all the clicked elements siblings
            let $siblings = $(this).parent().children();

            // we get it's current position among it
            let $result = $siblings.slice($siblings.index($(this))+1);

            // we keep slideToggle'in until we hit another H2, the break
            $result.each(function (index, value) {
                if ($(value).prop('nodeName') === 'H2'){
                    return false;
                }
                $(value).slideToggle('fast');
            })
        })
    })
}(jQuery))