$(document).ready(function($) {

    // Instantiate MixItUp:
    $('.timeline').mixItUp({
        layout: {
            display: 'block'
        },
        callbacks: {
            onMixEnd: function(state){                                
                if( state.activeSort == "ctid:desc" ){
                    $('#timeline li .timeline-date').show(); 
                    var ctID;
                    $('ul#timeline li.mix').each(function(index, el) {

                        if( ctID == $(el).data('ctid') ){                            
                            $(el).find('hr').hide();
                        }else{                            
                            $(el).find('hr').show();
                        }
                        ctID = $(el).data('ctid');
                    }); 
                }else{
                    var messageDate;
                    $('ul#timeline li.mix').each(function(index, el) {

                        if( messageDate == $(el).data('date') ){                            
                            $(el).find('.timeline-date').hide();        
                        }else{                            
                            $(el).find('.timeline-date').show();
                        }
                        messageDate = $(el).data('date');
                    });                    
                }               

            },
            onMixStart: function(state, futureState){
                $('#timeline li .timeline-date').hide(); 
                $('#timeline li > hr').hide(); 
            }
        }
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

    // Timeline Sticky Filters
    $('#timeline-filters').affix({
        offset: {
            top: $('#timeline-filters').offset().top
        }
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
        $('#timeline').mixItUp('filter', '.technical_consult_'+$(this).data('ctid'));
        console.log( $( 'li.technical_consult_'+$(this).data('id') ) );
    });

    /* ANGULAR */
    var buildCreateTechnicalConsultForm = function(){
        
        var loadClients = function(){
            /* Act on the event */
            $.ajax({                
                url: '/api/clients/',
                type: 'GET',
                dataType: 'json',
                data: '',
                beforeSend: function() {

                    $('.technical_consult_client').slideUp();
                    $('.technical_consult_contact').slideUp();
                    $('.technical_consult_project').slideUp();
                    $('.technical_consult_project_stage').slideUp();
                    $('.technical_consult_project_discipline').slideUp();

                    $('#technical_consult_client').html('');
                    $('#technical_consult_contact').html('');
                    $('#technical_consult_project').html('');
                    $('#technical_consult_project_stage').html('');
                    $('#technical_consult_project_discipline').html('');            

                    $('.loading.hidden').removeClass('hidden'); 
                }
            })      
            .done(function( data ) {
                $.each(data, function(index, val) {                         
                    $('#technical_consult_client').append('<option value="'+val.id+'">'+val.name+'</option>');
                });
                $('.technical_consult_client').slideDown();
                $('.loading').addClass('hidden');
                loadContacts( $('#technical_consult_client').val() );
                loadProjects( $('#technical_consult_client').val() );
            })
            .fail(function() {
                $('#technical_consult_client').html('<option value="">Erro ao carregar clientes</option>');
            });
        };  



        var loadContacts = function(client_id){
            /* Act on the event */
            $.ajax({                
                url: '/api/clients/'+client_id+'/contacts',
                type: 'GET',
                dataType: 'json',
                data: '',
                beforeSend: function() {
                        
                    $('.technical_consult_contact').slideUp();
                    $('#technical_consult_contact').html('');

                    $('.loading.hidden').removeClass('hidden'); 
                }
            })      
            .done(function( data ) {
                $.each(data, function(index, val) {                         
                    $('#technical_consult_contact').append('<option value="'+val.id+'">'+val.name+'</option>');
                });
                $('.technical_consult_contact').slideDown();            
                $('.loading').addClass('hidden');               
            })
            .fail(function() {
                $('#technical_consult_contact').html('<option value="">Erro ao carregar contatos</option>');
            });
        };  


        var loadProjects = function( client_id ){
            /* Act on the event */
            $.ajax({                
                url: '/api/clients/' + client_id + '/projects',
                type: 'GET',
                dataType: 'json',
                data: '',
                beforeSend: function() {
                    $('.technical_consult_project').slideUp();
                    $('.technical_consult_project_stage').slideUp();
                    $('.technical_consult_project_discipline').slideUp();

                    $('#technical_consult_project').html('');   
                    $('#technical_consult_project_stage').html(''); 
                    $('#technical_consult_project_discipline').html('');

                    $('.loading.hidden').removeClass('hidden'); 
                }
            })      
            .done(function( data ) {
                
                $.each(data, function(index, val) {                         
                    $('#technical_consult_project').append('<option value="'+val.id+'">'+val.title+'</option>');
                });

                $('.technical_consult_project').slideDown();

                loadProjectStages( $('#technical_consult_client').val(), $('#technical_consult_project').val() );       
                loadProjectDisciplines( $('#technical_consult_client').val(), $('#technical_consult_project').val() );

                $('.loading').addClass('hidden');   

            })
            .fail(function() {
                $('#technical_consult_project').html('<option value="">Erro ao carregar projetos</option>');
            });
        };



        var loadProjectStages = function( client_id, project_id ){
            /* Act on the event */
            $.ajax({                
                url: '/api/clients/' + client_id + '/projects/' + project_id + '/stages',
                type: 'GET',
                dataType: 'json',
                data: '',
                beforeSend: function() {    
                    $('.technical_consult_project_stage').slideUp();                                    
                    $('#technical_consult_project_stage').html('');                         
                    $('.loading.hidden').removeClass('hidden'); 
                }
            })      
            .done(function( data ) {
                
                $.each(data, function(index, val) {                         
                    $('#technical_consult_project_stage').append('<option value="'+val.id+'">'+val.title+'</option>');
                });
                
                $('.technical_consult_project_stage').slideDown();          

                $('.loading').addClass('hidden');   
            })
            .fail(function() {
                $('#technical_consult_project_stage').html('<option value="">Erro ao carregar etapas do projeto</option>');
            });

        };


        var loadProjectDisciplines = function( client_id, project_id ){
            /* Act on the event */
            $.ajax({                
                url: '/api/clients/' + client_id + '/projects/' + project_id + '/disciplines',
                type: 'GET',
                dataType: 'json',
                data: '',
                beforeSend: function() {    
                    $('.technical_consult_project_discipline').slideUp();               
                    $('#technical_consult_project_discipline').html('');            
                    $('.loading.hidden').removeClass('hidden'); 
                }
            })      
            .done(function( data ) {
                
                $.each(data, function(index, val) {                         
                    $('#technical_consult_project_discipline').append('<option value="'+val.id+'">'+val.title+'</option>');
                });
                $('#technical_consult_project_discipline').append('<option>-- Nenhuma --</option>');
                
                $('.technical_consult_project_discipline').slideDown();         

                $('.loading').addClass('hidden');   
            })
            .fail(function() {
                $('#technical_consult_project_discipline').html('<option value="">Erro ao carregar disciplinas do projeto</option>');
            });
        };
                        
        $('#technical_consult_client').change(function(event) {     
            loadProjects( $(this).val() );
            loadContacts( $(this).val() );
        });
        $('#technical_consult_project').change(function(event) {
            loadProjectStages( $('#technical_consult_client').val(), $(this).val() );       
            loadProjectDisciplines( $('#technical_consult_client').val(), $(this).val() );      
        });
        loadClients();
        // loadContacts( $('#technical_consult_client').val() );
    };
	
	
	buildCreateTechnicalConsultForm();



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
            $("#modal .modal-dialog .modal-content").html('<p class="text-center well-lg">' + '<span class="fa fa-spinner fa-spin"></span>' + '</p>');

            var target = $(this).attr("href");

            $("#modal .modal-dialog .modal-content").load(target, function() {
                $("#modal").modal("show");
            }).error(function(data) {
                $("#modal").find('.modal-content').html(data).modal("show");
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
            selector: 'textarea',
            height: 500,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            content_css: [
                '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
                '//www.tinymce.com/css/codepen.min.css'
            ]
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
        buildCreateTechnicalConsultForm();
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


    //Bootstrap WYSIHTML5 - text editor
    // $("textarea.wysihtml5").wysihtml5({
    //     "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
    //     "emphasis": true, //Italics, bold, etc. Default true
    //     "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
    //     "html": false, //Button which allows you to edit the generated HTML. Default false
    //     "link": true, //Button to insert a link. Default true
    //     "image": true, //Button to insert an image. Default true,
    //     "color": false, //Button to change color of font  
    //     "blockquote": true, //Blockquote  
    //     "size": 'xs' //default: none, other options are xs, sm, lg
    // });


    // TINYMCE
    tinymce.init({
        selector: 'textarea',
        height: 500,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste code'
        ],
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        content_css: [
            '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
            '//www.tinymce.com/css/codepen.min.css'
        ]
    });


    /* TIMEAGO */
    $('.timeago').timeago();


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