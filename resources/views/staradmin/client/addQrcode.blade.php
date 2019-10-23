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

@section('title', '添加收款码教程')

@section('right-menu')
@endsection
<!-- top nav end-->

@section('content')

<dl class="quanBox addQrcode">
          <dt>
            <font color="#108ee9">01</font><span>支付宝搜索“AA收款”点击进入官方平台</span>
          </dt>
          <dd>
            <img src="{{ asset('/clientapp/images/help/addCoin1.jpg') }}">
          </dd>
          <dt>
            <font color="#108ee9">02</font><span>进入AA收款，切换为<font color="#108ee9">填写人均金额。</font></span>
          </dt>
          <dd>
            <img src="{{ asset('/clientapp/images/help/addCoin2.jpg') }}">
          </dd>
          <dt>
            <font color="#108ee9">03</font><span>发起收款设置，出售价格100元，则填写人均
                金额100元，总人数2人，备注出售金币</span>
          </dt>
          <dd>
            <img src="{{ asset('/clientapp/images/help/addCoin3.jpg') }}">
          </dd>
          <dt>
            <font color="#108ee9">04</font><span>生成AA收款二维码，用手机自带截屏功能
                把图片保存到相册，然后在平台<font color="#108ee9">添加收款码图片</font></span>
          </dt>
          <dd>
              <img src="{{ asset('/clientapp/images/help/addCoin4.jpg') }}">
              <img src="{{ asset('/clientapp/images/help/addCoin5.jpg') }}">
          </dd>
        </dl>

@endsection

@section('footer-javascript')      
      @parent

@endsection
