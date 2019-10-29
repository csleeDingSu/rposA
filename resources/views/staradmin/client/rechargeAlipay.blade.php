@extends('layouts.default_app')

@section('top-css')
    @parent   
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

        #passcode {
          /*display: block;
          line-height:0;*/
          height: 0;
          /*overflow: hidden;*/
          visibility: hidden;
        }
         
    </style> 
@endsection

@section('top-javascript')
    @parent
     <script src="{{ asset('clientapp/js/lrz.mobile.min.js') }}"></script>
  <!-- <script type="text/javascript" src="{{ asset('clientapp/js/being.js') }}"></script> -->


@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '支付宝充值')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')
<input id="hidSession" type="hidden" value="{{!empty(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidPoint" type="hidden" value="{{!empty($wallet['gameledger']['103']->point) ? $wallet['gameledger']['103']->point : 0}}" />
<input id="hidMemberId" type="hidden" value="{{!empty($member->id) ? $member->id : 0}}" />
<input id="hidCoin" type="hidden" value="{{!empty($coin) ? $coin : 0}}" />
<input id="hidCash" type="hidden" value="{{!empty($cash) ? $cash : 0}}" />
<input id="hidRequestId" type="hidden" value="{{!empty($content->record->id) ? $content->record->id : 0}}" />

@php($seller = $content->record)

<div class="loading2" id="loading2"></div>

        <div class="payTime">请在<span class="minute">10</span>:<span class="second">00</span>完成付款，超时需重新充值</div>
        <div class="aliPayBox">
          <h3>支付金额</h3>
          <p class="money"><i>￥</i><span>{{$cash}}</span></p>
          <p id="passcode">{{!empty($content->record->passcode) ? $content->record->passcode : 0}}</p>
          <a class="copyBtn" id="copyBtn">复制支付口令</a>
          <ul class="helpBox">
            <li>
              <img src="{{ asset('/clientapp/images/aliPay1.png') }}">
              <p>复制支付口令<br>粘贴支付宝搜索框</p>
            </li>
            <li>
              <img src="{{ asset('/clientapp/images/aliPay2.png') }}">
              <p>向卖家支付宝<br>支付充值金额</p>
            </li>
            <li>
              <img src="{{ asset('/clientapp/images/aliPay3.png') }}">
              <p>完成付款后<br>点击充值完成</p>
            </li>
          </ul>
          <div class="paySeller">
            <h2>卖家信息</h2>
            <p><span>用户账号</span><span>
                <font color="#666">{{ substr($seller->member->phone,0,3) }}*****{{ substr($seller->member->phone, -4) }}</font>
              </span></p>
            <p><span>转卖挖宝币</span><span>
                <font color="#ff696f">{{$coin}}币</font>
              </span></p>
            <p><span>收款方式</span><span>
                <font color="#2d95e0">银行卡</font>
              </span></p>
            <p><span>转卖时间</span><span>{{$seller->created_at}}</span></p>
          </div>
          <div class="inBtnbox">
            <h2>请确认您已完成支付，再点击“充值完成”</h2>
            <a class="paySend">充值完成</a>
          </div>
        </div>
@endsection

@section('footer-javascript')   
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
            $(document).ready(function () {
              $('.scrolly').addClass('aliPayPage fix');
              getToken();

            });

            $(function () {

              $('.copyBtn').click(function () {
                let txt = $(this).prev('p').html();
                console.log(txt);
                copyText(txt);
              });

              $('.paySend').click(function () {
                submitPay();
                
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
                window.location.href = "/recharge/list";
              });

              $('.payShade').click(function (e) {
                console.log($(e.target).html());
                let a = $(e.target).find('.inBox').length;
                if (a > 0) {
                  $('.payShade').removeClass('on');
                }
              });
            });

      function submitPay() {
          var memberid = $('#hidMemberId').val();
          var coin = $('#hidCoin').val();
          var cash = $('#hidCash').val();
          var buyer_name = $('#buyer_name').val();
          var id = $('#hidRequestId').val();

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
                          window.location.href = '/recharge/list';
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
var countdownMinute = 10 //10分钟倒计时
var startTimes = new Date() //开始时间
var endTimes = new Date(startTimes.setMinutes(startTimes.getMinutes() + countdownMinute)) //结束时间
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
