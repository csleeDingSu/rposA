@extends('layouts.default_app')

@section('top-css')
    @parent  
    <link rel="stylesheet" href="{{ asset('/clientapp/css/free.css') }}" />
        
@endsection

@section('top-javascript')
    @parent
    <script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>

@endsection

@section('title', '活动规则')

@section('top-navbar')    
@endsection

@section('content')
<input id="hidPageId" type="hidden" value="{{empty($pageId) ? '' : $pageId}}" />
<div class="box">
<div class="freeHeader">
  <!-- <a class="returnBtn"><i class="fs">&lt;</i>返回</a> -->
  <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon2.png') }}"><span>返回</span></a>
  <a class="gzbtn">活动规则</a>
</div>

<img src="{{ asset('/clientapp/images/mcImg_02.png') }}" width="100%">
        <div class="freeView">
          <div class="intitle">——&nbsp;先领券 再购物&nbsp;——</div>
          <div class="inBody inGz">
            <p>在挖宝不仅可领取优惠券，还能<font color="#fde01e">抽奖领补贴</font>，每次<br>
                抽奖最多<font color="#fde01e">可赚12元补贴</font>（可提现），通过以下方式可获得大量抽奖次数：<br>
                • 新用户注册即送1次<br>
                • 邀请好友送1次/人，好友邀请别人你也得1次/人。<br>
                • 领券下单累计积分兑换<br>
                你邀请的好友也享受同等福利，邀请越多补贴越多，补贴无上限，从此购物全补贴，不花自己一份钱。<br>
                </p>
          </div>
        </div>
        <div class="freeView">
            <div class="intitle">——&nbsp;新品来袭 重磅让利&nbsp;——</div>
            <div class="inBody">

              <div class="listNav">
                <a class="one on">1次抽奖带走</a>
                <a class="two">2次抽奖带走</a>
                <a class="three">3次抽奖带走</a>
              </div>
              <div class="inList">
                <ul class="dtList">
                  <li>
                    <div class="imgBox">
                      <img src="{{ asset('/clientapp/images/mcImg.png') }}">
                    </div>
                    <div class="txtBox">
                      <h2>奇味酥脆饼干</h2>
                      <p><font>奇味酥脆饼干</font><i>原价80元</i></p>
                      <h3>1次抽奖 免费带走</h3>
                    </div>
                    <div class="btnBox">
                      <a><span>领券<br>购买</span></a>
                    </div>
                  </li> <li>
                      <div class="imgBox">
                        <img src="{{ asset('/clientapp/images/mcImg.png') }}">
                      </div>
                      <div class="txtBox">
                        <h2>奇味酥脆饼干</h2>
                        <p><font>奇味酥脆饼干</font><i>原价80元</i></p>
                        <h3>1次抽奖 免费带走</h3>
                      </div>
                      <div class="btnBox">
                        <a><span>领券<br>购买</span></a>
                      </div>
                    </li> <li>
                        <div class="imgBox">
                          <img src="{{ asset('/clientapp/images/mcImg.png') }}">
                        </div>
                        <div class="txtBox">
                          <h2>奇味酥脆饼干</h2>
                          <p><font>奇味酥脆饼干</font><i>原价80元</i></p>
                          <h3>1次抽奖 免费带走</h3>
                        </div>
                        <div class="btnBox">
                          <a><span>领券<br>购买</span></a>
                        </div>
                      </li> <li>
                          <div class="imgBox">
                            <img src="{{ asset('/clientapp/images/mcImg.png') }}">
                          </div>
                          <div class="txtBox">
                            <h2>奇味酥脆饼干</h2>
                            <p><font>奇味酥脆饼干</font><i>原价80元</i></p>
                            <h3>1次抽奖 免费带走</h3>
                          </div>
                          <div class="btnBox">
                            <a><span>领券<br>购买</span></a>
                          </div>
                        </li>
                </ul>
                <div class="isLastPage">下拉加载更多产品</div>
              </div>
            </div>
          </div>
</div>
@endsection

@section('fix-btn')
  <div class="card-fixed">
    <a class="fixBtn" href="/arcade"><img src="{{ asset('/clientapp/images/fixBtn.png') }}"></a>
  </div>
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
    <script src="{{ asset('/clientapp/js/free.js') }}"></script>
    
    
@endsection