@extends('admin.layouts.base-2cols')
@section('title', 'Phone List')
@section('content')
    
<div class="row">    
	<div class="col-md-12">
	
        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
		{{-- user lists --}}
		
                <div class="panel panel-info">
		    
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> Phone List</h3>
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
                                <a href="{!! URL::route('admin_member_phone_create', $member->id) !!}" class="btn btn-info" title="Add New Address"><i class="fa fa-plus"></i> Add New</a>
                            </div>
				
				
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            @if($lists->count())
                              <table class="table table-hover">
                              <thead>
                                  <tr>
                                      <th class="hidden-xs">Phone Number</th>
		                                  <th class="hidden-xs">Phone Type</th>
                                      <th>Is Default</th>
                                      <th>Action</th>
                                  </tr>
                                </thead>
                          <tbody>

                            @foreach($lists as $record)
                              <tr>
                                <td class="hidden-xs">{{ $record->number }}</td>
                                <td class="hidden-xs">{{ $record->phoneType->name }}</td>
                                <td>
                                @if($record->is_primary=='No')
                                <a href="{!! URL::route('admin_member_phone_make_default', ['id' => $record->id])!!}" class="btn btn-primary" title="Make Default">Make Default</a>
                                @else
                                <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                                @endif
                                 </td>
                                  <td>
                                @if($record->is_primary=='No')
                                    <a href="{!! URL::route('admin_member_phone_delete',['id' => $record->id, '_token' => csrf_token()]) !!}" class="margin-left-5 delete" title="Delete Phone" onclick="return confirm('Are you want to delete this phone?')"><i class="fa fa-trash-o fa-2x"></i></a>
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