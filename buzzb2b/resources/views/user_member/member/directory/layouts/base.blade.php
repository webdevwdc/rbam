{{-- Layout base admin panel --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600' rel='stylesheet' type='text/css'>	
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,300italic,500' rel='stylesheet' type='text/css'>
	
<!--	{!! Html::style('jacopo_admin/css/font-Open-Sans-italic.css') !!}
	{!! Html::style('jacopo_admin/css/font-Roboto-italic.css') !!}-->
	
	{!! Html::style('jacopo_admin/css/bootstrap.min.css') !!}
	{!! Html::style('jacopo_admin/css/baselayout.css') !!}
	{!! Html::style('jacopo_admin/css/admin_custom.css') !!}
	{!! Html::style('jacopo_admin/css/fonts.css') !!}
	{!! Html::style('//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css') !!}
	{!! Html::style('jacopo_admin/css/vendor/jquery.tagit.css') !!}
	{!! Html::style('jacopo_admin/css/vendor/tagit.ui-zendesk.css') !!}
	{!! Html::style('jacopo_admin/css/style.css') !!}
	{!! Html::style('jacopo_admin/css/custom.css') !!}
	
	{!! Html::script('jacopo_admin/js/jquery.min.js') !!}
	{!! Html::script('jacopo_admin/js/vendor/all.js') !!}
	{!! Html::script('jacopo_admin/js/jquery.cropit.js') !!}
	{!! Html::script('jacopo_admin/js/column.js') !!}

  
	<!--{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js') !!}-->

	<script>
	var BASE_URL = "{{ URL::to('/') }}/admin/";
	var CSRF_TOKEN = "{{ csrf_token() }}";
	var ABSPATH = "{{ asset('')}}";
	</script>
    
    @yield('head_css')
    {{-- End head css --}}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
		
</head>

    <body>
    
        @yield('container')

        
        @yield('before_footer_scripts')
        
	{!! Html::script('jacopo_admin/js/vendor/tinymce.js') !!}	
	{!! Html::script('jacopo_admin/js/jquery-ui.min.js') !!}	
	{!! Html::script('jacopo_admin/js/jquery.validate.min.js') !!}
    {!! Html::script('jacopo_admin/js/vendor/bootstrap.min.js') !!}
	{!! Html::script('jacopo_admin/js/vendor/tag-it.min.js') !!}
	{!! Html::script('jacopo_admin/js/custom_script.js') !!}
	{!! Html::script('jacopo_admin/js/tee_time_admin.js') !!}
        @yield('footer_scripts')
      
	<div class="loaderdiv">
	    <div><img src="{{ asset('jacopo_admin/images/loading.gif')}}" alt=""></div>
	</div>
    </body>
</html>