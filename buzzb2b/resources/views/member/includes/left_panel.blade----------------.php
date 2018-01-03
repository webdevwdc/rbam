<nav class="navbar-aside navbar-static-side ">
    <div class="sidebar-collapse nano">
        <div class="nano-content">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown side-profile text-left">
                        <span style="display: block;">
                            <img alt="image" class="img-circle" src="{{ asset('admin_assets/images/avtar-1.jpg') }}" width="40">
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear" style="display: block;"> <span class="block m-t-xs"> <strong class="font-bold">John Doe  <b class="caret"></b></strong></span></span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="#"><i class="fa fa-user"></i>My Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><i class="fa fa-key"></i>Logout</a></li>
                        </ul>
                    </div>
                </li>
                <li class="active">
                    <a href="{{ URL::route('admin_dashboard') }}"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard </span></a>
                </li>             
                <li>
                    <a href="{{ URL::route('admin_customer_list') }}"><i class="fa fa-users"></i> <span class="nav-label">Customers </span></a>       
                </li>                
            </ul>
        </div>
    </div>
</nav>