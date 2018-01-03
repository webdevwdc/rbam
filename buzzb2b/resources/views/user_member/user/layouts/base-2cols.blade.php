@extends('user_member.user.layouts.base')

@section('container')
{{-- navbar --}}
@include('user_member.user.layouts.navbar')

<div class="container-fluid">    
	<div class="row-fluid">

		<div class="col-sm-4 col-md-3 col-xs-12 sidebar common">
			@if(\Route::current()->getName() !=  'user-account')
				@include('user_member.user.layouts.sidebar')
			@else


			<ul class="nav peos-sidebar">
				@if((Session::get('MemberRole') == 'user'))
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default" >

						<div class="panel-heading"  role="tab" id="headingCategories">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">
									{{ Auth::user()->first_name.' '.Auth::user()->last_name }}
								</a>
							</h4>
						</div>
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

							<div id="collapseCategories"  class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCategories">
								<div id="member-category-list">
									<div class="checkbox">
										<label>
											<a href="{!! URL::route('member_logout') !!}"> Logout </a>
										</label>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>

				@endif


				@endif
			</div>

			<div class="col-sm-8 col-xs-12 main common">
				@yield('content')
			</div>
		</div>      
	</div>

	@stop    