@extends('admin.layouts.base-2cols')
@section('title', 'Dashboard')
@section('content')

<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <h4>
       <i class="fa fa-exchange"></i>
        Switch Selected Exchange
      </h4>
      <hr/>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12">

	    @foreach($exchange_list as $el)
	      <a href="{{ URL::route('admin_select_exchange', ['id' => $el->id ] ) }}"> 
	      <div class="stats-item margin-left-5 margin-bottom-12"><i class="fa fa-life-ring icon-large"></i> <span class="text-small margin-left-15">{{ $el->name }}</span>
	      <br/><br/>{{ $el->city_name }}</div>
	      </a>
	    @endforeach
	      
  </div>

</div>
@endsection 