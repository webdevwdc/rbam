  @php use App\Address; @endphp
@extends('user_member.member.directory.layouts.base-2cols')
@section('content')
<div id="exchange-directory">
    <div class="row">
        <div class="col-xs-12 col-lg-7" style="margin-top:20px;">
            <div class="input-group">
                <input id="search_member" class="form-control input-lg" placeholder="Search members..." name="search_member" value="" type="text">
                <span class="input-group-btn" onclick="callingAgainstCheckBox()">
                    <button id="submit-directory-exchange-search" class="btn btn-default btn-lg btn-search" type="submit">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    </button>
                </span>
            </div>
        </div>
    </div>
    <div class="row" style="margin-right:-70px; !important;">
        <div class="col-xs-12">
            <div class="results-members" style="margin-top:20px;">
                
            </div>
        </div>
    </div>
</div>
 
<script type="text/javascript">

function _callAjax(exchanges, categories) { 
      strCategories = strExchanges = '';
      
      $(".dirCategory").each(function( index ) {
      //alert('under each function');
        if($(this).is(":checked")){
          strCategories += $(this).val()+',';
        }
      });
      
      $( ".dirExchange" ).each(function( index ) {
        if($(this).is(":checked")){
          strExchanges += $(this).val()+',';
        }
      });
      
      var searchMember = $("#search_member").val();
      var dataString = 'exchanges=' + encodeURIComponent(strExchanges) + '&search_member= '+ searchMember + '&category=' + encodeURIComponent(strCategories) + '&_token={{ csrf_token() }}';

      $.ajax({
        type: 'POST',
        dataType:'HTML',
        data: dataString,
        url: '{{route('member_directory_ajax')}}',
        beforeSend: function(){
          
        },
        success: function(succResponse){
          //alert(succResponse);
          $('.results-members').html(succResponse);
        }
        
      }); 
    }
    
  $(document).ready(function(){
    _callAjax();
    
  });
  
  function callingAgainstCheckBox()
  {
    alert(89);
    _callAjax();
  }
  

</script> 
@endsection