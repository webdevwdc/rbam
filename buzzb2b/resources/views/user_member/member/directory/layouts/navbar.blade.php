<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">

    <div class="container-fluid margin-right-15">
        <div class="navbar-header">
            <a class="navbar-brand bariol-thin" href="#">
		<img src="{{ asset('jacopo_admin/images/logo.png') }}" alt="Buzzb2b" title="BuzzB2B"  />
	    </a>
        <div class="member">
          
         </div>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nav-main-menu">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
        </button>
        </div>

        <div class="collapse navbar-collapse" id="nav-main-menu">
            
            <div class="member">
         
               <a href="{!! URL::route('member_dashboard') !!}" class="test">Dashboard</a> 
                @if(Session::get('IS_ADMIN') == 1)
                    | 
                    <a href="{{route('pos-view')}}" class="test">Point Of Sale</a>
                @endif 
                
             </div>
            <div class="navbar-nav nav navbar-right">
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdown-profile">
                        @if(!empty(\Auth::user()->image))
			            <img src="{{ URL::asset('upload/members/'.\Auth::user()->image) }}" width="20">
                        @else
                        <img src="{{ URL::asset('upload/user.png') }}" width="20">
                        @endif
                        <span id="nav-email">{{ \Auth::user()->first_name.' '.\Auth::user()->last_name }}</span> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fa fa-user"></i> My Account</a></li>
                        <li class="divider"></li>

                        <li>
                        <a href="{!! URL::route('member_logout') !!}"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </div>
        </div>
    </div>
</div>