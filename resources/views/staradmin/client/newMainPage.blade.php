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

@php ($_life = empty($wallet['gameledger']['102']->life) ? 0 : $wallet['gameledger']['102']->life)

<div class="box">
        <input id="hidPageId" type="hidden" value="{{empty($pageId) ? '' : $pageId}}" />
        <input id="hidweChatVerificationStatus" type="hidden" value="{{empty($member->wechat_verification_status) ? '' : $member->wechat_verification_status}}" />
        <input id="hidgame102UsedPoint" type="hidden" value="{{$game_102_usedpoint}}" />
        <input id="hidgame102Life" type="hidden" value="{{empty($wallet['gameledger']['102']->life) ? 0 : $wallet['gameledger']['102']->life}}" />
        @if(!empty($member) && $member->wechat_verification_status == 0 && $game_102_usedpoint > 0)   <!-- wechat verified && old user-->    
        <div class="logo rel logo3-c1">
          <div class="searchBox" id="search">
            <img class="tipsImg" src="{{ asset('/clientapp/images/searchTips.png') }}">
            <img src="{{ asset('/clientapp/images/searchIcon.png') }}">
            <label>
              <input type="text" placeholder="复制淘宝商品标题 粘贴搜索" disabled />
            </label>
            <div class="sBtn" id="btn-search">查券</div>
          </div>

          <ul class="about">
            <li>① 复制淘宝商品标题</li>
            <li>② 粘贴找券</li>
            <li>③ 领券购买有奖励</li>
          </ul>
          <a class="goShare-c" href="/pre-share"></a>         
        </div>
        @else
           <!-- wechat not verify && new user -->
        <div class="logo rel logo3">
          <div class="searchBox" id="search">
            <img class="tipsImg" src="{{ asset('/clientapp/images/searchTips.png') }}">
            <img src="{{ asset('/clientapp/images/searchIcon.png') }}">
            <label>
              <input type="text" placeholder="复制淘宝商品标题 粘贴搜索" disabled />
            </label>
            <div class="sBtn" id="btn-search">查券</div>
          </div>

          <ul class="about">
            <li>① 复制淘宝商品标题</li>
            <li>② 粘贴找券</li>
            <li>③ 领券购买有奖励</li>
          </ul>
          <a class="goShare-c" href="/arcade"></a>          
        </div>
        @endif 

