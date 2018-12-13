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
  //溢出元素
  overHidden: function(cname) {
    var _h = $(window).height();
    var boxname;
    if (cname == null || cname - undefined) {
      boxname = $(".bodyView");
    } else {
      boxname = $(cname);
    }
    boxname.css({
      height: _h,
      "overflow-y": "hidden",
      display: "none"
    });
  },
  overShow: function(cname) {
    var _h = $(window).height();
    var boxname;
    if (cname == null || cname - undefined) {
      boxname = $(".bodyView");
    } else {
      boxname = $(cname);
    }
    console.log(_h);
    boxname.removeAttr("style");
  },
  //遮罩
  wrapShow: function(cname) {
    var that = this;
    var len = $("body").find(".wrapBox").length;
    if (len > 0) {
      return;
    } else {
      var wrap = '<div class="wrapBox opacity2">&nbsp;</div>';
      var me = this;
      // 遮罩显示
      if (cname) {
        $(cname).append(wrap);
      } else {
        $("body").append(wrap);
      }
    }
  },
  //遮罩
  wrapHide: function(callback) {
    $(".wrapBox").fadeOut(150, function() {
      if(callback && typeof callback == 'function'){
        callback();
      }
      $(this).remove();
      
    });
  },
  //删除全部遮罩
  wrapfaOutAll: function() {
    $(".wrapBox").fadeOut(150, function() {
      $(this).remove();
    });
  },
  //显示--scale
  scaleShow: function(cname, callback) {
    var cname = $(cname);
    cname.addClass("scaleShow").removeClass("scaleHide");
    if (callback && typeof callback == "function") {
      callback();
    }
  },
  //隐藏-scale
  scaleHide: function(cname) {
    var cname = $(cname);
    cname.addClass("scaleHide").removeClass("scaleShow");
  },
  //load
  loadShow: function(time, title, callback) {
    var that = this;
    var html =
      '<div class="loadIng"><div class="inBox dflex"><img src="../images/Loading.gif">';
    html += "<p>" + title + "</p>";
    html += "</div></div>";
    $(".container").append(html);
    that.wrapShow(".container");
    that.scaleShow(".loadIng");
    setTimeout(function() {
      that.loadHide(callback);
    }, time);
  },
  loadHide: function(callback) {
    var that = this;
    that.wrapHide();
    $(".loadIng").fadeOut(150, function() {
      if (callback && typeof callback == "function") {
        callback();
      }
      $(this).remove();
    });
  },
  success: function(title, callback) {
    var that = this;
    var title = title != "" ? title : "成功";
    var html = "";
    html += '<div class="successBox scaleHide dflex-2">';
    html += '<div class="inBox">';
    html += '<div class="inBody">';
    html += '<i class="icon"></i>';
    html += "<h2>" + title + "</h2>";
    html += "</div>";
    html += '<div class="btnBox dbox"><a class="dbox1 sureBtn">确定</a></div>';
    html += "</div>";
    html += "</div>";
    $(".card").append(html);
    that.wrapShow(".card");
    that.scaleShow(".successBox");
    if (callback && typeof callback == "function") {
      callback();
    }

    $(".successBox")
      .find(".sureBtn")
      .click(function() {
        that.wrapHide();
        that.successHide(callback);
      });

    $(".successBox")
      .find(".closeBtn")
      .click(function() {
        that.wrapHide();
        that.successHide();
      });
  },
  successHide: function(callback) {
    $(".successBox").fadeOut(150, function() {
      if (callback && typeof callback == "function") {
        callback();
      }
      $(this).remove();
    });
  },

  wrong: function(title, callback) {
    var that = this;
    var html =
      '<div class="wrongBox scaleHide dflex-2"><div class="inBox"><p>' +
      title +
      "</p></div></div>";
    $(".card").append(html);
    that.wrapShow(".card");
    that.scaleShow(".wrongBox");
    $(".wrongBox").click(function() {
      clearTimeout(ctime);
      that.wrongHide(callback);
    });

    var ctime = setTimeout(function() {
      console.log("timeDie");
      that.wrongHide(callback);
    }, 3000);
  },
  wrongHide: function(callback) {
    var that = this;
    that.wrapHide();
    $(".wrongBox").fadeOut(150, function() {
      if (callback && typeof callback == "function") {
        callback();
      }
      $(this).remove();
    });
  },
  //验证码
  telCode: function(ckname, time) {
    var i;
    $(ckname).addClass("die");
    live();

    function live() {
      i = parseInt(time);
      $(ckname).html("剩余" + i + "s");
      $(ckname).unbind("click");
      window._time = setInterval(muns, 1000);
    }

    function muns() {
      if (i == 1) {
        $(ckname).html("重发验证码");
        $(ckname).bind("click", live);
        clearInterval(_time);
        $(ckname).removeClass("on");
      } else {
        i--;
        $(ckname).html("剩余" + i + "s");
      }
    }
  },
  anRight: function(cname) {
    var me = this;
    var cname = $(cname);
    $(cname).show(0);
    cname.animate(
      {
        right: 0
      },
      150
    );
    me.overHidden();
  },
  anRightReturn: function(cname) {
    var me = this;
    var cname = $(cname);
    cname.animate(
      {
        right: "-100%"
      },
      150
    );
    $(cname).hide(0);
  },
  anBottom: function(cname) {
    var cname = $(cname);
    cname.animate(
      {
        bottom: 0
      },
      150
    );
  },
  anBottomReturn: function(cname) {
    var cname = $(cname);
    cname.animate(
      {
        bottom: "-100%"
      },
      150
    );
  },
  scrollBottom: function(a, b, callback) {
    var a = $(a);
    var b = $(b);
    if (a) {
      a.scroll(function() {
        var wHeight = a.height();
        var dHeight = b.height();
        var sHeight = dHeight - wHeight - 1;
        console.log(
          wHeight + ":::" + dHeight + ":::" + sHeight + "::" + a.scrollTop()
        );
        if (sHeight > 0) {
          if (a.scrollTop() >= sHeight) {
            if (callback && typeof callback == "function") {
              callback();
            }
          } else {
          }
        } else {
          console.log("暂无更多");
        }
      });
    } else {
      $(window).scroll(function() {
        var wHeight = $(window).height();
        var dHeight = $(document).height();
        console.log(dHeight);
        var sHeight = dHeight - wHeight;
        if (sHeight > 0) {
          if ($(window).scrollTop() >= sHeight) {
            if (callback && typeof callback == "function") {
              callback();
            } else {
              console.log("暂无更多");
            }
          }
        } else {
          console.log("暂无更多");
        }
      });
    }
  },

  tabBar: function(hname, bname) {
    var hn = $(hname);
    var bn = $(bname);
    hn.click(function() {
      var i = $(this).index();
      $(this)
        .addClass("on")
        .siblings()
        .removeClass("on");
      bn.children()
        .eq(i)
        .fadeIn("150")
        .siblings()
        .hide(0);
    });
  },
  run: function() {
    var that = this;
    console.log(this);
  }
};

being.runInlay(750);

$(function() {
  document.body.addEventListener("touchstart", function() {});
});
