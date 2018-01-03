@extends('admin.layouts.base-2cols')
@section('title', 'Edit : Member Associations')
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
						<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> Member Associations</h3>
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
								<li role="presentation"  class="active"><a href="{{ URL::route('admin_user_member_associations_edit',$addressable_id) }}">Member Associations</a></li>
								<li role="presentation" class=""><a href="{{ URL::route('admin_user_exchange_associations_edit',$addressable_id) }}">Exchange Associations</a></li>
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
									@if(is_object($details[0]->members) && count($details[0]->members)>0)
										@foreach($details[0]->members as $record)
											
											<tr>
											       <td><a href="{{ URL::route('admin_member_user_edit', $record->id) }}">{{ $record->name }}</a></td>
												<td>
													@if($record->pivot->primary)
														<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
													@else
														--
													@endif
												</td>
								
												<td>
													@if($record->pivot->primary)
														<span class="glyphicon glyphicon-ok text-muted" aria-hidden="true"></span>
													@elseif($record->pivot->admin)
														<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
													@else
														--
													@endif
												</td>
								
												<td>
													@if($record->pivot->primary || $record->pivot->admin)
														<span class="glyphicon glyphicon-ok text-muted" aria-hidden="true"></span>
													@elseif($record->pivot->can_access_billing)
														<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
													@else
														--
													@endif
												</td>
								
												<td>
													@if($record->pivot->primary || $record->pivot->admin)
														<span class="glyphicon glyphicon-ok text-muted" aria-hidden="true"></span>
													@elseif($record->pivot->can_pos_sell)
														<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
													@else
														--
													@endif
												</td>
								
												<td>
													@if($record->pivot->primary || $record->pivot->admin)
														<span class="glyphicon glyphicon-ok text-muted" aria-hidden="true"></span>
													@elseif($record->pivot->can_pos_purchase)
														<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
													@else
														--
													@endif
												</td>
												<td>
													@if($record->pivot->monthly_trade_limit)
														{{ $record->pivot->monthly_trade_limit }}
													@else
														--
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