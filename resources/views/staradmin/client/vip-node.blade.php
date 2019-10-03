@extends('layouts.default_app')

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

	.reload2 {
		display: none;
		background-color: #fff;
		position: fixed;
	    left: 0px;
	    top: 0px;
	    width: 100%;
	    height: 100%;
	    z-index: 9999;
	}

	.no-connection-list {
      font-size: 0.3rem;
    padding: 0.24rem;
    margin-top:2rem;
    }

    .no-connection-list li {
    color: #666;
    font-size: 0.26rem;
    padding-bottom: 0.2rem;
    text-align: center;
  }

  .no-connection-background {
	}

	.no-connection-background img {
	    width: 70%;
	    }

	.no-connection-list .line1 {
	    color: #333;
	    font-size: 0.36rem;
	    padding: 0.1rem;
	}

	.no-connection-list .line2 {
	    color: #ccc;
	    font-size: 0.28rem;
	    padding:0.1rem;
	}

	.no-connection-list .btn-refresh {
	    background-color: #ff466f;
	    font-size: 0.32rem;
	    border-radius: 0.1rem;
	    color: #fff;
	    padding: 0.2rem;
	    text-align: center;
	    margin: 0.1rem 2rem;
	}

    </style>
@endsection
@section('top-javascript')
@parent
<script src="{{ asset('/test/open-new-browser-2/js/mui.min.js') }}"></script>
	    <script type="text/javascript" charset="utf-8">
	      	mui.init();
	    </script>
@endsection

@section('top-navbar')
@endsection

@section('content')
<div class="loading"></div>
<div class="reload2">
	<ul class="no-connection-list">
      <li>
        <div class="no-connection-background">
            <img src="/clientapp/images/no-connection/no-internet.png" />
        </div>
      </li>
      <li class="line1">网络竟然崩溃了</li>
      <li class="line2">别紧张，重新刷新试试</li>
      <div class="btn-refresh" onclick="javascript:location.reload();">重新刷新</div>
  </ul>
</div>

@if (env('THISVIPAPP', false))
	@include('client.game-top-nav')
@endif

<div class="full-height">
	<!-- information table -->
	<div class="information-table">
		<div class="grid-container">
			<div class="box">
				<div class="btn-calculate">
					<div class="icon-red">1</div>
					<div class="balance-banner">
						<div class="icon-newcoin"></div>
						<div class="spanAcuPoint2">
							<span class="spanAcuPointAndBalance">0.00</span>
							<!-- <span class="spanAcuPoint" style="font-size: 0;">0</span> -->
						</div>
						<div class="btn-calculate-vip btn-redeemcash" id="btn-redeemcash"></div>
					</div>
				</div>
				<div class="speech-bubble-point">已赚了50金币大约可换5元</div>
			</div>
			
			<div class="box" id="btn-vip-wrapper">
				<div class="btn-rules-wrapper btn-vip-wrapper">
						<div class="btn-rules-vip"></div>
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
			<input id="topupurl" type="hidden" value="{{env('TOPUP_URL','#')}}" />
			<input id="isIOS" type="hidden" value="false" />	
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
		        	<div class="speech-bubble-chips">可多次点击</div>
		        	<div class="button-bet button-bet-1">1</div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">		        	
		        	<div class="button-bet button-bet-10">10</div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">
		        	<div class="button-bet button-bet-50">50</div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">		        	
		        	<div class="button-bet button-bet-100">100</div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">
		        	<div class="button-bet button-bet-500">500</div>
		        </div>
		    </div>
		    <div class="col-xs-2">
		        <div class="bet-box">
		        	<div class="speech-bubble-clear">可清除重选</div>		        	
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
		<!-- end button wrapper -->
	    </article>
	   </section>
	<!-- end progress bar -->
</div>

@if (env('THISVIPAPP', false))
	@include('client.game-ranking-vip')
@else
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
@endif


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

