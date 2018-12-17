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

		<div class="card left">
			<div class="icon-coin-wrapper">
				<div class="icon-coin"></div>
			</div>
			<div class="label-coin">当前可用挖宝币</div>
			<div class="label-coin right"><a href="#">历史明细</a></div>

			<div style="clear: both;"></div>
			
			<div class="wabao-coin">&nbsp;</div>
		</div>
		<!-- end wabao coin info -->

		<div class="full-width-tabs">
			<!-- redeem tabs -->
			<ul class="nav nav-pills">
			  <li class="{{ empty($slug) ? 'active' : '' }} take-all-space-you-can"><a class="tab" data-toggle="tab" href="#prize">奖品兑换</a></li>
			  <li class="{{ (!empty($slug) and $slug == 'history') ? 'active' : '' }} take-all-space-you-can"><a class="tab" data-toggle="tab" href="#history">我的充值卡</a></li>
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
				</div>
				<!-- end redeem list content -->
			</div>
		</div>
		
		<!-- End listing -->
	</div>
</div>

<!-- Modal starts -->
<div class="modal fade col-lg-12" id="viewvouchermode_p" tabindex="-1" >
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content vip-content">
            <div class="modal-body">
                <div class="modal-row">
					<ul class="nav nav-pills">
					  <li class="active take-all-space-you-can"><a data-toggle="tab" href="#single">单张提交</a></li>
					  <li class="take-all-space-you-can"><a data-toggle="tab" href="#multiple">批量提交</a></li>
					</ul>

					<div class="tab-content">
					  <div id="single" class="tab-pane fade in active vip-tab-pane">
					    卡号： <input type="text" name="card_no" placeholder="请输入卡号" /><br /><hr>
					    密码： <input type="text" name="password" placeholder="请输入密码" /><br /><hr>
					    <span class="modal-description">提交面值为100元，【卡密规则】 卡号15位，密码19位<br />
					    100元充值卡换VIP专场1次，200元充值卡换VIP专场2次<br />
					    以此类推</span>
					    <div class="modal-card">
                            <div id="redeem-" onClick="redeemVip('token', '');">
	                            <a class="btn btn-submit-vip" >提交</a>
	                        </div>
                        </div>
					  </div>

					  <div id="multiple" class="tab-pane fade vip-tab-pane">
					  	<textarea placeholder="卡号与密码之间用空额隔开，每张一行用回车隔开"></textarea><br />
					  	<span class="modal-description">提交面值为100元，【卡密规则】 卡号15位，密码19位<br />
					    100元充值卡换VIP专场1次，200元充值卡换VIP专场2次<br />
					    以此类推</span>
					    <div class="modal-card">
                            <div id="redeem-" onClick="redeemVip('token', '');">
	                            <a class="btn btn-submit-vip" >提交</a>
	                        </div>
                        </div>
					  </div>
					</div>

                    <div class="wrapper modal-full-height">
                    	<span class="vip-copy">通过以下方式获得话费充值卡<br />
                    	复制话费卷淘宝口令，打开手机淘宝购买</span>
                        <div class="modal-card">
							<div id="cut" class="copyvoucher">¥ K8454DFGH45H</div>
							<div class="cutBtn">一键复制</div>
						</div>
                	</div>
            </div>
        </div>
    </div>
</div> 
<!-- Modal Ends -->
@endsection





@section('footer-javascript')
    @parent
    <script src="{{ asset('/client/js/redeem.js') }}"></script>

<script>
$('#viewvouchermode_p').modal('show');
</script>

@endsection