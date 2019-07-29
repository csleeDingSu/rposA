@extends('layouts.default')

@section('title', '幸运转盘')

@section('top-css')
    @parent

    <link rel="stylesheet" href="{{ asset('/client/unpkg.com/flickity@2/dist/flickity.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/client/css/betting_table.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/progress_bar_new.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/game-node.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/results-node.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/history-node.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/wheel-new.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/productv2.css') }}" />
    

    <style>
    	
    	.reveal-modal {
		    /*position: relative;*/
		    margin: 0 auto;
		    top: 25%;
		}

		.isnext{ text-align: center;font-size: .26rem; color: #999; line-height: 1.6em; padding: .15rem 0; }

    </style>
@endsection
    	
@section('top-navbar')
@endsection

@section('content')
<a name="top"></a>

<div class="loading"></div>
<div class="reload">
	<div class="center-content">加载失败，请安刷新</div>
</div>
<div class="cardBody">
			<div class="box">

<div class="full-height">
	<!-- information table -->
	<div class="information-table">
		<div class="grid-container">
			<div class="box">
				
				<div class="btn-calculate">
					<div class="balance-banner">
						<div class="spanAcuPoint2">
							<span class="spanAcuPointAndBalance">0</span>元
							<!-- <span class="spanAcuPoint" style="font-size: 0;">0</span> -->
						</div>
						<div class="btn-redeemcash">抽奖规则</div>
					</div>
				</div>
				<div class="speech-bubble-point">满15元即可领取</div>
				<div class="profile-pic">
					<img class="profile-img-circle" src="{{ Auth::Guard('member')->user()->profile_pic ?? '/client/images/avatar.png' }}"> &nbsp;
				</div>
			</div>

			<div class="box" id="btn-vip-wrapper">
				<a href="/profile">
					<img class="icon-wheel-corner" src="{{ asset('/client/images/wheel/icon-wheel-corner.png') }}" />
					<div class="btn-life">剩{{ isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}次
					</div>
					<img class="icon-arrow-next" src="{{ asset('/client/images/wheel/icon-arrow-next.png') }}" />
					<div style="clear:both"></div>
				</a>
			</div>
			
			<input id="nTxt" class="nTxt" type="hidden" value="">
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
				  			<div class="left-chain"></div>
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
					<img src="{{ asset('/client/images/wheel/banner.png') }}" />
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
	      <div class="col-xs-2">
	      	
		        <div class="bet-box">
		        	<div data-level="1" class="button-bet-default">
		        		<div class="bet_amount">1</div>
		        		<div class="bet_status">起步</div>
		        	</div>
		        	<div class="circle-border">
		        	</div>
		        	<div class="DB_G_hand_1"></div>
		        </div>
			
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">		        	
		        	<div data-level="2" class="button-bet-default">
		        		<div class="bet_amount"><span class="multiply">x</span>3</div>
		        		<div class="bet_status">加倍</div>
		        	</div>
		        	<div class="circle-border">
		        	</div>
		        	<div class="DB_G_hand_1"></div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">
		        	<div data-level="3" class="button-bet-default">
		        		<div class="bet_amount"><span class="multiply">x</span>7</div>
		        		<div class="bet_status">加倍</div>
		        	</div>
		        	<div class="circle-border">
		        	</div>
		        	<div class="DB_G_hand_1"></div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">		        	
		        	<div data-level="4" class="button-bet-default">
		        		<div class="bet_amount"><span class="multiply">x</span>15</div>
		        		<div class="bet_status">加倍</div>
		        	</div>
		        	<div class="circle-border">
		        	</div>
		        	<div class="DB_G_hand_1"></div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">
		        	<div data-level="5" class="button-bet-default">
		        		<div class="bet_amount"><span class="multiply">x</span>31</div>
		        		<div class="bet_status">加倍</div>
		        	</div>
		        	<div class="circle-border">
		        	</div>
		        	<div class="DB_G_hand_1"></div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">		        	
		        	<div data-level="6" class="button-bet-default">
		        		<div class="bet_amount"><span class="multiply">x</span>63</div>
		        		<div class="bet_status">加倍</div>
		        	</div>
		        	<div class="circle-border">
		        	</div>
		        	<div class="DB_G_hand_1"></div>
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
			  </div>
			  <div class="button-card radio-primary right">
				<div class="radio btn-rectangle right-rectangle">
					<input name="rdbBet" class="invisible" type="radio" value="even">
					选择双数
				</div>
			  </div>
			  <div class="btn-trigger"></div>
			  <div class="DB_G_hand_2"></div>
			  <div class="DB_G_hand_3"></div>
		</div>
		<!-- end button wrapper -->
		<div style="clear: both;"></div>

		<div class="redeem-banner">
			<img src="{{ asset('/client/images/wheel/banner-title.png') }}" alt="share">
		</div>
	    </article>
    </section>
	<!-- end progress bar -->
	

	
</div>
{{-- @include('client.product') --}}
<div class="infinite-scroll">
	<ul class="list-2">								
			@include('client.productv2')
	</ul>
	{{ $vouchers->links() }}
	
	<p class="isnext">下拉显示更多...</p>

</div>
</div></div>
<!-- go back to top -->
	<a class="to-top" href="#top"><img src="{{ asset('/client/images/go-up.png') }}"/></a>
	
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
								<div class="packet-value">赢得15元红包</div>	
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
								
								<!-- <div class="span-purchase">嫌邀请好友麻烦？直接购买！</div>
								<a href="/purchase" class="link-button">
									<div class="modal-share-button">
										点击购买
									</div>
								</a> -->
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
		<div class="modal-dialog modal-sm close-modal" role="document">
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
											<li><span class="vip-highlight">无上限封顶，</span>想赢多少都行。</li>
											<li><span class="vip-highlight">自由试玩法，</span>自选金额不受限。</li>
											<li><span class="vip-highlight">每场送120元，</span>作为抽奖本金。</li>
											<li><span class="vip-highlight">无需邀请人，</span>直接玩不麻烦。</li>
										</ul>
									</div>
									<!-- <a href="/membership/buy/vip"><div class="btn-vip-submit">120元开通会员</div></a> -->
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
	</div>

<!--  end -->

<!-- Start Win -->

	<div class="modal fade col-md-12" id="win-modal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="packet-title">恭喜您猜对了</div>
				<div class="modal-body" style="padding:10px !important;">
					<div class="modal-row">
						<div class="wrapper modal-full-height">							
							<div class="modal-card">
								<div class="packet-value"><span class="packet-sign">+</span>6<span class="packet-currency">元</span></div>
								<div class="packet-info">前5局猜错<span class="highlight">亏损57元</span><br />第6局猜对<span class="highlight-green">奖励63元</span><br />最终奖励6元，<span class="highlight-red">赢到了6元</span><br />满15元可兑换红包</div>
								<div class="instructions">
									您已赢到6元，还差9元可兑换
								</div>
								<div class="close-win-modal modal-redeem-button btn-red-packet">
									确认领取
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
			<div class="modal-title modal-win-header">
				<div class="modal-win-title">差点抽中...再来一次...</div>
				<div class="modal-result">您还有1次机会</div>			
			</div>

			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-instruction">前5局猜错，<span class="highlight-grey">总亏损57元</span>，根据倍增式玩法，第6局将<span class="highlight-green">押注63元</span>，猜对能获得63元奖励，减去亏损的570还能赚6元。<br /><span class="highlight-red">赚到的元可兑换红包</span></div>
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
								<div class="packet-info">前5局猜错<span class="highlight">亏损57元</span><br />第6局猜对<span class="highlight-green">奖励63元</span><br />最终奖励6元，<span class="highlight-red">赢到了6元</span><br />满15元可兑换红包</div>
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
								  抽奖规则说明
								</div>
								<div class="instructions">
									<p>
										这是一个自助抽奖转盘，每次抽奖需自行设置单数或双数，并设置抽奖金币，抽中获得双倍回报。
									</p>
									<p>&nbsp;</p>
									<p>
										官方提供免费转盘金币，按照倍增玩法（具体规则进入抽奖体验)，赚到的金币可兑换红包。
									</p>
									<p>&nbsp;</p>
									<p>每场抽奖需抽满15元才可兑换红包。</p>
									<p>&nbsp;</p>
									<p>邀请好友可获得更多抽奖场次。</p>
								</div>
								<div class="close-modal modal-warning-button">
							{{-- @if($betting_count > 0) --}}
										<!-- <div class="btn-game-rules btn-rules-close">返回{{env('game_name', '幸运转盘')}}</div> -->
									{{-- @else --}}
										<!-- <div class="btn-game-rules btn-rules-timer"><span class="span-read">请阅读游戏规则</span> <span class="txtTimer"></span></div>	 -->
									{{-- @endif --}}
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
									默认拥有120游戏元用来抽奖，赚到的元会换成红包，1元兑换1元红包。</p>
									<p>
									这是自助的抽奖转盘，先选单数或双数再按抽奖，抽中就有元奖励，抽错就扣除元。</p>
									<p>
									12元被分成6次，按倍增式玩法，只要6次之内猜对，就能一直赚红包。</p>
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
	<!-- <script src="{{ asset('/client/js/NoSleep.js') }}"></script> -->

	<script type="text/javascript">
		var url = "{{ env('APP_URL'), 'http://boge56.com' }}";      
    	var port = "{{ env('REDIS_CLI_PORT'), '6001' }}";
    	var life = "{{isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}";

		$(document).ready(function () {

			var wechat_status = $('#hidWechatId').val();
			var wechat_name = $('#hidWechatName').val();
			var bet_count = $('#hidbetting_count').val();
			
			if(bet_count == 0){
				$('.selection').show();
			}

			var user_id = $('#hidUserId').val();

			$('.profile-pic').click(function(){
				window.location.href = '/profile';
			});


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

			$('.btn-vip-modal .btn-rules-vip').html('如何获得红包').addClass('btn-rules-normal');

			// $('.btn-vip-modal').on('click', showGameRules);

			$('.btn-vip-modal').click( function() {
		        $('#top-corner-game-rules').modal({backdrop: 'static', keyboard: false});
		    });

		 	// $('.btn-vip-modal').click( function() {
		  //       $('#vip-modal').modal({backdrop: 'static', keyboard: false});
		  //   });

			if (user_id <= 0) {
				openmodel();
			}

			if (life == 0) {
                $('.button-card').click( function() {
                    $('#reset-life-share').modal();
                });
            }

            //execute scroll pagination
            being.scrollBottom('.cardBody', '.box', () => {		

				page++;
				var max_page = parseInt($('#max_page').val());
				if(page > max_page) {
					$('#page').val(page);
					$(".isnext").html("@lang('dingsu.end_of_result')");
					$('.isnext').css('padding-bottom', '50px');

				}else{
					getPosts(page);
				}	
			});

		});

	//scroll pagination - start
		$('ul.pagination').hide();
		
		var page=1;

		function getPosts(page){
			$.ajax({
				type: "GET",
				url: window.location+"/?page"+page, 
				data: { page: page },
				beforeSend: function(){ 
				},
				complete: function(){ 
				  $('#loading').remove
				},
				success: function(responce) { 
					$('.list-2').append(responce.html);
				}
			 });
		}
	//scroll pagination - end
		

	</script>

	<script src="{{ asset('/client/js/Date.format.min.js') }}"></script>
	<script src="{{ asset('/client/js/game-node.js') }}"></script>
@endsection

<link rel="stylesheet" href="{{ asset('/client/css/intro_popup.css') }}"/>

	@include('client.intromodel')

