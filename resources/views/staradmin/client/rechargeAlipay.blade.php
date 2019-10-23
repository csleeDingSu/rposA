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

@section('title', '支付宝充值')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')

        <div class="payTime">请在<span>10</span>:<span>00</span>完成付款，超时需重新充值</div>
        <div class="aliPayBox">
          <h3>支付金额</h3>
          <p class="money"><i>￥</i><span>196.00</span></p>
          <a class="copyBtn">复制支付口令</a>
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
          <div class="inBtnbox">
            <h2>请确认您已完成支付，再点击“充值完成”</h2>
            <a class="paySend">充值完成</a>
          </div>
        </div>
@endsection

@section('footer-javascript')   
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
            });

            $(function () {

              $('.paySend').click(function () {
                being.showMsg('.coinShade');
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
              });
            });
      

    </script>

@endsection
