@extends('layouts.default')

@section('title', '个人中心')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/member.css') }}" />

<style>
</style>
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
					<div class="profile-pic"><img class="profile-img-circle" src="{{ $member->profile_pic ?? '/client/images/avatar.png' }}"> &nbsp; </div>
					<div class="name wechatname">{{ $member->wechat_name ?? $member->username }} </div>
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
				  	<span class="label-title">可兑换金额</span><br />
				  	<div class="point numbers">
						<span class="wabao-coin"></span>
				  	</div> 元
				  	<div class="redeembtn">
				  	<!-- <a href="/redeem"> -->
					  	<div class="button-redeem">兑换红包</div>
					<!-- </a> -->
					</div>
				  </div>
				  <div class="col-xs-6 border-right">
				  	未结算
				  	<div class="balance numbers">
				  		<span class="wabao-acupoint"></span>
				  	</div>
				  	 元
				  </div>
				  <div class="col-xs-6">
				  	已兑换
				  	<div class="life numbers">				  		
				  		<span class="wabao-usedpoint"></span>元
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

				<!-- VIP专场
				<li class="list-group-item first-item">
					<div class="vipmember">
						<div class="icon-wrapper">
							<div class="icon-vip"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						VIP专场
					</div>
				</li>
			-->
				<!-- 轮盘抽奖 -->
				<li class="list-group-item first-item">
					<div class="gamebtn">
						<div class="icon-wrapper">
							<div class="icon-wheel"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						轮盘抽奖
						<div class="game-life-count">剩余<span class="game-life"></span>次</div>
					</div>
				</li>
				
				<!-- 兑换奖品 -->
				<li class="list-group-item">
					<div class="redeembtn">
						<div class="icon-wrapper">
							<div class="icon-redeem"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>兑换红包
					</div>
				</li>				

				<!-- 我的奖品 -->
				<li class="list-group-item">
					<div class="redeemhistorybtn">
						<div class="icon-wrapper">
							<div class="icon-play"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						我的红包
					</div>
				</li>

				<!-- 我的场次 -->
				<li class="list-group-item">
					<div class="round">
						<div class="icon-wrapper">
							<div class="icon-round"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						我的场次
					</div>
				</li>

				<!-- 邀请记录 -->
				<li class="list-group-item">
					<div class="invitation_list">
						<div class="icon-wrapper">
							<div class="icon-add-friend"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						邀请记录
					</div>
				</li>

				<!-- 挖宝记录 -->
				<li class="list-group-item">
					<div class="allhistory">
						<div class="icon-wrapper">
							<div class="icon-play-history"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						转盘记录
					</div>
				</li>
			</ul>
		</div>

		<div class="listing-table long">
			<ul class="list-group">
				<li class="list-group-item first-item">
					<div class="faq">
						<div class="icon-wrapper">
							<div class="icon-faq"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						常见问题
					</div>
				</li>

				<li class="list-group-item" id="csBtn">
					<div class="icon-wrapper">
						<div class="icon-customer"></div>
					</div>
					<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
					联系客服
				</li>

				<li class="list-group-item">
					<div class="logout">					
						<div class="icon-wrapper">
							<div class="icon-logout"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						{{ trans('dingsu.logout') }}
					</div>					
				</li>
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

<style>

.viewimg
{
	margin-top: -50px;
	border-radius:50px 50px 0px 50px;
}
.qrimg
{
	max-width:100%;
	max-height:100%;
	
}
.imgdiv
{
	width: 90%;
	text-align: center;margin-left: auto;
    margin-right: auto;
    display: block;
}
</style>

