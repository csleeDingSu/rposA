@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" href="{{ asset('/clientapp/css/newMainPage.css') }}" />
    <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loading2 {
          height: 0.3rem;
          width: 0.3rem;
          position: relative;
          z-index: 9999;
        }

    </style>
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
          <a class="goShare-c"></a>         
        </div>

        <div class="navBox-3">
          <a href="/guide/redeem"><img src="{{ asset('/clientapp/images/index3-nav.png') }}">
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
          <a href="{{env('CUSTOMERSERVICELINK', '#')}}"><img src="{{ asset('/clientapp/images/index3-nav5.png') }}">
            <p>在线客服</p>
          </a>
        </div>

        <div class="banner">
          <a href="/shop"><img src="{{ asset('/clientapp/images/banner3.png') }}" width="100%" /></a>
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
                @php ($hong = $reward / 100)                
                @php ($_param = "?id=" . $p['id'] . "&goodsId=" . $p['goodsId'] . "&mainPic=" . $p['mainPic'] . "&title=" . $p['title'] . "&monthSales=" . $p['monthSales'] . "&originalPrice=" . $oldPrice . "&couponPrice=" . $p['couponPrice'] . "&couponLink=" . urlencode($p['couponLink']) . "&commissionRate=" . $commissionRate . "&voucher_pass=&life=" . $_life)
                <a href="/main/product/detail{{$_param}}">
                <div class="inBox">
                  <div class="imgBox">
                    <img src="{{$p['mainPic']}}_320x320.jpg">
                  </div>
                  <div class="txtBox flex1">
                    <h2 class="name">{{$p['title']}}</h2>
                    <div class="typeBox">
                      <span class="type-red">{{$p['couponPrice']}}元券</span>
                      <span class="type-price">淘宝<em>¥</em>{{$oldPrice}} | 销量{{$sales}}</span>
                      <!-- <span class="type-sred">返{{$reward}}积分</span> -->
                    </div>
                    <p class='newTxt'>券后价<em>¥</em>{{$promoPrice}} <span class="hong">下单奖{{$hong}}红包</span></p>
                    <div class="moneyBox">                        
                      <div class="btn-play-game">抽奖补贴</div>
                      <div class="btn-zero-buy">0元购买</div>
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
@php ($userid = isset(Auth::guard('member')->user()->id) ? Auth::guard('member')->user()->id : 0)
@php ($played = empty($wallet['gameledger'][102]->played) ? 0 : $wallet['gameledger'][102]->played)
@if ($userid > 0 && $played == 0)
<img class="newBie-footer" id="newbie" src="{{ asset('clientapp/images/main/newbie-bubble.png') }}">
@endif
@endsection

@section('footer-javascript')
<!-- Modal starts -->
<div class="modal fade col-md-12" id="redeem-plan-modal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
    <div class="modal-dialog modal-lg close-modal" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-row">
                  <div class="modal-title">
                    购物全补贴计划
                  </div>
                  <div class="modal-description">                    
                    挖宝APP不仅能找优惠券，还能抽奖领红包补贴，每场抽奖有98%概率获得12元。
                  </div>
                  <div class="modal-instructions">
                    <p>①用户注册和领券下单能获得<span class="highlight-red">少量抽奖场次</span></p>
                    <p>②邀请好友能获得<span class="highlight-red">大量抽奖场次</span></p>
                    <p>③被邀请的好友能享受同等福利</p>
                  </div>
                  <div class="modal-description">
                    全新购物理念，邀请好友抵买单，购物全额补贴，任性买买买不心疼。
                  </div>
                </div>
            </div>            
        </div>
        <div class="btn-close-modal">
          <img src="{{ asset('/clientapp/images/main/close.png') }}">
        </div>
    </div>
</div>
<!-- Modal Ends -->


    @parent  
    <script src="{{ asset('/clientapp/js/newMainPage.js') }}"></script>
    
@endsection