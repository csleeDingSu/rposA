@extends('layouts.default')

@section('title', '幸运转盘')

@section('top-css')
    @parent

    <link rel="stylesheet" href="{{ asset('/client/unpkg.com/flickity@2/dist/flickity.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/client/css/betting_table-vip.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/game-node-vip.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/results-node.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/history-node.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/wheel-new-vip.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/vip-node.css') }}" />
	<link rel="stylesheet" href="{{ asset('/client/css/keyboard.css') }}">

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
							<span class="spanAcuPointAndBalance">0</span>
							<!-- <span class="spanAcuPoint" style="font-size: 0;">0</span> -->
						</div>
						
						<a  href="googlechrome://navigate?url=https://j.youzan.com/tIigBi">
							<img class="btn-calculate-vip btn-redeemcash" src="{{ asset('/client/images/btn-topup.png') }}" />
						</a>
					
					</div>
				</div>
				<div class="speech-bubble-point">已赚了50金币大约可换5元</div>
			</div>
			
			<div class="box" id="btn-vip-wrapper">
				<div class="btn-rules-wrapper btn-vip-wrapper">
					<!-- <a href="/arcade"> -->
						<!--div class="btn-vip"></div-->
						<!-- <div class="btn-rules-vip">返回普通场</div> -->
						<div class="btn-rules-vip"><img src="{{ asset('/client/images/wheel/money.png') }}" />玩法介绍</div>
					<!-- </a> -->
					<div style="clear:both"></div>
				</div>
				<!--div class="btn-rules-wrapper btn-info-vip-wrapper">
						<div class="btn-info-vip">99%稳赢玩法</div>
					<div style="clear:both"></div>
				</div-->
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
			<input id="hidHall" type="hidden" value="" />
			<input id="hidBet" type="hidden" value="" />
			<input id="hidLastBet" type="hidden" value="" />
			<input id="hidLastBetAmount" type="hidden" value="" />
			<input id="hidLastReward" type="hidden" value="" />
			<input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
			<!-- <input id="hidWechatId" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" /> -->
			<input id="hidWechatId" type="hidden" value="0" />
			<input id="hidWechatName" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_name) ? Auth::Guard('member')->user()->wechat_name : null}}" />
			<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
			<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
			<input id='game_name' type="hidden" value="{{env('game_name', '幸运转盘')}}" />
			<input id='justlogin' type="hidden" value="{{Session::get('justlogin')}}" />			
	  	</div>

	</div>

	<!-- end information table -->

	<!--h2 class="strikethrough"><span>已抽奖<div class="span-play-count">0</div>次</span></h2-->

	<!-- swiper iframe -->
	<div class="swiper-container">
		<div class="carousel-cell">
			<div class="frame-wrapper">
				<div class="results-body">
					<div class="results-wrapper">
					<div class="results-row">
						<div class="chain-wrapper results-left">
							<div class="chain"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-1" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-2" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-3" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-4" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-5" class="results-box"></div>
						</div>
						<div class="chain-wrapper results-right">
							<div class="right-chain"></div>
						</div>
				  	</div>


				  	<div class="results-row">
				  		<div class="chain-wrapper results-left">
				  			<div class="chain"></div>
				  			<div class="left-chain"></div>
				  		</div>
				  		<div class="box-wrapper">
							<div id="result-10" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-9" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-8" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-7" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-6" class="results-box"></div>
						</div>
						<div class="chain-wrapper results-right"></div>
				  	</div>

				  	<div class="results-row">
				  		<div class="chain-wrapper results-left">
				  			<div class="chain"></div>
				  		</div>
				  		<div class="box-wrapper">
							<div id="result-11" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-12" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-13" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-14" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-15" class="results-box"></div>
						</div>
						<div class="chain-wrapper results-right">
							<div class="right-chain results-right"></div>
						</div>
				  	</div>

				  	<div class="results-row">
				  		<div class="chain-wrapper results-left">
				  			<div class="chain"></div>
				  		</div>
				  		<div class="box-wrapper">
							<div id="result-20" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-19" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-18" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-17" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-16" class="results-box"></div>
						</div>
						<div class="chain-wrapper results-right"></div>		
				  	</div>

				  	<div class="results-row">
				  		<div class="chain-wrapper results-left">
				  			<div class="chain"></div>
				  		</div>
				  		<div class="box-wrapper">
							<div id="result-21" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-22" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-23" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-24" class="results-box"></div>
						</div>
						<div class="box-wrapper">
							<div id="result-25" class="results-box"></div>
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
					<img src="{{ asset('/client/images/vip/banner.png') }}" />
				</div>
				<div id="wheel_container" class="big-border">
					<div class="small-border g6">

						<div class="shan">
							<span class="span-odd"><span class="odd-sign"></span><span class="odd-payout">0</span>金币</span>
							<div class="div-odd">单数 <span class="odd-number">1</span></div>
						</div>

						<div class="shan">
							<span class="span-even">0金币</span>
							<div class="div-even">双数 <span class="even-number">2</span></div>
						</div>

						<div class="shan">
							<span class="span-odd">0金币</span>
							<div class="div-odd">单数 <span class="odd-number">3</span></div>
						</div>

						<div class="shan">
							<span class="span-even">0金币</span>
							<div class="div-even">双数 <span class="even-number">4</span></div>
						</div>
						
						<div class="shan">
							<span class="span-odd">0金币</span>
							<div class="div-odd">单数 <span class="odd-number">5</span></div>
						</div>

						<div class="shan">
							<span class="span-even">0金币</span>
							<div class="div-even">双数 <span class="even-number">6</span></div>
						</div>						
					</div>
				</div>
				<div id="txtCounter" class="middle-label"></div>
				<div class="DB_G_hand start-game"></div>
		    </div>
		</div>

		<div class="carousel-cell">
			<div class="frame-wrapper">
				<div class="history-body">
					<div class="history-wrapper">
						<table class="history-table">
						    <tbody>
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
						        <tr id="row-8">
						            <td class="history-number"></td>
						            <td class="history"></td>
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
	<!--div class="instruction">请猜下一局幸运号是单数或双数</div-->

	<!-- progress bar -->
	<section class="barWrapper">
      	<article class="barBox">
	      <div class="rule"></div>
	      <input type="hidden" class="span-bet" value="0" />
	      	<div class="col-xs-2">
		        <div class="bet-box">
		        	<div class="button-bet">1</div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">		        	
		        	<div class="button-bet">10</div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">
		        	<div class="button-bet">50</div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">		        	
		        	<div class="button-bet">100</div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">
		        	<div class="button-bet">500</div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">		        	
		        	<div class="button-bet-clear"></div>
		        </div>
		    </div>
		    <div style="clear: both;"></div>
	      <!-- button wrapper -->
		<div class="button-wrapper">
	        <div class="button-card radio-primary">
	        	<div class="radio btn-rectangle left-rectangle">
					<input name="rdbBet" class="invisible" type="radio" value="odd">
					选择单数
				</div>
				<div class="DB_G_hand selection"></div>				
			  </div>
			  <div class="button-card radio-primary right">
				<div class="radio btn-rectangle right-rectangle">
					<input name="rdbBet" class="invisible" type="radio" value="even">
					选择双数
				</div>
			  </div>
			  <div class="btn-trigger"></div>
		</div>
		<div style="clear: both;"></div>

		<div class="redeem-banner">
			<img src="{{ asset('/client/images/vip/redeem-banner.png') }}" alt="share">
		</div>

		<div class="redeem-prize-wrapper"></div>
		<div style="clear: both"></div>

		<div class="redeem-info">
			<div class="info-box">
				<div class="info-title">
					<img src="{{ asset('/client/images/vip/decoration.png') }}" />换购规则<img src="{{ asset('/client/images/vip/decoration.png') }}" />
				</div>
				<hr />
				关于金币：<span class="info-highlight">金币是用来换购产品使用，通过幸运转盘游戏获得，1金币等于1元。</span><br />
				<br />
				如何换购：<span class="info-highlight">进入礼品专区，挑选换购产品，下单后平台发货，每次换购完会自动扣除等值金币。</span>
				<br />
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
	<div class="modal fade col-md-12" id="reset-life-max_bk" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
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
								<div class="modal-confirm-button btn-reset-life btn-red-packet">
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

	<div class="modal fade col-md-12" id="reset-life-max" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
	<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="packet-title">恭喜您!</div>
				<div class="modal-body">
					<div class="modal-row">
						<div class="wrapper modal-full-height">							
							<div class="modal-card">
								<div class="packet-value">赢得<span class="spanVipPoint"></span>元红包</div>	
								<div class="instructions">
									您已结算红包：<div class="packet-point">&nbsp;</div>元
								</div>
								<div class="modal-confirm-button btn-reset-life btn-red-packet">确认结算</div>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>
