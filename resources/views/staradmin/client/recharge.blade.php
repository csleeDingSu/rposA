@extends('layouts.default_app')

@section('top-css')
    @parent
    <style type="text/css">
      body {
        background: #f2f2f2;
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

@section('title', '充值挖宝币')

@section('right-menu')
<a href="/recharge/list" class="rechargeListBtn">充值记录</a>
@endsection
<!-- top nav end-->

@section('content')
<!-- <div class="cionPage rechargePage"> -->
<div class="hrf3"></div>

        <div class="coinBox">
          <div class="inTitle">
            <h2>选择数量</h2>
          </div>
          <ul class="inList">
            <li class="on">
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>50</span></p>
              <h2>售价&nbsp;48元</h2>
            </li>
            <li>
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>100</span></p>
              <h2>售价&nbsp;96元</h2>
            </li>
            <li>
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>200</span></p>
              <h2>售价&nbsp;196元</h2>
            </li>
            <li>
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>500</span></p>
              <h2>售价&nbsp;490元</h2>
            </li>
            <li>
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>1000</span></p>
              <h2>售价&nbsp;980元</h2>
            </li>
            <li>
              <p><img src="{{ asset('/clientapp/images/user-coin.png') }}"><span>2000</span></p>
              <h2>售价&nbsp;1980元</h2>
            </li>
          </ul>

          <div class="sendBox">
            <a href="recharge/rechargeAlipay" class="rechargeBtn">确认充值</a>
          </div>

          <p class="rechargetHint"><font color="#333333">充值须知：</font>充值挖宝币均由平台用户提供转卖，平台仅提供出售信息，不出售挖宝币。充值前请先确认好支付信息，确认无误后再进行支付，若因操作失误导致损失由自己承担，平台不负责任。</p>


        </div>
<!-- </div> -->
@endsection

@section('footer-javascript')      
      @parent
      <script type="text/javascript">
            $(document).ready(function () {
              $('.scrolly').addClass('cionPage rechargePage');
            });
      </script>

      <script type="text/javascript">
        $(function () {

        //选择数量
        $('.cionPage  li').click(function () {
          let vm = $(this);
          vm.addClass('on').siblings().removeClass('on');
        });


          
      });
    </script>

@endsection
