<ul class="nav peos-sidebar">

	{{-- <h1>&nbsp;</h1> --}}

	@yield('sidebar-header')

	@yield('sidebar-links')

	<li><hr /></li>

	@yield('sidebar-bottom-links')

	@if($currentUser)
		<li role="presentation"><a href="{{ route('user.session.destroy') }}">Sign Out</a></li>
	@endif

</ul>

    
<script>
    var HTTP_HOST = "<?php echo $_SERVER['HTTP_HOST'];?>";

    $('.showcity').click(function(){
        
        var url = "{{ route('city.getcity') }}";
    	$.ajax({
		url:url,
		type:"POST",
		success:function(msg){
                //alert(msg);
                    var obj = $.parseJSON(msg);
                    
                    console.log(obj);
                    
                    var htmlli = "";
                    $.each( obj, function( key, value ) {
                    htmlli += value.value;
                    //htmlli += '<li class="list-group-item"><h3><a href="{{ route('directory.exchange.index', '337la' ) }}"> 337la</h3></li>';
                    /*
                        if (HTTP_HOST == value.domain+"dedicatedresource.net") {
                            htmlli += '<li class="list-group-item"><h3><a href="'+value.domain+'/dedicatedresource.net'+'"><strong>'+value.name+'</strong></a> (selected)</a></h3></li>';       
                        }else{
                            htmlli += '<li class="list-group-item"><h3><a href="/'+value.domain+'">'+value.city_name+'</h3></li>';
                         }
                      
                      */
                    });
                    $('.concatli').html(htmlli);
		}
	});
        $("#EnSureModal").modal();
    });
  </script>