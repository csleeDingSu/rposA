@extends('layouts.default')

@section('title', '挖宝大冒险')

@section('top-css')
    @parent

    <link rel="stylesheet" href="{{ asset('/client/unpkg.com/flickity@2/dist/flickity.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/client/css/progress_bar_new.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/game.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/results.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/history.css') }}" />
    

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
				<div id="balance-wrapper">
					<div class="number number-vip">
						<span class="balance-vip" id="spanPoint">0</span>
						<div class="btn-calculate-vip-wrapper">
							<div class="btn-calculate-vip">结算</div>
						</div>
					</div>
				</div>
			</div>

			<div class="box" id="btn-vip-wrapper">
				<div class="btn-rules-wrapper">
					<a href="/arcade">
						<div class="btn-rules-vip">返回普通场</div>
					</a>
					<div style="clear:both"></div>
				</div>
			</div>

			<input id="result" type="hidden" value="6">
		    <input id="freeze_time" type="hidden" value="">
		    <input id="draw_id" type="hidden" value="">
		    <input id="hidTotalBalance" type="hidden" value="" />
			<input id="hidBalance" type="hidden" value="" />
			<input id="hidLevel" type="hidden" value="" />
			<input id="hidLevelId" type="hidden" value="" />
			<input id="hidLatestResult" type="hidden" value="" />
			<input id="hidConsecutiveLose" type="hidden" value="" />
			<input id="hidMergePoint" type="hidden" value="" />
			<input id="hidHall" type="hidden" value="" />
			<input id="hidFee" type="hidden" value="" />
			<input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
			<input id="hidWechatId" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" />
			<input id="hidWechatName" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_name) ? Auth::Guard('member')->user()->wechat_name : null}}" />
			<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
			<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
	  	</div>
	</div>
	<!-- end information table -->

	<!-- swiper iframe -->
	<div class="swiper-container">
		<div class="carousel-cell">
			<div class="frame-wrapper">
				<div class="results-body">
					<div class=".results-wrapper">
					<div class="timer-row">
						<div class="timer-wrapper">
		        			<div class="icon-timer"></div>
		        		</div>
						开奖倒计时：<span class="span-timer"></span>秒
					</div>

					<div class="results-row">
						<div class="chain-wrapper results-left"></div>
						<div class="box-wrapper">
							<div id="result-1" class="results-box">1</div>
						</div>
						<div class="box-wrapper">
							<div id="result-2" class="results-box">2</div>
						</div>
						<div class="box-wrapper">
							<div id="result-3" class="results-box">3</div>
						</div>
						<div class="box-wrapper">
							<div id="result-4" class="results-box">4</div>
						</div>
						<div class="box-wrapper">
							<div id="result-5" class="results-box">5</div>
						</div>
						<div class="chain-wrapper results-right">
							<div class="right-chain"></div>
						</div>
				  	</div>


				  	<div class="results-row">
				  		<div class="chain-wrapper results-left">
				  			<div class="left-chain"></div>
				  		</div>
				  		<div class="box-wrapper">
							<div id="result-10" class="results-box">1</div>
						</div>
						<div class="box-wrapper">
							<div id="result-9" class="results-box">2</div>
						</div>
						<div class="box-wrapper">
							<div id="result-8" class="results-box">3</div>
						</div>
						<div class="box-wrapper">
							<div id="result-7" class="results-box">4</div>
						</div>
						<div class="box-wrapper">
							<div id="result-6" class="results-box">5</div>
						</div>
						<div class="chain-wrapper results-right"></div>
				  	</div>

				  	<div class="results-row">
				  		<div class="chain-wrapper results-left"></div>
				  		<div class="box-wrapper">
							<div id="result-11" class="results-box">1</div>
						</div>
						<div class="box-wrapper">
							<div id="result-12" class="results-box">2</div>
						</div>
						<div class="box-wrapper">
							<div id="result-13" class="results-box">3</div>
						</div>
						<div class="box-wrapper">
							<div id="result-14" class="results-box">4</div>
						</div>
						<div class="box-wrapper">
							<div id="result-15" class="results-box">5</div>
						</div>
						<div class="chain-wrapper results-right">
							<div class="right-chain results-right"></div>
						</div>
				  	</div>

				  	<div class="results-row">
				  		<div class="chain-wrapper results-left">
				  			<div class="left-chain"></div>
				  		</div>
				  		<div class="box-wrapper">
							<div id="result-20" class="results-box">1</div>
						</div>
						<div class="box-wrapper">
							<div id="result-19" class="results-box">2</div>
						</div>
						<div class="box-wrapper">
							<div id="result-18" class="results-box">3</div>
						</div>
						<div class="box-wrapper">
							<div id="result-17" class="results-box">4</div>
						</div>
						<div class="box-wrapper">
							<div id="result-16" class="results-box">5</div>
						</div>
						<div class="chain-wrapper results-right"></div>		
				  	</div>

				  	<div class="results-row">
				  		<div class="chain-wrapper results-left"></div>
				  		<div class="box-wrapper">
							<div id="result-21" class="results-box">1</div>
						</div>
						<div class="box-wrapper">
							<div id="result-22" class="results-box">2</div>
						</div>
						<div class="box-wrapper">
							<div id="result-23" class="results-box">3</div>
						</div>
						<div class="box-wrapper">
							<div id="result-24" class="results-box">4</div>
						</div>
						<div class="box-wrapper">
							<div id="result-25" class="results-box">5</div>
						</div>
						<div class="chain-wrapper results-right"></div>
				  	</div>
				  </div>
				</div>
			</div>
		</div>

		<div class="carousel-cell">
			<div class="frame-wrapper">
		        <div id="wheel_container"></div>
		        <div class="spinning">转盘转动中不能选号</div>
		    </div>
		</div>

		<div class="carousel-cell">
			<div class="frame-wrapper">
				<div class="history-body">
					<div class="history-wrapper">
						<table class="history-table">
						    <tbody>
						    	<tr>
						        	<td class="timer" colspan="2">
						        		<div class="timer-wrapper">
						        			<div class="icon-timer"></div>
						        		</div>
						        		开奖倒计时：<span class="span-timer"></span>秒
						        	</td>
						        </tr>
						        <tr id="row-1">
						            <td class="history-number"></td>
						            <td class="history">
						            	<!--div class="points">630 <span class="additional">+40</span></div-->
							        </td>
						        </tr>
						        <tr id="row-2">
						            <td class="history-number"></td>
						            <td class="history">
						            </td>
						        </tr>
						        <tr id="row-3">
						            <td class="history-number"></td>
						            <td class="history">
						            </td>
						        </tr>
						        <tr id="row-4">
						            <td class="history-number"></td>
						            <td class="history"></td>
						        </tr>
						        <tr id="row-5">
						            <td class="history-number"></td>
						            <td class="history"></td>
						        </tr>
						        <tr id="row-6">
						            <td class="history-number"></td>
						            <td class="history"></td>
						        </tr>
						        <tr id="row-7">
						            <td class="history-number"></td>
						            <td class="history"></td>
						        </tr>
						        <tr>
						        	<td class="legend" colspan="2">
						        		<div class="even"><span class="history-label"></span></div><div class="legend-item">代表双数</div>
						        		<div class="odd"><span class="history-label"></span></div><div class="legend-item">代表单数</div>
						        		<div class="odd-fail"><span class="history-label"></span></div><div class="even-fail overlap"><span class="history-label"></span></div><div class="legend-item">代表失败</div>
						        	</td>
						        </tr>
						    </tbody>
						</table>
					</div>
				</div>
			</div>
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
									恭喜获得<span class="spanVipPoint"></span>挖宝币
								</div>
								<div class="modal-message-content">
									结算需扣除<span class="spanFee"></span>手续费，最终到账<span class="spanNetVip"></span>
								</div>
								<div class="modal-message-manual">
									查看说明
								</div>
								<div class="modal-message-balance">
									您当前总挖宝币：<div class="packet-point">&nbsp;</div>
								</div>
								<div class="modal-message-button btn-reset-life">
									确认结算 结束本次挖宝
								</div>
								<div class="modal-message-footer">
									结算后的挖宝币可兑换奖品
								</div>												
							</div>
						</div>
					</div>							
				</div>
			</div>
			<div id="btn-close-max" class="btn-close-wabao">暂不结算 返回本次挖宝</div>
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
								<div class="modal-message-title">
									恭喜获得<span class="spanVipPoint"></span>挖宝币
								</div>
								<div class="modal-message-content">
									结算需扣除<span class="spanFee"></span>手续费，最终到账<span class="spanNetVip"></span>
								</div>
								<div class="modal-message-manual">
									查看说明
								</div>
								<div class="modal-message-balance">
									您当前总挖宝币：<div class="packet-point">&nbsp;</div>
								</div>
								<div class="modal-message-button btn-reset-life">
									确认结算
								</div>
								<div class="modal-message-footer">
									你需要结算后，才能继续进入VIP场
								</div>
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
								<div class="modal-warning-content redeem-error">
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

