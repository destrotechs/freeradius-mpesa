$(document).ready(function(){
   $('li a').click(function(){
     $('li a').each(function(a){
       $( this ).removeClass('selectedclass')
     });
     $( this ).addClass('selectedclass');
   });
  
  $('ul a').click(function(){
     $('ul a').each(function(a){
      $( this ).removeClass('selectedclass')
     });
     $( this ).addClass('selectedclass');
   });
});