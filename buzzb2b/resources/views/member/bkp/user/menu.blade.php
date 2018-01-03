<div class="col-xs-12" style="margin-bottom: 20px;">
	<ul class="nav nav-pills sub-pills exchange-users-edit-sub-pills">
		<li role="presentation" class="active"><a href="{{ URL::route('admin_user_edit',$details->id) }}">Details</a></li>
		<li role="presentation" class=""><a href="#">Profile</a></li>
		<li role="presentation" class=""><a href="#">Member Associations</a></li>
		<li role="presentation" class=""><a href="#">Exchange Associations</a></li>
		<li role="presentation" class=""><a href="{{ URL::route('admin_user_address_edit',$details->id) }}">Addresses</a></li>
		<li role="presentation" class=""><a href="{{ URL::route('admin_user_phone_edit',$details->id) }}">Phones</a></li>
	</ul>
</div>