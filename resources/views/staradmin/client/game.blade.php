@extends('layouts.default')

@section('title', '幸运转盘')

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
				<div class="btn-calculate">
					<div class="balance-banner">
						<img class="icon-newcoin" src="{{ asset('/client/images/coin.png') }}" />
						<div class="spanAcuPoint2">
							<span class="spanAcuPoint">0</span>
						</div>
						<img class="btn-redeemcash" src="{{ asset('/client/images/btn-redeemcash.png') }}" />
					</div>
				</div>
				<!-- <div class="btn-calculate">
					<div class="balance-banner">
						<span class="spanAcuPoint">0</span>
					</div>
				</div> -->
				<!--div class="coin"></div>
				<div class="number">
					<span class="balance spanAcuPoint">0</span>
					<div class="btn-calculate-wrapper">
						<div class="btn-calculate">兑换红包</div>
					</div>
				</div-->
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
				<div class="btn-rules-wrapper btn-vip-modal btn-vip-wrapper">
						<!--div class="btn-vip"></div-->
						<div class="btn-rules-normal"></div>
					<div style="clear:both"></div>
				</div>
			</div>
			@endif

			<input id="result" type="hidden" value="6">
		    <input id="freeze_time" type="hidden" value="">
		    <input id="draw_id" type="hidden" value="">
			<input id="hidTotalBalance" type="hidden" value="" />
			<input id="hidBalance" type="hidden" value="" />
			<input id="hidLevel" type="hidden" value="" />
			<input id="hidLevelId" type="hidden" value="" />
			<input id="hidLatestResult" type="hidden" value="" />
			<input id="hidConsecutiveLose" type="hidden" value="" />
			<input id="hidHall" type="hidden" value="" />
			<input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
			<!-- <input id="hidWechatId" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" /> -->
			<input id="hidWechatId" type="hidden" value="0" />
			<input id="hidWechatName" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_name) ? Auth::Guard('member')->user()->wechat_name : null}}" />
			<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
			<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
			<input id='hidbetting_count' type="hidden" value="{{$betting_count}}" />
			<input id='game_name' type="hidden" value="{{env('game_name', '幸运转盘')}}" />
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
						幸运倒计时：<span class="span-timer"></span>秒
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
				<div id="wheel_banner">
					<img src="{{ asset('/client/images/wheel-banner.png') }}" />
				</div>
		        <div id="wheel_container"></div>
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
						        		幸运倒计时：<span class="span-timer"></span>秒
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
	<div class="spinning">转盘转动中，请等待结果。</div>
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
									恭喜获得150金币
								</div>
								<div class="modal-message-content">
									每次最多可获得150金币<br />
									您当前已经封顶
								</div>
								<div class="modal-message-balance">
									您当前总金币：<div class="packet-point">&nbsp;</div>
								</div>
								<div class="modal-confirm-button btn-reset-life">
									确认结算
								</div>
								<!--a href="/share">
								<div class="modal-invite-button">
									分享好友获挖宝机会
								</div>
								</a-->										
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
									本次赚了<span class="spanAcuPoint">0</span>金币
								</div>
								<div class="modal-warning-info">
								  需要满150才能结算
								</div>
								<h1 class="divider">已结算金币：<span class="wallet-point"></span></h1>
								<div class="modal-content-wrapper">
									<div class="modal-warning-content">
										<div class="col-xs-4 voucher-wrapper">
											<div class="voucher-value"><span class="voucher-yuan">￥</span>30</div>
										</div>
										<div class="col-xs-8">
											<div class="voucher-description">300金币兑换</div>
											<div class="voucher-instruction">免单现金红包</div>
										</div>
									</div>
								</div>
								<div class="modal-content-wrapper">
									<div class="modal-warning-content">
										<div class="col-xs-4 voucher-wrapper">
											<div class="voucher-value"><span class="voucher-yuan">￥</span>50</div>
										</div>
										<div class="col-xs-8">
											<div class="voucher-description">500金币兑换</div>
											<div class="voucher-instruction">免单现金红包</div>
										</div>
									</div>
								</div>
								<div class="modal-content-wrapper">
									<div class="modal-warning-content">
										<div class="col-xs-4 voucher-wrapper">
											<div class="voucher-value"><span class="voucher-yuan">￥</span>100</div>
										</div>
										<div class="col-xs-8">
											<div class="voucher-description">1000金币兑换</div>
											<div class="voucher-instruction">免单现金红包</div>
										</div>
									</div>
								</div>
								<div style="clear: both"></div>

								<div class="close-modal modal-warning-button">
									返回{{env('game_name', '幸运转盘')}}
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

	<div class="modal fade col-md-12" id="reset-life-play_bk" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-warning-title">
									您拥有<span class="spanAcuPoint">0</span>金币
								</div>
								<div class="speech-balloon">
								  <div class="arrow top right"></div>
								  您有<span class="spanAcuPoint">0</span>金币未结算 需满150才能结算
								</div>
								<div class="modal-content-wrapper">
									<div class="modal-warning-content">
										<div class="col-xs-4 voucher-wrapper">
											<div class="voucher-value"><span class="voucher-yuan">￥</span>30</div>
											<div class="voucher-label">购物补助金</div>
										</div>
										<div class="col-xs-8">
											<div class="voucher-description">30元购物补助金</div>
											<div class="voucher-instruction">需要300金币兑换</div>
										</div>
									</div>
								</div>
								<div class="modal-content-wrapper">
									<div class="modal-warning-content">
										<div class="col-xs-4 voucher-wrapper">
											<div class="voucher-value"><span class="voucher-yuan">￥</span>50</div>
											<div class="voucher-label">购物补助金</div>
										</div>
										<div class="col-xs-8">
											<div class="voucher-description">50元购物补助金</div>
											<div class="voucher-instruction">需要500金币兑换</div>
										</div>
									</div>
								</div>
								<div class="modal-content-wrapper">
									<div class="modal-warning-content">
										<div class="col-xs-4 voucher-wrapper">
											<div class="voucher-value"><span class="voucher-yuan">￥</span>100</div>
											<div class="voucher-label">购物补助金</div>
										</div>
										<div class="col-xs-8">
											<div class="voucher-description">100元购物补助金</div>
											<div class="voucher-instruction">需要1000金币兑换</div>
										</div>
									</div>
								</div>
								<div style="clear: both"></div>

								<div class="close-modal modal-warning-button">
									返回{{env('game_name', '幸运转盘')}}
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
				<div class="share-logo-wrapper">
                	<img class="share-logo" src="{{ asset('/client/images/no-life.png') }}" width="77" height="77" />
                </div>
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card share-card">
								<div class="modal-share-title">
									您的次数已用完
								</div>
								<div class="modal-invite-content">
									<h1 class="modal-invite-title">您有以下选择</h1>
									<ol class="vegan-list">
										<li>购买次数，首次购买仅需5.8元/次，之后购买9.9元/次，每天限购5次。</li>
										<li>邀请好友加入，邀请1个获得{{env('sharetofriend_youwillget', '1')}}次机会</li>
									</ol>
								</div>
								<a href="/purchase" class="link-button">
									<div class="modal-share-button">
										我要购买
									</div>
								</a>
								<a href="/share" class="link-button">
									<div class="modal-vip-button">
										邀请好友
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
									你猜的游戏正在进行中
								</div>

								<div class="close-modal modal-warning-button">
									继续游戏
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
									本次游戏失败
								</div>
								<div class="modal-lose-content">
									本局盈利的金币清零
								</div>
								<div class="modal-confirm-button btn-reset-life">
									继续游戏
								</div>
								<!--a href="/share">
								<div class="modal-invite-button">
									分享好友获挖宝机会
								</div>
								</a-->
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
									当前不能玩游戏
								</div>
								<div class="modal-warning-content">
									您必须把游戏机会兑换成金币
								</div>

								<div class="btn-reset-life-continue modal-warning-button">
									兑换金币
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
									这是个猜单双的游戏，原始积分为1200，依次被分成6次供玩家下注[10,30,70,150,310, 640]<br />
									<span class="highlight">玩法解释：</span><br />
									第一局下注10积分，如果猜错，第二局下注30积分，这样能保证第二局猜中后，不仅把第一局亏的填补上，而且还能赚积分。<br />
									一共被分成6次下注，只要6次内猜中一次，就能不停循环的赚取更多积分。<br />
									<span class="highlight">如何兑换红包：</span><br />
									赚到的积分可兑换免单红包（可提现），大约兑换比率：10金币兑换1元。
								</div>

								@if($betting_count > 0)
									<div class="btn-game-rules btn-rules-close">返回{{env('game_name', '幸运转盘')}}</div>
								@else
									<div class="btn-game-rules btn-rules-timer"><span class="span-read">请阅读游戏规则</span> <span class="txtTimer"></span></div>	
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

	<div class="modal fade col-md-12" id="vip-modal" tabindex="-1" role="dialog" aria-labelledby="vip-label" aria-hidden="true">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content vip-background">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card vip-modal-card">
								<div class="vip-card">
									<div class="vip-card-title">
										<img src="{{ asset('/client/images/vip/left_deco.png') }}" width="18px" height="13px" /> 会员特权 <img src="{{ asset('/client/images/vip/right_deco.png') }}" width="18px" height="13px" />
									</div>
									<div class="vip-card-desc">
										<ul>
											<li><span class="vip-highlight">赠送1200金币，</span>可结算红包。</li>
											<li><span class="vip-highlight">无上限封顶，</span>想赚多少都行。</li>
											<li><span class="vip-highlight">无需邀请人，</span>直接玩不麻烦。</li>
										</ul>
									</div>
									<a href="/membership"><div class="btn-vip-submit">99元开通会员</div></a>
								</div>								
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

