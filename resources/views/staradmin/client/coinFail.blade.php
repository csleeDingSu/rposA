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
              <img src="{{ asset('/clientapp/images/coinClose2.png') }}">
            </div>
            <div class="inDetail">
              <h2>
                <font color="#ff8282">发布失败</font>
              </h2>
              <p><font color="#ff8282">失败原因：提交收款码金额与出售金币金额不一致！</font>
              </p>
            </div>
          </dd>
         
          <dd class="fail">
            <div class="inTtimeBox">
              <h2>08-22</h2>
              <p>15:30</p>
            </div>
            <div class="inIcon">
              <img src="{{ asset('/clientapp/images/coinRight.png') }}">
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
