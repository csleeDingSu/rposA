@extends('layouts.default_app')

@section('top-css')
    @parent  
@endsection

@section('top-javascript')
    @parent
    <script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>

@endsection

@section('title', '首页')

@section('top-navbar')    
@endsection

@section('content')
<div class="box">
        <input id="hidPageId" type="hidden" value="" />
        <div class="logo rel">
          <img src="{{ asset('/clientapp/images/logo.png') }}" width="100%">
          <div class="searchBox">
            <img src="{{ asset('/clientapp/images/searchIcon.png') }}">
            <label>
              <input type="text" placeholder="复制淘宝商品标题 粘贴搜索" id="search">
            </label>
            <a href="javascript:goSearch();">查券</a>
          </div>
        </div>
        <ul class="about">
          <li>①打开淘宝app</li>
          <li>②复制商品标题</li>
          <li>③粘贴搜索</li>
        </ul>
        <div class="ztBox">
          <div class="total">
            <span>今日已领取</span>
            <i>2</i>
            <i>2</i>
            <i>2</i>
            <i>2</i>
            <span>元</span>
          </div>
          <div class="list">
            <a href="#">
              <span><img src="{{ asset('/clientapp/images/demoImg2.png') }}"></span>
              <h2>¥ 3.0</h2>
              <p>热销1.7万件</p>
            </a>
            <a href="#">
              <span><img src="{{ asset('/clientapp/images/demoImg2.png') }}"></span>
              <h2>¥ 3.0</h2>
              <p>热销1.7万件</p>
            </a>
            <a href="#">
              <span><img src="{{ asset('/clientapp/images/demoImg2.png') }}"></span>
              <h2>¥ 3.0</h2>
              <p>热销1.7万件</p>
            </a>
          </div>
        </div>


        <div class="banner">
          <a><img src="{{ asset('/clientapp/images/banner.png') }}" width="100%"></a>
        </div>
        <h2 class="listTitle">超值爆款产品</h2>
        <div class="listBox">
          
        </div>
        <hr class="h36">
</div>
@endsection

@section('footer-javascript')
    @parent  
    <script src="{{ asset('/clientapp/js/newMainPage.js') }}"></script>

@endsection