@extends('admin.layouts.base-2cols')
@section('title', 'Staff List')
@section('content')
    
		<div class="row">    
	     <div class="col-md-12">
	
			        {{-- messages section start--}}
			        @include('admin.includes.messages')
				    {{-- messages section end--}}
	
		            {{-- user lists --}}
		
                <div class="panel panel-info">
				    <div style="text-align: center;">
						@if(Session::has('succmsg'))
						    <span style="color:green">{{ Session::get('succmsg') }}</span>
						@endif
						@if(Session::has('errmsg'))
						    <span style="color:red">{{ Session::get('errmsg') }}</span>
						@endif			
				    </div>
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> Staff List</h3>
                    </div>
                    <div class="panel-body">
		    
						<div class="col-md-12 col-xs-12">
							<div class="row">
								<div class="col-md-12"><!-- password_confirmation text field -->
									
									{{-- messages section start--}}
									@include('admin.includes.settings_tab')
									{{-- messages section end--}}
								</div>	
							</div>
						</div>
			
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <a href="{!! URL::route('admin_setting_staffs_create') !!}" class="btn btn-info" title="Add New Address"><i class="fa fa-plus"></i> Add New</a>
                            </div>
				
				
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                              @if(!empty($lists))
                              <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Email</th>
											<th>Name</th>
											<th>Primary Contact</th>
											<th>Exchange Admin</th>
											<th>Member Admin</th>
											<th>Can View Accounting</th>
											<th>Salesperson</th>						
                                            <th></th>
                                        </tr>
                                    </thead>
                            <tbody>
                             
                             @foreach($lists as $record)
                                <tr>
					                <td>
					                	<a href="{{ URL::route('admin_setting_staffs_edit',$record->user_id) }}">{{ $record->user->email }}</a>
					                </td>
                                    <td>{{ $record->user->first_name }} {{ $record->user->last_name }}</td>
					               <td>
					                @if(count($record->primary)>0) 
					                  <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
					                @endif
					               </td>
					                <td>
						                @if( count($record->primary || $record->is_exchange_admin)) 
						                <i class="fa fa-check" aria-hidden="true" style="color:green;"></i> 
						                @endif
					                </td>
					               <td>
						                @if( count($record->is_member_admin || $record->is_exchange_admin || $record->primary)) 
						                <i class="fa fa-check" aria-hidden="true" style="color:green;"></i> 
						                @endif
					               </td>
					               <td>
						               @if( count($record->can_view_accounting || $record->is_exchange_admin || $record->primary))
						               <i class="fa fa-check" aria-hidden="true" style="color:green;"></i> 
						               @endif
					               </td>
					                <td>
						                @if(count($record->is_salesperson || $record->is_exchange_admin || $record->primary))
						                <i class="fa fa-check" aria-hidden="true" style="color:green;"></i> 
						                @endif
					                </td>
                                   <td>
                                    @if( $record->user->is_admin==0)
                                    <a href="{{route('admin.makeAdmin',$record->id)}}" class="margin-left-5 delete" title="Make Admin">
                                    <i class="fa fa-user"></i>
                                    </a>
                                    @endif
                                    @if( $record->user->is_admin==1)
                                    <a href="{{route('admin.makeAdmin',$record->id)}}" class="margin-left-5 delete" title="Remove Admin">
                                    <i class="fa fa-user" style="color: green"></i>
                                    </a>
                                    @endif
		                           @if(!$record->primary) 

                                    <a href="{!! URL::route('admin_staff_delete',['id' => $record->id, '_token' => csrf_token()]) !!}" class="margin-left-5 delete" title="Delete Staff" onclick="return confirm('Are you want to delete this staff?')">
                                    <i class="fa fa-trash-o fa-2x"></i>
                                    </a>
                                   @endif
                                  
					               </td>
                                 </tr>
                            </tbody>
                                @endforeach

                              </table>
                              
                              @else
                                  <span class="text-warning"><h5>Oops! Looks like you have no users... <a href="{{ URL::route('admin_setting_staffs_create') }}">Create one now.</a></h5></span>
                              @endif
                          </div>
                      </div>
                    </div>
                </div>
	         </div>
		</div>
    
@endsection 