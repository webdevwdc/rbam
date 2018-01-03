@extends('admin.layouts.base-2cols')
@section('title', 'Settings')
@section('content')
    
<div class="row">    
	<div class="col-md-12">
	
         {{-- messages section start--}}
          @include('admin.includes.messages')
	       {{-- messages section end--}}
	
		{{-- user lists --}}
		
                <div class="panel panel-info">
		    
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> Settings</h3>
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
                          <div class="col-md-12">
                              <table class="table table-hover">
                                    <thead>
                                        <tr><th>Delete Member</th></tr>
                                      </thead>
                                      <tbody>

                                        <tr>
					                              <td class="hidden-xs">
						                              <a href="{!! URL::route('admin_member_delete', ['id' => $member->id])!!}" class="btn-info" title="Delete Member" onclick="return confirm('Are you want to delete this member?')">Delete Member Now</a>
                                        </td>
					      
                                        </tr>
                                      </tbody>

                              </table>
                          </div>
                      </div>
                    </div>
                </div>
	</div>
</div>
    
@endsection 