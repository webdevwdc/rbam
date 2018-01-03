@extends('admin.layouts.base-2cols')
@section('title', 'Edit : Exchange Associations')
@section('content')
<div class="row">
	<div class="col-md-12">
		{{-- messages section start--}}
		@include('admin.includes.messages')
		{{-- messages section end--}}
	
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-12">
						<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> Exchange Associations</h3>
					</div>
				</div>
			</div>
		
			<div class="panel-body">
				<div class="col-md-12 col-xs-12">
					<div class="row">
						<div class="col-md-12"><!-- password_confirmation text field -->
							<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_edit',$addressable_id) }}">Details</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_image',$addressable_id) }}">Profile</a></li>
								<li role="presentation"><a href="{{ URL::route('admin_user_member_associations_edit',$addressable_id) }}">Member Associations</a></li>
								<li role="presentation"  class="active"><a href="{{ URL::route('admin_user_exchange_associations_edit',$addressable_id) }}">Exchange Associations</a></li>
								<li role="presentation"><a href="{{ URL::route('admin_user_address_edit',$addressable_id) }}">Addresses</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_phone_edit',$addressable_id) }}">Phones</a></li>
							</ul>
						</div>	
					</div>
				</div>
				<div class="row">
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
						@if(is_object($details) && count($details)>0)
							<table class="table table-hover">
								<thead>
									<tr>
										<th>Member</th>
										<th>Primary Contact</th>
										<th>Admin </th>
										<th>Billing Access </th>
										<th>Sales Access  </th>
										<th>Purchase Access </th>	
										<th>Monthly Trade Limit </th>
									</tr>
								</thead>
								<tbody>
									@if(is_object($details) && count($details)>0)
										@foreach($details as $record)
											
											
										@endforeach
									@endif
								</tbody>
							</table>
											
							@else
								<div class="row">
								<div class="col-md-12">
								<br/>
								This user is not an associated staff member of any exchanges.
								</div>
								</div>
							@endif
														
						</div> 
					</div>
				</div>
			</div>
		</div>    			
	</div>
</div>
@endsection 