jQuery(document).ready(function ($) {

    // var demo = localStorage.getItem('demo123');
    // if ( !demo ) {
    //     localStorage.setItem('demo123', 'nothing');
    // }
    // console.log('testing:', demo);


    // animation list post type
    var listPostTypeSection = $( '.maddie-list-posttype-widget' ).parents('section');

    function addAnimationPostTypeItem(el) {
        el.each(function( index ) {

            if ( $(this).find('.posttype_item_animate_yes').length >= 1 && $(this).find('.maddie-post-item.animated').length < 1 ) {

                console.log('test');
    
                var rect = $(this).get(0).getBoundingClientRect();
    
                if ( rect.bottom > 0 && rect.top < (window.innerHeight || document.documentElement.clientHeight) ) {
                    $(this).find('.maddie-post-item').addClass('animated slideInUp');
                }
            }
        });     
    }

    addAnimationPostTypeItem(listPostTypeSection);

    $(document).scroll(function () {
        addAnimationPostTypeItem(listPostTypeSection);
    });

});