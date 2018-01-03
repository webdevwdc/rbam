<!DOCTYPE html>

<html lang="en">
<head>
    <title>@yield('title')</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link rel="shortcut icon" type="image/x-icon" href="{{url('landing_page/images/favicon.ico')}}">
     <link href="{{url('landing_page/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
     <link href="{{url('landing_page/css/main.css')}}" rel="stylesheet" type="text/css">
     <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700" rel="stylesheet">
</head>

<body>
    <!-- Header Start -->
    <nav class="navbar navbar-default navbar-fixed-top prosper-navbar" role="navigation">
        <div class="container">
            <div class="navbar-header pull-left">
                <a class="navbar-brand" href="{{route('landing_page')}}">
                    <img src="{{url('landing_page/images/logo.png')}}" alt="" width="70" height="70">
                </a>
            </div>

            

            <ul class="nav navbar-nav navbar-right">
                <li><a class="navbar-top-link" href="tel:+3185888820"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span><span class="link-name">(318) 588-8820</span></a></li>

                <li>
                     <a class="navbar-top-link" href="{{route('giftcard_balance')}}" target="_new">
                         <span class="glyphicon glyphicon-credit-card" aria-hidden="true">
                         </span><span class="link-name">Gift Card</span>
                     </a>
                 </li>
                 
                <li>
                
                @if(Session::has("ADMIN_ACCESS_ROLE"))
                    <li>
                        <a class="navbar-top-link" href="{{route('admin_dashboard')}}" target="_new">
                         <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>
                         <span class="link-name login_hover">Dashboard</span>
                        </a>
                      </li>
                @elseif(!Session::has("ADMIN_ACCESS_ROLE"))
                    @if(Session::get("MemberRole") == 'member')
                    <li>
                        <a class="navbar-top-link" href="{{route('member_dashboard')}}" target="_new">
                         <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>
                         <span class="link-name login_hover">Dashboard</span>
                        </a>
                    </li>
                
                    @elseif(Session::get("MemberRole") == 'user')
                    <li>
                        <a class="navbar-top-link" href="{{route('user_dashboard')}}" target="_new">
                         <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>
                         <span class="link-name login_hover">Dashboard</span>
                        </a>
                    </li>
                    @else

                        <a class="navbar-top-link" href='JavaScript:void(0);' target="_new">
                            <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>
                            <span class="link-name login_hover">Login</span>
                            <ul class="subMenu" id="home">
                               <li><a href="{{route('admin_login')}}">Login as Admin</a></li>
                               <li><a href="{{route('login_dashboard')}}">Login as Member</a></li>      
                            </ul>
                        </a>                        
                    @endif
                        
                @else
                    <a class="navbar-top-link" href='JavaScript:void(0);' target="_new">
                     <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>
                     <span class="link-name login_hover">Login</span>
                        <ul class="subMenu" id="home">
                            <li><a href="{{route('admin_login')}}">Login as Admin</a></li>
                            <li><a href="{{route('login_dashboard')}}">Login as Member</a></li>      
                        </ul>
                    </a>
                @endif
                    
                </li>
                
            </ul>
        </div> <!-- .container -->
    </nav>
    <!-- Header End -->
    @yield('content')
    <div class="container footer-wrap">
        @include('landing_view_page.footer')
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{url('landing_page/js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{url('landing_page/js/bootstrap.js')}}"></script>
    @yield('js')
   
</body>

</html>