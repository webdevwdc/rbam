@extends('admin.layouts.base-2cols')
@section('title', 'Directory Profile')
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
                        <h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i> {{ Session::get('EXCHANGE_CITY_NAME') }} : Directory Profile</h3>
                    </div>
                </div>
            </div>
       <div class="panel-body">

		<div class="col-md-12 col-xs-12">
			<div class="row">
				<div class="col-md-12">
					@include('admin.includes.member_edit_tab')
				</div>	
			</div>
			    
			<div>&nbsp;</div>
			
						{!! Form::open(array('route'=>['admin_directory_profile_update', $details->id ], 'id'=>'', 'class'=>'form-validate','method'=>'post','files'=>true)) !!}				
			<div class="group_1">
												    
				<div class="row">
										
					<div class="col-xs-12 col-md-6">
					<!-- input: description -->
					<div class="form-group">
						<div class="row">
						{{ Form::label('description', 'Short Description', ['class' => 'col-sm-5 col-lg-3 control-label']) }}
						<div class="col-sm-7 col-lg-9">
							{{ Form::textarea('description', $details->description, ['class' => 'form-control', 'rows' => '5', 'placeholder' => 'Please enter a short description of your business...']) }}
						</div>
						</div>
					</div>

					<!-- input: view_on_dir -->
					<div class="form-group">
						<div class="col-sm-offset-3 col-md-offset-4 col-lg-offset-4 col-sm-9 col-md-6 col-lg-5">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="view_on_dir" value="1" {{ ( $details->view_on_dir ) ? 'checked' : '' }}> Viewable on directory
								</label>
							</div>
						</div>
					</div>

			            <div class="tagDiv">
						    <div class="form-group">
						            <label>Search Tags</label>
						                <p>To add a new tag, click directly behind the last shown tag and begin typing. To save it, press "tab" or "enter". To remove a tag, click the "X" button that appears on the right side of the tag while hovering.</p>
						            <ul id="member_tags">
						                @if(isset($details->tag))
						                    @foreach($details->tag as $tag)
						                        <li>{{ $tag->name }}</li>
						                    @endforeach
						                @endif
					                </ul>
						    </div>
						</div>
					</div>
				    
					<div class="col-md-6">
						<div class="form-group">
						<div class="row">
							<label class="col-sm-4 col-lg-3 control-label">{{ (isset($details->image->filename) && $details->image->filename) ? 'Change logo' : 'Upload your logo'  }}</label>    
							<div class="col-sm-8 col-lg-9">
								<input type="file" name="member_logo" id="imgInp">
								<div id="errordiv" style="color:red;"></div>

								@if((isset($details->image->filename) && $details->image->filename) && file_exists(public_path('upload/members/thumb/'.$details->image->filename)))
									<img src="{{ asset('upload/members/thumb/'.$details->image->filename) }}" height="150" width="175" id="curimg">
								@else
									<img src="{{ asset('images/blank.png') }}" class="img-rounded img-responsive" id="curimg" height="150" width="175">
								@endif
						    
							</div>
							</div>
						</div>
						    
						<br/>
						    
							@php
							     $selcatArr = array();
							     if(isset($details->category)){
									foreach($details->category as $cat){
									    $selcatArr[] = $cat->id;
									}
							     }
							@endphp
						    
						 <div class="form-group">
							<div class="row">							
							
							{{ Form::label('member_categories', 'Category', ['class' => 'col-sm-4 col-lg-3 control-label']) }}
							<div class="col-sm-8 col-lg-9">
								{{Form::select('member_categories[]', $categories, $selcatArr,array('multiple'=>'multiple', "style"=>'height:303px'))}}
								
							</div>
							</div>
						</div>
					   
					</div>
				    
				</div>
				    
				    
				 <div class="row">
				 <div class="col-xs-12 col-sm-12 col-lg-12 text-center">
				{!! Form::submit('Save', array("class"=>"btn btn-info pull-right green")) !!}
				<a href="{{ URL::route('admin_member') }}" class="btn btn-info pull-right">Back</a>
				{!! Form::close() !!}
				</div>
				</div>
			</div>
		    <input type="hidden" name="member_id" id="member_id" value="{{$member_id}}">
			
		</div >
    </div>
      </div>
	
    
</div>
</div>
<script>
    $(document).ready(function() {
        $("#member_tags").tagit({
	    allowSpaces : true,
	    afterTagAdded: function(event, ui) {
		// SAVE the tag I have just added to my sql database
		var tagLabel = ui.tagLabel;
		var memberID = $('#member_id').val();
		
		$.ajax({
		    url: BASE_URL+'set_tags',
		    type: 'POST',
		    data:{"_token":CSRF_TOKEN, "term":tagLabel, "member_id":memberID},
		    success : function(response){
		    }
	       });
	    },
	
	    beforeTagRemoved: function(event, ui) {
		var tagLabel = ui.tagLabel;
		var memberID = $('#member_id').val();
		$.ajax({
		    url: BASE_URL+'remove_tags',
		    type: 'POST',
		    data:{"_token":CSRF_TOKEN, "term":tagLabel, "member_id":memberID},
		    success : function(response){ 
		       $('#member_id').val('');
		    }
	       });
	    }
	 
	});
	
	$("#member_tags").tagit({
	    afterTagRemoved: function(event, ui) {
		// do something special
		console.log(ui.tag);
	    }
	});
	
    });
    
    
    function readURL(input) { 
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#curimg').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imgInp").change(function(){ alert(BASE_URL);
		var fileExtension = ['jpeg','jpg','png'];
		if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
			$('#errordiv').html("Only formats are allowed : "+fileExtension.join(', '));
			return false;
		}
		else{
			$('#errordiv').html('');
			readURL(this);	
		}
	});
</script>
    
@endsection 