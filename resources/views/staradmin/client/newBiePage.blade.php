@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" href="{{ asset('/clientapp/css/newBiePage.css') }}" />
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

@section('title', '新人0元购')

@section('top-navbar')    
@endsection

@section('content')

@php ($life = empty($wallet['gameledger']['102']->life) ? 0 : $wallet['gameledger']['102']->life)

<div class="box">
        <input id="hidPageId" type="hidden" value="{{empty($pageId) ? '' : $pageId}}" />
        <input id="hidweChatVerificationStatus" type="hidden" value="{{empty($member->wechat_verification_status) ? '' : $member->wechat_verification_status}}" />
        <input id="hidgame102UsedPoint" type="hidden" value="{{$game_102_usedpoint}}" />
        <input id="hidgame102Life" type="hidden" value="{{empty($wallet['gameledger']['102']->life) ? 0 : $wallet['gameledger']['102']->life}}" />
   
        <div class="logo rel logo3-zero">
          <div class="c-header">
           <!--  <div class="pageHeader rel">
              <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/zero-back-.png') }}"><span>返回</span></a>
              <h2></h2>
              <a class="rules">补贴说明</a>
            </div> -->
          </div>
          @php($_url = ($isMacDevices) ? '/download-app' : env('DOWNLOAD_APP_ANDROID', '#'))
          <a class="download-app" href="{{$_url}}"><img src="{{ asset('clientapp/images/newbie/download.png') }}"></a>
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
                @php ($hong = $reward / 100)
                @php ($_param = "?id=" . $p['id'] . "&goodsId=" . $p['goodsId'] . "&mainPic=" . $p['mainPic'] . "&title=" . $p['title'] . "&monthSales=" . $p['monthSales'] . "&originalPrice=" . $oldPrice . "&couponPrice=" . $p['couponPrice'] . "&couponLink=" . urlencode($p['couponLink']) . "&commissionRate=" . $p['commissionRate'] . "&voucher_pass=&life=" . $life)
                <div class="inBox">
                  <div class="imgBox">
                    <a href="/main/product/detail{{$_param}}"> 
                      <img src="{{$p['mainPic']}}_320x320.jpg">
                    </a>
                  </div>
                  <div class="txtBox flex1">
                    <h2 class="name">{{$p['title']}}</h2>
                    <div class="typeBox">
                      <span class="type-red">{{$p['couponPrice']}}元券</span>
                      <span class="type-price">淘宝<em>¥</em>{{$oldPrice}} | 销量{{$sales}}</span>
                      <!-- <span class="type-sred">返{{$reward}}积分</span> -->
                    
                    </div>
                    <div class="moneyBox">
                      <div class="amount"><em>¥</em>0</div>
                      <div class="txt">APP专享补贴</div>
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
    <!-- draw rules starts -->
    <div class="modal fade col-md-12" id="draw-rules" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
      <div class="modal-dialog modal-lg close-modal" role="document">
        <div class="modal-content">
          <div class="modal-body">        
            <div class="modal-row">
              <div class="wrapper modal-full-height">
                <div class="modal-card">
                  <div class="modal-title">
                    抽奖补贴说明
                  </div>
                  <div class="instructions">
                    <p>抽奖补贴由挖宝提供，每1次抽奖有98.43%概率获得12元红包，红包可提现，抽奖次数来源说明：</p>
                    <p>①新用户注册送1次抽奖。</p>
                    <p>②邀请好友注册并认证，可获得1次抽奖，好友邀请别人，你也可以获得1次抽奖。</p>
                    <p>③领券下单返积分，1200积分兑换1次抽奖。</p>
                  </div>
                  <div class="txt-life">你当前拥有 <span class="mylife">{{$life}}</span> 次抽奖机会</div>
                  <div class="modal-go-button">
                    马上抽奖
                  </div>
                </div>
              </div>
            </div>              
          </div>
        </div>
      </div>
    </div>

    @parent  
    <script src="{{ asset('/clientapp/js/newBiePage.js') }}"></script>

@endsection