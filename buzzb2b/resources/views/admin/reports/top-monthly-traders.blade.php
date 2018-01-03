@extends('admin.layouts.base-2cols')
@section('title', 'Top Monthly Traders')
@section('content')
<div class="row">
  <div class="col-md-12">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-12">
					<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : Reports / Top Monthly Traders</h3>
				</div>
			</div>
		</div>
	</div>
    
    <div class="traders-search">
        <form action="{{route('admin-search-traders')}}" id="trade-form" method="post">
        {!! csrf_field() !!} 
        	{{ Form::select('date', ['this_week'=>'This Week', 'this_month'=>'Last 30 Days', 'three_months'=>'Last 3 Months','six_months'=>'Last 6 Months','one_year'=>'1 Year','all'=>'Forever','7'=>'Date Range'], null, ['class' => 'trade-button trade']) }}
        <!-- date range start from here -->
        <div class="trade-date-range">
        	<input type="text" name="start_date" class="start search-date datepicker"> To
        	<input type="text" name="end_date" class="end search-date datepicker">
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
                          <th>Amount</th>
                         
                        </tr>
                      </thead>
                      <tbody>
                      
                    @foreach($list as $list)
                      <tr>
                        <td>{{$list->member_name}}</td>
                        <td>$ {{$list->total_barter / 100}}</td>
                      </tr>
                    @endforeach
                      </tbody>
                </table>
               @else
             <div style="margin-top: 20px;text-align: center;font-weight: 600;">No transactions match this criteria.</div>
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
         $('#trade-form').submit();
        }
      });
	});
</script>

<script> 
$(document).ready(function() {
 $(".datepicker").datepicker(); 
}); 
</script>
@endsection