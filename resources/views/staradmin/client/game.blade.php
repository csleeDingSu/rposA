@extends('layouts.default')

@section('title', '挖宝大冒险')

@section('top-css')
    @parent

    <link rel="stylesheet" href="{{ asset('/client/unpkg.com/flickity@2/dist/flickity.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/client/css/progress_bar_new.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/game.css') }}" />
    

    <style>
    	
    	.reveal-modal {
		    /*position: relative;*/
		    margin: 0 auto;
		    top: 25%;
		}

    </style>
@endsection
    	
@section('top-navbar')
@endsection

@section('content')
<div class="loading"></div>
<div class="reload">
	<div class="center-content">加载失败，请安刷新</div>
</div>
<div class="full-height">
	<!-- information table -->
	<div class="information-table">
		<div class="grid-container">
			<div class="box">
				<div class="coin"></div>
				<div class="number">
					<span class="balance spanAcuPoint">0</span>
					<div class="btn-calculate-wrapper">
						<div class="btn-calculate">兑换红包</div>
					</div>
				</div>
			</div>

			@if(isset(Auth::Guard('member')->user()->vip_life) and Auth::Guard('member')->user()->vip_life > 0)
			<div class="box" id="btn-vip-wrapper">
				<div class="btn-rules-wrapper">
					<a href="/vip">
						<!--div class="btn-vip"></div-->
						<div class="btn-rules-vip">进入VIP专场</div>
					</a>
					<div style="clear:both"></div>
				</div>
			</div>
			@else
			<div class="box" id="btn-vip-wrapper">
				<div class="btn-rules-wrapper btn-vip-modal">
						<!--div class="btn-vip"></div-->
						<div class="btn-rules-normal">VIP专场收益增10倍</div>
					<div style="clear:both"></div>
				</div>
			</div>
			@endif

			<input id="hidTotalBalance" type="hidden" value="" />
			<input id="hidBalance" type="hidden" value="" />
			<input id="hidLevel" type="hidden" value="" />
			<input id="hidLevelId" type="hidden" value="" />
			<input id="hidLatestResult" type="hidden" value="" />
			<input id="hidConsecutiveLose" type="hidden" value="" />
			<input id="hidHall" type="hidden" value="" />
			<input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
			<input id="hidWechatId" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" />
			<input id="hidWechatName" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_name) ? Auth::Guard('member')->user()->wechat_name : null}}" />
			<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
			<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
			<input id='hidbetting_count' type="hidden" value="{{$betting_count}}" />
	  	</div>
	</div>
	<!-- end information table -->

	<!-- swiper iframe -->
	<div class="swiper-container">
		<div class="carousel-cell">
			<iframe id="ifm_result" class="embed-responsive-item" src="/results" allowtransparency="true" frameBorder="0" scrolling="no" align="middle">
			</iframe>
		</div>

		<div class="carousel-cell">
			<iframe id="ifm_wheel" class="embed-responsive-item" src="/wheel" allowtransparency="true" frameBorder="0" scrolling="no">
			</iframe>
		</div>

		<div class="carousel-cell">
			<iframe id="ifm_history" class="embed-responsive-item" src="/history" allowtransparency="true" frameBorder="0" scrolling="no">
			</iframe>
		</div>
	</div>
	<!-- end swiper iframe -->

	<div class="instruction">请猜下一局幸运号是单数或双数</div>

	<!-- progress bar -->
	<section class="barWrapper">
      	<article class="barBox">
	      <div class="rule">
	          <h2 class="payout-info hide"></h2>
	        <ul>
	          <li>
	            <span class="span-1">10</span>
	            <dl>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	            </dl>
	          </li>
	          <li>
	            <span class="span-2">30</span>
	            <dl>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	            </dl>
	          </li>
	          <li>
	            <span class="span-3">70</span>
	            <dl>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	            </dl>
	          </li>
	          <li>
	            <span class="span-4">150</span>
	            <dl>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	            </dl>
	          </li>
	          <li>
	            <span class="span-5">310</span>
	            <dl>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	            </dl>
	          </li>
	          <li>
	            <span class="span-6">630</span>
	            <dl>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	              <dd></dd>
	            </dl>
	          </li>
	        </ul>
	      </div>
	      <div class="barIn">
	        <p><span class="span-balance">1200</span> / 1200</p>
	        <div class="barImg"></div>
	      </div>

	      <!-- button wrapper -->
		<div class="button-wrapper">
	        <div class="button-card radio-primary">
	        	<div class="radio btn-rectangle">
					<input name="rdbBet" class="invisible" type="radio" value="odd">单数
					<span class="bet">押</span><span class="bet-container">0</span>
				</div>
			  </div>
			  <div class="button-card radio-primary right">
				<div class="radio btn-rectangle">
					<input name="rdbBet" class="invisible" type="radio" value="even">双数
					<span class="bet">押</span><span class="bet-container">0</span>
				</div>
			  </div>
		</div>
		<!-- end button wrapper -->
	    </article>
    </section>
	<!-- end progress bar -->

	
