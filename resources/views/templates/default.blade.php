<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Consultas Técnicas</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="Developed By Luciano Tonet">
    <meta name="keywords" content="Bootstrap 3, Laravel 5.1, Responsive">
    <!-- bootstrap 3.3.6 -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="{{ asset('css/morris/morris.css') }}" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="{{ asset('css/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- DateTime Picker -->
    <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- fullCalendar -->
    <!-- <link href="{{ asset('css/fullcalendar/fullcalendar.css') }}" rel="stylesheet" type="text/css" /> -->
    <!-- Daterange picker -->
    <link href="{{ asset('css/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="{{ asset('css/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="{{ asset('css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />

    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>

    <!-- Bootstrap Select -->
    <link href="{{ asset('css/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- BAR RATING -->
    <link rel="stylesheet" href="{{ asset('js/barrating/themes/bars-movie.css') }}">

    <!-- Theme style -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom styles -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
  <![endif]-->

  <style type="text/css">

  </style>
</head>
<body class="skin-black" ng-app="mainApp">
    <!-- header logo: style can be found in header.less -->
    <header class="header">
        <a href="{{ url('/') }}" class="logo">
            Consultas Técnicas
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            @if (Auth::check())
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
            @endif

            <div class="navbar-right">
                @if (Auth::check())
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user"></i>
                                <span><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                                <li class="dropdown-header text-center">Minha conta</li>

                                <li>
                                    <a href="{{ url('logout') }}"><i class="fa fa-sign-out fa-fw pull-right"></i> Sair</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="nav nav-pills pull-right">
                        <li>
                            <a class="" href="{{ url('/login') }}">Entrar</a>
                        </li>
                    </ul>
                @endif
            </div>


        </nav>
    </header>
    <div class="wrapper row-offcanvas row-offcanvas-left">
        @if (Auth::check())
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">


                <section class="sidebar">
                <!-- Sidebar user panel -->

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">

                        <li class="{{ Request::is('clientes*') ? 'active' : '' }}">
                            <a href="{!! url('clientes') !!}">
                                <i class="fa fa-user"></i> <span>Clientes</span>
                            </a>
                                @if ( Request::is('clientes*') )
                                <ul>
                                    <li class="{{ Request::is('clientes') ? 'active' : '' }}">
                                        <a href="{!! url('clientes') !!}">Ver todos</a>
                                    </li>
                                    <li class="{{ Request::is('clientes/create') ? 'active' : '' }}">
                                        <a href="{!! url('clientes/create') !!}">Adicionar cliente</a>
                                    </li>
                                </ul>
                                @endif
                        </li>

                        <li class="{{ Request::is('obras*') ? 'active' : '' }}">
                            <a href="{!! url('obras') !!}">
                                <i class="fa fa-building-o"></i> <span>Obras</span>
                            </a>
                                @if ( Request::is('obras*') )
                                <ul>
                                    <li>
                                        <a href="{!! url('obras') !!}">Ver todas</a>
                                    </li>
                                    <li>
                                        <a href="{!! url('obras/create') !!}">Adicionar Obra</a>
                                    </li>
                                </ul>
                                @endif
                        </li>
                        <!-- <li class="{{ Request::is('consultas_tecnicas*') ? 'active' : '' }}">
                            <a href="{!! url('consultas_tecnicas') !!}">
                                <i class="fa fa-check"></i> <span>Consultas Técnicas</span>
                            </a>
                                @if ( Request::is('consultas_tecnicas*') )
                                <ul>
                                    <li>
                                        <a href="{!! url('consultas_tecnicas') !!}">Ver todas</a>
                                    </li>
                                    <li>
                                        <a href="{!! url('consultas_tecnicas/create') !!}">Adicionar Consulta Técnica</a>
                                    </li>
                                </ul>
                                @endif
                        </li> -->
                    </ul>
                </section>
                <!-- /.sidebar -->

            </aside>

        @endif

            <aside class="<?php echo (Auth::check()) ? 'right-side' : ''; ?>">

                <!-- Main content -->
                <section class="content">

                    <!-- System Notifications -->
                    @if(Session::has('sys_notifications'))
                        <div class="alert-group">
                            @foreach ( Session::get('sys_notifications') as $sys_notification )
                                <div class="alert alert-{!! $sys_notification['type'] or 'info' !!}">
                                    @if ( !@$sys_notification['important'] )
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    @endif
                                    {!! $sys_notification['message'] !!}
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <!-- /System Notifications -->

                    @if (Auth::check() && count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif

                    <!-- MAIN CONTENT -->
                        @yield('content')
                    <!-- /MAIN CONTENT -->

                    @include('templates.modal')

                </section><!-- /.content -->

                <div class="footer-main">

                </div>

            </aside><!-- /.right-side -->

        </div><!-- ./wrapper -->

        <!-- jQuery 2.0.2 
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> -->
        <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>

        <!-- jQuery UI 1.10.3 -->
        <script src="{{ asset('js/jquery-ui-1.10.3.min.js') }}" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>

        <script src="{{ asset('js/plugins/chart.js') }}" type="text/javascript"></script>

    <!-- PLUGINS -->

    <!-- DateTime Picker -->
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <!-- DateTime Picker  -->
    <script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}" type="text/javascript"></script>

     <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
    <!-- calendar -->
    <script src="{{ asset('js/plugins/fullcalendar/fullcalendar.js') }}" type="text/javascript"></script>
    <!-- timago -->
    <script src="{{ asset('js/plugins/timeago/jquery.timeago.js') }}" type="text/javascript"></script>
    <!--VALIDATE JS -->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}" type="text/javascript"></script>
    <!--TinySort JS -->
    <script src="{{ asset('js/plugins/tinysort/tinysort.min.js') }}" type="text/javascript"></script>
    <!--Isotope -->
    <script src="{{ asset('js/plugins/isotope/isotope.pkgd.min.js') }}" type="text/javascript"></script>
    <!-- Tinymce -->
    <script src="{{ asset('js/plugins/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
    <!-- jquery.printElement -->
    <script src="{{ asset('js/plugins/printElement/jquery.printElement.min.js') }}" type="text/javascript"></script>
    <!-- Bootstrap Select -->
    <script src="{{ asset('js/plugins/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>



    <!-- Director App -->
    <script src="{{ asset('js/Director/app.js') }}" type="text/javascript"></script>

    <!-- Director dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('js/Director/dashboard.js') }}" type="text/javascript"></script>

    <!-- BAR RATING JS -->
    <script src="{{ asset('js/barrating/jquery.barrating.min.js') }}" type="text/javascript"></script>

    <!-- MixItUp -->
    <script src="{{ asset('js/jquery.mixitup.min.js') }}"></script>

    <!-- MAIN JS -->
    <script src="{{ asset('js/script.js') }}" type="text/javascript"></script>

    <!-- Director for demo purposes -->
    <script type="text/javascript">
    $('input').on('ifChecked', function(event) {
        // var element = $(this).parent().find('input:checkbox:first');
        // element.parent().parent().parent().addClass('highlight');
        $(this).parents('li').addClass("task-done");
        console.log('ok');
    });
    $('input').on('ifUnchecked', function(event) {
        // var element = $(this).parent().find('input:checkbox:first');
        // element.parent().parent().parent().removeClass('highlight');
        $(this).parents('li').removeClass("task-done");
        console.log('not');
    });

    </script>
    <script>
    $('#noti-box').slimScroll({
        height: '400px',
        size: '5px',
        BorderRadius: '5px'
    });

    $('.timelinescroll').innerHeight( window.innerHeight );

    $('input[type="checkbox"].flat-grey, input[type="radio"].flat-grey').iCheck({
        checkboxClass: 'icheckbox_flat-grey',
        radioClass: 'iradio_flat-grey'
    });
    </script>
    <script type="text/javascript">
    $(function() {
        "use strict";
        //BAR CHART
        var data = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [65, 59, 80, 81, 56, 55, 40]
            },
            {
                label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [28, 48, 40, 19, 86, 27, 90]
            }
            ]
        };


    });
    // Chart.defaults.global.responsive = true;
    </script>

    @include('templates.footer')

</body>
</html>