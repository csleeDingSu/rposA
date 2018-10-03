$('.radio-primary').click(function(){
    $('.radio-primary').not(this).find('.radio').removeClass('clicked');
    $(this).find('.radio').toggleClass('clicked');
  });