<!--  end -->

	<!-- new -->
	<div class="modal fade col-md-12" id="reset-life-play" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg close-modal" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-title">
								  兑换说明
								</div>
								<div class="instructions">
									每局满15元结算兑换红包<br>
									您已赢到<span class="packet-acupoint">10</span>元，还差<span class="packet-acupoint-to-win">5</span>元兑换
								</div>
								<div class="close-modal modal-warning-button">
									知道了
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
                	<img class="share-logo" src="{{ asset('/client/images/no-life.png') }}" width="60" height="60" />
                </div>
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card share-card">
								<div class="modal-share-title">
									您的场次已用完
								</div>
								<div class="modal-invite-content">
									<h1 class="modal-invite-title">邀请好友送场次</h1>
									邀请<span class="highlight-peach">1个</span>人送<span class="highlight-peach">1场</span>转盘(15次抽奖)<br/>
									好友邀请<span class="highlight-peach">2个</span>，你再获得<span class="highlight-peach">1场次</span>。
									<a href="/share" class="link-button">
										<div class="modal-vip-button">
											邀请好友
										</div>
									</a>
								</div>
								<div class="span-purchase">嫌邀请好友麻烦？直接购买！</div>
								<a href="/purchase" class="link-button">
									<div class="modal-share-button">
										点击购买
									</div>
								</a>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade col-md-12" id="reset-life-share-bk" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
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
										<li>Q币购买次数，首次购买仅需<span class="_1st_basic_topup">6Q币/次</span>，之后购买10Q币/次，每天限购5次。</li>
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
								<div class="modal-warning-content redeem-error">
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
								<div class="modal-lose-title">
									本轮游戏失败
								</div>
								<div class="modal-lose-content">
									很遗憾，您未能赢得红包
								</div>
								<div class="modal-warning-button btn-reset-life">
									知道了
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
			<div class="modal-content">
				<div class="modal-body">
					<div class="modal-row">
						<div class="wrapper modal-full-height">							
							<div class="modal-card">
								<div class="packet-title">抽中金币</div>
								<div class="packet-value">6</div>
								<div class="close-win-modal modal-redeem-button btn-red-packet">
									确认领取
								</div>
								<div class="instructions">
									您已抽中6金币
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

	<div class="modal fade col-md-12" id="lose-modal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-win-title">好可惜！差点就中了!</div>
								<div class="modal-instruction">这局亏了50元，继续加油哦</div>
								<div class="close-win-modal modal-redeem-button">
									再抽一次
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
				<div class="packet-title">恭喜您猜对了</div>
				<div class="modal-body" style="padding:10px !important;">
					<div class="modal-row">
						<div class="wrapper modal-full-height">							
							<div class="modal-card">
								<div class="packet-value"><span class="packet-sign">+</span>6<span class="packet-currency">元</span></div>
								<div class="packet-info">前5局猜错<span class="highlight">亏损570积分</span><br />第6局猜对<span class="highlight-green">奖励630积分</span><br />最终奖励60积分，<span class="highlight-red">赢到了6元</span><br />满15元可兑换红包</div>
								<div class="instructions">
									您已赢到6元，还差9元可兑换
								</div>
								<a href="/member/login/register">
									<div class="btn-red-packet">确认领取</div>
								</a>
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
		<div class="modal-dialog modal-lg close-modal" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-title">
								  倍增式玩法说明
								</div>
								<div class="instructions">
									第1局10积分，如果猜错了怎么办？<br/>
									第2局就投30积分，如果第2局猜对，就能得到30积分，扣掉第1局亏的10积分，最终还赚20积分。<br />
									如果第2局还猜错，第3局就投70积分。 。 。<br />
									1200游戏积分能做6次倍增，这是猜单双的游戏，6次之内猜对的概率是99%。<br />
									如果猜对就返回从10积分开始。
								</div>
								<div class="close-modal modal-warning-button">
									知道了
								</div>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!-- New - Top right corner Game Rules starts -->
	<div class="modal fade col-md-12" id="top-corner-game-rules" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg close-modal" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-title">
								  玩法说明
								</div>
								<div class="instructions">
									<p>
									默认拥有1200游戏积分用来抽奖，赚到的积分会换成红包，10积分兑换1元红包。</p>
									<p>
									这是自助的抽奖转盘，先选单数或双数再按抽奖，抽中就有积分奖励，抽错就扣除积分。</p>
									<p>
									1200积分被分成6次，按倍增式玩法，只要6次之内猜对，就能一直赚红包。</p>
								</div>
								<div class="close-modal modal-warning-button">
									知道了
								</div>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>
