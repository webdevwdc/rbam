@extends('member.layouts.base-2cols')
@section('title', 'Member Switch')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <h4>
       <i class="fa fa-exchange"></i>
        Switch Selected Member
      </h4>
      <hr/>
  </div>
   
	@foreach($all_member_user as $member_user)
	<a href="{{route('admin_member_dashboard')}}?member_id={{$member_user->member->id}}&exchange_id={{$member_user->member->exchange->id}}">
	      <div class="stats-item margin-left-5 margin-bottom-12">
	        <i class="fa fa-user icon-large"></i> 
	        <span class="text-small margin-left-15">{{$member_user->member->exchange->name}}</span>
	        <br/><br/>{{$member_user->member->name}}
	     </div>
	</a>
	@endforeach
</div>
@endsection