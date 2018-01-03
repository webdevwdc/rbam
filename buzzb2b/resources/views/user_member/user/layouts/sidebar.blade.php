<!-- adding categories model -->
@php
  use App\Category;
  $name = new Category();
  $data = $name->GetAll();
@endphp
<!-- end here -->
<ul class="nav peos-sidebar">
@if((Session::get('MemberRole') == 'user'))
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default" >
			
			<div class="panel-heading"  role="tab" id="headingCategories">
		  		<h4 class="panel-title">
		    		<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseCategories" aria-expanded="true" aria-controls="collapseCategories">Search </a>
				</h4>
			</div>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			
			<div id="collapseCategories"  class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCategories">
					<div id="member-category-list">
						<div class="checkbox">
							<label>
								 <input type="checkbox" name="category">Bartertech Hosuten
							</label>
						</div>
						<div class="checkbox">
							<label>
								 <input type="checkbox" name="category">Bartertech Hosuten
							</label>
						</div>
					</div>
				</div>
				
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
			
			
				<div id="collapseCategories"  class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingCategories">
				 
					<!-- write here all the category -->
					@if(!empty($data))
					@foreach($data as $name)
					<div class="checkbox">
						<form action="{{route('user_dashboard')}}" method="post" id="category">
						    <input type="hidden" name="_token" value="{{ csrf_token() }}">
						  	<input name="category" value="{{$name->id}}"  class="laravel" type="checkbox">{{$name->name}}
						  </form>
					</div>
					@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
@endif
</ul>

<script type="text/javascript">
	$(document).ready(function(){
    	$('.laravel').click(function(){
           var val = $(this).is(":checked");
            $('#category').submit();
    	});
	});
</script>

