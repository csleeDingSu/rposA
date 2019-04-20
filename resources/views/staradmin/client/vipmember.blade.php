@extends('layouts.default')

@section('title', 'VIP场会员')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/vipmember.css') }}" />
	<link href="{{ asset('/client/css/pagination.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('top-javascript')
	@parent
	<script src="{{ asset('/client/ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
@endsection

@section('top-navbar')
@endsection

@section('content') 
<div class="full-height no-header">
	<div class="container">
		<!-- wabao coin info -->
		<input type="hidden" id="hidUserId" name="hidUserId" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}">
		<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
		<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
		<input id="hidWechatId" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" />
		<input type="hidden" id="page" value="1" />
		<input type="hidden" id="max_page" value="1" />

		<div class="member-box">
			<div class="card">
				<div class="col-xs-3 left-menu">
					<a href="/profile" class="back">
				        <div class="icon-back glyphicon glyphicon-menu-left" aria-hidden="true"></div>
				    </a>
				</div>

				<div class="col-xs-6 brand-title">
					VIP场会员
				</div>
			
				<div class="col-xs-3"></div>
				
			</div>
			<div class="row">
					<div class="col-xs-7">
						<div class="vip-title">VIP场会员特权</div>
						<ul class="vip-list">
							<li><span class="highlight">赠送1200金币，</span>可结算红包。</li>
							<li><span class="highlight">无上限封顶，</span>想赚多少都行。</li>
							<li><span class="highlight">无需邀请人，</span>直接玩不麻烦。</li>
						</ul>
					</div>
					<div class="col-xs-5">
						<div class="point"><div class="sign">¥</div> 99.00</div>
						<a href="/membership"><div class="btn-submit">开通会员</div></a>
					</div>
				</div>
		</div>
		
		<div class="top-background">
			<img src="{{ asset('/client/images/membership/vip-bg.png') }}" />
		</div>

		<div class="full-width-tabs">
			<!-- tab content -->
			<div class="tab-content">
				<!-- end redeem list content -->

				<!-- redeem history content -->
				<div id="history" class="tab-pane fade in active">
					<div id="redeem-history"></div>
					<p class="isnext">下拉显示更多...</p>
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

    @parent
    <script src="{{ asset('/client/pagination.js.org/dist/2.1.4/pagination.min.js') }}"></script>
    <script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
    <script src="{{ asset('/client/js/jquery.animateNumber.js') }}"></script>
    <script src="{{ asset('/client/js/js.cookie.js') }}"></script>
    <script src="{{ asset('/client/js/vipmember.js') }}"></script>
    <script type="text/javascript">
    	var end_of_result = "@lang('dingsu.end_of_result')";
    </script>
@endsection