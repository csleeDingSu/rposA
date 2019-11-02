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

@section('title', '吱口令付款教程')

@section('right-menu')
@endsection


@section('content')
<dl class="quanBox">
  <dt>
    <font color="#4eb6ff">01</font><span>打开支付宝app首页，点击搜索框。粘贴吱口令。</span>
  </dt>
  <dd>
    <img src="{{ asset('clientapp/images/help/alipay1a.png') }}">
    <img src="{{ asset('clientapp/images/help/alipay1b.png') }}">
  </dd>
  <dt>
    <font color="#4eb6ff">02</font><span>显示卖家支付宝账号，点击“去转账>”</span>
  </dt>
  <dd>
    <img src="{{ asset('clientapp/images/help/alipay2.png') }}">
  </dd>
  <dt>
    <font color="#4eb6ff">03</font><span>输入付款金额，确认转账，完成转账后，进入挖宝平台点击“充值完成”</span>
  </dt>
  <dd>
    <img src="{{ asset('clientapp/images/help/alipay3a.png') }}">
    <img src="{{ asset('clientapp/images/help/alipay3b.png') }}">
  </dd>
</dl>
@endsection

@section('footer-javascript')

    @parent

@endsection