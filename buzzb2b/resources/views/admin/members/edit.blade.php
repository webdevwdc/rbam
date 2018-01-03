@extends('admin.layouts.base-2cols')
@section('title', 'Exchange Edit')
@section('content')
    
<div class="row">
    <div class="col-md-12">

        {{-- messages section start--}}
        @include('admin.includes.messages')
	{{-- messages section end--}}
	
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i> Edit Exchange</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
		<div class="col-md-12 col-xs-12">
		    <div class="row">
			    <div class="col-md-12"><!-- password_confirmation text field -->
				    <h4>Exchange Details</h4>
			    </div>	
		    </div>	
		</div>
		<div class="row">
		  <div class="col-md-12">
			<ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
			    
			    <li class=" active "><a href="">Details</a></li>
			    <li class=""><a href="">Account</a></li>
			    <li class=""><a href="">Directory Profile</a></li>
			    <li class=""><a href="">Financial</a></li>
			    <li class=""><a href="">Users</a></li>
			    <li class=""><a href="">Addresses</a></li>
			    <li class=""><a href="">Phones</a></li>
			    <li class=""><a href="">Settings</a></li>
				
			</ul>
			    
		    <table class="table table-hover">
			  <thead>
			      <tr>
				  <th>Details</th>
				  <th>Account</th>
				  <th>Directory Profile</th>
				  <th>Financial</th>
				  <th>Users</th>
				  <th>Addresses</th>
				  <th>Phones</th>
				  <th>Settings</th>  
			      </tr>
			  </thead>
		    </table>
		  </div>
		</div>
            </div>
        </div>
    </div>
</div>
    
@endsection 