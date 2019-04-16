@extends('layouts.default')

@section('title', '开通会员')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/membership.css') }}" />
@endsection

@section('top-navbar')
@endsection

@section('content')

<div class="full-height no-header">
	<div class="container">
		<div class="member-box">
			<!-- member id -->
			<div class="card left">
				<div class="col-xs-6 member-wrapper">
					<div class="name"></div>
					<div style="clear: both;"></div>
				</div>
				<div class="col-xs-6 member-wrapper">
					<div class="button-wrapper">
					</div>
				</div>
				<div style="clear: both;"></div>
			</div>
			<!-- end member id -->

			<!-- member details -->
			<div class="information-table">
				  <div class="col-xs-12">
				  	<img src="{{ asset('/client/images/coin.png') }}" width="22" height="22" alt="button redeem" /> <span class="label-title">可用金币</span><br />
				  	<div class="point numbers"></div>
				  	<a href="/redeem">
					  	<div class="button-redeem">兑换红包</div>
					</a>
				  </div>
				  <div class="col-xs-6 border-right">
				  	未结算
				  	<div class="balance numbers"></div>
				  </div>
				  <div class="col-xs-6">
				  	已兑换
				  	<div class="life numbers">				  		
				  		元
				  	</div>

				  </div>
			</div>
			<!-- end member details -->
		</div>
		
		<div class="top-background">
			<img src="{{ asset('/client/images/membership/bg.png') }}" />
		</div>
		<div class="bottom-background"></div>

		<!-- member listing -->
		<div class="listing-table">
			<div class="image-wrapper">
				<a href="/share">
					<img src="{{ asset('/client/images/share.png') }}" alt="share">
				</a>
			</div>
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
	<div class="modal fade col-md-12" id="verify-wechat" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
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
							<div class="row">
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

<!-- customer service modal -->
<div class="modal fade col-md-12" id="csModal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-title">
			<h1><img src="{{ asset('/client/images/weixin.png') }}" width="30" height="29" /> 请加客服微信</h1>
		</div>
		<div class="modal-content modal-wechat">
			<div class="modal-body">
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						<div class="modal-card">
							<div class="instructions">
								客服微信在线时间：<span class="highlight">早上9点~晚上9点</span>
							</div>
						</div>
						<div class="row">
							<div id="cutCS" class="copyvoucher">{{env('wechat_id', 'BCKACOM')}}</div>
							<div class="cutBtnCS">点击复制</div>
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
	<script src="{{ asset('/client/js/public.js') }}" ></script>
	
	<script type="text/javascript">
		$(document).ready(function () {
			var wechat_status = $('#hidWechatStatus').val();
			
			$('.unverify').click(function(){
				$('#verify-wechat').modal();
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

			var clipboardCS = new ClipboardJS('.cutBtnCS', {
				target: function () {
					return document.querySelector('#cutCS');
				}
			});

			clipboardCS.on('success', function (e) {
				$('.cutBtnCS').addClass('cutBtnCS-success').html('<i class="far fa-check-circle"></i>复制成功');
			});

			clipboardCS.on('error', function (e) {
				//$('.cutBtn').addClass('cutBtn-fail').html('<i class="far fa-times-circle"></i>复制失败');
				$('.cutBtnCS').addClass('cutBtnCS-success').html('<i class="far fa-check-circle"></i>复制成功');
			});

			$('#csBtn').click(function () {
				$('#csModal').modal();
			});
	
		});	
	</script>
@endsection
