@extends('admin.layouts.base-2cols')
@section('title', 'Member StandBy')
@section('content')
<div class="row">
  <div class="col-md-12">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-12">
					<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : Reports / Members on standby</h3>
				</div>
			</div>
		</div>
	</div>

    <div class="traders-search">
        <form action="{{route('admin-member-show-standby')}}" id="standby" method="post">
        {!! csrf_field() !!} 
        	{{ Form::select('date', ['this_week'=>'This Week', 'this_month'=>'Last 30 Days', 'three_months'=>'Last 3 Months','six_months'=>'Last 6 Months','one_year'=>'1 Year','all'=>'Forever','7'=>'Date Range'], null, ['class' => 'trade-button trade']) }}

        <div class="trade-date-range">
        	<input type="text" name="start_date" class="start search-date datepicker" placeholder="Start Date"> To
        	<input type="text" name="end_date" class="end search-date datepicker" placeholder="End Date">
        	<button type="submit" class="btn btn-success">Filter</button>
        </div>

        </form>
    	
    </div>
        @if(!empty($list))
          <!-- table start from here -->
                <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Member name</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($list as $standby)
                    
                      <tr>
                        <td>{{$standby->member_name}}</td>
                      </tr>
                   @endforeach
                      </tbody>
                </table>
               @else
               <tr>
             <div style="margin-top: 20px;text-align: center;font-weight: 600;">No transactions match this criteria.</div>
             </tr>
             @endif
        <!-- end here -->

 </div>
</div>

<!-- search query start from here -->
<script type="text/javascript">
	$(document).ready(function(){
      $('.trade').change(function(){
        var value = $(this).val();
        if(value==7){
        	$('.trade-date-range').css('display','block');
        }else{
         $('#standby').submit();
        }
      });
	});
</script>

<script> 
$(document).ready(function() {
 $(".datepicker").datepicker({
  dateFormat: 'yy-mm-dd',
 }); 
}); 
</script>
@endsection