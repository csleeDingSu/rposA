@extends('layouts.default_app')

@section('top-css')
    @parent    
    <style type="text/css">
      body {
        background: #f2f2f2;
      }
    </style>
    <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loading2 {
          position: fixed;
          left: 0px;
          top: 0;
          width: 100%;
          height: 100%;
          z-index: 9999;
          background: url(/client/images/preloader.gif) center no-repeat;
          background-color: rgba(255, 255, 255, 0.5);
          background-size: 32px 32px;
          visibility: hidden;
        }

        .payMoney {
          height: 3.3rem;
        }

        .payCardPage .buyName input {
          margin-top: 0.1rem !important;
          font-weight: 500 !important;
        }
         
         .guideCard {
          display: block;
          margin: 0 2.2rem;
          font-size: .28rem;
          color: #666;
          line-height: .68rem;
          text-align: center;
          margin-bottom: .2rem;   
          border-radius: 1rem;
          background-color: #f4f4f4;

        }

        .guideCard img{
          height: 0.5rem;
          margin-top: -0.03rem;
        }

        .arrow {
          height: 0.3rem !important;
        }

        .cbank {
          color: #999 !important;
          font-size: 0.26rem !important;
          padding: 0 0.1rem !important;
        }

        .cJcheng .inShow .hintBox {
          margin-bottom: 1.5rem !important;
        }

        .cJcheng{
          background: rgba(0, 0, 0, 0.5) !important;
        }

        .coinShade img {
          height: 100% !important;
        }

        .copyBtnOrderId {
          display: inline-block;
          font-size: .2rem;
          color: #fff;
          padding: 0 .12rem;
          line-height: .38rem;
          border-radius: .05rem;
          background: #2d95e0;
          margin: 0 0 0 0.1rem;

        }

        .orderid {
          text-align: right;
          width: 75%;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('test/html_design/css/style.css') }}" />
@endsection

@section('top-javascript')
    @parent
     <script src="{{ asset('clientapp/js/lrz.mobile.min.js') }}"></script>
  <!-- <script type="text/javascript" src="{{ asset('test/html_design/js/being.js') }}"></script> -->
  <script type="text/javascript">
var being2 = {
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
  }
  };
      </script>


@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="/recharge"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '银行卡充值')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')

<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidPoint" type="hidden" value="{{!empty($wallet['gameledger']['103']->point) ? $wallet['gameledger']['103']->point : 0}}" />
<input id="hidMemberId" type="hidden" value="{{!empty($member->id) ? $member->id : 0}}" />
<input id="hidCoin" type="hidden" value="{{!empty($coin) ? $coin : 0}}" />
<input id="hidCash" type="hidden" value="{{!empty($cash) ? $cash : 0}}" />
<input id="hidRequestId" type="hidden" value="{{!empty($content->record->id) ? $content->record->id : 0}}" />
<input id="hidExpired" type="hidden" value="{{!empty($content->record->locked_time->date) ? $content->record->locked_time->date : (!empty($content->record->locked_time) ? $content->record->locked_time : 0)}}" />

@php($recod = empty($content->record) ? null : $content->record)
@php($company = empty($content->company) ? null : $content->company)

<div class="loading2" id="loading2"></div>

<div class="payMoney">
          <h2 class="timeHint">请在 <font color="#ffec15"><span class="minute">10</span> : <span class="second">00</span></font> 内完成付款，超时需重新充值</h2>
          <h3>支付金额</h3>
          <p><i>￥</i><span>{{!empty($cash) ? $cash : 0}}</span></p>
          <a class="guideCard cJchengShow"><img src="{{ asset('/clientapp/images/recharge/alipay.png') }}">&nbsp;<img src="{{ asset('/clientapp/images/recharge/weixin.png') }}">&nbsp;转账教程&nbsp;<img class="arrow" src="{{ asset('/clientapp/images/recharge/l.png') }}"></a>
        </div>

        <ul class="payCard">
          <li><span>账户姓名</span>
            <p class="name">{{empty($company->account_name) ? '' : $company->account_name}}</p><a class="copyBtn">复制</a>
            <p class="cbank">{{empty($company->bank_name) ? '银行名称' : $company->bank_name}}</p>
          </li>
          <li><span>银行号码</span>
            <p class="name">{{empty($company->account_number) ? '' : $company->account_number}}</p><a class="copyBtn">复制</a>
          </li>
        </ul>
        <div class="paySeller">
          <h2>卖家信息</h2>
          <p><span>用户账号</span><span>
              <font color="#666">{{ empty($company->phone) ? '' : substr($company->phone,0,3) }}*****{{ empty($company->phone) ? '' : substr($company->phone, -4) }}</font>
            </span></p>
          <p><span>转卖挖宝币</span><span>
              <font color="#ff696f">{{!empty($coin) ? $coin : 0}}币</font>
            </span></p>
          <p><span>收款方式</span><span>
              <font color="#2d95e0">银行卡</font>
            </span></p>
          <p><span>转卖时间</span><span>{{empty($recod->created_at) ? '' : $recod->created_at}}</span></p>
          <p><span>订单编号</span><span class="orderid" id="orderid">{{empty($recod->uuid) ? '' : $recod->uuid}}</span><a class="copyBtnOrderId">复制</a></span></p>
        </div>
        <div class="buyName">
          <span>您的姓名</span>
          <label><input id="buyer_name" type="text" placeholder="请输入您的真实姓名，以便核实发币"></label>
        </div>
        <div class="inBtnbox">
          <h2>请确认您已完成支付，再点击“充值完成”</h2>
          <a class="paySend">充值完成</a>
        </div>
