@extends('layouts.default')

@section('title', '个人中心')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/member.css') }}" />
@endsection

@section('content')

<!-- <input id="hidWechatStatus" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" /> -->

<input id="hidWechatStatus" type="hidden" value="0" />

<div class="full-height">
	<div class="container">
		<div class="member-box">
			<!-- member id -->
			<div class="card left">
				<div class="col-xs-6 member-wrapper">
					<div class="name">{{ $member->username }}</div>
					<div style="clear: both;"></div>
				</div>
				<div class="col-xs-6 member-wrapper">
					<div class="button-wrapper">
					@if($member->wechat_verification_status == 0)				
						<img src="{{ asset('/client/images/verified.png') }}" width="130" height="30" alt="verified" />
					@else
						<img class="unverify" src="{{ asset('/client/images/unverify.png') }}" width="130" height="30" alt="unverify" />					
					@endif
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<!-- end member id -->

			<!-- member details -->
			<div class="information-table">
				  <div class="col-xs-12">
				  	<img src="{{ asset('/client/images/coin.png') }}" width="22" height="22" alt="button redeem" /> 可用金币<br />
				  	<div class="point numbers">{{ number_format($wallet->current_point, 0, '.', '') }}</div>
				  	<a href="/redeem">
					  	<div class="button-redeem">兑换红包</div>
					</a>
				  </div>
				  <div class="col-xs-6 border-right">
				  	未结算
				  	<div class="balance numbers">{{ number_format($wallet->current_life_acupoint, 0, '.', '') }}</div>
				  </div>
				  <div class="col-xs-6">
				  	已兑换
				  	<div class="life numbers">				  		
				  		{{ number_format($usedpoint, 0, '.', '') }}
				  	</div>
				  </div>
			</div>
			<!-- end member details -->
		</div>
		
		<div class="top-background">
			<img src="{{ asset('/client/images/top-background.png') }}" />
		</div>
		<div class="bottom-background"></div>

		<!-- member listing -->
		<div class="listing-table">
			<div class="image-wrapper">
				<a href="/share">
					<img src="{{ asset('/client/images/share.png') }}" alt="share">
				</a>
			</div>
			<ul class="list-group">

				<!-- VIP专场 -->
				@if(count($vip_status->where('redeem_state', '3')) > 0)
					<a href= "/vip">
				@elseif(count($vip_status->where('redeem_state', '2')) > 0)
					<a href= "/redeem/history">
				@elseif(count($vip_status->where('redeem_state', '1')) > 0)
					<a href= "/redeem/history">
				@else
					<a href= "/redeem">
				@endif
				
					<li class="list-group-item first-item">
						<div class="icon-wrapper">
							<div class="icon-vip"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						@if(count($vip_status->where('redeem_state', '3')) > 0)
							<div class="vip-inprogress">@lang('dingsu.inprogress')</div>
						@elseif(count($vip_status->where('redeem_state', '2')) > 0)
							<div class="vip-redeemticket">@lang('dingsu.vip_ticket_not_yet_used')</div>
						@elseif(count($vip_status->where('redeem_state', '1')) > 0)
							<div class="vip-redeemticket">@lang('dingsu.waiting_for_approve')</div>
						@else
							<div class="vip-redeemticket">@lang('dingsu.redeem_vip_ticket')</div>
						@endif
						VIP专场
					</li>
				</a>
				
				<!-- 兑换奖品 -->
				<a href="/redeem">
					<li class="list-group-item">					
							<div class="icon-wrapper">
								<div class="icon-redeem"></div>
							</div>
							<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
							兑换奖品					
					</li>
				</a>

				<!-- 我的奖品 -->
				<a href="/redeem/history">
					<li class="list-group-item">
						<div class="icon-wrapper">
							<div class="icon-play"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						我的奖品
					</li>
				</a>

				<!-- 邀请记录 -->
				<a href="/invitation_list">
					<li class="list-group-item">
						<div class="icon-wrapper">
							<div class="icon-add-friend"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						邀请记录
					</li>
				</a>			

				<!-- 挖宝记录 -->
				<a href="/allhistory">
					<li class="list-group-item">
						<div class="icon-wrapper">
							<div class="icon-play-history"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						玩赚记录
					</li>
				</a>

				<!-- 挖宝攻略 -->
				<a href="/tips">
					<li class="list-group-item">
						<div class="icon-wrapper">
							<div class="icon-tips"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						免单攻略
					</li>
				</a>
			</ul>
		</div>

		<div class="listing-table long">
			<ul class="list-group">

				<a href="/faq">
					<li class="list-group-item first-item">
						<div class="icon-wrapper">
							<div class="icon-faq"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						常见问题
					</li>
				</a>

				<a href="#">
					<li class="list-group-item" id="csBtn">
						<div class="icon-wrapper">
							<div class="icon-customer"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						联系客服
					</li>
				</a>

				<a href = "/logout">
					<li class="list-group-item">					
						<div class="icon-wrapper">
							<div class="icon-logout"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						{{ trans('dingsu.logout') }}					
					</li>
				</a>				
			</ul>
		 </div>
		<!-- end member listing -->
	</div>
</div>

@endsection



@section('footer-javascript')
<!-- Steps Modal starts -->
	<div class="modal fade col-md-12" id="verify-steps" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-title">
				<h1>您有红包等待领取</h1>				
				<div class="reward">
					<span class="reward-amount">{{env('newbie_willget_bonus', '60.00')}}</span>元
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

<!-- customer service modal -->
<div class="modal fade col-md-12" id="csModal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-title">
			<h1>请加客服微信</h1>
		</div>
		<div class="modal-content modal-wechat">
			<div class="modal-body">
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						<div class="modal-card">
							<div class="instructions">
								客服微信在线时间：早上8点-晚上9点
							</div>
						</div>
						<div class="row">
							<div id="cut" class="copyvoucher">WABAO666</div>
							<div class="cutBtn">一键复制</div>
						</div>
						<div class="modal-card">
							<div class="instructions-dark">
								请按复制按钮，复制成功后到微信添加。<br/> 如复制不成功，请到微信手动输入添加。
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- customer service modal Ends -->

	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	
	<script type="text/javascript">
		$(document).ready(function () {
			var wechat_status = $('#hidWechatStatus').val();
			
			$('.unverify').click(function(){
				$('#csModal').modal();
			});

			var clipboard = new ClipboardJS('.cutBtn', {
				target: function () {
					return document.querySelector('#cut');
				}
			});

			clipboard.on('success', function (e) {
				$('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
			});

			clipboard.on('error', function (e) {
				//$('.cutBtn').addClass('cutBtn-fail').html('<i class="far fa-times-circle"></i>复制失败');
				$('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
			});

			var clipboardCS = new ClipboardJS('#cutBtnCS', {
				target: function () {
					return document.querySelector('#cutCS');
				}
			});

			clipboardCS.on('success', function (e) {
				$('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
			});

			clipboardCS.on('error', function (e) {
				//$('.cutBtn').addClass('cutBtn-fail').html('<i class="far fa-times-circle"></i>复制失败');
				$('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
			});

			$('#csBtn').click(function () {
				$('#csModal').modal();
			});
	
		});	
	</script>
@endsection
