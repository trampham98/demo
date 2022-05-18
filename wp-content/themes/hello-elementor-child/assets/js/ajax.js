jQuery(document).ready(function ($) {
    $.ajax({
        url: maddie_ajax_obj.ajax_url,
        type: 'post',
        data: {
            'action':'my_action',
            'whatever': maddie_ajax_obj.we_value,
        },
        success: function( response ) {
            console.log('demo ajax');
            console.log(response);
        },
    });

    // search news
    function submitFormNewsFilter() {
        $("form.news_filter_form select").on('change', function(){
            var sectionObj    = $(this).parents('section');

            var formFilterObj = $(this).parents('form');
            var pageURL       = formFilterObj.attr('action');
            var postPerPage   = formFilterObj.data("query").post_per_page;


            var terms = {};
            $( "form.news_filter_form select" ).each(function( index ) {
                var key = $(this).attr('name');
                terms[key] = $(this).val();
            });

            $.ajax({
                url: maddie_ajax_obj.ajax_url,
                type: 'post',
                data: {
                    'action':'maddie_filter_news',
                    'page_url': pageURL,
                    'post_per_page': postPerPage,
                    'terms': terms,
                },
                success: function( response ) {
                    // console.log(response);
                    const url = new URL(pageURL);
                    $.each( terms, function( key, value ) {
                        url.searchParams.set(key, value);
                    });
                    window.history.pushState({}, '', url);

                    sectionObj.find('.maddie-posts-content').html( response );
                },
            });
        });
    }

    // Call action
    submitFormNewsFilter();
});