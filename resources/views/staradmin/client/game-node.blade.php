@php
    if (env('THISVIPAPP','false')) {
        $default = 'layouts.default_app';
    } else {
        $default = 'layouts.default';
    }
@endphp

@extends($default)

@section('title', '幸运转盘')

@section('top-css')
    @parent

    <link rel="stylesheet" href="{{ asset('/client/unpkg.com/flickity@2/dist/flickity.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/client/css/betting_table.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/progress_bar_new.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/game-node.css?version=1.0.1') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('/client/css/game-ranking.css') }}" /> -->
    <link rel="stylesheet" href="{{ asset('/client/css/results-node.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/history-node.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/wheel-new.css') }}" />
    <link rel="stylesheet" href="{{ asset('/client/css/productv2.css') }}" />
    

    <style>
        /* Paste this css to your style sheet file or under head tag */
        /* This only works with JavaScript, 
        if it's not present, don't show loader */
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .loading2 {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('/client/images/preloader.gif') center no-repeat;
            background-color: rgba(255, 255, 255, 1);
            background-size: 32px 32px;
        }
       
    	
    	.reveal-modal {
		    /*position: relative;*/
		    margin: 0 auto;
		    top: 25%;
		}

		.isnext{ text-align: center;font-size: .26rem; color: #999; line-height: 1.6em; padding: .15rem 0; }

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
    	
@section('top-navbar')
@endsection

@section('game-top-nav')
	@if (env('THISVIPAPP', false))
		@include('client.game-top-nav')
	@endif
@endsection

@section('content')
@if (!env('THISVIPAPP', false))
<a name="top"></a>
@endif

<div class="loading2" id="loading2"></div>
<div class="reload">
	<div class="center-content">加载失败，请安刷新</div>
</div>
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

<div class="cardBody"><div class="box">
<div class="full-height">
	<!-- information table -->
	<div class="information-table">
		<div class="grid-container">
			<div class="box">				
				<div class="btn-calculate">
					<div class="balance-banner">
						<div class="spanAcuPoint2">
							<span class="spanAcuPointAndBalance">{{empty($wallet->acupoint) ? 0 : $wallet->acupoint}}</span>元补贴
						</div>
						<div class="btn-withdraw"></div>
					</div>
				</div>
				<a href="#" onclick="closecss('speech-bubble-point');">
					<div class="speech-bubble-point">满{{env('coin_min', '6')}}元提现 最高{{env('coin_max', '12')}}元</div>
				</a>
			</div>
			@if (env('THISVIPAPP', false))
				<div id="flex-right-menu">
					<div class="box">
						<div class="btn-life">
							剩{{empty($wallet->life) ? 0 : $wallet->life}}次
						</div>
					</div>
				</div>
			@else
				<div class="box" id="btn-vip-wrapper">
					<div class="btn-profile">
						规则说明
					</div>
				</div>
			@endif
			
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
			<input id="hidCreatedAt" type="hidden" value="{{isset(Auth::Guard('member')->user()->created_at) ? Auth::Guard('member')->user()->created_at : 0}}" />
			<input id="hidWechatStatus" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? Auth::Guard('member')->user()->wechat_verification_status : 1}}" />
			<input id="hidWechatId" type="hidden" value="0" />
			<input id="hidWechatName" type="hidden" value="{{isset(Auth::Guard('member')->user()->wechat_name) ? Auth::Guard('member')->user()->wechat_name : null}}" />
			<input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
			<input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />
			<input id='hidbetting_count' type="hidden" value="{{$betting_count}}" />
			<input id='game_name' type="hidden" value="{{env('game_name', '幸运转盘')}}" />
			<input id='hidMaxAcupoint' type="hidden" value="{{env('coin_max', '12')}}" />
			<input id='hidMinAcupoint' type="hidden" value="{{env('coin_min', '6')}}" />
			<input id='hidIsApp' type="hidden" value="{{env('THISVIPAPP','false')}}" />
			<input id='hidLife' type="hidden" value="{{empty($wallet->life) ? 0 : $wallet->life}}" />
			<input id="hidPhone" type="hidden" value="{{empty(Auth::Guard('member')->user()->phone) ? 0 : Auth::Guard('member')->user()->phone}}" />
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
				<div class="first-life">
					<div class="div-life">还剩<span class="span-life">15</span>次抽奖</div>
					<div class="div-time"></div>
				</div>
				@if (env('THISVIPAPP', false))
				<div class="banner-rules">
					<img src="{{ asset('/client/images/wheel/banner-rules.png') }}" />
				</div>	
				@endif
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
				<div class="DB_G_hand_2"></div>
			  </div>
			  <div class="button-card radio-primary right">
				<div class="radio btn-rectangle right-rectangle">
					<input name="rdbBet" class="invisible" type="radio" value="even">
					选择双数
				</div>
				<div class="DB_G_hand_2 right-hand"></div>
			  </div>
			  <div class="btn-trigger"></div>
			  <div class="DB_G_hand_3"></div>
		</div>
		<!-- end button wrapper -->
		<div style="clear: both;"></div>
		
	    </article>
    </section>
	<!-- end progress bar -->
	
