@extends('user_member.member.layouts.base-2cols')
@section('title', 'Cashier Add')
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
			    <li @if(in_array(Route::current()->getName(), array('member_setting'))) {{ "class=active" }} @endif>
			    	<a href="{{route('member_setting')}}">Directory Settings</a>
			    </li>
			    <li @if(in_array(Route::current()->getName(), array('users_setting'))) {{ "class=active" }} @endif>
			    	<a href="{{route('users_setting')}}">Users</a>
			    </li>

			    <li @if(in_array(Route::current()->getName(), array('address_setting'))) {{ "class=active" }} @endif>
			     	<a href="{{route('address_setting')}}">Addresses</a>
			    </li>

			    <li @if(in_array(Route::current()->getName(), array('phone_setting'))) {{ "class=active" }} @endif>
			     	<a href="{{route('phone_setting')}}">Phones</a>
			    </li>
			    
			    <li @if(in_array(Route::current()->getName(), array('cashier_setting','create_cashier_setting'))) {{ "class=active" }} @endif>
			     	<a href="{{route('cashier_setting')}}">Cashiers</a>
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
						<td style="font-size:17px;font-weight: 500;">
							{{$member_user->first_name. ' '.$member_user->last_name}}
						</td>
						<td>
							@if(in_array($member_user->user_id, $cashiers))
	 						<button id="{{$member_user->member_id}}" user_id="{{$member_user->user_id}}"  type="button" style="margin-left:34px;width:109px;" data-toggle="modal" data-target="#detach" class="btn btn-danger btn-block member-detach">Detach</button>
							@else
								<button id="{{$member_user->member_id}}" user_id="{{$member_user->user_id}}"  type="button" style="margin-left:34px;width:109px;" data-toggle="modal" data-target="#myModal" class="btn btn-success btn-block member-data">Add Cashier</button>
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
                {!! Form::open(array('route'=>['cashier_save'],'class'=>'form-validate')) !!}
				Cashier name:{{ Form::text('nickname', null, array('class' => 'field')) }}
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
      {!! Form::open(array('route'=>['cashier_save'],'class'=>'form-validate','method'=>'post')) !!}
      <div class="modal-body">
        <button type="submit"class="btn btn-success btn-block">Add as Cashier</button>
        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
      </div>
      <input type="hidden" name="member_id" id='member_id'>
      <input type="hidden" name="user_id" id='user_id'>

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
      {!! Form::open(array('route'=>['member_cashier_delete'],'class'=>'form-validate','method'=>'post')) !!}
      <div class="modal-body">
        <button type="submit"class="btn btn-danger btn-block">Remove</button>
        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
      </div>
      <input type="hidden" name="user_id" id='user_data'>
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

	$('.member-data').click(function(){
		var user = $(this).attr("user_id");
		$('#user_id').val(user);
	})

	/*for detach*/
	$('.member-detach').click(function(){
		var member = $(this).attr("user_id");
		$('#user_data').val(member);
	})
});
</script>
@endsection