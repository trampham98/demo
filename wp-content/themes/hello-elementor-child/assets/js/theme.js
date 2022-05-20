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

    /**
     * Search Job
     */
    var jobsList = $('.save_jobs_data').data('jobs_list');
    console.log( 'jobsList', jobsList );

    function initFilterJobs() {
        var form = $('.job_filter_form');

        form.on("keyup", "input[name=keyword]",  function(){
            filterJobs();
        });

        form.on("click", "input[type=checkbox]",  function(){
            var checkboxVal  = $(this).val();
            var selectObj    = form.find('select[name="tax_job_team[]"] option[value='+ checkboxVal +']');
            if ( $(this).is(':checked') ) {
                selectObj.prop("selected", true)
            } else {
                selectObj.prop("selected", false)
            }
            
            filterJobs();
        });
    }

    function filterJobs() {
        var jobs          = jobsList;
        var form          = $('.job_filter_form');
        var keyword       = form.find('input[name="keyword"]').val().trim().toLowerCase();
        var teams         = form.find('select[name="tax_job_team[]"]').val();

        var teamsSelected = teams ? teams.length : null;
        var hasKeyword    = keyword !== "";

        if( hasKeyword || teamsSelected ){
            jobs = jobsList.filter( function( job ){

                if ( teamsSelected && !hasMatchedArray( teams, job.jobTeamsId ) ) {
                    return false;
                }

                if( hasKeyword ){
                    var found = keyword.split(" ").filter( function(k) {
                        return job.jobTitle.toLowerCase().indexOf(k) > -1;
                    });
                    return found.length ? job : false;
                }
                
                return job;
            });
        }
        console.log('jobs', jobs);
        
        var listHtml         = '';
        var countJobs        = jobs.length;
        
        var jobsContainerObj = $('#jobs_container');
        var $jobItemTemplate = $($('#job-item-template').html());

        for (var i = 0; i < countJobs; i++) {

            var jobItem = $jobItemTemplate.clone();

            jobItem.find('.job-item-title').text( jobs[i].jobTitle );
            jobItem.find('.job-item-title').attr( 'href', jobs[i].jobLink );
            jobItem.find('.job-item-title').attr( 'data-link', jobs[i].jobId );

            jobItem.find('.job-item-team').text( jobs[i].jobTeamsName );
            if ( jobs[i].jobTeamsId ) {
                jobItem.find('.job-item-team').attr( 'data-teams', jobs[i].jobTeamsId );
            }
            
            jobItem.find('.job-item-date').text( jobs[i].jobDate );

            listHtml += jobItem.get(0).outerHTML;
            jobsContainerObj.html(listHtml);
        }
        
        if ( countJobs < 1 ) {
            jobsContainerObj.html('<p>'+form.data('empty')+'</p>');
        }
    }

    function hasMatchedArray( a1, a2 ){
        return  a1.filter(function(n) { return a2.indexOf(n) !== -1;}).length > 0;
    }

    initFilterJobs();

    // save current obj
    var jobsViewed = JSON.parse(localStorage.getItem("jobsViewed"));

    if ( jobsViewed ) {
        jobsViewedHtml = '';
        for (var index = 0; index < jobsViewed.length; index++) {
            var element      = jobsViewed[index];
            var jobTitleItem = $('.job-item-title[data-link="'+ element +'"]');

            jobsViewedHtml += '<a href="'+ jobTitleItem.attr('href') +'">'+ jobTitleItem.text() +'<a/>';
            $('.jobs-viewed-wrapper').html(jobsViewedHtml);
        }
    }

    $(document).on('click', '.job-item-title', function () {
        var ids   = [];
        var jobID = $(this).attr('data-link');

        if ( !jobsViewed ) {
            ids[0] = jobID;
        } else {
            ids = jobsViewed;
            if ( $.inArray( jobID, ids ) < 0 ) {
                ids.unshift(jobID);
            } else {
                ids.splice( ids.indexOf(jobID), 1 );
                ids.unshift(jobID);
            }
            
            if ( ids.length > 5 ) {
                ids.pop()
            }
        }
        localStorage.setItem("jobsViewed", JSON.stringify(ids));
    });
});