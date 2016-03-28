$(document).ready(function($) {

    // Instantiate MixItUp:
    $('.timeline').mixItUp('multiMix', {
        load: {
            filter: '.email_message_reply, .email_message_event, .email_message_send'
        },
        layout: {
            display: 'block'
        },
        // controls: {
        //     toggleFilterButtons: true,
        //     toggleLogic: 'and'
        // },
        callbacks: {
            onMixEnd: function(state){                                                
                var messageDate;
                $('ul#timeline li.mix:visible').each(function(index, el) {

                    if( messageDate == $(el).data('date') ){                            
                        $(el).find('.timeline-date').hide();        
                    }else{                            
                        $(el).find('.timeline-date').show();
                    }
                    messageDate = $(el).data('date');              

                });                                    

            },
            onMixStart: function(state, futureState){
                $('#timeline li .timeline-date').hide(); 
                $('#timeline li > hr').hide(); 
            }
        }
    });

    $('#timeline-filters .filter').on('click', function(e) {
        e.preventDefault();        
        console.log( $(this).data('printlabel') );
    });

    // Print timeline
    $("a.printtimeline").click(function(e) {
        e.preventDefault();


        // var printContents = document.getElementById('timeline').innerHTML;
        // var originalContents = document.body.innerHTML;

        // document.body.innerHTML = printContents;

        window.print();

        // document.body.innerHTML = originalContents;

    });




    $(".scrollto").click(function (){
        from = $(this).offset().top;
        to   = $( $(this).attr('href') ).offset().top - $('#timeline-filters').height() + 15;
        console.log( to - from );
        $('html, body').animate({
            scrollTop: to
        }, 1000);
    });    

   

    $('ul.timeline li').click(function(event) {
        // $('#timeline').mixItUp('filter', '.technical_consult_'+$(this).data('ctid'));
        
        // console.log( $( 'li.technical_consult_'+$(this).data('id') ) );
    });



    // STICKYTABS
    $('.nav.nav-tabs').stickyTabs();

    var modalscripts = function() {

        /*
            MODAL RELOAD    
        */
        // Remove the data-toggle attribute inside the modals to prevent modals close
        $.each($(".modal [data-target=#modal]"), function(index, val) {
            $(this).removeAttr('data-toggle');
        });

        // Inside the modals, if another modal is called, so open the respective content via AJAX in the same modal opened
        $(".modal [data-target=#modal]").click(function(ev) {

            ev.preventDefault();
            var target = $(this).attr("href");

            $("#modal .modal-dialog .modal-content").html('<p class="text-center well-lg">' + '<span class="fa fa-spinner fa-spin"></span>' + '</p>');
            
            $("#modal .modal-dialog .modal-content").load(target, function() {            
                $("#modal").modal("show");
            }).error(function(data) {
                $("#modal").find('.modal-dialog').html(data).modal("show");
            });;

        });

        //Bootstrap WYSIHTML5 - text editor
        $(".modal textarea.wysihtml5").wysihtml5({
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": false, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": true, //Button to insert an image. Default true,
            "color": false, //Button to change color of font  
            "blockquote": true, //Blockquote  
            "size": 'xs' //default: none, other options are xs, sm, lg
        });

        /* BAR-RATING */
        $('.modal .bar-rating').barrating({            
            theme: 'bars-movie',
            initialRating: null,
            showValues: true,
            showSelectedRating: false,
            reverse: false,
            readonly: false,
            fastClicks: true,
            silent: false,
            wrapperClass: 'br-wrapper',
            hoverState: true,
        });

        // TINYMCE
        tinymce.init({
            selector: 'textarea.tinymce',
            menubar: false,
            toolbar_items_size: 'small',
            height : 300,        
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code paste textcolor'
            ],
            toolbar: 'styleselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
            statusbar: false
        });

    };


    //LIMPA MODALS
    $('body').on('hidden.bs.modal', '#modal', function() {
        $(this).removeData('bs.modal');
        $(this).find('.modal-content').html('<p class="text-center well-lg">' + '<span class="fa fa-spinner fa-spin"></span>' + '</p>');
    });

    $('body').on('show.bs.modal', '#modal', function(event) {

    });

    $('body').on('loaded.bs.modal', '#modal', function() {
        modalscripts();
    });


    /* BAR-RATING */
    $('.bar-rating').barrating({

        // Specify a theme
        theme: 'bars-movie',

        // initial rating
        initialRating: null,

        // display rating values on the bars?
        showValues: true,

        // append a div with a rating to the widget?
        showSelectedRating: false,

        // reverse the rating?
        reverse: false,

        // make the rating ready-only?
        readonly: false,

        // remove 300ms click delay on touch devices?
        fastClicks: true,

        // supress callbacks when controlling ratings programatically
        silent: false,

        // class applied to wrapper div
        wrapperClass: 'br-wrapper',

        // change state on hover?
        hoverState: true,

    });


    // Bootstrap WYSIHTML5 - text editor
    $("textarea.wysihtml5").wysihtml5({
        "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
        "emphasis": true, //Italics, bold, etc. Default true
        "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
        "html": false, //Button which allows you to edit the generated HTML. Default false
        "link": true, //Button to insert a link. Default true
        "image": false, //Button to insert an image. Default true,
        "color": false, //Button to change color of font  
        "blockquote": true, //Blockquote  
        "size": 'sm' //default: none, other options are xs, sm, lg
    });


    // TINYMCE
    tinymce.init({
        selector: 'textarea.tinymce',
        menubar: false,
        toolbar_items_size: 'small',
        height : 300,        
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code paste textcolor'
        ],
        toolbar: 'styleselect | bold italic forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
        statusbar: false
    });


    /* TIMEAGO */
//    $('.timeago').timeago();


    /* Bootstrap Select */
    $('.selectpicker').selectpicker({            
        size: 4
    });


});

/**
 * jQuery Plugin: Sticky Tabs
 *
 * @author Aidan Lister <aidan@php.net>
 * @version 1.2.0
 */
(function($) {
    $.fn.stickyTabs = function(options) {
        var context = this

        var settings = $.extend({
            getHashCallback: function(hash, btn) {
                return hash
            }
        }, options);

        // Show the tab corresponding with the hash in the URL, or the first tab.
        var showTabFromHash = function() {
            var hash = window.location.hash;
            var selector = hash ? 'a[href="' + hash + '"]' : 'li.active > a';
            $(selector, context).tab('show');
        }

        // We use pushState if it's available so the page won't jump, otherwise a shim.
        var changeHash = function(hash) {
            if (history && history.pushState) {
                history.pushState(null, null, '#' + hash);
            } else {
                scrollV = document.body.scrollTop;
                scrollH = document.body.scrollLeft;
                window.location.hash = hash;
                document.body.scrollTop = scrollV;
                document.body.scrollLeft = scrollH;
            }
        }

        // Set the correct tab when the page loads
        showTabFromHash(context)

        // Set the correct tab when a user uses their back/forward button
        $(window).on('hashchange', showTabFromHash);

        // Change the URL when tabs are clicked
        $('a', context).on('click', function(e) {
            var hash = this.href.split('#')[1];
            var adjustedhash = settings.getHashCallback(hash, this);
            changeHash(adjustedhash);
        });

        return this;

    };

}(jQuery));