</div>
@endsection

@section('footer-javascript')

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

<!-- Start Reset Life Max -->
	<div class="modal fade col-md-12" id="reset-life-max" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<img src="{{ asset('/client/images/vip/icon-win.png') }}" class="img-wabao" />
								<div class="modal-message-title">
									恭喜获得150挖宝币
								</div>
								<div class="modal-message-content">
									每次最多可获得150挖宝币<br />
									您当前已经封顶
								</div>
								<div class="modal-message-balance">
									您当前总挖宝币：<div class="packet-point">&nbsp;</div>
								</div>
								<div class="modal-message-button btn-reset-life">
									确认结算
								</div>												
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>
<!--  end -->

<!-- Start Reset Life Play -->

	<div class="modal fade col-md-12" id="reset-life-play" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-warning-title">
									兑换说明
								</div>
								<div class="modal-warning-content">
									需满150挖宝币，系统会自动结算。<br />
									150挖宝币约等于15元红包，请再接再厉。
								</div>

								<div class="close-modal modal-warning-button">
									我知道了
								</div>												
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

<!-- Start Reset Life Share -->

	<div class="modal fade col-md-12" id="reset-life-share" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<img src="{{ asset('/client/images/warning.jpg') }}" class="img-warning" />
								<div class="modal-warning-title">
									您当前没有挖宝次数
								</div>
								<div class="modal-warning-content">
									邀请好友注册将获得挖宝次数
								</div>
								<a href="/share" class="link-button">
									<div class="modal-warning-button">
										邀请好友加入
									</div>
								</a>													
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

<!-- Start Reset Life Bet -->

	<div class="modal fade col-md-12" id="reset-life-bet" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<img src="{{ asset('/client/images/warning.jpg') }}" class="img-warning" />
								<div class="modal-warning-title">
									当前不能结算
								</div>
								<div class="modal-warning-content">
									本局挖宝尚未完成
								</div>

								<div class="close-modal modal-warning-button">
									继续挖宝
								</div>												
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

<!-- Start Reset Life Lose -->

	<div class="modal fade col-md-12" id="reset-life-lose" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<img src="{{ asset('/client/images/vip/icon-lose.png') }}" class="img-wabao" />
								<div class="modal-lose-title">
									本次挖宝失败
								</div>
								<div class="modal-lose-content">
									本局盈利的挖宝币清零
								</div>
								<div class="modal-message-button btn-reset-life">
									继续挖宝
								</div>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

<!-- Start Reset Life Start -->

	<div class="modal fade col-md-12" id="reset-life-start" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<img src="{{ asset('/client/images/warning.jpg') }}" class="img-warning" />
								<div class="modal-warning-title">
									当前不能挖宝
								</div>
								<div class="modal-warning-content">
									您必须把挖宝机会兑换成挖宝币
								</div>

								<div class="btn-reset-life-continue modal-warning-button">
									兑换挖宝币
								</div>												
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