<!-- Steps Modal starts -->
	<div class="modal fade col-md-12" id="new-verify-wechat" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								
									<img class="viewimg" src="{{ asset('/client/images/avatar.png') }}" width="80" height="82" alt="avatar" />
								
								<div class=" text-center">
									兑换红包请扫码加客服微信<br>
									<span class="cs-working-hour">工作时间:早上9点-晚上9点</span>
								</div>								
							</div>
							<div class="row imgdiv">								
								<img class="qrimg" src="{{ asset('/client/images/csqrcode.gif') }}" alt="qr image" />
							</div>
							<div class="row">								
								<div class="bottom">长按识别二维码</div>
							</div>
						</div>
					</div>							
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
									由于有个别用户用多个小号来套取红包福利。我们需要对您的微信进行审核，审核通过即可兑换紅包。
									
									<div class="wechat-instructions-highlight">
										<p>审核要求：</p>
										<p>1. 朋友圈有真实内容。</p>
										<p>2. 微信是多年的老号。</p>
									</div>
									如果您满足以上条件，<br/>
									请添加微信客服【<span id="cut2" class="wechat_id">{{env('wechat_id', 'LUNLY028')}}</span>】审核。
								</div>								
							</div>
							<div class="row">
								<!-- <a href="/validate">
									<img src="{{ asset('/client/images/btn-verify.png') }}" width="154" height="44" alt="Verify" />
								</a> -->
								<div class="cutBtnCS2">复制微信号</div>
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
						<div class="row imgdiv">								
							<img class="qrimg" src="{{ asset('/client/images/qr.jpg') }}" alt="qr image" />
						</div>
						<div class="row">								
							<div class="bottom">长按识别二维码</div>
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
	<script src="{{ asset('/client/js/jquery.animateNumber.js') }}"></script>
	<script src="{{ asset('/client/js/js.cookie.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function () {
			var wechat_status = "<?php Print($member->wechat_verification_status);?>";
			var current_point = getNumeric("<?php Print($wallet->current_point);?>");
			var acupoint = getNumeric("<?php Print($wallet->current_life_acupoint);?>");
			var usedpoint = getNumeric("<?php Print($usedpoint);?>");
            var previous_point = Cookies.get('previous_point');
            if(previous_point !== undefined && previous_point > 0){
                previous_point = (getNumeric(previous_point));

                $('.wabao-coin')
                  .prop('number', previous_point)
                  .animateNumber(
                    {
                      number: (current_point)
                    },
                    1000
                  );
                Cookies.remove('previous_point');
            } else {
                $('.wabao-coin').html((current_point));
            }

            $('.wabao-acupoint').html(acupoint);

            $('.wabao-usedpoint').html(usedpoint);

            $('.game-life').html("<?php Print($member->current_life);?>");

            $('.gamebtn').click(function(){
					window.location.href = "/arcade";
				});

            $('.vipmember').click(function(){
				// window.location.href = "/vipmember";
				window.location.href = "/vip";
			});

			$('.round').click(function(){
				window.location.href = "/round";
			});

			$('.invitation_list').click(function(){
				window.location.href = "/invitation_list";
			});

			$('.allhistory').click(function(){
				window.location.href = "/allhistory";
			});

			$('.faq').click(function(){
				window.location.href = "/faq";
			});

			$('.logout').click(function(){
				window.location.href = "/logout";
			});	

			if (wechat_status == 0) {
				$('.redeembtn').click(function(){
					window.location.href = "/redeem";
				});

				$('.redeemhistorybtn').click(function(){
					window.location.href = "/redeem/history";
				});
			} else {

				$('.redeembtn').click(function(){
					$('.cutBtnCS2').removeClass('cutBtnCS2-success').html('复制微信号');;
					$('#new-verify-wechat').modal();
				});
				$('.redeemhistorybtn').click(function(){
					$('.cutBtnCS2').removeClass('cutBtnCS2-success').html('复制微信号');;
					$('#new-verify-wechat').modal();
				});

			}

			$('.unverify').click(function(){
				$('.cutBtnCS2').removeClass('cutBtnCS2-success').html('复制微信号');;
				$('#new-verify-wechat').modal();
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

			var clipboard = new ClipboardJS('.cutBtnCS2', {
				target: function () {
					return document.querySelector('#cut2');
				}
			});

			clipboard.on('success', function (e) {
				$('.cutBtnCS2').addClass('cutBtnCS2-success').html('<i class="far fa-check-circle"></i>复制成功');
			});

			clipboard.on('error', function (e) {
				$('.cutBtnCS2').addClass('cutBtnCS2-success').html('<i class="far fa-check-circle"></i>复制成功');
			});
	
		});	

	function getNumeric(value) {
	  	return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
	  }

	</script>
@endsection
