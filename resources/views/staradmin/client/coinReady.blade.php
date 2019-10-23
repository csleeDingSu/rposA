@extends('layouts.default_app')

@section('top-css')
    @parent      
@endsection

@section('top-javascript')
    @parent

@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '订单详情')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')

<dl class="coinDetail">
          <dd>
            <div class="inTtimeBox">
              <h2>08-22</h2>
              <p>15:30</p>
            </div>
            <div class="inIcon">
              <img src="{{ asset('/clientapp/images/coinRight2.png') }}">
            </div>
            <div class="inDetail">
              <h2><font color="#51c000">买家付款完成</font></h2>
              <p>买家已完成付款，请核实收款金额<font color="#ff6b6b">￥198</font>
              </p>
            </div>
          </dd>
          <dd>
            <div class="inTtimeBox">
              <h2>08-22</h2>
              <p>15:30</p>
            </div>
            <div class="inIcon">
              <img src="{{ asset('/clientapp/images/coinUser2.png') }}">
            </div>
            <div class="inDetail">
              <h2>已匹配到买家<font color="#609cff">135****8888</font>
              </h2>
              <p>已匹配到买家，等待买家充值</p>
            </div>
          </dd>
          <dd>
            <div class="inTtimeBox">
              <h2>08-22</h2>
              <p>15:30</p>
            </div>
            <div class="inIcon">
              <img src="{{ asset('/clientapp/images/coinClose2.png') }}">
            </div>
            <div class="inDetail">
              <h2>
                <font color="#fe8686">买家付款失败</font>
              </h2>
              <p>已匹配到买家，等待买家充值</p>
            </div>
          </dd>
          <dd>
            <div class="inTtimeBox">
              <h2>08-22</h2>
              <p>15:30</p>
            </div>
            <div class="inIcon">
              <img src="{{ asset('/clientapp/images/coinUser2.png') }}">
            </div>
            <div class="inDetail">
              <h2>已匹配到买家<font color="#609cff">135****8888</font>
              </h2>
              <p>已匹配到买家，等待买家充值</p>
            </div>
          </dd>
          <dd>
              <div class="inTtimeBox">
                <h2>08-22</h2>
                <p>15:30</p>
              </div>
              <div class="inIcon">
                <img src="{{ asset('/clientapp/images/coinUserT2.png') }}">
              </div>
              <div class="inDetail">
                <h2>正在匹配买家</h2>
                <p>订单正在转卖中，等待匹配买家</p>
              </div>
            </dd>
            <dd>
                <div class="inTtimeBox">
                  <h2>08-22</h2>
                  <p>15:30</p>
                </div>
                <div class="inIcon">
                  <img src="{{ asset('/clientapp/images/coinRight2.png') }}">
                </div>
                <div class="inDetail">
                  <h2>订单已提交</h2>
                  <p>转卖订单已提交，正在处理中</p>
                </div>
              </dd>
        </dl>

@endsection

@section('footer-javascript')      
      @parent
      <script type="text/javascript">
      $(document).ready(function () {
        $('.card-body').addClass('bgf3');
        $('.scrolly').addClass('fix');
      });

@endsection
