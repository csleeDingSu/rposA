var being = {
  respond: function(width) {
      var deviceWidth = document.documentElement.clientWidth || window.innerWidth;
      if (deviceWidth >= width) {
        deviceWidth = width;
      }
      if (deviceWidth <= 320) {
        deviceWidth = 320;
      }
      document.documentElement.style.fontSize = deviceWidth / 7.5 + "px";

  },
  //字体大小
  runInlay: function(data) {
    var me = this;
    me.respond(data);
	window.onresize = function() {
		me.respond(data);
	  };
  },
  shade:()=>{
    let html='<div class="card-shade"></div>';
    let i=$('body').find('.card-shade').length
    if(i<1){
      $('body').append(html);
      $('.card-shade').fadeIn(150);
    }
  },
  showMsg:function(classname){
    let that=this;
    that.shade();
    let cname=$(classname);
    cname.addClass('on');
  },
  hideMsg:function(classname){
    $('.card-shade').fadeOut(150,()=>{
      $('.card-shade').remove();
    });
    let cname=$(classname);
    cname.removeClass('on');
  },
};
 

being.runInlay(750);

$(function() {
  document.body.addEventListener("touchstart", function() {});
});

window.onload = function() {
  // 阻止双击放大
  var lastTouchEnd = 0;
  document.addEventListener('touchstart', function(event) {
      if (event.touches.length > 1) {
          event.preventDefault();
      }
  });
  document.addEventListener('touchend', function(event) {
      var now = (new Date()).getTime();
      if (now - lastTouchEnd <= 300) {
          event.preventDefault();
      }
      lastTouchEnd = now;
  }, false);

  // 阻止双指放大
  document.addEventListener('gesturestart', function(event) {
      event.preventDefault();
  });
}





