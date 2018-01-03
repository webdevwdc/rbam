<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
        <li @if(in_array(Route::current()->getName(), array('admin_setting_finance'))) {{ "class=active" }} @endif>
                <a href="{{ URL::route('admin_setting_finance') }}">Financial Details</a>
        </li>
                
        <li @if(in_array(Route::current()->getName(), array('admin_setting_staffs','admin_setting_staffs_create','admin_setting_staffs_edit'))) {{ "class=active" }} @endif><a href="{{ URL::route('admin_setting_staffs') }}">Staff</a></li>
                
        <li @if(in_array(Route::current()->getName(), array('admin_setting_address', 'admin_exchange_address_create'))) {{ "class=active" }} @endif>
                <a href="{{ URL::route('admin_setting_address') }}">Address</a>
        </li>
                
        <li @if(in_array(Route::current()->getName(), array('admin_setting_phone', 'admin_exchange_phone_create'))) {{ "class=active" }} @endif>
                <a href="{{ URL::route('admin_setting_phone') }}">Phones</a>
        </li>
</ul>