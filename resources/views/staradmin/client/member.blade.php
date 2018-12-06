@extends('layouts.default')

@section('title', '个人中心')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/flickity.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/client/css/member.css') }}" />
@endsection

@section('content')

<input id="hidWechatStatus" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" />

<div class="full-height">
	<div class="container">
		<div class="member-box">
			<!-- member id -->
			<div class="card left">
				<div class="col-xs-6 member-wrapper">
					<div class="name">{{ $member->username }}</div>
					<div style="clear: both;"></div>
					<div class="member-id">ID:{{ $member->id }}</div>
				</div>
				<div class="col-xs-6 member-wrapper">
					@if($member->wechat_verification_status == 0)
					<div class="button-verified">
						<div class="icon-verified-wrapper">
							<div class="icon-verified"></div>
						</div>
						<div class="verified">已通过实名认证</div>
					</div>
					@else
					<div class="button-unverified">
						<div class="unverified">还没通过实名认证</div>
					</div>
					@endif
				</div>
				<div style="clear: both;"></div>
			</div>
			<!-- end member id -->

			<!-- member details -->
			<div class="information-table">
				  <div class="col-xs-4">
				  	总挖币数<br />
				  	<span class="point numbers">{{ number_format($wallet->current_point, 0, '.', '') }}</span><br />
				  	<a href="/redeem"><span class="button">兑换奖品</span></a>
				  </div>
				  <div class="col-xs-4 middle-border">
				  	未结算<br />
				  	<span class="balance numbers">{{ number_format($wallet->current_life_acupoint, 0, '.', '') }}</span><br />
				  	<a href="/arcade"><span class="button">继续挖宝</span></a>
				  </div>
				  <div class="col-xs-4">
				  	剩余次数<br />
				  	<span class="life numbers">{{ $wallet->current_life }}</span><br />
				  	<a href="/share"><span class="button">马上增加</span></a>
				  </div>
			</div>
			<!-- end member details -->
		</div>
		
		<div class="top-background"></div>
		<div class="bottom-background"></div>

		<!-- member listing -->
		<div class="listing-table">
			<div class="image-wrapper">
				<a href="/share">
					<img src="{{ asset('/client/images/share.png') }}" alt="share">
				</a>
			</div>
			<ul class="list-group">
				<a href="/invitation_list">
					<li class="list-group-item first-item">
						<div class="icon-wrapper">
							<div class="icon-add-friend"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						邀请记录
					</li>
				</a>
				<a href="/redeem/history">
					<li class="list-group-item">
						<div class="icon-wrapper">
							<div class="icon-play"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						我的奖品
					</li>
				</a>

				<a href="/redeem">
					<li class="list-group-item">					
							<div class="icon-wrapper">
								<div class="icon-redeem"></div>
							</div>
							<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
							兑换奖品					
					</li>
				</a>

				<a href="/allhistory">
					<li class="list-group-item">
						<div class="icon-wrapper">
							<div class="icon-play-history"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						挖宝记录
					</li>
				</a>

				<a href="/tips">
					<li class="list-group-item">
						<div class="icon-wrapper">
							<div class="icon-withdraw"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						挖宝攻略
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

				<!-- <a href="/customer_service"> -->
					<li class="list-group-item" id="csBtn">
						<div class="icon-wrapper">
							<div class="icon-customer"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						联系客服
					</li>
				<!-- </a> -->

				<a href = "/logout">
					<li class="list-group-item">					
						<div class="icon-wrapper" style="padding: 0px 5px 5px 6px">
							<i class="fa fa-sign-out-alt"></i>						
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
	<div class="modal fade col-md-12" id="verify-steps" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: grey;">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-title">
				<h1>请加客服微信</h1>
				通过审核才能享受网站福利
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
									请按复制按钮，复制成功后到微信添加。<br />
									如复制不成功，请到微信手动输入添加。
								</div>								
							</div>
						</div>
					</div>							
				</div>
			</div>

			<div class="modal-card">
				<div class="btn-close">
					<a href="/">
						<div class="glyphicon glyphicon-remove-circle" style="float: left;color: #ffd200;"></div>
						<div class="left"> 不想认证，先逛逛看。</div>
					</a>
				</div>
			</div>
		</div>
	</div>
<!-- Steps Modal Ends -->

<!-- customer service modal -->
	<div class="modal fade col-md-12" id="csModal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: grey; background: rgba(0,0,0,.5);">
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
								<div id="cutCS" class="copyvoucher">WABAO666</div>
								<div class="cutBtn" id = "cutBtnCS">一键复制</div>
							</div>
							<div class="modal-card">
								<div class="instructions-dark">
									请按复制按钮，复制成功后到微信添加。<br />
									如复制不成功，请到微信手动输入添加。
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
			
			if(wechat_status > 0) {
				$('#verify-steps').modal({backdrop: 'static', keyboard: false});
			}

			var clipboard = new ClipboardJS('.cutBtn', {
				target: function () {
					return document.querySelector('#cut');
				}
			});

			var clipboard = new ClipboardJS('#cutBtnCS', {
				target: function () {
					return document.querySelector('#cutCS');
				}
			});

			clipboard.on('success', function (e) {
				$('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
			});

			clipboard.on('error', function (e) {
				//$('.cutBtn').addClass('cutBtn-fail').html('<i class="far fa-times-circle"></i>复制失败');
				$('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
			});

			$('#csBtn').click(function () {
				$('#csModal').modal();
			});
	
		});	
	</script>
@endsection
