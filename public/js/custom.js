$(document).ready(function(){
  
  $(".btn-primary").on("mouseover",function(){
    $(this).parent('div').addClass('bg-darkblue');
  });
   $(".btn-primary").on("mouseout",function(){
    $(this).parent('div').removeClass('bg-darkblue');
  });
   $(".card").fadeIn(1000);
});