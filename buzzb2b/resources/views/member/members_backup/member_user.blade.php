@extends('admin.layouts.base-2cols')
@section('title', 'Member User')
@section('content')
    
<div class="row">    
	<div class="col-md-12">
	
        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
		{{-- user lists --}}
		
                <div class="panel panel-info">
		    
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> Member User</h3>
                    </div>
			
		    
                    <div class="panel-body">
		    
			<div class="col-md-12 col-xs-12">
				<div class="row">
					<div class="col-md-12"><!-- password_confirmation text field -->
						@include('admin.includes.member_edit_tab')
					</div>	
				</div>
			</div>
			
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <a href="{!! URL::route('admin_member_user_create',$member->id) !!}" class="btn btn-info" title="Add New"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                              @if($lists->count())
                              <table class="table table-hover">
                                    <thead>
                                        <tr>
						<th>Email</th>
						<th>Name</th>
						<th>Bartercard#</th>
						<th>Primary Contact</th>	
						<th>Admin</th>
						<th>Billing Access</th>
						<th>Sales Access</th>
						<th>Purchase Access</th>
						<th>Monthly Trade Limit</th>	
						<th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                      @foreach($lists as $record)
                                          <tr>
						<td><a href="{!! URL::route('admin_member_user_edit', ['id' => $member]) !!}" >{{ $record->email }}</a></td>
						<td>{{ $record->first_name }} {{ $record->last_name }}</td>
						<td></td>
						<td>
							@if($record->members[0]->pivot->primary)
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							@else
								--
							@endif							
						</td>		
						<td>
							@if($record->members[0]->pivot->primary)
								<span class="glyphicon glyphicon-ok text-muted" aria-hidden="true"></span>
							@elseif($record->members[0]->pivot->admin)
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							@else
								--
							@endif
						</td>
		
						<td>
							@if($record->members[0]->pivot->primary || $record->members[0]->pivot->admin)
								<span class="glyphicon glyphicon-ok text-muted" aria-hidden="true"></span>
							@elseif($record->members[0]->pivot->can_access_billing)
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							@else
								--
							@endif
						</td>
		
						<td>
							@if($record->members[0]->pivot->primary || $record->members[0]->pivot->admin)
								<span class="glyphicon glyphicon-ok text-muted" aria-hidden="true"></span>
							@elseif($record->members[0]->pivot->can_pos_sell)
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							@else
								--
							@endif
						</td>
		
						<td>
							@if($record->members[0]->pivot->primary || $record->members[0]->pivot->admin)
								<span class="glyphicon glyphicon-ok text-muted" aria-hidden="true"></span>
							@elseif($record->members[0]->pivot->can_pos_purchase)
								<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
							@else
								--
							@endif
						</td>
						<td>
							@if($record->members[0]->pivot->monthly_trade_limit)
								{{ $record->members[0]->pivot->monthly_trade_limit }}
							@else
								--
							@endif
						</td>
							<td>
							@if(!isset($record->bartercard))
							<a class="btn btn-primary issue_bartercard" title="Issue Bartercard" data-toggle="modal" data-user-id="{{ $record->id }}" data-member-id="{{ $member_id }}"><i class="fa fa-credit-card"></i>
								Issue Bartercard</a>

							<a href="{!! URL::route('admin_member_user_delete',$record->id) !!}" onclick="return confirm('Are you sure want to delete this record')" class="btn btn-danger" title="Delete"><i class="fa fa-times"></i>
								Delete</a>									
							@endif
							
	
							</td>
                                          </tr>
                                      </tbody>
                                      @endforeach

                              </table>
                              
                              @else
                                  <span class="text-warning"><h5>No results found.</h5></span>
                              @endif
                          </div>
                      </div>
                    </div>
                </div>
                
                
	</div>
</div>
	
	
<!-- Modal start for issue bartercard -->
<div id="issuebartercard" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Issue Bartercard</h4>
			<h5>You are about to issue this user a bartercard. Are you sure you want to do this?</h5>
			<div id="msg-section"></div> 
      </div>
      <div class="modal-body">
    <input type="hidden" name="member_id" id="member_id">
	<input type="hidden" name="user_id" id="user_id">
    <div class="form-group">
	    <label class="col-sm-4 control-label">Bartercard #</label>
	    <div class="col-sm-6">
		    {{ Form::text('barter_card', 20, ['id'=>'barter_card', 'class' => 'form-control required']) }}
	    </div>
    </div>
    

	<div class="row"></div>

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      	<button type="button" id="btn_issue_bartercard" class="btn btn-default">Issue bartercard</button>			
      </div>

    </div>

  </div>
</div>
<!-- Modal end for issue bartercard -->	
    
@endsection 