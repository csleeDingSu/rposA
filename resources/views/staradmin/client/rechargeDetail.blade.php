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
  <a class="returnBtn" href="/summary"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '订单详情')

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
          <h3>充值挖宝币</h3>
          <p><img src="{{asset('clientapp/images/summary/icon-coin-big.png')}}"><span>{{!empty($cash) ? $cash : 0}}</span></p>
          <ul class="payCard">
          <li><span>订单状态</span>
            <p class="name">{{empty($company->account_name) ? '' : $company->account_name}}</p><a class="copyBtn">复制</a>
          </li>
          <li><span>付款金额</span>
            <p class="name">{{empty($company->account_number) ? '' : $company->account_number}}</p><a class="copyBtn">复制</a>
          </li>
          <li><span>卖家信息</span>
            <p class="name">{{empty($company->account_number) ? '' : $company->account_number}}</p><a class="copyBtn">复制</a>
          </li>
          <li><span>订单编号</span>
            <p class="name">{{empty($company->account_number) ? '' : $company->account_number}}</p><a class="copyBtn">复制</a>
          </li>
          <li><span>下单时间</span>
            <p class="name">{{empty($company->account_number) ? '' : $company->account_number}}</p><a class="copyBtn">复制</a>
          </li>

        </ul>
          
        </div>

        
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
        </div>
        <div class="buyName">
          <span>您的姓名</span>
          <label><input id="buyer_name" type="text" placeholder="请输入您的真实姓名，以便核实发币"></label>
        </div>
        <div class="inBtnbox">
          <a class="paySend"><img src="{{asset('clientapp/images/coin/kefu2.png')}}"> 若有付款问题，请联系客服处理 ></a>
        </div>
@endsection

@section('footer-javascript')
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

      //充值完成

      $('.paySend').click(function () {
        // submitPay();
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

    </script>

@endsection