@endsection

@section('footer-javascript')
<!-- 充值教程 -->
<div class="cJcheng">
    <div class="inShow">
        <div class="hd"><a class="on">支付宝转账</a> <a>微信转账</a></div>
        <div class="bd">
            <div class="inBox">
                <ul>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/alpay-1.png') }}" />
                            <p>01打开支付宝选择“转账”</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/alpay-2.png') }}" />
                            <p>02选择“转到银行卡”</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/alpay-3.png') }}" />
                            <p>03输入银行卡信息及金额</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/alpay-4.png') }}" />
                            <p>04确认转账信息及备注手机账号</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/alpay-5.png') }}" />
                            <p>05确认支付金额</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/alpay-6.png') }}" />
                            <p>06账单提示“付款成功”完成操作</p>
                        </div>
                    </li>
                </ul>
                <div class="hintBox">
                    <p>
                        付款成功后，<br /> 返回平台“确认充值”页面点击“充值完成”
                    </p>
                </div>
            </div>
            <div class="inBox">
                <ul>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/wxpay-1.png') }}" />
                            <p>01打开微信钱包选择“收付款”</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/wxpay-2.png') }}" />
                            <p>02下拉选择“转账到银行卡”</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/wxpay-3.png') }}" />
                            <p>03输入银行卡信息及金额</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/wxpay-4.png') }}" />
                            <p>04确认转账信息备注手机账号</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/wxpay-5.png') }}" />
                            <p>05选择右上角“支付中心”图标</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/wxpay-6.png') }}" />
                            <p>06选择“账单”功能</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/wxpay-7.png') }}" />
                            <p>07查看支付账单信息</p>
                        </div>
                    </li>
                    <li>
                        <div>
                            <img src="{{ asset('/clientapp/images/help/wxpay-8.png') }}" />
                            <p>08确认“到账成功”</p>
                        </div>
                    </li>
                </ul>
                <div class="hintBox">
                    <p>
                        付款成功后，<br /> 返回平台“确认充值”页面点击“充值完成”
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="payShade">
    <div class="inBox">
      <p>付款已超时，返回充值页面</p>
    </div>
  </div>

  <div class="coinShade ">
      <div class="inBox fix">
        <img src="{{ asset('/clientapp/images/coinShare.png') }}">
        <h2>充值完成</h2>
        <p>预计5-10分钟内挖宝币到账，<br>
          您可以在-<font color="#ff9528">充值记录</font>-查看进展</p>
          <a class="inClostBtn">我知道了</a>
      </div>
    </div>

      @parent
      <script type="text/javascript">
        var token = null;

            $(document).ready(function () {
              $('.scrolly').addClass('payCardPage');
              getToken();
            });

            $(function () {
      //复制
      $('.copyBtn').click(function () {
        $('.copyBtn').css('background-color', '#2d95e0');
        $(this).html("复制");
        let txt = $(this).prev('p').html();
        console.log(txt);
        copyText(txt);
        $(this).html("成功");
        $(this).css('background-color','#35cd4e');
      });

      $('.copyBtnOrderId').click(function () {
        $('.copyBtnOrderId').css('background-color', '#2d95e0');
        $(this).html("复制");
        let txt = $(this).prev('span').html();
        console.log(txt);
        copyText(txt);
        $(this).html("成功");
        $(this).css('background-color','#35cd4e');
      });

      //充值完成

      $('.paySend').click(function () {
        submitPay();
      });

      $('.payShade').click(function (e) {
        console.log($(e.target).html());
        let a = $(e.target).find('.inBox').length;
        if (a > 0) {
          $('.payShade').removeClass('on');
        }
        being.hideMsg('.payShade');
      });

      $('.coinShade ').click(function (e) {
          console.log($(e.target).html());
          let a = $(e.target).find('.inBox').length;
          if(a>0){
            being.hideMsg('.coinShade');
          }
        });

        $('.inClostBtn').click(function(){
          being.hideMsg('.coinShade');
          window.location.href = "/summary";
        });

        // 充值教程
        $(".cJchengShow").click(() => {
            being2.wrapShow();
            $(".cJcheng").slideDown(150);
        });

        $(".cJcheng .hd a").click(function() {
            let that = $(this);
            let i = that.index();
            that
                .addClass("on")
                .siblings()
                .removeClass("on");
            $(".cJcheng .bd .inBox")
                .eq(i)
                .fadeIn(0)
                .siblings()
                .fadeOut(0);
        });
        $(".cJcheng").click(function(e) {
            var target = $(e.target).closest(".inShow").length;
            if (target > 0) {
                return;
            } else {
                $(".cJcheng").slideUp(150);
                being2.wrapHide();
            }
        });

    });


        function submitPay() {
          var memberid = $('#hidMemberId').val();
          var coin = $('#hidCoin').val();
          var cash = $('#hidCash').val();
          var buyer_name = $('#buyer_name').val();
          var id = $('#hidRequestId').val();

          if (buyer_name == '') {
            $('.payShade .inBox').html('<p>请填写你的姓名</p>');
            being.showMsg('.payShade');
            return false;
          }

          document.getElementById('loading2').style.visibility="visible";

          $.ajax({
                type: 'POST',
                url: "/api/make-resell-paid",
                data: { 'buyerid': memberid, 'coin': coin, 'cash': cash, 'buyer_name': buyer_name, 'id' : id },
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { 
                    document.getElementById('loading2').style.visibility="hidden";
                    console.log(error.responseText);
                    alert('提交失败');
                  },                  
                success: function(data) {
                    document.getElementById('loading2').style.visibility="hidden";
                    if(data.success){
                        being.showMsg('.coinShade');
                        setTimeout(function(){ 
                          window.location.href = '/summary';
                        }, 3000);                      
                    } else {
                      console.log(data);
                      alert('提交失败');
                    }
                }
            });
           
        }

        function getToken(){
          var session = $('#hidSession').val();
          var id = $('#hidMemberId').val();
          //login user
          if (id > 0) {
              $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
                  // console.log(data);
                  if(data.success) {
                      token = data.access_token;
                  }
              });
          }
        }


        var txt_arr = ["充值未成功请重新生成"];
