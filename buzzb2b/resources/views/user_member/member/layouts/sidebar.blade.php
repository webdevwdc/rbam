<ul class="nav nav-sidebar">
    @if((Session::get('MemberRole') == 'member'))
        <li @if(in_array(Route::current()->getName(), array('member_dashboard'))) {{ "class=active" }} @endif> 
		<a href="{{ URL::route('member_dashboard') }}"> <i class="fa fa-dashboard"></i>Dashboard</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('admin_phone_type','admin_phone_type_create','admin_phone_type_edit'))) {{ "class=active" }} @endif> 	
		<a href="{{ route('member_directory') }} "> <i class="fa fa-phone"></i>Directory</a>
   	    </li>
		
		
	    <li @if(in_array(Route::current('pos-view')->getName(), array('admin_category','admin_category_create','admin_category_edit'))) {{ "class=active" }} @endif> 	
		   <a href="{{route('pos-view')}}"> <i class="fa fa-exchange"></i>Point of sale</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('member_transaction','search-transcation'))) {{ "class=active" }} @endif> 	
		   <a href="{{ URL::route('member_transaction') }}"> <i class="fa fa-exchange"></i>Tansaction</a>
   	    </li>
   	  
		
	    <li @if(in_array(Route::current()->getName(), array('billing','load-cba', 'payment-profile', 'payment-profile-add'))) {{ "class=active" }} @endif> 	
		   <a href="{{URL::route('billing')}}"> <i class="fa fa-exchange"></i>Billing</a>
   	    </li>
		 
	    <li @if(in_array(Route::current()->getName(), array('member_referrals'))) {{ "class=active" }} @endif> 	
		   <a href="{{ URL::route('member_referrals') }}"> <i class="fa fa-users" aria-hidden="true"></i>Referrals</a> 
   	    </li>

   	    <li @if(in_array(Route::current()->getName(),['member_setting','users_setting','address_setting','users_create','address_create','phone_setting','phone_create','cashier_setting','create_cashier_setting'])) {{ "class=active" }} @endif> 	
		  <a href="{{ URL::route('member_setting') }}"> <i class="fa fa-wrench" aria-hidden="true"></i>Settings</a>
   	    </li>

   	    <li @if(in_array(Route::current()->getName(),['switch_member'])) {{ "class=active" }} @endif> 	
		  <a href="{{route('switch_member')}}">
		    <i class="fa fa-user" aria-hidden="true"></i>Switch To Member
		  </a>
   	    </li>
    @endif
</ul>