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



const copyText = (text) => {
  const textString = text.toString();
  let input = document.querySelector('#copy-input');
  if (!input) {
    input = document.createElement('input');
    input.id = "copy-input";
    input.readOnly = "readOnly";        // 防止ios聚焦触发键盘事件
    input.style.position = "fixed";
    input.style.left = "-1000px";
    input.style.zIndex = "-1000";
    input.style.opacity = "0";
    document.body.appendChild(input)
  }
  input.value = textString;
  selectText(input, 0, textString.length);
  if (document.execCommand('copy')) {
    document.execCommand('copy');
    // alert('已复制到粘贴板');
  }else {
    console.log('不兼容');
  }
  input.blur();
  function selectText(textbox, startIndex, stopIndex) {
    if (textbox.createTextRange) {//ie
      const range = textbox.createTextRange();
      range.collapse(true);
      range.moveStart('character', startIndex);//起始光标
      range.moveEnd('character', stopIndex - startIndex);//结束光标
      range.select();//不兼容苹果
    } else {//firefox/chrome
      textbox.setSelectionRange(startIndex, stopIndex);
      textbox.focus();
    }
  }
};



