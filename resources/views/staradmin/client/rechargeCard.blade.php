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

@section('title', '银行卡充值')

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
@php($bank = $content->record)

<div class="loading2" id="loading2"></div>
<div class="payMoney">
          <h2 class="timeHint">请在 <font color="#ffec15">10 : 00</font> 内完成付款，超时需重新充值</h2>
          <h3>支付金额</h3>
          <p><i>￥</i><span>{{$cash}}</span></p>
        </div>
        <ul class="payCard">
          <li><span>账户姓名</span>
            <p class="name">{{$bank->account_name}}</p><a class="copyBtn">复制</a></a>
          </li>
          <li><span>银行号码</span>
            <p class="name">{{$bank->account_number}}</p><a class="copyBtn">复制</a></a>
          </li>
          <li><span>银行名称</span>
            <p>
              <font color="#2d95e0">{{$bank->bank_name}}</font>
            </p>
          </li>
        </ul>
        <div class="paySeller">
          <h2>卖家信息</h2>
          <p><span>用户账号</span><span>
              <font color="#666">157****6889</font>
            </span></p>
          <p><span>转卖挖宝币</span><span>
              <font color="#ff696f">{{$coin}}币</font>
            </span></p>
          <p><span>收款方式</span><span>
              <font color="#2d95e0">银行卡</font>
            </span></p>
          <p><span>转卖时间</span><span>{{$bank->created_at}}</span></p>
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
<div class="payShade">
    <div class="inBox">
      <p>付款已超时，返回充值页面</p>
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
        let txt = $(this).prev('p').html();
        console.log(txt);
        copyText(txt);
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
                data: { 'memberid': memberid, 'coin': coin, 'cash': cash, 'buyer_name': buyer_name, 'id' : id },
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
                        $('.payShade').addClass('on');
                        // setTimeout(function(){ 
                        //   window.location.href = '/profile';
                        // }, 5000);                      
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
      

    </script>

@endsection
