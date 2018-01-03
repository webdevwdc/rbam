@extends('admin.layouts.base-2cols')
@section('title', 'Member List')
@section('content')

<div class="row">    

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
                                <a href="{!! URL::route('admin_member_create') !!}" class="btn btn-info" title="Add New Member"><i class="fa fa-plus"></i> Add New</a>
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
                            						<td><a href="{!! URL::route('admin_member_details', ['id' => $record->id]) !!}" style="color: #2cafe3;" >{{ $record->name}}</a> @if($record->prospect)<span class="badge badge-info">Prospect</span>@endif</td>
                            						<td>{{number_format($record->barter/100,2)}}</td>
                            						<td>{{number_format($record->cba/100,2)}}</td>
                            						<td>{{ number_format($record->credit_limit/100,2) }}</td>
                            						<td>{{ ($record->ex_purchase_comm_rate)? $record->ex_purchase_comm_rate/100: '--' }} / {{ ($record->ex_sale_comm_rate)? $record->ex_sale_comm_rate/100: '--' }}</td>
                            						<td>{{ ($record->ref_purchase_comm_rate)? $record->ref_purchase_comm_rate/100: '--' }} / {{ ($record->ref_sale_comm_rate)? $record->ref_sale_comm_rate/100 : '--' }}</td>
                            						<td>{{ date('jS M, Y', strtotime($record->created_at)) }}</td>
                            						<td>{{ timeAgo($record->updated_at) }} ago</td>	
                                          
                                          <td>
                                           
                                            @if($record->admin==0)
                                              <a href="{{route('admin.makeMemberAdmin',$record->id)}}" title="Make Admin">
                                              <i class="fa fa-user"></i>
                                              </a> 
                                              @endif
                                              @if($record->admin==1)
                                              <a href="{{route('admin.makeMemberAdmin',$record->id)}}" title="Remove Admin">
                                              <i class="fa fa-user" style="color:green"></i>
                                              </a> 
                                              @endif 
                                            <a href="{!! URL::route('admin_member_details', ['id' => $record->id]) !!}" title="Edit Member">
                                            <i class="fa fa-pencil-square-o fa-2x"></i>
                                            </a>

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