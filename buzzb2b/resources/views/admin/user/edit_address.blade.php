@extends('admin.layouts.base-2cols')
@section('title', 'Edit : User Address')
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
						<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> User</h3>
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
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_member_associations_edit',$addressable_id) }}">Member Associations</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_exchange_associations_edit',$addressable_id) }}">Exchange Associations</a></li>
								<li role="presentation" class="active"><a href="{{ URL::route('admin_user_address_edit',$addressable_id) }}">Addresses</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_phone_edit',$addressable_id) }}">Phones</a></li>
							</ul>
						</div>	
					</div>
				</div>
				<div class="row address-edit">
					<div class="col-lg-10 col-md-3 col-sm-9" style="text-align:right;">
						<a href="{{ URL::route('admin_user') }}" class="btn btn-warning">Back to Users</a>
					</div>
					<div class="col-lg-2 col-md-3 col-sm-3">
						<a href="{{ URL::route('admin_user_address_update',$addressable_id) }}" class="btn btn-success" title="Add New Address">
							<i class="fa fa-plus"></i> Add New
						</a>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th>User Address</th>
										<th style="text-align: center;">Default</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@if(is_object($details) && count($details)>0)
										@foreach($details as $dtls)
											<tr>
												<td>
													<p></p>
													<address>
														{{$dtls->address1}}, @if($dtls->address2) {{ $dtls->address2 }} @endif <br> {{ $dtls->city }}, {{$dtls->map_state_address->abbrev }}, {{ $dtls->zip }}
													</address>
													<p></p>
												</td>
												<td style="text-align: center;">
													@if($dtls->is_default == 'Yes')
														<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
													@else
														<a href="{{URL::route('admin_user_address_default',[$dtls->id,$dtls->addressable_id])}}" class="btn btn-primary" title="Make Default">Make Default</a>
													@endif
												</td>
												<td style="text-align: center;">
													@if($dtls->is_default == 'Yes')
														<button type="button" class="btn btn-danger" disabled="disabled">Delete</button>
													@else
														<a href="{{ URL::route('admin_user_address_delete',[$dtls->id,$dtls->addressable_id]) }}" class="btn btn-danger" title="Delete Address" onclick="return confirm('Do you want to delete this record?');">
															Delete
														</a>
													@endif
												</td>
											</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div> 
					</div>
				</div>
			</div>
		</div>    			
	</div>
</div>
@endsection 