<!-- Start Reset Life Start -->

	<div class="modal fade col-md-12" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<img src="{{ asset('/client/images/vip/icon-notification.png') }}" class="img-notification" />
								<div class="modal-notification-title">
									您充值 <span class="span-topup">500</span> 金币已到账
								</div>
								<div class="modal-notification-content">
									充值前余额 <span class="span-before">500.31</span> 金币<br />
									充值后余额 <span class="span-after">1000.31</span>金币
								</div>

								<div class="modal-notification-button">
									知道了
								</div>
								<div class="modal-notification-info">
								到账时间：<span class="span-updated">2019年8月18日18点05分</span>
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
								<div class="btn-view-game-rules">
									了解倍投 更容易中
								</div>												
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

<!--  end -->

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
		<div class="nologin-bg">
			<div class="instructions"><span class="highlight">无限制抽奖</span> 任你抽到爽</div>
			<div class="instructions"><span class="highlight">卡券奖品</span> 拿到手软</div>
			<div class="instructions"><span class="highlight">100%随机</span> 绝无作弊</div>			
			<a href="/nlogin">
				<div class="btn-login"></div>
			</a>
		</div>		
	</div>
</div>
<!-- haven't login modal Ends-->
<div class="openForm">
	<div class="formWrapper">
	<div class="formTitle">玩法介绍</div>
	<div class="closeForm">x 关闭</div>
	<div class="formBody">
		这是自助式抽奖，需自选单双和投入金币，投1金币可抽1.96金币，50%中奖率，使用倍增投币法能让中奖率提高到98%,<span class="highlight1">倍增投币法说明：</span><br />
		✗第一次投入1金币，没抽中。<br />
		✗第二次投入3金币，也没中。<br />
		✓第三次投入8金币，抽中了。<br />
		当第三次抽中，<span class="highlight1">能赚到8×1.96=15.68金币</span>，扣除三次<span class="highlight2">总投币12金币</span>，最终<span class="highlight3">赚了3.68金币</span>。<br /><br />
		这就是倍增投币法，从1金币起步，没抽中就增加，抽中后又从1金币起步，不停循环赚取大量金币，更具体倍增方案可参考表格：<br />
	</div>

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
	    <td>12</td>
	    <td>15.68</td>
	    <td>87.50%</td>
	    <td>3.68</td>
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

	<div class="btn-calculate-vip formButtonWrapper" id="btn-calculate-vip">
		<!-- <a  href="{{$wbp['wbp']}}{{env('TOPUP_URL','#')}}"> -->
			<div class="formButton">充值金币</div>
		<!-- </a> -->
	</div>
</div>

<!-- is newbie start modal -->
<div class="modal fade col-md-12" id="modal-isnewbie" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="newbie">
			<img class="newbie-bg" src="{{ asset('/client/images/newbie-bg.png') }}">
			<div class="introduction-bg">
				<p class="title">
					采用<span class="txt-bold">倍增式投币法</span>，68金币可投币5次，每5次内中1次即可无限抽，中奖率高达96.84%，大量金币等你抽。
				</p>
				<div class="introduction-bet">
	                <div class="circle">1<br><span class="txt">起步</span></div>
	                <div class="line-connect"></div>
	                <div class="circle">3<br><span class="txt">加倍</span></div>
	                <div class="line-connect"></div>
	                <div class="circle">8<br><span class="txt">加倍</span></div>
	                <div class="line-connect"></div>
	                <div class="circle">18<br><span class="txt">加倍</span></div>
	                <div class="line-connect"></div>
	                <div class="circle">38<br><span class="txt">加倍</span></div>
	            </div>
			</div>
			<a  href="#" onclick="show_openform();">
				<div class="btn-topup">点击了解详情</div>
			</a>
			<div class="btn-close-bg" id="btn-go-topup">
				<!-- <a href="{{$wbp['wbp']}}{{env('TOPUP_URL','#')}}"> -->
					无需了解 去充值金币 >
				<!-- </a> -->
			</div>
		</div>	
	</div>
