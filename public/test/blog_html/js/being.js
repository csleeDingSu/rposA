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
};
 

being.runInlay(750);

$(function() {
  document.body.addEventListener("touchstart", function() {});
});
