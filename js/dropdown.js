$(document).ready(function(){
    $('.dropdown').hover(function(){
      $(this).find('.dropdown-menu').first().stop(true, true).slideDown(300);
    }, function(){
      $(this).find('.dropdown-menu').first().stop(true, true).slideUp(200);
    });
});