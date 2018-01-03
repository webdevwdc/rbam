@php
  use App\Category;
  use App\Exchange;

  $name = new Category();
  $data = $name->GetAll();

  $exchange = new Exchange();
  $exchange_name = $exchange->GetExchange();
 @endphp
<ul class="nav peos-sidebar">
 @if((Session::get('MemberRole') == 'user'))
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default" >
			
			<div class="panel-heading"  role="tab" id="headingCategories">
		  		<h4 class="panel-title">
		    		<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">
		    			Search partner exchanges
		    		</a>
				</h4>
			</div>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			
			<form action="{{route('directory')}}" method="post" id="category2">

			<div id="collapseCategories"  class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCategories"> 
			   @php
			   //$session[] = Session::get('exchanges');
			   $session[] = Session::get('EXCHANGE_ID');
			   @endphp				
			    @foreach($exchange_name as $exchange)

			    @if($exchange->id == Session::get('EXCHANGE_ID'))
			      
					<div id="member-category-list">
						<div class="checkbox">
							<label>
							     <input type="hidden" name="_token" value="{{ csrf_token() }}">
								 
								 {{ Form::checkbox('exchanges[]',$exchange->id,in_array($exchange->id,$session), ['class' => 'dirExchange', 'onclick' => 'callingAgainstCheckBox()', 'disabled'=>'disabled']) }}
								 {{$exchange->city_name}}
								 
							</label>
						</div>
					</div>
				@endif	
			    @endforeach
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
					@if(!empty($data))
					@foreach($data as $name)
					<div class="checkbox">
						<label>
						    <input type="hidden" name="_token" value="{{ csrf_token() }}">
						  	<input name="category" value="{{$name->id}}"  class="dirCategory" type="checkbox" onclick="callingAgainstCheckBox()">{{$name->name}}
						</label>
					</div>
					@endforeach
					@endif
				</div>
				</form>
			</div>
		</div>
	</div>
@endif
</ul>