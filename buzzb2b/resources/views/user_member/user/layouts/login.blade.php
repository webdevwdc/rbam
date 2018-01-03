{{-- Layout base admin panel --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>BuzzB2B Administrator - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600' rel='stylesheet' type='text/css'>	
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,300italic,500' rel='stylesheet' type='text/css'>

	{!! Html::style('jacopo_admin/css/bootstrap.min.css') !!}
	{!! Html::style('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css') !!}
	{!! Html::style('jacopo_admin/css/fonts.css') !!}	
        {!! Html::style('jacopo_admin/css/style.css') !!}
	<script>
	var BASE_URL = "{{ URL::to('/') }}/admin/";
	var CSRF_TOKEN = "{{ csrf_token() }}";
	</script	
    @yield('head_css')
    {{-- End head css --}}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

    <body>
    
    <div class="login_main"> 
        @yield('content')
    </div>
        
        @yield('before_footer_scripts')
        {!! Html::script('jacopo_admin/js/vendor/jquery-1.10.2.min.js') !!}
	{!! Html::script('jacopo_admin/js/jquery.validate.min.js') !!}
        {!! Html::script('jacopo_admin/js/vendor/bootstrap.min.js') !!}
	{!! Html::script('jacopo_admin/js/custom_script.js') !!}
        @yield('footer_scripts')
       
    </body>
</html>