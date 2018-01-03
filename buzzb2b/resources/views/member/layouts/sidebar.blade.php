<ul class="nav nav-sidebar">
@if((Session::get('ADMIN_ACCESS_ROLE') == 'admin'))
            <li @if(in_array(Route::current()->getName(), array('member'))) {{ "class=active" }} @endif> 	
		<a href="{{ URL::route('member') }}"> <i class="fa fa-dashboard"></i>Dashboard</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('admin_phone_type','admin_phone_type_create','admin_phone_type_edit'))) {{ "class=active" }} @endif> 	
		<a href="{{ route('member-directory') }}"> <i class="fa fa-phone"></i>Directory</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('pos'))) {{ "class=active" }} @endif> 
		   <a href="{{route('pos')}}"> <i class="fa fa-exchange"></i>Point of sale</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('transaction','search-transcation','admin-member-search-transcation'))) {{ "class=active" }} @endif> 	
		   <a href="{{ URL::route('transaction') }}"> <i class="fa fa-exchange"></i>Transaction</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('member-billing','member-load-cba'))) {{ "class=active" }} @endif> 	
		   <a href="{{URL::route('member-billing')}}"> <i class="fa fa-exchange"></i>Billing</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('referrals'))) {{ "class=active" }} @endif> 	
		   <a href="{{ URL::route('referrals') }}"> <i class="fa fa-users" aria-hidden="true"></i>Referrals</a> <!--  -->
   	    </li>

   	    <li @if(in_array(Route::current()->getName(), array('member-setting','users-setting','users-address','users-phone','users-create-address','users-create-cashiers','users-create-phone','users-cashiers'))) {{ "class=active" }} @endif> 	
		  <a href="{{ URL::route('member-setting') }}"> <i class="fa fa-wrench" aria-hidden="true"></i>Settings</a>
   	    </li>
	    <li @if(in_array(Route::current()->getName(), array('switch-member'))) {{ "class=active" }} @endif> 	
		   <a href="{{route('switch-member')}}"> <i class="fa fa-exchange"></i>Switching Member</a>
   	    </li>
@endif
</ul>