<!-- Start Reset Life Manual -->

	<div class="modal fade col-md-12" id="reset-life-manual" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-manual-title">
									手续费说明
								</div>
								<div class="modal-manual-content">
									为了方便玩家兑换VIP入场卷，以及能够优惠获得原始积分，每局游戏平台采用1000挖宝币兑换1200原始积分，当玩家挖宝赢得挖宝币结算时，需返还<span class="spanFee"></span>作为挖宝手续费。
								</div>
								<div class="modal-manual-button">
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

	@parent
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="{{ asset('/client/cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js') }}"></script>
	<script src="{{ asset('/client//unpkg.com/flickity@2/dist/flickity.pkgd.min.js') }}"></script>
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script src="{{ asset('/client/js/jquery.rotate.min.js') }}"></script>
    <script src="{{ asset('/client/js/jquery.wheelOfFortune.js') }}"></script>
    <script src="{{ asset('/client/js/js.cookie.js') }}"></script>
    <script src="{{ asset('/client/js/ifvisible.js') }}"></script>
	<script src="{{ asset('/client/js/NoSleep.js') }}"></script>

	<script type="text/javascript">
		var url = "{{ env('APP_URL'), 'http://boge56.com' }}";      
    	var port = "{{ env('REDIS_CLI_PORT'), '6001' }}";

		$(document).ready(function () {

			var wechat_status = $('#hidWechatId').val();
			var wechat_name = $('#hidWechatName').val();

			$('.reload').click(function(){
				window.location.href = window.location.href;
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

		var noSleep = new NoSleep();

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
	<script src="{{ asset('/client/js/vip.js') }}"></script>
@endsection