</div>

@if (env('THISVIPAPP', false))
	@include('client.game-ranking')
@else
	<div class="redeem-banner">
		<img src="{{ asset('/client/images/wheel/banner-title.png') }}" alt="share">
	</div>
	<div class="infinite-scroll">
		<ul class="list-2">								
				@include('client.productv2')
		</ul>
		{{ $vouchers->links() }}
		
		@if (!empty($vouchers))
			<p class="isnext">下拉显示更多...</p>
		@endif

	</div>
@endif
</div></div>

@if (!env('THISVIPAPP', false))
<!-- go back to top -->
	<a class="to-top" href="#top"><img src="{{ asset('/client/images/go-up.png') }}"/></a>
@endif

@endsection

@section('footer-javascript')

<!-- new haven't login modal -->
<div class="modal fade col-md-12" id="modal-no-login" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="cls-modal-no-login">您还未登录，正在跳转登录页面...</div>					
	</div>
</div>

<!-- haven't login start modal -->
	<div class="modal fade col-md-12" id="modal-no-login-old" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<a href="/nlogin">
				<div class="nologin-bg">
					<div class="instructions"><span class="highlight">无限制抽奖</span> 任你抽到爽</div>
					<div class="instructions"><span class="highlight">卡券奖品</span> 拿到手软</div>
					<div class="instructions"><span class="highlight">100%随机</span> 绝无作弊</div>			
					<div class="btn-login"></div>
				</div>		
			</a>
		</div>
	</div>
	<!-- haven't login modal Ends-->

<!-- newbie start modal -->
	<div class="modal fade col-md-12" id="modal-newbie" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
				<div class="newbie-bg"></div>
		</div>
	</div>
	<!-- newbie modal Ends-->

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

	<div class="modal fade col-md-12" id="modal-withdraw-insufficient" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg close-modal" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-title">
								  
								</div>
								<div class="instructions">
									<p>
										<span class="highlight-header">您已抽到<span class="withdraw-value">0</span>元</span>
									</p>
									<p>满6元提现，最高抽<span class="highlight-coin-max">{{env('coin_max', '12')}}</span>元
									</p>
								</div>
								<div class="close-modal modal-warning-button">
									继续抽奖
								</div>
							</div>
						</div>
					</div>							
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade col-md-12" id="modal-withdraw" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg close-modal" role="document">
			<div class="modal-content">
				<div class="modal-body">				
					<div class="modal-row">
						<div class="wrapper modal-full-height">
							<div class="modal-card">
								<div class="modal-title">
								  
								</div>
								<div class="instructions">
									<p>
										<span class="highlight-header">您已抽到<span class="drawn">0</span>元</span>
									</p>
									<p>
										满{{env('coin_min', '6')}}元可提现，最高可抽{{env('coin_max', '12')}}元
										<br>
										提现则结束本次抽奖
									</p>
								</div>
								<div class="btn-go-withdraw">
									马上结算 结束抽奖
								</div>
								<div class="close-modal modal-warning-butto	n">
									继续抽奖 抽{{env('coin_max', '12')}}元
								</div>
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
				<div class="modal-body">
					<div class="modal-row">
						<div class="wrapper modal-full-height">							
							<div class="modal-card">
								<div class="packet-value">{{env('coin_max', '12')}}元补贴到手</div>	
								<div class="instructions">
									抽奖已达上限，{{env('coin_max', '12')}}元红包已抽完
								</div>
								<div class="modal-confirm-button btn-reset-life btn-red-packet">申请提现</div>
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
									邀请<span class="highlight-peach">1个</span>好友送<span class="highlight-peach">1次</span>抽奖补贴(可抽{{env('coin_max',12)}}元)<br/>
									好友邀请<span class="highlight-peach">1个</span>，你再获<span class="highlight-peach">1次抽奖补贴</span>。
									<a href="/share" class="link-button">
										<div class="modal-vip-button">
											邀请好友
										</div>
									</a>
									<a href="/redeem" class="link-button">
										<div class="modal-redeem-button">
											余额提现
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

