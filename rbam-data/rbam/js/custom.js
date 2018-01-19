$('input[type=checkbox]').on('change', function() {
  var div = $(this).closest('.check-bx');
  $(this).is(":checked") ? div.addClass("checked-bg") : div.removeClass("checked-bg");
});
/******/
$('.collapse').on('shown.bs.collapse', function(){
$(this).parent().find(".fa").removeClass("fa-plus").addClass("fa-minus");
}).on('hidden.bs.collapse', function(){
$(this).parent().find(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
});
/****/
$(function () {
  $('[data-toggle="popover"]').popover()
})

/*$(document).ready(function () {
    $('img#photo').imgAreaSelect({
        aspectRatio: '1:1',
        onSelectEnd: getSizes
    });
});*/