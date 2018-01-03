<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">

        <li @if(in_array(Route::current()->getName(), array('admin_member_details'))) {{ "class=active" }} @endif">
                <a href="{{ URL::route('admin_member_details', $member->id)}}">Details</a>
        </li>
                
        <li 
           @if(in_array(Route::current()->getName(), array('admin_edit_user_account_details'))) {{ "class=active" }} @endif">
            <a href="{{ URL::route('admin_edit_user_account_details', $member->id) }}">
              Account
            </a>
        </li>
                
        <li 
            @if(in_array(Route::current()->getName(), array('admin_directory_profile'))) {{ "class=active" }} @endif">
            <a href="{{ URL::route('admin_directory_profile', $member->id) }}">
                Directory Profile
            </a>
       </li>
        
        <li @if(in_array(Route::current()->getName(), array('admin_user_edit_financial_details'))) {{ "class=active" }} @endif"><a href="{{ URL::route('admin_user_edit_financial_details', $member->id)}}">Financial</a></li>
                
        <li @if(in_array(Route::current()->getName(), array('admin_member_user', 'admin_member_user_edit'))) {{ "class=active" }} @endif">
                 <a href="{{ URL::route('admin_member_user', $member->id) }}">Users</a>
        </li>
                
        <li @if(in_array(Route::current()->getName(), array('admin_member_address', 'admin_member_address_create'))) {{ "class=active" }} @endif">
                <a href="{{ URL::route('admin_member_address', $member->id)}}">Addresses</a>
        </li>
                
        <li @if(in_array(Route::current()->getName(), array('admin_member_phone', 'admin_member_phone_create'))) {{ "class=active" }} @endif">
                <a href="{{ URL::route('admin_member_phone', $member->id)}}">Phones</a>
        </li>
                
        <li @if(in_array(Route::current()->getName(), array('admin_member_settings'))) {{ "class=active" }} @endif">
                <a href="{{ URL::route('admin_member_settings', $member->id)}}">Settings</a>
        </li>
                                
        
</ul>