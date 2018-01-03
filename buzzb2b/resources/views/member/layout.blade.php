<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Buzzb2b Sites - Administrator Panel | @yield('title')</title>

        <!-- Bootstrap -->
        <link href="{{ asset('admin_assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin_assets/css/waves.min.css') }}" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('admin_assets/css/nanoscroller.css') }}">
        <link href="{{ asset('admin_assets/css/morris-0.4.3.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin_assets/css/menu-light.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('admin_assets/css/style.css') }}" type="text/css" rel="stylesheet">
        <link href="{{ asset('admin_assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">


        <link href="{{ asset('admin_assets/css/app.min.1.css') }}" rel="stylesheet">
        <link href="{{ asset('admin_assets/css/fullcalendar.min.css') }}" rel="stylesheet">

        <link href="{{ asset('admin_assets/css/themify-icons.css') }}" rel="stylesheet">
        <link href="{{ asset('admin_assets/css/color.css') }}" rel="stylesheet">
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="pace-done red dark">
        <!-- Static navbar -->

        <nav class="navbar navbar-default yamm navbar-fixed-top">
            <div class="container-fluid">
                <button type="button" class="navbar-minimalize minimalize-styl-2  pull-left "><i class="fa fa-bars"></i></button>

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ URL::route('admin_dashboard') }}">   Mahogany Sites</a><i class="fa fa-caret-left" aria-hidden="true"></i>
                </div>
                
            </div><!--/.container-fluid -->
        </nav>
        <section class="page">
            @include('admin.includes.left_panel')

            <div id="wrapper">
                @yield('content')
            </div>
        </section>

        <script type="text/javascript" src="{{ asset('admin_assets/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('admin_assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('admin_assets/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('admin_assets/js/jquery.nanoscroller.min.js') }}"></script>
        <script src="{{ asset('admin_assets/js/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <!-- Flot -->
        <script src="{{ asset('admin_assets/js/flot/jquery.flot.js') }}"></script>
        <script src="{{ asset('admin_assets/js/flot/jquery.flot.tooltip.min.js') }}"></script>
        <script src="{{ asset('admin_assets/js/flot/jquery.flot.resize.js') }}"></script>
        <script src="{{ asset('admin_assets/js/flot/jquery.flot.pie.js') }}"></script>
        <script src="{{ asset('admin_assets/js/flot/curved-line-chart.js') }}"></script>
        <script src="{{ asset('admin_assets/js/chartjs/Chart.min.js') }}"></script>
        <script src="{{ asset('admin_assets/js/pace.min.js') }}"></script>
        <script src="{{ asset('admin_assets/js/waves.min.js') }}"></script>
        <script src="{{ asset('admin_assets/js/morris_chart/raphael-2.1.0.min.js') }}"></script>
        <script src="{{ asset('admin_assets/js/morris_chart/morris.js') }}"></script>
        <script src="{{ asset('admin_assets/js/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('admin_assets/js/jquery-jvectormap-world-mill-en.js') }}"></script>

        <!--<script src="js/jquery.nanoscroller.min.js"></script>-->
        <script type="text/javascript" src="{{ asset('admin_assets/js/custom.js') }}"></script>
        <!-- ChartJS-->
        <script src="{{ asset('admin_assets/js/chartjs/Chart.min.js') }}"></script>

        <!--page js-->
        <script src="{{ asset('admin_assets/js/moment.min.js') }}"></script>

        <script src="{{ asset('admin_assets/js/jquery.simpleWeather.min.js') }}"></script>
        <script src="{{ asset('admin_assets/js/fullcalendar.min.js') }}"></script>

        <script src="{{ asset('admin_assets/js/index.js') }}"></script>
    </body>
</html>