</div>
<!-- is newbie modal Ends-->

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
	
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>


    <script type="text/javascript">
		var wbp = "{{$wbp['wbp']}}";
        var platform = "{{$wbp['platform']}}";
        var browser = "{{$wbp['browser']}}";
        var topupurl = $('#topupurl').val();

        console.log(platform);

        mui.plusReady(function(){
		             // 在这里调用plus api
		             alert('ready');
		});

        if (platform == 'iOS') {
        	$('#isIOS').val('true');
			// document.getElementById("btn-purchase-point").addEventListener("click", function(evt) {
			//     var a = document.createElement('a');
			//     a.setAttribute("href", topupurl);
			//     a.setAttribute("target", "_blank");
			//     var dispatch = document.createEvent("HTMLEvents");
			//     dispatch.initEvent("click", true, true);
			//     a.dispatchEvent(dispatch);
			// }, false); 

			document.getElementById("btn-calculate-vip").addEventListener("click", function(evt) {
				alert(1);
			    var a = document.createElement('a');
			    a.setAttribute("href", topupurl);
			    a.setAttribute("target", "_blank");
			    var dispatch = document.createEvent("HTMLEvents");
			    dispatch.initEvent("click", true, true);
			    a.dispatchEvent(dispatch);
			}, false); 

			document.getElementById("btn-go-topup").addEventListener("click", function(evt) {
				alert(111);
			    var a = document.createElement('a');
			    a.setAttribute("href", topupurl);
			    a.setAttribute("target", "_blank");
			    var dispatch = document.createEvent("HTMLEvents");
			    dispatch.initEvent("click", true, true);
			    a.dispatchEvent(dispatch);
			}, false);      		

    	} else if (platform == 'AndroidOS') {
    		$('#isIOS').val('AndroidOS');
   //  		document.getElementById("btn-purchase-point").addEventListener('tap',function(){
			// 	plus.runtime.openURL(topupurl);
			// });
			var urlStr = encodeURI($('#topupurl').val());
            $('#btn-calculate-vip').click(function() {
                plus.runtime.openURL(urlStr);
            });

			// document.getElementById("btn-calculate-vip").addEventListener('tap',function(){
			// 	// alert(2);
			// 	plus.runtime.openURL(topupurl);
			// });

			$('#btn-go-topup').click(function() {
                plus.runtime.openURL(urlStr);
            });

			// document.getElementById("btn-go-topup").addEventListener('tap',function(){
			// 	// alert(222);
			// 	plus.runtime.openURL(topupurl);
			// });

    	} else {

   //  		$('#btn-purchase-point').click(function(){
			// 	window.location.href = topupurl;
			// });
			$('#btn-calculate-vip').click(function(){
				// alert(3);
				// window.location.href = topupurl;
				window.open(topupurl, '_blank'); 
			});
			$('#btn-go-topup').click(function(){
				// alert(333);
				// window.location.href = topupurl;
				window.open(topupurl, '_blank'); 
			});

    	}    	

	</script>

	<script type="text/javascript">
		var url = "{{ env('APP_URL'), 'http://boge56.com' }}";      
    	var port = "{{ env('REDIS_CLI_PORT'), '6001' }}";
    	var prefix = "{{ env('REDIS_PREFIX'), '' }}";

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
			
            $(".btn-rules-vip").click(() => {  

                being.wrapShow();
                $(".openForm").slideDown(150);
                $(".wrapBox ").click(function (e) {
                  being.wrapHide();
                  $(".openForm").slideUp(150);
                });
                $('.openForm').modal();
                $('.modal-backdrop').css("z-index", "3");

              });

            $(".instructions2").click(() => {  
            	$('#modal-isnewbie').modal('hide');
	            being.wrapShow();
	            $(".openForm").slideDown(150);
	            $(".wrapBox ").click(function (e) {
	              being.wrapHide();
	              $(".openForm").slideUp(150);
	            });
	          });
        	
        	$('.closeForm').click(function() {
	            $(".openForm").hide();
	            $('.modal').modal('hide')
	            // $('.modal-backdrop').remove() // removes the grey overlay.
	            $('.modal-backdrop').css("z-index", "-1");
            });

            $('.btn-view-game-rules').click(function() {
            	$('.modal').modal('hide');
				$('.modal-backdrop').remove(); 
            	$('.btn-rules-vip').trigger("click");
            });
		});

		function show_openform() { 
			$('#modal-isnewbie').modal('hide');
            being.wrapShow();
            $(".openForm").slideDown(150);
            $(".wrapBox ").click(function (e) {
              being.wrapHide();
              $(".openForm").slideUp(150);
            });
		}

	</script>

	<script src="{{ asset('/client/js/Date.format.min.js') }}"></script>
	<script src="{{ asset('/client/js/vip-node.js') }}"></script>
@endsection
