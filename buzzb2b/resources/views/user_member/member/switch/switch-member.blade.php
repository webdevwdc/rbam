@extends('user_member.member.layouts.base-2cols')
@section('title', 'Switch Member')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <h4>
       <i class="fa fa-exchange"></i>
        Switch Selected Member
      </h4>
      <hr/>
  </div>
   @if(!empty($members))
    @foreach($members as $member)
	<a href="{{route('member_dashboard')}}?member_id={{$member->member_id}}">
	      <div class="stats-item margin-left-5 margin-bottom-12">
	        <i class="fa fa-user icon-large"></i> 
	        <span class="text-small margin-left-15">{{ $member->exchange_name }}</span>
	        <br/><br/>{{ $member->membername }}
	     </div>
	</a>
	@endforeach
	@endif

</div>
@endsection