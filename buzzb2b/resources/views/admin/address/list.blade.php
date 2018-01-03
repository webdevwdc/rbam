@extends('admin.layouts.base-2cols')
@section('title', 'Address List')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> Address List</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <a href="{!! URL::route('admin_address_create') !!}" class="btn btn-info" title="Add New Address"><i class="fa fa-plus"></i> Add New</a>
                            </div>
				
				
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                              @if($lists->count())
                              <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="hidden-xs">Address</th>
                              					    <th class="hidden-xs">City Name</th>
                              					    <th class="hidden-xs">State</th>
                              					    <th class="hidden-xs">Zip</th>
                                            <th>Is Default</th>
                                            <th>Action</th>
					                                  <th></th>
                                        </tr>
                                    </thead>
                                      <tbody>

                                      @foreach($lists as $record)
                                      <tr>
					                              <td class="hidden-xs">{{ $record->address1.' '.$record->address2 }}</td>
                                        <td class="hidden-xs">{{ $record->city }}</td>
					                              <td class="hidden-xs">{{ $record->state->name }}</td>
					                              <td class="hidden-xs">{{ $record->zip }}</td>
					                              <td class="hidden-xs">{{ $record->is_default }}</td>
                                        <td>
                                        <a href="{!! URL::route('admin_address_edit', ['id' => $record->id]) !!}" title="Edit Address"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                        
                                        </td>
                            					 <td style="text-align:center;">
                            						@if($record->is_default=='No')
                                        <a href="{!! URL::route('admin_address_delete',['id' => $record->id, '_token' => csrf_token()]) !!}" class="margin-left-5 delete" title="Delete Address" onclick="return confirm('Are you want to delete this address?')"><i class="fa fa-trash-o fa-2x"></i></a>
                            						<a href="{!! URL::route('admin_address_make_default', ['id' => $record->id])!!}" class="btn btn-primary" title="Make Default">Make Default</a>
                            						@else
                            						<i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
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
    
@endsection 