<!-- Game Rules starts -->
	<div class="modal fade col-md-12" id="game-rules" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-title">
				<h1>游戏规则说明</h1>
			</div>
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="instructions">
									每局拥有1200的游戏积分，分6次来玩。
								</div>
								<img src="{{ asset('/client/images/rules_timeline.png') }}" class="rules-content-img-timeline"/>
								<div class="instructions">
									第一次押10积分，如果不中下次押30，如果还不中下次押70，不停的增加投入。<br />
									如果猜中，就返回10积分重新押起。<br />
									所以只要6次内猜中一次，就能无限循环不停赚积分，赚的积分可提现。<br />
									6次全错的话，扣除赚到的积分。
								</div>

								@if($betting_count > 0)
									<div class="btn-game-rules btn-rules-close">开始游戏</div>
								@else
									<div class="btn-game-rules btn-rules-timer">请阅读游戏规则 <span class="txtTimer"></span></div>	
								@endif
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>
<!-- Steps Modal Ends -->


<!-- VIP Modal -->

	<div class="modal fade col-md-12 col-sm-10" id="vip-modal" tabindex="-1" role="dialog" aria-labelledby="vip-label" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content vip-background">
                <div class="vip-logo-wrapper">
                	<img class="vip-logo" src="{{ asset('/client/images/vip/vip-big.png') }}" width="53" height="48" />
                </div>
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card vip-modal-card">
								<img class="vip-title" src="{{ asset('/client/images/vip/vip-title.png') }}" width="250" height="28" />
								<div class="vip-card">
									<img class="img-vip" src="{{ asset('/client/images/vip/v1.png') }}" width="20" height="17" /><div class="vip-card-title">VIP场的结算方式：</div>
									<div style="clear: both;"></div>
									<div class="vip-card-desc">原始积分1200可结算，挖宝无上限，想挖多少就挖多少。</div>
								</div>
								<div class="vip-card">
									<img class="img-vip" src="{{ asset('/client/images/vip/v2.png') }}" width="20" height="17" /><div class="normal-card-title">普通场的结算方式：</div>
									<div style="clear: both;"></div>
									<div class="normal-card-desc">原始积分1200不可结算，最多可挖宝150，只能结算150挖宝币。</div>
								</div>
								<!--div class="vip-info">入场要求：兑换500挖宝币或消耗100元话费卷</div-->
								<a href="/redeem"><div class="btn-vip-submit">兑换VIP入场卷</div></a>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

	@parent
	
	<script src="{{ asset('/client/cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js') }}"></script>
	<script src="{{ asset('/client//unpkg.com/flickity@2/dist/flickity.pkgd.min.js') }}"></script>
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script src="{{ asset('/client/js/game.js') }}"></script>
	<!-- <script src="{{ asset('/client/js/NoSleep.js') }}"></script> -->

	<script type="text/javascript">
		$(document).ready(function () {

			var wechat_status = $('#hidWechatId').val();
			var wechat_name = $('#hidWechatName').val();

			$('.reload').click(function(){
				window.location.href = window.location.href;
			});
			
			$('.btn-rules').click(function(){
				$('#game-rules').modal('show');
			});

			$('.btn-vip-modal').click(function(){
				$('#vip-modal').modal('show');
			});
			
			if(wechat_status > 0) {
				$('#verify-steps').modal({backdrop: 'static', keyboard: false});
			}

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

		});	

		// var noSleep = new NoSleep();

		// function enableNoSleep() {
		//   noSleep.enable();
		//   // document.removeEventListener('click', enableNoSleep, false);
		//   document.removeEventListener('touchstart', enableNoSleep, false);
		// }

		// Enable wake lock.
		// (must be wrapped in a user input event handler e.g. a mouse or touch handler)
		// document.addEventListener('click', enableNoSleep, false);
		// document.addEventListener('touchstart', enableNoSleep, false);

		// ...

		// Disable wake lock at some point in the future.
		// (does not need to be wrapped in any user input event handler)
		//noSleep.disable();

	</script>
@endsection