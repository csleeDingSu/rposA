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

@section('title', '提交吱口令教程')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')

<dl class="quanBox addQrcode">
          <dt>
            <font color="#108ee9">01</font><span>AA收款码生成页面--点击“通知其他好友”</span>
          </dt>
          <dd>
            <img src="{{ asset('/clientapp/images/help/copyTxt1.jpg') }}">
          </dd>
          <dt>
            <font color="#108ee9">02</font><span>点击“微信好友”,生成AA收款吱口令弹框</span>
          </dt>
          <dd>
            <img src="{{ asset('/clientapp/images/help/copyTxt2.jpg') }}">
          </dd>
          <dt>
            <font color="#108ee9">03</font><span>点击“微信好友”,生成AA收款吱口令弹框</span>
          </dt>
          <dd>
            <img src="{{ asset('/clientapp/images/help/copyTxt3.jpg') }}">
          </dd>
        </dl>

@endsection

@section('footer-javascript')      
      @parent

@endsection
