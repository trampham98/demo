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


    function searchKeyword() {
        var inputKeywordObj = document.getElementById("keyword");
        inputKeywordObj.addEventListener("keyup", function (e) {
            var inputText = e.target.value;
            var filter    = inputText.toLowerCase();

            filterJobsByTitle(filter);
        });
    }

    function filterJobByTerm() {

        var checklistTerms = [];

        $( "input[type=checkbox]" ).click(function() {
            var jobTermsObj   = $('.archive-job-wrapper .maddie-post-item .job-item-team');
            var checkboxValue = parseInt( $(this).val() );
    
            if ( $(this).is(':checked') ) {
                checklistTerms.push( parseInt(checkboxValue) );
            } else {
                checklistTerms = $.grep(checklistTerms, function(value) {
                    return value != checkboxValue;
                });
            }    
    
            if ( checklistTerms.length > 0 ) {
                jobTermsObj.each(function( index ) {
                    var terms     = $(this).data('terms');
                    var matchTerm = false;
    
                    $.each( checklistTerms, function( key, value ) {
                        if ( $.inArray( value, terms ) >= 0 ) {
                            matchTerm = true;
                        }
                    });
                        
                    if ( matchTerm ) {
                        $(this).parents('.maddie-post-item').removeClass('d-none');
                    } else {
                        $(this).parents('.maddie-post-item').addClass('d-none');
                    }
        
                });
            } else {
                jobTermsObj.parents('.maddie-post-item').removeClass('d-none');
            }
            
        });
    }

    function filterJobsByTitle( filterKeyword, filterTeam='' ) {

        var jobTitlesObj = $('.archive-job-wrapper .maddie-post-item a.job-item-title');
        var countJob     = 0;   

        jobTitlesObj.each(function( index ) {
            
            var jobTitle = $( this ).text().toLowerCase();

            if ( jobTitle.indexOf( filterKeyword ) > -1 ) {
                $(this).parents('.maddie-post-item').removeClass('d-none');
                $(this).parents('.maddie-post-item').addClass('active');

            } else {
                $(this).parents('.maddie-post-item').addClass('d-none');
                $(this).parents('.maddie-post-item').removeClass('active');

                countJob++;
            }
        });

        if ( countJob == jobTitlesObj.length ) {
            if ( $('p.no-post').length < 1 ) {
                $( ".archive-job-wrapper .page-content" ).append( "<p class='no-post'>No post</p>" );
            }
        } else {
            $( "p.no-post" ).remove();
        }
    }

    searchKeyword();
    filterJobByTerm();
});