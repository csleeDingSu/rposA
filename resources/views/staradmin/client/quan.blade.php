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

@section('title', '查券教程')

@section('right-menu')
@endsection


@section('content')
<dl class="quanBox">
  <dt>
    <font color="#ff9a4f">01</font><span>在淘宝内长按商品标题，点击“拷贝”标题</span>
  </dt>
  <dd>
    <img src="{{ asset('clientapp/images/help/quan1.png') }}">
  </dd>
  <dt>
    <font color="#ff9a4f">02</font><span>打开“挖宝商城”app</span>
  </dt>
  <dd>
    <img src="{{ asset('clientapp/images/help/quan2.png') }}">
  </dd>
  <dt>
    <font color="#ff9a4f">03</font><span>在首页点击搜索框，粘贴标题，找到商品</span>
  </dt>
  <dd>
    <img src="{{ asset('clientapp/images/help/quan3.png') }}">
    <img src="{{ asset('clientapp/images/help/quan4.png') }}">
  </dd>
  <dt>
    <font color="#ff9a4f">04</font><span>点击产品进入详情页，点击“领取优惠券”进入淘宝app领券页面，省钱购买</span>
  </dt>
  <dd>
    <img src="{{ asset('clientapp/images/help/quan5.png') }}">
    <img src="{{ asset('clientapp/images/help/quan6.png') }}">
  </dd>
</dl>
@endsection

@section('footer-javascript')

    @parent

@endsection