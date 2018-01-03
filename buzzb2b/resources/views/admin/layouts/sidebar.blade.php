<ul class="nav nav-sidebar adminSidebarScroll">

@if((Session::get('ADMIN_ACCESS_ROLE') == 'admin'))
        <li @if(in_array(Route::current()->getName(), array('admin_dashboard'))) {{ "class=active" }} @endif> 	
		<a href="{{ URL::route('admin_dashboard') }}"> <i class="fa fa-dashboard"></i>Dashboard</a>
   	    </li>

   	    <li @if(in_array(Route::current()->getName(), array('directory'))) {{ "class=active" }} @endif> 	
		<a href="{{ URL::route('directory') }}"> <i class="fa fa-folder"></i>Directory</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('admin_phone_type','admin_phone_type_create','admin_phone_type_edit'))) {{ "class=active" }} @endif> 
		<a href="{{ URL::route('admin_phone_type') }}"> <i class="fa fa-phone"></i>Phone Type Master</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('admin_category','admin_category_create','admin_category_edit'))) {{ "class=active" }} @endif> 	
		<a href="{{ URL::route('admin_category') }}"> <i class="fa fa-exchange"></i>Category Master</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('admin_exchange','admin_exchange_create','admin_exchange_edit'))) {{ "class=active" }} @endif> 	
		<a href="{{ URL::route('admin_exchange') }}"> <i class="fa fa-exchange"></i>Exchange Master</a>
   	    </li>
		
		<!-- barter card section start -->
		<li @if(in_array(Route::current()->getName(), array('bartercard','add-bartercard','edit-bartercard'))) {{ "class=active" }} @endif> 
		<a href="{{ URL::route('bartercard') }}"> <i class="fa fa-credit-card"></i>Barter Card</a>
   	    </li>
		
		<!-- end barter card section -->


	    <li @if(in_array(Route::current()->getName(), array('admin-search-transcation','admin-date-search-transcation'))) {{ "class=active" }} @endif> 	
		<a href="{{ URL::route('admin-search-transcation') }}"> <i class="fa fa-exchange"></i>Transactions</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('admin_member','admin_member_create','admin_member_edit','admin_member_details','admin_member_address','admin_member_address_create','admin_member_phone','admin_member_phone_create','admin_member_user','admin_member_user_edit','admin_member_settings','admin_user_edit_financial_details','admin_edit_user_account_details','admin_member_user_create','admin_directory_profile'))) {{ "class=active" }} @endif> 	
		<a href="{{ URL::route('admin_member') }}"> <i class="fa fa-exchange"></i>Members</a>
   	    </li>
		
	    <li @if(in_array(Route::current()->getName(), array('admin_user','admin_user_create','admin_user_edit','admin_user_address_edit','admin_user_phone_edit','admin_user_image','admin_user_member_associations_edit','admin_user_exchange_associations_edit', 'admin_user_phone_update'))) {{ "class=active" }} @endif> 	
		<a href="{{ URL::route('admin_user') }}"> <i class="fa fa-users" aria-hidden="true"></i>Users</a>
   	    </li>
		
	    <li  @if(in_array(Route::current()->getName(), array('admin-user-referral-details'))) {{ "class=active" }} @endif>
   	    <a href="{{ URL::route('admin-user-referral-details') }}"> <i class="fa fa-exchange"></i>Referrals</a>	
   	    </li>
		
	    <!-- gift cards -->
   	    <li  @if(in_array(Route::current()->getName(), array('admin-user-gift-card-details','issue-giftcacrd'))) {{ "class=active" }} @endif>
   	    <a href="{{ URL::route('admin-user-gift-card-details') }}"> <i class="fa fa-gift" aria-hidden="true"></i>Giftcards</a>	
   	    </li>
		
	    <li  @if(in_array(Route::current()->getName(), array('admin-reports','admin-reports-traders','admin-search-traders','admin-member-standby','admin-member-show-standby','admin-inter-exchange-trading','admin-search-exchange-traders'))) {{ "class=active" }} @endif>
		<a href="{{ URL::route('admin-reports') }}"> <i class="fa fa-cog" aria-hidden="true"></i></i>Reports</a>
   	    </li>
		
		
	    <li  @if(in_array(Route::current()->getName(), array('admin_setting_finance', 'admin_setting_address', 'admin_exchange_address_create', 'admin_setting_phone', 'admin_exchange_phone_create','admin_setting_staffs','admin_setting_staffs_create','admin_setting_staffs_edit'))) {{ "class=active" }} @endif>
		<a href="{{ URL::route('admin_setting_finance') }}"> <i class="fa fa-cog" aria-hidden="true"></i></i>Settings</a>
   	    </li>

   	    
	    <li @if(in_array(Route::current()->getName(), array('admin_switch_exchange'))) {{ "class=active" }} @endif> 	
		<a href="{{ URL::route('admin_switch_exchange') }}"> <i class="fa fa-exchange"></i>Switching Exchange</a>
   	    </li>

   	    
	    <li @if(in_array(Route::current()->getName(), array('admin_cash_referral'))) {{ "class=active" }} @endif> 	
		<a href="{{ route('admin_cash_referral') }}"> <i class="fa fa-exchange"></i>Cash Referral</a>
   	    </li>
@endif
</ul>