<!-- Start Win -->

	<div class="modal fade col-md-12" id="win-modal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-title modal-win-header">
				<div class="modal-win-title">恭喜你猜对了</div>
				<div class="modal-result">+10</div>
				大约可兑换现金￥1元				
			</div>

			<div class="modal-content">
				<img class="separator" src="{{ asset('/client/images/progress-bar/separator.png') }}" width="300" height="13" />
				<div class="background">奖励规则说明</div>
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<img class="modal-progress-bar" src="{{ asset('/client/images/progress-bar/10.png') }}" width="250" height="50" />
								<div class="modal-instruction">游戏原始积分1200，你前0次都猜错了，亏损<span class="modal-minus">0积分</span>，第1次猜对，赚了<span class="modal-add">+10积分</span>。<br />
								所以最终赚到10积分（10-0=10）</div>
								<div class="close-win-modal modal-redeem-button">
									领取奖励
								</div>												
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

<!-- Start Win -->
	<div class="modal fade col-md-12" id="red-packet-modal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="packet-title">恭喜你获得免单红包</div>
				<div class="modal-body" style="padding:10px !important;">
					<div class="modal-row">
						<div class="wrapper modal-full-height">							
							<div class="modal-card">
								<div class="packet-value"><span class="packet-sign">￥</span>45</div>
								<div class="packet-info">可提现支付宝</div>
								<div class="instructions">
									<h1 class="divider">领取方式</h1>
									注册后，进入 <img src="{{ asset('/client/images/small-life.png') }}" width="20" height="20" /> <span class="highlight">{{env('game_name', '幸运转盘')}}</span> 赚金币换领取<br />
									新人免费玩3次 可赚45元
								</div>
								<a href="/member/login/register">
									<div class="btn-red-packet">注册</div>
								</a>
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
    <script src="{{ asset('/client/js/jquery.animateNumber.js') }}"></script>
    <script src="{{ asset('/client/js/public.js') }}" ></script>
	<!-- <script src="{{ asset('/client/js/NoSleep.js') }}"></script> -->

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
	<script src="{{ asset('/client/js/game.js') }}"></script>
@endsection