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
                        <h3 class="panel-title bariol-thin">
                          <i class="fa fa-user"></i>
                          Cash Referral Details
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
			      <div class="col-lg-10 col-md-9 col-sm-9">&nbsp;</div>
			      <div class="col-lg-2 col-md-3 col-sm-3">
				  <a href="{!! route('admin_cash_referral') !!}" class="btn btn-info" title="Return to Cash Referrals"><i class="fa fa-backward"></i> Back</a>
			      </div>
                        </div>
			@if(count($record) > 0)
                     <div class="row">
                        <div class="col-md-12">                            			      
			      <div class="col-md-6">
				    <h3>Referred By</h3>
				    <table class="table table-hover">
					  <tr>
						<td>Name :</td>
						<td>{{ $record->user->first_name }} {{ $record->user->last_name }}</td>
					  </tr>
					  <tr>
						<td>Email :</td>
						<td>{{ $record->user->email }}</td>
						      
					  </tr>					  
				    </table>
			      </div>
			      <div class="col-md-6">
				    <h3>Referred To</h3>
				    <table class="table table-hover">
					  <tr>
						<td>Name :</td>
						<td>{{ $record->member->name }}</td>
					  </tr>
					  <tr>
						<td>Email :</td>
						<td>{{ $record->member->user[0]->email }}</td>
					  </tr>
					  <tr>
						<td>Phone :</td>
						<td>{{$record->member->phones[0]->number}}</td>						      
					  </tr>						
				    </table>						
			      </div>			       
                        </div>
                    </div>
			<div class="row">
			      <div class="col-md-12">
				    <div class="col-md-6">
					  <h3>Referring Customer</h3>
					  <table class="table table-hover">					  
						<tr>
						      <td>Name :</td>
						      <td>{{ $record->fullname }}</td>
						</tr>
						<tr>
						      <td>Email :</td>
						      <td>{{ $record->email }}</td>
						</tr>
						<tr>
						      <td>Phone :</td>
						      <td>{{ $record->phone }}</td>						      
						</tr>
					  </table>						
				    </div>
				    <div class="col-md-6">
					  <h3>Personal message</h3>
					  <table class="table table-hover">
						<tr>
						      <td>
							    @if($record->personal_message)
								  {{ $record->personal_message }}
							    @else
								  --
							    @endif
						      </td>
						</tr>
					  </table>					  
				    </div>
			      </div>
			</div>
		  @else
			<span class="text-warning"><h5>No results found.</h5></span>
		  @endif
                    </div>
                </div>
                
                
	</div>
</div>
    
@endsection 