var num = 0;
var timer_txt = setInterval(function () {
    //text.innerText = txt_arr[num];
    num++;
    if (num === 4) {
        num = 0;
    }
}, 1500)

//倒计时
var minute = document.querySelector(".minute")
var second = document.querySelector(".second")
// 准备
var t = $('#hidExpired').val().split(/[- :]/);
var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
var expired = new Date(d);
var countdownMinute = 10 //10分钟倒计时
var startTimes = new Date() //开始时间
var endTimes = (expired==0) ? new Date(startTimes.setMinutes(startTimes.getMinutes() + countdownMinute)) : expired //结束时间
var curTimes = new Date() //当前时间
var surplusTimes = endTimes.getTime() / 1000 - curTimes.getTime() / 1000 //结束毫秒-开始毫秒=剩余倒计时间

// 进入倒计时
countdowns = window.setInterval(function () {
    surplusTimes--;
    var minu = Math.floor(surplusTimes / 60)
    var secd = Math.round(surplusTimes % 60)
    // console.log(minu+":"+secd)
    minu = minu <= 9 ? "0" + minu : minu
    secd = secd <= 9 ? "0" + secd : secd
    minute.innerHTML = minu
    second.innerHTML = secd
    // checkdata();
    if (surplusTimes <= 0) {
        alert("订单已过期,请勿支付,请重新发起订单！");
        window.history.go(-1);
        location.reload();
        clearInterval(countdowns)
    }
}, 1000)

function closeWebPage() {
    var userAgent = navigator.userAgent;
    if (userAgent.indexOf("Firefox") != -1 || userAgent.indexOf("Chrome") != -1) {
        window.location.href = "about:blank";
    } else if (userAgent.indexOf("Android") > -1 || userAgent.indexOf("Linux") > -1) {
        window.opener = null;
        window.open("about:blank", "_self", "").close();
    } else {
        window.pener = null;
        window.open("about:blank", "_self");
        window.close();
    }
}

      

    </script>

@endsection
