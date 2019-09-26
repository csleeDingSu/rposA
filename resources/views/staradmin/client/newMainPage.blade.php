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
        <input id="hidPageId" type="hidden" value="{{empty($pageId) ? '' : $pageId}}" />
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
          @if(!empty($product))
            @foreach($product['list'] as $p)
              @php ($oldPrice = number_format((float)$p['originalPrice'], 2, '.', ''))
              @php ($newPrice = $p['originalPrice'] - $p['couponPrice'] - 12)
              @php ($newPrice = ($newPrice > 0) ? $newPrice : 0)
              @php ($sales = ($p['monthSales'] >= 1000) ? number_format(((float)$p['monthSales'] / 10000), 2, '.', '') . '万' : $p['monthSales'] . '件')
              @php ($reward = (int)($newPrice * 10))
              @php ($reward = ($reward <= 0) ? '100' : $reward)
              @php ($_param = "?id=" . $p['id'] . "&goodsId=" . $p['goodsId'] . "&mainPic=" . $p['mainPic'] . "&title=" . $p['title'] . "&monthSales=" . $p['monthSales'] . "&originalPrice=" . $oldPrice . "&couponPrice=" . $p['couponPrice'] . "&couponLink=" . urlencode($p['couponLink']) . "&voucher_pass=")
              
              
              <div class="inBox">
                <div class="imgBox">
                  <a href="/main/product/detail{{$_param}}"> 
                    <img src="{{$p['mainPic']}}">
                  </a>
                </div>
                <div class="txtBox flex1">
                  <h2 class="name">{{$p['title']}}</h2>
                  <div class="typeBox">
                    <span class="type-red">{{$p['couponPrice']}}元券</span>
                    <span class="type-sred">奖励 {{$reward}} 积分</span>
                    <span class="type-blue">抽奖补贴12元</span>
                  </div>
                  <div class="moneyBox">
                    <p class="icon">¥</p>
                    <p class="nowTxt">{{$newPrice}}</p>
                    <p class="oldTxt"><em class="fs">¥</em>{{$oldPrice}}</p>
                    <p class="num">热销{{$sales}}</p>
                  </div>
                </div>
              </div>
          @endforeach 
          @endif
      
        </div>
        <hr class="h36">
</div>
@endsection

@section('footer-javascript')
    @parent  
    <script src="{{ asset('/clientapp/js/newMainPage.js') }}"></script>

@endsection