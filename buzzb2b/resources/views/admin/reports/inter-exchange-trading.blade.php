@extends('admin.layouts.base-2cols')
@section('title', 'Inter Exchange Trading')
@section('content')
<div class="row">
  <div class="col-md-12">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-12">
					<h3 class="panel-title bariol-thin"><i class="fa fa-lock"></i>{{ Session::get('EXCHANGE_CITY_NAME') }} : Reports</h3>
				</div>
			</div>
		</div>
	</div>
    <div class="traders-search">
        <form action="{{route('admin-search-exchange-traders')}}" id="exchange-trade-form" method="post">
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
    <!-- table start from here -->
    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th style="text-align: left;"></th>
                          <th  style="text-align: center;" colspan="2">Barter (T$)</th>
                          <th  style="text-align: center;" colspan="2">Barter Fees ($)</th>
                          <th  style="text-align: center;" colspan="2">Giftcard Fees ($)</th>
                          <th  style="text-align: center;" colspan="2">Referral Fees ($)</th>
                          <th  style="text-align: center;" colspan="2">Sales Fees ($)</th>
                          <th  style="text-align: center;" colspan="2">Tips ($)</th>
                         
                        </tr>
                        <tr>
              						<th style="">Exchange</th>
              						<th style="">In</th>
              						<th style="">Out</th>
              						<th style="">In</th>
              						<th style="">Out</th>
              						<th style="">In</th>
              						<th style="">Out</th>
              						<th style="">In</th>
              						<th style="">Out</th>
              						<th style="">In</th>
              						<th style="">Out</th>
              						<th style="">In</th>
              						<th style="">Out</th>
				                </tr>
                      </thead>
                      @foreach($exchange_trders as $exchange_trder)
                      <tbody>
                      <tr>
                        <td>{{$exchange_trder->city_name}}</td>
                        <td>$ {{$exchange_trder->barter_earn / 100}}</td>
                        <td>$ {{$exchange_trder->barter_out / 100}}</td>
                        <td>$ {{$exchange_trder->barter_in / 100}}</td>
                        <td>$ {{$exchange_trder->barter_fee_out / 100}}</td>
                        <td>$ {{$exchange_trder->gift_earn/10}}</td>
                        <td>$ {{$exchange_trder->gift_out/10}}</td>
                        <td>$ {{$exchange_trder->referral_in/10}}</td>
                        <td>$ {{$exchange_trder->referral_out/10}}</td>
                        <td>$ {{$exchange_trder->sales_earn/10}}</td>
                        <td>$ {{$exchange_trder->sales_out/10}}</td>
                        <td>$ {{$exchange_trder->tip_earn/100}}</td>
                        <td>$ {{$exchange_trder->tip_out/100}}</td>
                      </tr>
                   
                      </tbody>
                    @endforeach
                </table>
    <!-- end table here -->
    

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
         $('#exchange-trade-form').submit();
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