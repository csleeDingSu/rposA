@extends('layouts.default_app')

@section('title', '购物补贴')

@section('top-navbar')    
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/redeem_v2.css?version=1.0.0') }}" />
	<link href="{{ asset('/client/css/pagination.css') }}" rel="stylesheet" type="text/css">
	<style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loading2 {
          position: fixed;
          left: 0px;
          top: 0;
          width: 100%;
          height: 100%;
          z-index: 9999;
          background: url(/client/images/preloader.gif) center no-repeat;
          background-color: rgba(255, 255, 255, 1);
          background-size: 32px 32px;
        }

    </style>
@endsection

@section('top-javascript')
	@parent
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>

@endsection

@section('content') 
<div class="loading2" id="loading2"></div>
<!-- wabao coin info -->
<input type="hidden" id="hidUserId" name="hidUserId" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}">
<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
<input id="hidWechatId" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" />
<input type="hidden" id="page" value="1" />
<input type="hidden" id="max_page" value="1" />
<input type="hidden" id="reload_pass" value="{{ env('reload_pass','￥EXpZYiJPcpg￥') }}" />
<input type="hidden" id="this_vip_app" value="{{ env('THISVIPAPP','false') }}" />

<div class="c-header">
	<div class="pageHeader rel">
	  <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/zero-back-.png') }}"><span>返回</span></a>
	  <h2 class="h-title">购物补贴</h2>
	</div>
</div>

<div class="box-i">
	<div class="i-play">抽的多补的多</div>
	<div class="i-withdraw">可提现支付宝</div>
	<div class="i-redeem">可兑换挖宝币</div>
	<br style="clear: left;" />
</div>

<div class="box-summary">
	<div class="bg">
		<img src="{{asset('clientapp/images/redeem/box-summary-icon.png')}}">
		<div class="line1"><span class="yuan"><span class="wabao-coin"></span>元</span></div>
		<div class="line2">邀请好友送场次，抽更多红包，<a href="/share">去邀请></a></div>
	</div>
</div>

<div class="full-width-tabs">
	<!-- redeem tabs -->
	<ul class="nav nav-pills">
	  <li class="{{ empty($slug) ? 'active' : '' }} take-all-space-you-can">
	  	<a class="tab" data-toggle="tab" href="#prize">兑换奖品</a>
	  </li>
	  <li class="{{ (!empty($slug) and $slug == 'history') ? 'active' : '' }} take-all-space-you-can">
	  	<a class="tab" data-toggle="tab" href="#history">我的兑换</a>
	  </li>
	</ul>
	<!-- end redeem tabs -->

	<!-- tab content -->
	<div class="tab-content">
		<!-- redeem list content -->
		<div id="prize" class="prize tab-pane fade {{ empty($slug) ? 'in active' : '' }}">
			<div id="softpin"></div>
			<div id="newProduct"></div>
			<div class="vipProduct"></div>
		</div>
		<!-- end redeem list content -->

		<!-- redeem history content -->
		<div id="history" class="tab-pane fade {{ (!empty($slug) and $slug == 'history') ? 'in active' : '' }}">

			<div id="redeem-history"></div>

			<p class="isnext">下拉显示更多...</p>
		</div>
		<!-- end redeem list content -->
	</div>
</div>
@endsection

@section('footer-javascript')
<!-- Modal starts -->
<div class="modal fade col-lg-12" id="card-no-modal" tabindex="-1" style="z-index: 9999">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content vip-card-content">
            <div class="modal-body">
            	<div class="img-wrapper">
	        		<img class="btn-close-card" src="{{ asset('/client/images/btn-close.png') }}" width="22" height="22" />
	        	</div>
                <div class="modal-row">
                      <span class="card-no-description">
                        	卡号与卡密之间请用“空格”隔开，<br />
                        	每张卡张勇一行用“回车（Enter键）”隔开，<br />
                        	例：<br />
                        </span>
                        <span class="card-no-example">123456789456125 5878596541257456987</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Ends -->

<!-- Modal starts -->
<div class="modal fade col-lg-12" id="using-vip-modal" tabindex="-1" style="z-index: 9999">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content vip-using-content">
            <div class="modal-body">
                <div class="modal-row">
                        <div class="using-description">
                        	您上次的VIP入场券<br />
                        	还未结算
                        </div>
                </div>
            </div>
        </div>
        <div class="btn-close-modal">返回继续</div>
    </div>
</div>
<!-- Modal Ends -->

<!-- Steps Modal starts -->
	<div class="modal fade col-md-12" id="verify-steps" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: #666666;">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-title">
				<h1>您有红包等待领取</h1>
				<div class="reward">
					<span class="reward-amount">{{env('newbie_willget_bonus', '45.00')}}</span><span style="font-size: 46px;">元</span>
				</div>
				<div class="reward-instructions">
					需要微信认证才能领取
				</div>
			</div>
			<div class="modal-content modal-wechat">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="body-title">添加客服微信号</div>
								<div class="instructions">
									在线时间：早上9：00～晚上21：00
								</div>								
							</div>
							<div class="row">
								<div id="cut" class="copyvoucher">{{env('wechat_id', 'BCKACOM')}}</div>
								<div class="cutBtn">一键复制</div>
							</div>
							<div class="modal-card">
								<div class="instructions-dark">
									请按复制按钮，复制成功后到微信添加<br />
									如复制不成功，请到微信手动输入添加
								</div>								
							</div>
						</div>
					</div>							
				</div>
			</div>

			<div class="modal-card">
				<div class="btn-close">
					<a href="/">
						不要红包先逛逛看
					</a>
				</div>
			</div>
		</div>
	</div>
<!-- Steps Modal Ends -->

<!-- Steps Modal starts -->
	<div class="modal fade col-md-12" id="wechat-verification-modal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<img src="{{ asset('/client/images/avatar.png') }}" width="80" height="82" alt="avatar" />
								<div class="wechat-instructions">
									你的账号还未通过微信认证，<br />
									不能兑换红包，请先认证。
								</div>								
							</div>
							<div>
								<a href="/validate">
									<img src="{{ asset('/client/images/btn-verify.png') }}" width="154" height="44" alt="Verify" />
								</a>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>
<!-- Steps Modal Ends -->

<!-- merge point Modal starts -->
<div class="modal fade col-lg-12" id="merge-point-modal" tabindex="-1" style="z-index: 9999">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content vip-using-content">
            <div class="modal-body">
                <div class="modal-row">
                        <div class="using-description">
                        	兑换成功
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--merge point Modal Ends -->

    @parent
    <script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
    <script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
    <script src="{{ asset('/client/js/jquery.animateNumber.js') }}"></script>
    <script src="{{ asset('/client/js/js.cookie.js') }}"></script>
    <script src="{{ asset('/client/js/redeem_v2.js?version=1.0.1') }}"></script>
    <script type="text/javascript">
    	var end_of_result = "@lang('dingsu.end_of_result')";
    	document.onreadystatechange = function () {
        var state = document.readyState
        if (state == 'interactive') {
        } else if (state == 'complete') {
          setTimeout(function(){
              document.getElementById('interactive');
              document.getElementById('loading').style.visibility="hidden";
              document.getElementById('loading2').style.visibility="visible";
              $('.loading').css('display', 'initial');
              document.getElementById('loading2').style.visibility="hidden";
          },100);
        }
      }
    </script>
@endsection