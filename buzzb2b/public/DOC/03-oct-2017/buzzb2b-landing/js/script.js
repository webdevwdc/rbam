$(document).ready(function(){

myArray = ["Dining", "Air Conditioning", "Advertising", "Window Tinting"];

var options = {
  fadeInSpeed: 1000,
  displayDuration: 2000,
  fadeOutSpeed: 1000,
  delay: 500
};

$("#example").cycleText(myArray, options);

});
