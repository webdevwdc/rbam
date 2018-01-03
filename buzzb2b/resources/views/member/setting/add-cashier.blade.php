@extends('member.layouts.base-2cols')
@section('content')
<style type="text/css">
.cashier{
	margin-top: 14px;
    width: 71px;
    float: right;
    margin-right: 196px;
}
</style>
<div class="row">
    <div class="col-md-12">
    	<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
		     <li @if(in_array(Route::current()->getName(), array('member-setting'))) {{ "class=active" }} @endif>
			    	<a href="{{route('member-setting')}}">Directory Settings</a>
			 </li>
		    <li @if(in_array(Route::current()->getName(), array('users-setting'))) {{ "class=active" }} @endif>
		    	<a href="{{route('users-setting',[$member->id])}}">Users</a>
		    </li>

		    <li @if(in_array(Route::current()->getName(), array('users-address','users-create-address'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-address',[$member->id])}}">Addresses</a>
			</li>

		    <li @if(in_array(Route::current()->getName(), array('users-phone'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-phone',[$member->id])}}">Phones</a>
			</li>
		    <li @if(in_array(Route::current()->getName(), array('users-cashiers','users-create-cashiers'))) {{ "class=active" }} @endif>
			     	<a href="{{route('users-cashiers',[$member->id])}}">Cashiers</a>
			    </li>
		</ul>
		{{-- messages section start--}}
		@include('admin.includes.messages')
		{{-- messages section end--}}
	</div>
	<div class="col-md-6">
		<h5>Add By Account</h5>
		<p>Choose a cashier from your list of authorized users.</p>
		<div class='row'>
			<div class="col-md-10">
				<table>
					@if(!empty($member_users))
					@foreach($member_users as $member_user)
					<tr>
						<td style="font-size:17px;font-weight: 500;">{{$member_user->name}}</td>
						<td>
							@if(!in_array($member_user->member_id,array_flatten($cashiers))) 
							<button id="{{$member_user->member_id}}" type="button" style="margin-left:34px;width:109px;" data-toggle="modal" data-target="#myModal" class="btn btn-success btn-block member-data">
							 Add as Cashier
							</button>
							@else
							<button id="{{$member_user->member_id}}"  type="button" data-toggle="modal" data-target="#detach" style="margin-left:34px;width:109px;" class="btn btn-danger btn-block member-deattach ">
							 Detach
							 </button>
							@endif
						</td>
					</tr>
					@endforeach
					@endif
				</table>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<h5>Add By Name</h5>
		<p>
			Add a cashier to the list by name, 
			code or nickname. This does not require the cashier to have a user account.
		</p>
		<div class='row'>
			<div class="col-md-10">
                {!! Form::open(array('route'=>['users-save-cashiers'],'class'=>'form-validate','method'=>'post')) !!}
				Cashier name:{{ Form::text('nickname', null, array('class' => 'field')) }}
				<input type="hidden" name="user_id" value='{{$member->id}}'>
				<div class="cashier">
				<button type="submit" class="btn btn-success btn-block">
					Add
				</button>
				</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Make User a Cashier</h4>
      </div>
        <P class="modal-header">
          You are about to make this user a cashier of this member. Are you sure you want to do this?
        </P>
      {!! Form::open(array('route'=>['users-save-cashiers'],'class'=>'form-validate','method'=>'post')) !!}
      <div class="modal-body">
        <button type="submit"class="btn btn-success btn-block">Add as Cashier</button>
        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
      </div>
      <input type="hidden" name="member_id" id='member_id'>
      <input type="hidden" name="user_id" value='{{$member->id}}'>
      {{ Form::close() }}
    </div>
  </div>
</div>

<!-- for deatch cashier modal -->
<div id="detach" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Remove User from Cashiers</h4>
      </div>
        <P class="modal-header">
          You are about to remove this user from being a cashier of this member. Are you sure you want to do this?
        </P>
      {!! Form::open(array('route'=>['delete-cashier'],'class'=>'form-validate','method'=>'post')) !!}
      <div class="modal-body">
        <button type="submit"class="btn btn-danger btn-block">Remove</button>
        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
      </div>
      <input type="hidden" name="member_id" id='member_data'>
      <input type="hidden" name="user_id" value='{{$member->id}}'>
      {{ Form::close() }}
    </div>
  </div>
</div>

<!-- end deattch modal -->

<script type="text/javascript">
$(document).ready(function(){
	$('.member-data').click(function(){
		var member = $(this).attr("id");
		$('#member_id').val(member);
	})

	/*for detach*/
	$('.member-deattach').click(function(){
		var member = $(this).attr("id");
		$('#member_data').val(member);
	})
});
</script>
@endsection