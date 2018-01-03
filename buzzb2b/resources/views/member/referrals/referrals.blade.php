@extends('admin.layouts.base-2cols')
@section('title', 'Referrals')
@section('content')
<div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : Referrals</h3>
                    </div>
                </div>
            </div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Referring Member</th>
						<th>Name of Referred</th>
						<th>Informed?</th>
						<th>Phone Number</th>
						<th>Reffered</th>
					</tr>
				</thead>
					<tbody>
						@if(!empty($referrals))
						@foreach($referrals as $reffer)
						<tr>
							<td>{{$reffer->referred_to}}</td>
							<td>{{$reffer->referred_by}}</td>
							<td>
							@if($reffer->informed==1)
							Yes
							@endif
							</td>
							<td>{{$reffer->phone}}</td>
							<td>{{$reffer->created_at->format('m-d-Y')}}</td>
						</tr>
						@endforeach

						
					</tbody>
			</table>
				<div class="paginator">
				  {!! $referrals->render(); !!}
				</div>
				@else
				  <span class="text-warning"><h5>No results found.</h5></span>
				@endif
		</div>
	</div>
</div>
@endsection