<!-- Start Win -->

	<div class="modal fade col-md-12" id="win-modal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true" style="background-color: rgba(17, 17, 17, 0.65);">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="packet-title">恭喜您抽中了</div>
				<div class="modal-body" style="padding:10px !important;">
					<div class="modal-row">
						<div class="wrapper modal-full-height">							
							<div class="modal-card">
								<div class="packet-value">15元红包</div>
								<div class="packet-info">本局抽中<span class="highlight-green">15元红包</span><br />前4局没抽中<span class="highlight">亏损12元</span><br /><span class="highlight-red">最终赚了5元</span></div>
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
										这是一个自助抽奖转盘，需投币和选单双数，具体抽奖规则如下：
									</p>
									<p>
										从1元开始抽，如果没抽中，下局加倍，最多可加倍5次，只要6次内能抽中1次，就能获得红包，抽中概率98.43%
									</p>
									<p>
										每次抽中后返回1元从新开始，又有5次加倍的机会，不停循环抽红包。
									</p>
									<p>&nbsp;</p>
									<p># 每场最多可抽12元封顶</p>
									<p># 邀请好友可获得更多抽奖场次</p>
									<p># 抽奖概率由系统随机产生</p>
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

<!-- customer service modal -->
<div class="modal fade col-md-12" id="csModal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-wechat">
			<div class="modal-body">
				<div class="modal-row">
					<div class="wrapper modal-full-height">
						<div class="modal-card">
							<div class="title">
								请加人工客服微信
							</div>
							<div class="instructions">
								审核发放红包
							</div>
						</div>
						<div class="row imgdiv">								
							<img class="qrimg" src="{{ asset('/client/images/qr.jpg') }}" alt="qr image" />
						</div>
						<div class="row">								
							<div class="bottom">长按图片识别二维码</div>
							<span class="highlight">客服上班时间:早上9点-晚上9点</span>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- customer service modal Ends -->

<!-- wechat verify Modal starts -->
  <div class="modal fade col-md-12" id="wechat-verification-modal" tabindex="-1" role="dialog" aria-labelledby="viewvouchermodellabel" aria-hidden="true">
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
              <div>
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
<!-- wechat verify Modal Ends -->

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
		document.onreadystatechange = function () {
          var state = document.readyState
          if (state == 'interactive') {
          } else if (state == 'complete') {
            setTimeout(function(){
                document.getElementById('interactive');
                document.getElementById('loading2').style.visibility="hidden";
            },100);
          }
        }

		var url = "{{ env('APP_URL'), 'http://boge56.com' }}";      
    	var port = "{{ env('REDIS_CLI_PORT'), '6001' }}";
    	var prefix = "{{ env('REDIS_PREFIX'), '' }}";
    	// var life = "{{isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}";

		$(document).ready(function () {
			
			var wechat_status = $('#hidWechatId').val();
			var wechat_name = $('#hidWechatName').val();
			var bet_count = $('#hidbetting_count').val();
			var is_app = $('#hidIsApp').val();
			var win_coin_max = Number($('#hidMaxAcupoint').val());
			var win_coin_min = Number($('#hidMinAcupoint').val());
			var _point = Number($('.spanAcuPointAndBalance').html());
			
			if(bet_count == 0){
				$('.selection').show();
			}

			// if ((_point > 0) && (_point < win_coin_min)) {
			// 	$('#modal-withdraw-insufficient').modal();
			// }

			var user_id = $('#hidUserId').val();

			$('.reload').click(function(){
				window.location.href = window.location.href;
			});

			$('.close-modal').click(function () {
				$('.modal').modal('hide');
				$('.modal-backdrop').remove();
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


			$('.banner-rules').click(function() {
		        $('#game-rules').modal();
		    });

		    $('.btn-profile').click(function() {
		        $('#game-rules').modal();
		    });

			if ((user_id <= 0) && (is_app == false)) {
				
				openmodel();
			
				$('.barWrapper').click( function() {
	            	openmodel();
	            });
	            	
			}

			$('.newbie-bg').click(function() {
				$('.modal').modal('hide');
				$('.modal-backdrop').remove();
			});
		

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
					console.log(responce);
					// if (responce.html == null || responce.html = '') {
					// 	$(".isnext").html('');	
					// }
				}
			 });
		}
	//scroll pagination - end

	function closecss(cssname) {
		var name = '.' + cssname;
		$('' +name + '').css('display', 'none');

	}
		
	</script>

	<script src="{{ asset('/client/js/Date.format.min.js') }}"></script>
	<script src="{{ asset('/client/js/game-node.js') }}"></script>
	<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
	
@endsection

@if (!env('THISVIPAPP', false))
	<link rel="stylesheet" href="{{ asset('/client/css/intro_popup.css') }}"/>

	@include('client.intromodel')
@endif

