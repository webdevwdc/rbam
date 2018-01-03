<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <div class="container-fluid margin-right-15">
        <div class="navbar-header">
            <a class="navbar-brand bariol-thin" href="#">
		          <img src="{{ asset('jacopo_admin/images/logo.png') }}" alt="Buzzb2b" title="BuzzB2B"  />
	          </a>
          <div class="member">
          @php $member = Request::segment(1);@endphp
           @if($member =='member') 
           <style type="text/css"> .test{color: #1a393a !important;</style>
           @endif
            @if($member =='admin') 
             <style type="text/css"> .test2{color: #1a393a !important;</style>
           @endif
           @if($member == 'pos')
            <style type="text/css"> .pos{color: #1a393a !important;</style>
           @endif
          <a href="{!! URL::route('member') !!}" class="test">Member</a> | 
          <a href="{{route('pos')}}" class="pos" >Point Of Sale</a> | 
          <a href="{!! URL::route('admin_dashboard') !!}" class="test2">Admin</a>   
         </div>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-main-menu">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="nav-main-menu">
            
            <div class="navbar-nav nav navbar-right">
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdown-profile">
			            <img src="{{ URL::asset('jacopo_admin/images/'.\Auth::guard('admin')->user()->image) }}" width="20">
                        <span id="nav-email">{{ \Auth::guard('admin')->user()->first_name.' '.\Auth::guard('admin')->user()->last_name }}</span> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
		    
			             <li><a href="{!! URL::route('admin-manage-account') !!}"><i class="fa fa-user"></i> My Account</a></li>
			             <li class="divider"></li>
			    
			                 <li>
                            <a href="{!! URL::route('admin_logout') !!}"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </div>
        </div>
    </div>
</div>