<!-- New - Top right corner Game Rules starts -->

<!-- customer service modal -->
<div class="modal fade col-md-12" id="modal-sure-win" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-title">倍增式玩法说明</div>
		<div class="modal-content modal-wechat">
			<div class="modal-body">
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						<div class="modal-card">
							<div class="sure-win-title">6次猜中1次就能稳赚</div>
							<img src="{{ asset('/client/images/vip/sure-win.png') }}" width="250px" />
							<div class="instructions">
								按照倍增式玩法提示的数字<span class="highlight">[1-3-7-15-31-63]</span>去选择投注。只要在6次中猜中任何一次，就能保证稳赚。
							</div>
						</div>
						<div class="close-modal modal-redeem-button">
							我知道了
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- customer service modal Ends -->

<!-- check-vip-status modal -->
<div class="modal fade col-md-12" id="modal-check-vip-status" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-title">金币不足</div>
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						<div class="modal-card">
							<div class="instructions2">VIP专场需满120金币</div>
							<div class="instructions2">您有<span class="yourPoint">0</span>金币，还差<span class="pointStillNeed">120</span>金币</div>
							<div class="instructions3">1元等于1金币， 充值一次永久使用</div>

							<a href="https://j.youzan.com/tIigBi" onclick="window.open(this.href,'_system'); return false;">
								<div class="btn-purchase-point">立刻充值</div>
							</a>

						</div>
						<div class="vip-title">
							<img src="{{ asset('/client/images/vip/left_deco.png') }}" width="18px" height="13px" /> VIP专场特权 <img src="{{ asset('/client/images/vip/right_deco.png') }}" width="18px" height="13px" />
						</div>
						<div class="vip-desc">
							<ul>
								<li><span class="vip-highlight">兑换精选豪礼，</span>iPhone拿不停。</li>
								<li><span class="vip-highlight">无上限封顶，</span>想赢多少都行。</li>
								<li><span class="vip-highlight">自由式玩法，</span>自选金额不受限。</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- check-vip-status modal Ends-->

