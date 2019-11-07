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
          margin: 0.2rem 0 0 0;
        }

        .payCardPage .payMoney h3{
          color: #aaa !important;
          font-size: 0.32rem !important;
        }

        .payCardPage .payMoney p{
          color: #333 !important;
          font-size: 0.62rem !important;
        }
        
        .payCardPage .payMoney p img{
          height: 0.5rem;
        }

        .payCardPage .payMoney p span{
          padding: 0 0.1rem;
        }

        .payCardPage .payCard li span {
          color: #333 !important;
        }

        .payCardPage .payCard .status {
          width: 80%;
          margin: 0;
          text-align: right;
        }

        .payCardPage .payCard .fail {
          color: #ff4e4e !important;
        }

        .payCardPage .payCard .success {
          color: #23ca27 !important;
        }

        .payCardPage .payCard .in-progress {
          color: #6ac2ff !important;
        }

        .payCardPage .payCard .amount {
          color: #333 !important;
        }

        .payCardPage .payCard .seller{
          color: #999 !important;
        }

        .payCardPage .payCard .orderid {
          color: #aaa !important;
          margin: 0 !important;
        }

        .payCardPage .payCard .when {
          color: #aaa !important;
        }

        .payCardPage .inBtnbox {
          width: 100%;
    text-align: center;
    margin: 0.5rem;
        }

        .paySend {
          /*display: inline-block;*/
          font-size: .3rem !important;
          color: #fff !important;
          /*padding: 0 .12rem;*/
          /*line-height: .38rem;*/
          border-radius: 1rem !important;
          background-image: linear-gradient(to right, #d5eaf8 0%, #2d95e0 100%) !important;
          padding: 0.2rem !important;

        }

        .paySend img{
          height: 0.5rem;
        }

        .payCardPage .payCard .copy {
          color: #ff4141 !important;
        }

        .payCardPage .payCard .copy-success {
          color: #23ca27 !important;
        }

        .point {
          padding: 0.5rem;
        }

        .payCardPage .payCard .reason {
          font-size: 0.24rem !important;
          border-radius: 10px;
          background-color: #f9f9f9;
          padding: 0.1rem;
          color: #ff4e4e !important;
        }

    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('test/html_design/css/style.css') }}" />
@endsection

@section('top-javascript')
    @parent
     <script src="{{ asset('clientapp/js/lrz.mobile.min.js') }}"></script>

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
<input id="hidRechargeId" type="hidden" value="{{!empty($recharge_id) ? $recharge_id : 0}}" />
<div class="loading2" id="loading2"></div>

<div class="payMoney">
  <h3>充值挖宝币</h3>
  <p class="point"><img src="{{asset('clientapp/images/summary/icon-coin-big.png')}}"><span id="point">0</span></p>
  <ul class="payCard">
    <li><span>订单状态</span><span class="status" id="status"><span class="reason">原因：test</span>付款失败</span><hr/></li>
    <li><span>付款金额</span><span class="status amount" id="amount">180元</span><hr/></li>
    <li><span>卖家信息</span><span class="status seller" id="phone">123***123</span><hr/></li>
    <li><span>订单编号</span><span class="status"><span class="copy">复制</span><span class="orderid" id="orderid">112222</span><hr/></li>
    <li><span>下单时间</span><span class="status when" id="when">2019-11-11 11:11:11</span><hr/></li>
    <li>
      <div class="inBtnbox">
        <a class="paySend"><img src="{{asset('clientapp/images/coin/kefu2.png')}}"> 若有付款问题，请联系客服处理 ></a>
      </div>
    </li>
  </ul>

</div>

        
        
        
@endsection

@section('footer-javascript')
      @parent
      <script type="text/javascript">
        var token = null;

        document.onreadystatechange = function () {
        var state = document.readyState
        if (state == 'interactive') {
        } else if (state == 'complete') {
            document.getElementById('interactive');
            document.getElementById('loading').style.visibility="hidden";
            // document.getElementById('loading2').style.visibility="visible";
            $('.loading').css('display', 'initial');
        }
      }

        $(document).ready(function () {
          $('.scrolly').addClass('payCardPage');
          getToken();
        });

            $(function () {
      //复制
      $('.copy').click(function () {
        $(this).html("复制");
        let txt = $(this).next('span').html();
        console.log(txt);
        copyText(txt);
        $(this).removeClass('copy');
        $(this).html("成功");
        $(this).addClass('copy-success');
      });


    });

  function getToken(){
    var session = $('#hidSession').val();
    var id = $('#hidMemberId').val();
    var recharge_id = $('#hidRechargeId').val();
    //login user
    if (id > 0) {
        
        document.getElementById('loading2').style.visibility="visible";

        $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
            // console.log(data);
            if(data.success) {
                token = data.access_token;
                getRechargeDetail(recharge_id);
            }
        });
    }
  }

  function getRechargeDetail(id) {
    var memberid = $('#hidMemberId').val(); 
    $.ajax({
          type: 'GET',
          url: "/api/buyer-tree",
          data: { 'memberid': memberid, 'id' : id },
          dataType: "json",
          beforeSend: function( xhr ) {
              xhr.setRequestHeader ("Authorization", "Bearer " + token);
          },
          error: function (error) { 
              document.getElementById('loading2').style.visibility="hidden";
              console.log(error.responseText);
              alert('下载失败，重新刷新试试');
            },                  
          success: function(data) {
            document.getElementById('loading2').style.visibility="hidden";
            console.log(data);
            console.log(data.record);
            var status = data.record.status_id;
            var is_locked = data.record.is_locked;
            var amount = data.record.amount;
            var point = data.record.point;
            var phone = data.record.member.phone;
            phone = (phone != '') ? (phone.substring(0,3) + '*****' + phone.slice(-4)) : '';
            var orderid = data.record.uuid;
            var when = data.record.created_at;
            var txt_status = '';
            var txt_reason = '';
            var cls_status = 'in-progress';

            if (status == 1) {
              txt_status = '等待付款';
            } else if (status == 2 && is_locked == 1) {
              txt_status = '等待付款';
            } else if (status == 2 && is_locked != 1) {
              txt_status = '等待卖家';
            } else if (status == 3) {
              txt_status = '已提交审核';
            } else if (status == 4) {
              txt_status = '交易成功';
              var cls_status = 'success';
            } else if (status == 5) {
              txt_reason = '付款超时';
              cls_status = 'fail';
              txt_status = '<span class="reason">原因：' + txt_reason + '</span>交易失败';
            } else if (status == 7) {
              txt_reason = data.record.reason;
              cls_status = 'fail';
              txt_status = '<span class="reason">原因：' + txt_reason + '</span>交易失败';
            }

            $("#status").html(txt_status);
            $("#status").addClass(cls_status);
            $("#point").html(parseInt(point));
            $("#amount").html(parseInt(amount)+ '元');
            $("#phone").html(phone);
            $("#orderid").html(orderid);
            $("#when").html(when);
          }
      });
  }

    </script>

@endsection
