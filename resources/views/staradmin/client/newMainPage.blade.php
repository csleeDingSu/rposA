@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" href="{{ asset('/clientapp/css/newMainPage.css') }}" />
    
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
          <div class="searchBox" id="search">
            <img class="tipsImg" src="{{ asset('/clientapp/images/searchTips.png') }}">
            <img src="{{ asset('/clientapp/images/searchIcon.png') }}">
            <label>
              <input type="text" placeholder="复制淘宝商品标题 粘贴搜索" disabled="true">
            </label>
            <div class="sBtn" id="btn-search">查券</div>
          </div>
        </div>
        @if(!empty($member) && $member->wechat_verification_status == 0)   <!-- wechat verified -->    
          @include('/client/main_partial_wechat_verify')
        @else
          @include('/client/main_partial_wechat_unverify')
        @endif
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