@extends('admin.layouts.base-2cols')
@section('title', 'Exchange List')
@section('content')
    
<div class="row">    
	<div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-search"></i> Exchange search</h3>
                    </div>
                    <div class="panel-body">
                        {!! Form::open(['route' => 'admin_exchange', 'class'=>'form-validate', 'method' => 'post']) !!}
                        <!-- email text field -->
                                <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                        {{-- Form::label('keyword','Keyword: ') --}}
                                                        {!! Form::text('keyword', $keyword, ['class' => 'form-control required', 'placeholder' => 'Enter The Keyword']) !!}
                                                </div>
                                                <!-- first_name text field -->
                                        </div>
                                </div>

                        <div class="form-group">
                            <a href="{!! URL::route('admin_exchange') !!}" class="btn btn-default search-reset"><i class="fa fa-refresh" aria-hidden="true"></i> Reset</a>
                            {!! Form::submit('Search', ["class" => "btn btn-info", "id" => "search-submit"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>                
	</div>
	<div class="col-md-12">
	
        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
		{{-- user lists --}}
		
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> Exchange List</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <a href="{!! URL::route('admin_exchange_create') !!}" class="btn btn-info" title="Add New Exchange"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                                <div class="row">
                          <div class="col-md-12">
                              @if( $lists->count() )
                              <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="hidden-xs">Domian Name</th>
					    <th class="hidden-xs">City Name</th>
                                            <!--<th>Status</th>-->
                                            <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      @foreach($lists as $record)
                                          <tr>
					      <td class="hidden-xs">{{ $record->name}}</td>
					      <td class="hidden-xs">{{ $record->city_name}}</td>
                                              
                                              <!--<td>
                                                  @if($record->status=='Active')
                                                  <a title="Active" style="cursor:poniter" class="btn btn-success btn-xs" href="{!! URL::route('admin_exchange_change_status', ['id' => $record->id]) !!}" onclick="return confirm('Are you want to change the status?')">Active</a>
                                                  @else
                                                  <a title="Inactive" style="cursor:poniter" class="btn btn-danger btn-xs" href="{!! URL::route('admin_exchange_change_status', ['id' => $record->id]) !!}" title="Status" onclick="return confirm('Are you want to change the status?')">Inactive</a>
                                                  @endif
                                              </td>-->
                                              <td>
                                                <a href="{!! URL::route('admin_exchange_edit', ['id' => $record->id]) !!}" title="Edit Country"><i class="fa fa-pencil-square-o fa-2x"></i></a>
                                               <!--<a href="{!! URL::route('admin_exchange_delete',['id' => $record->id, '_token' => csrf_token()]) !!}" class="margin-left-5 delete" title="Delete Country" onclick="return confirm('Are you want to delete this country?')"><i class="fa fa-trash-o fa-2x"></i></a>-->

                                              </td>
                                          </tr>
                                      </tbody>
                                      @endforeach
                              </table>
                              <div class="paginator">
                                  {!! $lists->appends(['keyword' => $keyword])->render(); !!}
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