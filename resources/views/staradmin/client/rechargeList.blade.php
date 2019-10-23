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

@section('title', '充值记录')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')
<div class="coinList">
          <div class="inBox ">
            <h2><span>200挖宝币</span>
              <font color="#6ac2ff">等待卖家发币</font>
            </h2>
            <p><span>2019-08-22 15:30</span>
              <font color="#686868">充值&nbsp;198元</font>
            </p>
          </div>
          <div class="inBox ">
            <h2><span>200挖宝币</span>
              <font color="#23ca27">卖家已发币</font>
            </h2>
            <p><span>2019-08-22 15:30</span>
              <font color="#686868">充值&nbsp;198元</font>
            </p>
          </div>
          <div class="inBox ">
              <h2><span>200挖宝币</span>
                <font color="#ff8282">拒绝退回</font>
              </h2>
              <p><span>2019-08-22 15:30</span>
                <font color="#686868">充值&nbsp;198元</font>
              </p>
              <h3>退回原因：无收到充值金额！</h3>
            </div>
        </div>

@endsection

@section('footer-javascript')      
      @parent
      <script type="text/javascript">
            $(document).ready(function () {
              $('.card-body').addClass('bgf3');
            });
      </script>

@endsection
