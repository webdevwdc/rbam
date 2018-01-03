@extends('admin.layouts.base-2cols')
@section('title', 'Dashboard')
@section('content')

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <h3><i class="fa fa-dashboard"></i> Dashboard : {{ Session::get('EXCHANGE_CITY_NAME') }}</h3>
      <hr/>
  </div>
</div>

    
@endsection 