<!-- insufficient point modal -->
<div class="modal fade col-md-12" id="modal-insufficient-point" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="insufficient-point">金币不足 请充值</div>					
	</div>
</div>
<!-- insufficient point modal Ends -->

<!-- haven't login start modal -->
<div class="modal fade col-md-12" id="modal-no-login" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="instructions1 nologin-bg">
			<p>
			独创的自助式抽奖，<br>赚积分换购超值奖品，本专场特点
			</p>
			<div class="instructions2 instruction-top-padding"><span class="glyphicon glyphicon-star cust-star"></span>无抽奖上限，无限任你抽。</div>
			<div class="instructions2"><span class="glyphicon glyphicon-star cust-star"></span>大量超值奖品，闪电换购。</div>
			<div class="instructions2"><span class="glyphicon glyphicon-star cust-star"></span>100%公平机制，绝无作弊。</div>
			<a href="/nlogin">
				<div class="btn-login"></div>
			</a>
		</div>		
	</div>
</div>
<!-- haven't login modal Ends-->
<div class="openForm">
	<div class="formTitle">玩法介绍</div>
	<div class="formBody">
		这是个可设置金币的自助抽奖平台，每次50%抽中概率，如何提
		高抽中概率？可以用倍增法，看如下：<br />
		第一局设1金币，没抽中。<br />
		第二局设3金币，没抽中。<br />
		第三局设8金币，抽中了。<br />
		这就是倍增法：当你没抽中的时候，就设定更多的金币，<br />
		像案例里的<span class="highlight1">第三局抽中赚了15.68金币</span>，扣除<span class="highlight2">三局投入的11金币</span>，<br />
		最终<span class="highlight3">赚到4.68金币</span>。
	</div>
	<div class="formTableTitle">可以参考以下的倍增表格：</div>

	<table class="formTable">
	  <tr>
	    <th>次数</th>
	    <th>本次投入</th>
	    <th>总投入</th>
	    <th>抽中金币</th>
	    <th>概率</th>
	    <th>最终赚到</th>
	  </tr>
	  <tr>
	    <td>1</td>
	    <td>1</td>
	    <td>1</td>
	    <td>1.96</td>
	    <td>50%</td>
	    <td>0.96</td>
	  </tr>
	  <tr>
	    <td>2</td>
	    <td>3</td>
	    <td>4</td>
	    <td>5.88</td>
	    <td>70%</td>
	    <td>1.88</td>
	  </tr>
	  <tr>
	    <td>3</td>
	    <td>8</td>
	    <td>11</td>
	    <td>15.68</td>
	    <td>87.50%</td>
	    <td>4.68</td>
	  </tr>
	  <tr>
	    <td>4</td>
	    <td>18</td>
	    <td>30</td>
	    <td>35.28</td>
	    <td>93.75%</td>
	    <td>5.28</td>
	  </tr>
	  <tr>
	    <td>5</td>
	    <td>38</td>
	    <td class="suggestion"><strong>68</strong><img src="/client/images/vip/label_suggestion.png" /></td>
	    <td>174.48</td>
	    <td>96.87%</td>
	    <td>6.48</td>
	  </tr>
	  <tr>
	    <td>6</td>
	    <td>80</td>
	    <td>148</td>
	    <td>156.8</td>
	    <td>98.43%</td>
	    <td>8.8</td>
	  </tr>
	</table>
