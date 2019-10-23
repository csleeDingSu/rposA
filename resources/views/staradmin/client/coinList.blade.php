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

@section('title', '转卖记录')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')

<div class="coinList">
          <a href="/coin/ready" class="inBox payReady">
            <h2><span>200挖宝币</span>
              <font color="#6ac2ff">正在匹配买家</font>
            </h2>
            <p><span>2019-08-22 15:30</span>
              <font color="#686868">售价&nbsp;198元</font>
            </p>
          </a>
          <a href="/coin/payIng" class="inBox payIng">
            <h2><span>200挖宝币</span>
              <font color="#ffa200">已匹配到买家 125****6839</font>
            </h2>
            <p><span>2019-08-22 15:30</span>
              <font color="#686868">售价&nbsp;198元</font>
            </p>
          </a>
          <a href="/coin/payOver" class="inBox payOver">
            <h2><span>200挖宝币</span>
              <font color="#51c000">买家付款完成</font>
            </h2>
            <p><span>2019-08-22 15:30</span>
              <font color="#686868">售价&nbsp;198元</font>
            </p>
          </a>
          <a href="/coin/fail" class="inBox payFail">
              <h2><span>200挖宝币</span>
                <font color="#ff8282">发布失败</font>
              </h2>
              <p><span>2019-08-22 15:30</span>
                <font color="#686868">售价&nbsp;198元</font>
              </p>
              <h3>失败原因：提交收款码金额与出售金币金额不一致！</h3>
            </a>
        </div>

@endsection

@section('footer-javascript')      
      @parent
      <script type="text/javascript">
      $(document).ready(function () {
        $('.card-body').addClass('bgf3');
      });

@endsection
