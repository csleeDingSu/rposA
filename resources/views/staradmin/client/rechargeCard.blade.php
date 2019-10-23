@extends('layouts.default_app')

@section('top-css')
    @parent    
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
<div class="payMoney">
          <h2 class="timeHint">请在 <font color="#ffec15">10 : 00</font> 内完成付款，超时需重新充值</h2>
          <h3>支付金额</h3>
          <p><i>￥</i><span>196.00</span></p>
        </div>
        <ul class="payCard">
          <li><span>账户姓名</span>
            <p class="name">王小二</p><a class="copyBtn">复制</a></a>
          </li>
          <li><span>账户姓名</span>
            <p class="name">5888 9999 9888 6666 333</p><a class="copyBtn">复制</a></a>
          </li>
          <li><span>银行名称</span>
            <p>
              <font color="#2d95e0">建设银行</font>
            </p>
          </li>
        </ul>
        <div class="paySeller">
          <h2>卖家信息</h2>
          <p><span>用户账号</span><span>
              <font color="#666">157****6889</font>
            </span></p>
          <p><span>转卖挖宝币</span><span>
              <font color="#ff696f">200币</font>
            </span></p>
          <p><span>收款方式</span><span>
              <font color="#2d95e0">银行卡</font>
            </span></p>
          <p><span>转卖时间</span><span>2019-11-20 15:30</span></p>
        </div>
        <div class="buyName">
          <span>您的姓名</span>
          <label><input type="text" placeholder="请输入您的真实姓名，以便核实发币"></label>
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
            $(document).ready(function () {
              $('.scrolly').addClass('payCardPage');
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
        $('.payShade').addClass('on');
      });

      $('.payShade').click(function (e) {
        console.log($(e.target).html());
        let a = $(e.target).find('.inBox').length;
        if (a > 0) {
          $('.payShade').removeClass('on');
        }
      });

    });
      

    </script>

@endsection