</div>
	@parent
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="{{ asset('/client/cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js') }}"></script>
	<script src="{{ asset('/client//unpkg.com/flickity@2/dist/flickity.pkgd.min.js') }}"></script>
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	<script src="{{ asset('/client/js/jquery.rotate.min.js') }}"></script>
    <script src="{{ asset('/client/js/jquery.wheel.js') }}"></script>
    <script src="{{ asset('/client/js/js.cookie.js') }}"></script>
    <script src="{{ asset('/client/js/ifvisible.js') }}"></script>
    <script src="{{ asset('/client/js/jquery.animateNumber.js') }}"></script>
    <script src="{{ asset('/client/js/public.js') }}" ></script>
	<script src="{{ asset('/client/js/slide.js') }}"></script>

	<script type="text/javascript">
		var url = "{{ env('APP_URL'), 'http://boge56.com' }}";      
    	var port = "{{ env('REDIS_CLI_PORT'), '6001' }}";

    (function() {
			    var ev = new $.Event('remove'),
			        orig = $.fn.remove;
			    $.fn.remove = function() {
			        $(this).trigger(ev);
			        return orig.apply(this, arguments);
			    }
			})();

		$(document).ready(function () {

			var wechat_status = $('#hidWechatId').val();
			var wechat_name = $('#hidWechatName').val();

			var user_id = $('#hidUserId').val();

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

			$('#viewgamerules').on('click', showGameRules);
			
			$('.btn-vip-modal').click( function() {
		        $('#top-corner-game-rules').modal({backdrop: 'static', keyboard: false});
		    });

		    $('.button-info').click( function() {
		        $('#modal-sure-win').modal();
		    });

            $(".btn-rules-vip").click(() => {  
                being.wrapShow();
                $(".openForm").slideDown(150);
                $(".wrapBox ").click(function (e) {
                  being.wrapHide();
                  $(".openForm").slideUp(150);
                });
              });


			// if (user_id <= 0) {
			// 	openmodel();
			// }	

			// $('.btn-calculate-vip').click( function() {
		 //        window.open("https://j.youzan.com/tIigBi", "_system");
		 //    });

		});

	</script>

	<script src="{{ asset('/client/js/Date.format.min.js') }}"></script>
	<script src="{{ asset('/client/js/vip-node.js') }}"></script>
@endsection
