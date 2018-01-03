@extends('admin.layouts.base-2cols')
@section('title', 'Cash Referrals')
@section('content')

<div class="row">    

      <div class="col-md-12">
	
        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
		{{-- user lists --}}
		
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title bariol-thin">
                          <i class="fa fa-user"></i>
                          Cash Referral List
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
                            <div class="col-lg-2 col-md-3 col-sm-3">
                                <!-- <a href="{!! URL::route('admin_member_create') !!}" class="btn btn-info" title="Add New Member"><i class="fa fa-plus"></i> Add New</a> -->
                            </div>
                        </div>
                     <div class="row">
                        <div class="col-md-12">
                            @if(count($lists) > 0)
                            <table class="table table-hover">
                                  <thead>
                                      <tr>
					  <th width="15%">Referred By</th>
					  <th>Referred To</th>
                                          <th>Referring Customer</th>
                              		  <th>Details</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($lists as $record)
                                      <tr>
                                        <td>{{ $record->user->first_name }} {{ $record->user->last_name }}</td>
                                        <td>{{ $record->member->name }}</td>
                                        <td>Name: {{ $record->fullname }}<br>Email: {{ $record->email }}<br>{{ $record->phone }}</td>
                                        <td><a href="{{ route('admin_cash_referral_show', $record->id) }}" class="btn btn-success">View Details</a></td>
                                      </tr>
                                    </tbody>
                                    @endforeach
                            </table>
                            <div class="paginator">
                                @if(isset($keyword))
                                  {!! $lists->appends(['keyword' => $keyword])->render(); !!}
                                @else
                                  {!! $lists->render(); !!}
                                @endif
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