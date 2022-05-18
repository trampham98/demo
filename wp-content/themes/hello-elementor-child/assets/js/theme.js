jQuery(document).ready(function ($) {

    // var demo = localStorage.getItem('demo123');
    // if ( !demo ) {
    //     localStorage.setItem('demo123', 'nothing');
    // }
    // console.log('testing:', demo);

    // get params
    function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
    
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
    
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };

    function addNewsYearOptValue() {
        var c_news_year = getUrlParameter('news_year');
        $('select[name=news_year] option').each(function( index ) {
            var optValue = $(this).val();
            if ( optValue !='' ) {
                optValueArr = optValue.split('/');
                $(this).val(optValueArr[3]);
                if ( $(this).val() == c_news_year ) {
                    $(this).attr("selected","selected");
                }
            }
        });
    }

    // search news
    function submitFormNewsFilter() {
        $("form.news_filter_form select").on('change', function(){
            $(this).closest('form').submit();
        });
    }

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

    // animation list post type
    var listPostTypeSection = $( '.maddie-list-posttype-widget' ).parents('section');

    $(document).scroll(function () {
        addAnimationPostTypeItem(listPostTypeSection);
    });

    addAnimationPostTypeItem(listPostTypeSection);
    addNewsYearOptValue();
    // submitFormNewsFilter();
});