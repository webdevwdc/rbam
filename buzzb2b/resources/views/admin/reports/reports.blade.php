@extends('admin.layouts.base-2cols')
@section('title', 'Reports')
@section('content')
<div class="row">
  <div class="col-md-12">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-12">
					<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : Reports</h3>
				</div>
			</div>
		</div>
	</div>
    
    <div class="reports-search">
    	<a href="{{route('admin-reports-traders')}}" class="btn btn-danger reports-menu" role="button">Top Monthly Traders</a>
    	<a href="{{route('admin-member-standby')}}" class="btn btn-danger reports-menu" role="button">Members On Standby</a>
    	<!-- <a href="{{route('admin-accounts-total-member')}}" class="btn btn-danger reports-menu" role="button">Account Totals By Member</a> -->
    	<a href="{{route('admin-inter-exchange-trading')}}" class="btn btn-danger reports-menu" role="button">Inter-Exchange Trading</a>
    </div>

 </div>
</div>
@endsection