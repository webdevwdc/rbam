@extends('member.layouts.base')

@section('container')
{{-- navbar --}}

@include('user_member.member.layouts.navbar')
<div class="container-fluid">    
	<div class="row-fluid">
		<div class="col-sm-3 col-md-3 col-xs-12 sidebar">
			@php
			use App\Category;
			use App\Exchange;

			$name = new Category();
			$data = $name->GetAll();

			$exchange = new Exchange();
			$exchange_name = $exchange->GetExchange();
			@endphp
			<ul class="nav peos-sidebar">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default" >

						<div class="panel-heading"  role="tab" id="headingCategories">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">Search partner exchanges</a>
							</h4>
						</div>
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

							<form action="{{route('directory')}}" method="post" id="category2">

								<div id="collapseCategories"  class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCategories"> 
									{{-- @php
									//$session[] = Session::get('exchanges');
									$session[] = Session::get('EXCHANGE_ID');
									@endphp				
									@foreach($exchange_name as $exchange) --}}

									<div id="member-category-list">
										<div class="checkbox">
											<label>
												<input type="hidden" name="_token" value="{{ csrf_token() }}">

												{{ Form::checkbox('exchanges[]',$memberExchange->id,'', ['class' => 'dirExchange', 'checked'=>'checked', 'disabled'=>'disabled']) }}
												{{$memberExchange->city_name}}

											</label>
										</div>
									</div>
									{{-- @endforeach --}}
								</div>
							</form>
						</div>
					</div>
				</div>


				<div class="panel-group"  id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading"  role="tab" id="headingCategories">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">Filter Categories</a>
							</h4>
						</div>
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

							<form action="{{route('directory')}}" method="post" id="category">
								<div id="collapseCategories"  class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCategories">
									<!-- write here all the category -->
									@if(!empty($memberCategories))
									@foreach($memberCategories as $eachCategory)
									<div class="checkbox">
										<label>
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<input name="category" value=""  class="dirCategory" type="checkbox" onclick="abc();">{{$eachCategory->category->name }}
										</label>
									</div>
									@endforeach
									@endif
								</div>
							</form>
						</div>
					</div>
				</div>
			</ul>
			<br>
			<br>
			<br>

		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-9 col-md-offset-2 col-xs-12 main">
			@yield('content')
		</div>
	</div>      
</div>

@stop    