@extends('layouts.default')

@section('title', '兑换奖品')

@section('left-menu')
    <a href="/profile" class="back">
        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/redeem.css') }}" />
	<link href="{{ asset('/client/css/pagination.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('top-javascript')
	@parent
	<script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>
@endsection

@section('content') 
<div class="full-height">
	<div class="container">
		<!-- wabao coin info -->
		<input type="hidden" id="hidUserId" name="hidUserId" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}">
		<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
		<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
		<input id="hidWechatId" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" />

		<div class="card left">
			<div class="icon-coin-wrapper">
				<div class="icon-coin"></div>
			</div>
			<div class="label-coin">当前可用挖宝币</div>
			<div class="label-coin right"><a href="/summary">挖宝币明细</a></div>

			<div style="clear: both;"></div>
			
			<div class="wabao-coin">&nbsp;</div>
		</div>
		<!-- end wabao coin info -->

		<div class="full-width-tabs">
			<!-- redeem tabs -->
			<ul class="nav nav-pills">
			  <li class="{{ empty($slug) ? 'active' : '' }} take-all-space-you-can"><a class="tab" data-toggle="tab" href="#prize">奖品兑换</a></li>
			  <li class="{{ (!empty($slug) and $slug == 'history') ? 'active' : '' }} take-all-space-you-can"><a class="tab" data-toggle="tab" href="#history">我的奖品</a></li>
			</ul>
			<!-- end redeem tabs -->

			<!-- tab content -->
			<div class="tab-content">
				<!-- redeem list content -->
				<div id="prize" class="prize tab-pane fade {{ empty($slug) ? 'in active' : '' }}">
				</div>


				<!-- end redeem list content -->

				<!-- redeem history content -->
				<div id="history" class="tab-pane fade {{ (!empty($slug) and $slug == 'history') ? 'in active' : '' }}">
					<div id="redeem-history"></div>
					<div id="redeem-pagination"></div>
				</div>
				<!-- end redeem list content -->
			</div>
		</div>
		
		<!-- End listing -->
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
                        	您上次的VIP入场卷<br />
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
					¥ <span class="reward-amount">45.00</span>
				</div>
				<div class="reward-instructions">
					认证后能获得3次挖宝机会<br />
					每次挖宝机会会能获得15元
				</div>
			</div>
			<div class="modal-content modal-wechat">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="body-title">添加客服认证</div>
								<div class="instructions">
									在线时间：早上8：00～晚上21：00
								</div>								
							</div>
							<div class="row">
								<div id="cut" class="copyvoucher">WABAO666</div>
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

    @parent
    <script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
    <script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
    <script src="{{ asset('/client/js/jquery.animateNumber.js') }}"></script>
    <script src="{{ asset('/client/js/js.cookie.js') }}"></script>
    <script src="{{ asset('/client/js/redeem.js') }}"></script>
@endsection