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
});