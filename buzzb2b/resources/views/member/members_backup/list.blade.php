@extends('admin.layouts.base-2cols')
@section('title', 'Member List')
@section('content')

<div class="row">    
<!--	<div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-search"></i> Member search</h3>
                    </div>
			
                   <div class="panel-body">
                        {!! Form::open(['route' => 'admin_member', 'class'=>'form-validate', 'method' => 'post']) !!}
                                <div class="row">
                                        <div class="col-md-6">
                                                <div class="form-group">
                                                        {!! Form::text('keyword', $keyword, ['class' => 'form-control required', 'placeholder' => 'Enter The Keyword']) !!}
                                                </div>
                                        </div>
                                </div>

                        <div class="form-group">
                            <a href="{!! URL::route('admin_member') !!}" class="btn btn-default search-reset"><i class="fa fa-refresh" aria-hidden="true"></i> Reset</a>
                            {!! Form::submit('Search', ["class" => "btn btn-info", "id" => "search-submit"]) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
			
                </div>                
	</div>
-->
      <div class="col-md-12">
	
        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
		{{-- user lists --}}
		
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-user"></i> {{ Session::get('EXCHANGE_CITY_NAME') }} : Member List</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <a href="{!! URL::route('admin_member_create') !!}" class="btn btn-info" title="Add New Exchange"><i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                                <div class="row">
                          <div class="col-md-12">
                              @if( $lists->count() )
                              <table class="table table-hover">
                                    <thead>
                                        <tr>
						<th width="15%">Name</th>
						<th>Barter Balance (T$)</th>
						<th>CBA Balance ($)</th>
						<th>Credit Limit (T$)</th>
						<th>Comm. Rate (P/S %)</th>
						<th>Ref. Rate (P/S %)</th>
						<th>Member Since</th>
						<th>Last Updated</th>
						<th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      @foreach($lists as $record)
                                          <tr>
						<td><a href="{!! URL::route('admin_member_details', ['id' => $record->id]) !!}" >{{ $record->name}}</a> @if($record->prospect)<span class="badge badge-info">Prospect</span>@endif</td>
						<td>--</td>
						<td>--</td>
						<td>{{ number_format($record->credit_limit/100,2) }}</td>
						<td>{{ ($record->ex_purchase_comm_rate)? $record->ex_purchase_comm_rate/100: '--' }} / {{ ($record->ex_sale_comm_rate)? $record->ex_sale_comm_rate/100: '--' }}</td>
						<td>{{ ($record->ref_purchase_comm_rate)? $record->ref_purchase_comm_rate/100: '--' }} / {{ ($record->ref_sale_comm_rate)? $record->ref_sale_comm_rate/100 : '--' }}</td>
						<td>{{ date('jS M, Y', strtotime($record->created_at)) }}</td>
						<td>{{ timeAgo($record->updated_at) }} ago</td>	
                                              <!--<td>
                                                  @if($record->status=='Active')
                                                  <a title="Active" style="cursor:poniter" class="btn btn-success btn-xs" href="{!! URL::route('admin_exchange_change_status', ['id' => $record->id]) !!}" onclick="return confirm('Are you want to change the status?')">Active</a>
                                                  @else
                                                  <a title="Inactive" style="cursor:poniter" class="btn btn-danger btn-xs" href="{!! URL::route('admin_exchange_change_status', ['id' => $record->id]) !!}" title="Status" onclick="return confirm('Are you want to change the status?')">Inactive</a>
                                                  @endif
                                              </td>-->
                                              <td>
                                                <a href="{!! URL::route('admin_member_details', ['id' => $record->id]) !!}" title="Edit Country"><i class="fa fa-pencil-square-o fa-2x"></i></a>
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