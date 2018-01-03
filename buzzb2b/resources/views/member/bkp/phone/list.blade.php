@extends('admin.layouts.base-2cols')
@section('title', 'Phone Number List')
@section('content')
    
<div class="row">    
	<div class="col-md-12">
                <!--<div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-search"></i> Phone Number search</h3>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['route' => 'admin_manage_phone', 'class'=>'form-validate', 'method' => 'post']) !!}
                                <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                        {!! Form::text('keyword', $keyword, ['class' => 'form-control required', 'placeholder' => 'Enter Number']) !!}
                                                </div>
                                        </div>
                                </div>

                        <div class="form-group">
                            <a href="{!! URL::route('admin_manage_phone') !!}" class="btn btn-default search-reset"><i class="fa fa-refresh" aria-hidden="true"></i> Reset</a>
                            {!! Form::submit('Search', ["class" => "btn btn-info", "id" => "search-submit"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>-->
                </div>                
	</div>
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> Phone Number List</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <a href="{!! URL::route('admin_phone_create') !!}" class="btn btn-info" title="Add New Phone"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                              @if( $phones->count() )
                              <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="hidden-xs">Phone Number</th>
					    <th>Phone Type</th>
                                            <th>Primary</th>
                                            <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      @foreach($phones as $phone)
                                          <tr>
					      <td class="hidden-xs">{{ $phone->number }}</td>
					      <td>{{ $phone->phone_type }}</td>
                                              <td>
                                                  @if($phone->is_primary=='No')
                                                  <a href="{!! URL::route('admin_phone_make_default', ['id' => $phone->id])!!}" class="btn btn-primary" title="Make Default">Make Default</a>
                                                  @else
                                                  <i class="fa fa-check" aria-hidden="true" style="color:green;"></i>
                                                  @endif
                                              </td>
                                              <td>
                                                <a href="{!! URL::route('admin_phone_edit', ['id' => $phone->id]) !!}" title="Edit Phone"><i class="fa fa-pencil-square-o fa-2x"></i></a>
						@if($phone->is_primary == 'No')
                                                <a href="{!! URL::route('admin_phone_delete',['id' => $phone->id, '_token' => csrf_token()]) !!}" class="margin-left-5 delete" title="Delete Phone" onclick="return confirm('Are you want to delete this phone?')"><i class="fa fa-trash-o fa-2x"></i></a>
						@endif
                                              </td>
                                          </tr>
                                      </tbody>
                                      @endforeach
                              </table>
                              <div class="paginator">
                                  {!! $phones->appends(['keyword' => $keyword])->render(); !!}
                              </div>
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