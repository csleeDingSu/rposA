@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" href="{{ asset('/clientapp/css/zeroPricePage.css') }}" />
    
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
   
        <div class="logo rel logo3-zero">
          <div class="c-header">
            <div class="pageHeader rel">
              <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
              <h2></h2>
              <a class="rules">补贴说明</a>
            </div>
          </div>       
        </div>

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
                @php ($commissionRate = ($commissionRate > 0) ? $commissionRate : 0)
                @php ($reward = (int)($promoPrice * $commissionRate))
                @php ($reward = ($reward <= 0) ? '100' : $reward)
                @php ($_param = "?id=" . $p['id'] . "&goodsId=" . $p['goodsId'] . "&mainPic=" . $p['mainPic'] . "&title=" . $p['title'] . "&monthSales=" . $p['monthSales'] . "&originalPrice=" . $oldPrice . "&couponPrice=" . $p['couponPrice'] . "&couponLink=" . urlencode($p['couponLink']) . "&commissionRate=" . $p['commissionRate'] . "&voucher_pass=&life=" . $_life)
                
                <div class="inBox">
                  <div class="imgBox">
                    <a href="/main/product/detail{{$_param}}"> 
                      <img src="{{$p['mainPic']}}_320x320.jpg">
                    </a>
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
          @endforeach 
        @endif
      
        </div>
        <div class="lastHint">下拉显示更多产品...</div>
        <hr class="h36">
</div>
@endsection

@section('footer-javascript')
    @parent  
    <script src="{{ asset('/clientapp/js/zeroPricePage.js') }}"></script>

@endsection