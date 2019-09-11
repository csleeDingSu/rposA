@extends('layouts.default_app')

@section('top-css')
    @parent
    <link rel="stylesheet" href="{{ asset('/clientapp/css/receipt_guide.css') }}" />    
@endsection

<!-- top nav -->
@section('left-menu')
  <a class="returnBtn" href="javascript:goBack();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
@endsection

@section('title', '淘宝订单号提交教程')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('top-javascript')
    @parent
    
@endsection

@section('content')
  <div class="step">
    <div class="step-title"><span class="step-number">01</span> 打开淘宝app，进入- “我的淘宝”</div>
    <img class="step-img" src="{{ asset('/client/images/receipt/1.png') }}">
  </div>
  <div class="step">
    <div class="step-title"><span class="step-number">02</span> 点击 “我的订单”，找到通过平台领券下的订单</div>
    <img class="step-img" src="{{ asset('/client/images/receipt/2.png') }}">
  </div>
  <div class="step">
    <div class="step-title"><span class="step-number">03</span> 点击订单进入 “订单详情” 找到 “订单骗号” 复制</div>
    <img class="step-img" src="{{ asset('/client/images/receipt/3.png') }}">
  </div>
  <div class="step">
    <div class="step-title"><span class="step-number">04</span> 进入 “下单奖励” 页面 粘贴淘宝订单号提交</div>
    <img class="step-img" src="{{ asset('/client/images/receipt/4.png') }}">
  </div>

@endsection

@section('footer-javascript')
    @parent      

@endsection