<div class="mui-btn mui-btn-blue" style="margin:50px auto;width: 300px;" id="openURL">点击唤醒浏览器打开链接</div>

        <div class="navBox-3">
          <a id="btn-test"><img src="{{ asset('/clientapp/images/index3-nav.png') }}">
            <p>查券教程</p>
          </a>
          <a href="/pre-share"><img src="{{ asset('/clientapp/images/index3-nav2.png') }}">
            <p> 邀请赚钱</p>
          </a>
          <a href="/receipt"><img src="{{ asset('/clientapp/images/index3-nav3.png') }}">
            <p>下单奖励</p>
          </a>
          <a href="/shop"><img src="{{ asset('/clientapp/images/index3-nav4.png') }}">
            <p>金币换购</p>
          </a>
          <a href="/test/open-new-browser-2/"><img src="{{ asset('/clientapp/images/index3-nav5.png') }}">
            <p>在线客服</p>
          </a>
        </div>

        <div class="banner">
          <a href="/tips"><img src="{{ asset('/clientapp/images/banner3.png') }}" width="100%" /></a>
        </div>

        <a name="p"></a>
        @if(!empty($product_zero['list'][0]))
        
        <h2 class="title-0goumai"><a href="/main/zero-price-product" class="title-checkall">查看全部<img class="icon-zero-go" src="{{ asset('/clientapp/images/icon-zero-go.png') }}"/></a></h2>
        <h2 class="line"></h2>
        <div class="zeroBox">
          <div class="list">
            @php($i = 0)
            @foreach($product_zero['list'] as $p)
                @php ($i++)
                @if ($i > 3)
                  @break
                @endif
                @php ($oldPrice = $p['originalPrice'])
                @php ($promoPrice = $p['originalPrice'] - $p['couponPrice'])
                @php ($promoPrice = ($promoPrice > 0) ? $promoPrice : 0)
                @php ($newPrice = $p['originalPrice'] - $p['couponPrice'] - 12)
                @php ($newPrice = ($newPrice > 0) ? $newPrice : 0)
                @php ($sales = ($p['monthSales'] >= 1000) ? number_format(((float)$p['monthSales'] / 10000), 2, '.', '') . '万' : $p['monthSales'] . '件')
                @php ($commissionRate = $p['commissionRate'])
                @php ($commissionRate = ($commissionRate > 0) ? (int)$commissionRate : 0)
                @php ($reward = (int)($promoPrice * $commissionRate))
                @php ($reward = ($reward <= 0) ? '100' : $reward)
                @php ($_param = "?id=" . $p['id'] . "&goodsId=" . $p['goodsId'] . "&mainPic=" . $p['mainPic'] . "&title=" . $p['title'] . "&monthSales=" . $p['monthSales'] . "&originalPrice=" . $oldPrice . "&couponPrice=" . $p['couponPrice'] . "&couponLink=" . urlencode($p['couponLink']) . "&commissionRate=" . $commissionRate . "&voucher_pass=&life=" . $_life)
            <a href="/main/product/detail{{$_param}}">
              <span><img class="zeroBox-product-img" src="{{$p['mainPic']}}_320x320.jpg"></span>
              <p class="title-0gou-product">{{$p['title']}}</p>
              <h2 class="butie-padding"><img class="butie" src="/clientapp/images/butie.png"><span class="butie-font">¥</span> <span class="butiejia">0</span></h2>
            </a>
          @endforeach 
        
          </div>
        </div>
        @endif

        <h2 class="listTitle"></h2>
        <div class="listBox">
          @if(!empty($product))
            @foreach($product['list'] as $p)
                @php ($oldPrice = $p['originalPrice'])
                @php ($promoPrice = $p['originalPrice'] - $p['couponPrice'])
                @php ($promoPrice = ($promoPrice > 0) ? $promoPrice : 0)
                @php ($newPrice = $p['originalPrice'] - $p['couponPrice'] - 12)
                @php ($newPrice = ($newPrice > 0) ? $newPrice : 0)
                @php ($sales = ($p['monthSales'] >= 1000) ? number_format(((float)$p['monthSales'] / 10000), 2, '.', '') . '万' : $p['monthSales'] . '件')
                @php ($commissionRate = $p['commissionRate'])
                @php ($commissionRate = ($commissionRate > 0) ? (int)$commissionRate : 0)
                @php ($reward = (int)($promoPrice * $commissionRate))
                @php ($reward = ($reward <= 0) ? '100' : $reward)
                @php ($_param = "?id=" . $p['id'] . "&goodsId=" . $p['goodsId'] . "&mainPic=" . $p['mainPic'] . "&title=" . $p['title'] . "&monthSales=" . $p['monthSales'] . "&originalPrice=" . $oldPrice . "&couponPrice=" . $p['couponPrice'] . "&couponLink=" . urlencode($p['couponLink']) . "&commissionRate=" . $commissionRate . "&voucher_pass=&life=" . $_life)
                <a href="/main/product/detail{{$_param}}">
                <div class="inBox">
                  <div class="imgBox">
                    <img src="{{$p['mainPic']}}_320x320.jpg">
                  </div>
                  <div class="txtBox flex1">
                    <h2 class="name">{{$p['title']}}</h2>
                    <div class="typeBox">
                      <span class="type-price">淘宝<em>¥</em>{{$oldPrice}}</span>
                      <span class="type-red">{{$p['couponPrice']}}元券</span>
                      <span class="type-sred">返{{$reward}}积分</span>
                    </div>
                    <p class='newTxt'>券后价格<em>¥</em>{{$promoPrice}}</p>
                    <div class="moneyBox">                        
                      <p class="txt-red">补贴价格<em>¥</em><span class="num-reward">{{$newPrice}}</span></p>
                      <p class="num">热销{{$sales}}</p>
                    </div>
                  </div>
                </div>
              </a>
          @endforeach 
        @endif
      
        </div>
        <div class="lastHint">下拉显示更多产品...</div>
        <hr class="h36">
</div>
@endsection

@section('footer-javascript')
    @parent  
    <script src="{{ asset('/clientapp/js/newMainPage.js') }}"></script>
    <script src="{{ asset('/clientapp/js/mui.min.js') }}"></script>
    <link href="{{ asset('/clientapp/css/mui.min.css') }}" rel="stylesheet"/>
    <script type="text/javascript" charset="utf-8">
        mui.init();

      document.getElementById("btn-test").addEventListener('tap',function(){
        //
        plus.runtime.openURL("{{url('/guide/redeem')}}");
      });

      document.getElementById("openURL").addEventListener('tap',function(){
        //
        plus.runtime.openURL("https://www.baidu.com");
      });
    </script>

@endsection