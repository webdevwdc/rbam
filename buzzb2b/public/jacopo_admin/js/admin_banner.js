$(document).ready(function(){
	
	$('.orderChanged').hide();
	
        $("tbody").sortable({
			items: 'tr',
			opacity: 0.6,
			axis: 'y',
			stop: function (event, ui) {
			    var orderdata = $(this).sortable('toArray', { attribute: 'data-order' });
			    
				var iddata = $(this).sortable('toArray', { attribute: 'data-id' });
				
				$('.loaderdiv').show();
				$.ajax({
				url: BASE_URL+'banner/orderupdate',
				type: 'POST',
				data: {"_token":CSRF_TOKEN,"orderdata": orderdata.toString(),"iddata":iddata.toString()},
				success : function(response){
					$('.loaderdiv').hide();
					var data = $.parseJSON(response);
					//console.log(data);
					//alert(data.result);
					if (data.result == true) {
						//alert(loader_pic);
						var imageOrder = 1;
						$('.orderClass').each(function(){
						$(this).html(imageOrder);
						imageOrder = parseInt(imageOrder) + 1;
						});
						$('.orderChanged').show();
					}else{
						alert("Banner order is not changed.");
					}
				
				}
				}); 
			}
		    });

});
