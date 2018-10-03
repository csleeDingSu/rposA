@extends('layouts.app')

@section('title', '闯关猜猜猜')

@section('top-css')
    @parent

    <link rel="stylesheet" href="{{ asset('/client/css/arcade.css') }}" />
@endsection
    	
@section('content')	
	<div class="wrapper">
		<div class="full-width-tabs" id="level-tabs">

		  <ul class="nav nav-tabs border-active">
			<li class="active take-all-space-you-can pass"><a href="#nr-tab1">关数<div class="level-number">1</div></a></li>
			<li class="take-all-space-you-can pass"><a href="#nr-tab2">关数<div class="level-number">2</div></a></li>
			<li class="take-all-space-you-can"><a href="#nr-tab3">关数<div class="level-number">3</div></a></li>
			<li class="take-all-space-you-can"><a href="#nr-tab4">关数<div class="level-number">4</div></a></li>
			<li class="take-all-space-you-can"><a href="#nr-tab5">关数<div class="level-number">5</div></a></li>
			<li class="take-all-space-you-can"><a href="#nr-tab6">关数<div class="level-number">6</div></a></li>
		  </ul>

		  <div class="tab-content div-pass">
			<div class="tab-pane active" id="nr-tab1">
				<div class="container tab-table">
					<div class="row">
					  <div class="col-xs-6">
						<div class="voucher-wrapper">
							<div class="voucher-phone"></div>
							<div class="voucher-label">20元话费充值</div>
						</div>
					  </div>
					  <div class="col-xs-6 text-right title status">
						<a href="#" class="status-pass">马上领取</a>
					  </div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="nr-tab2">
				<div class="container">
					<div class="row">
					  <div class="col-xs-6">
						<div class="voucher-wrapper">
							<div class="voucher-phone"></div>
							<div class="voucher-label">40元话费充值</div>
						</div>
					  </div>
					  <div class="col-xs-6 text-right title status">
						<a href="#" class="status-pass">马上领取</a>
					  </div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="nr-tab3">
				<div class="container">
					<div class="row">
					  <div class="col-xs-6">
						<div class="voucher-wrapper">
							<div class="voucher-tmall"></div>
							<div class="voucher-label">100天猫购物卡</div>
						</div>
					  </div>
					  <div class="col-xs-6 text-right title status">不可领取</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="nr-tab4">
				<div class="container">
					<div class="row">
					  <div class="col-xs-6">
						<div class="voucher-wrapper">
							<div class="voucher-tmall"></div>
							<div class="voucher-label">200天猫购物卡</div>
						</div>
					  </div>
					  <div class="col-xs-6 text-right title status">不可领取</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="nr-tab5">
				<div class="container">
					<div class="row">
					  <div class="col-xs-6">
						<div class="voucher-wrapper">
							<div class="voucher-tmall"></div>
							<div class="voucher-label">400天猫购物卡</div>
						</div>
					  </div>
					  <div class="col-xs-6 text-right title status">不可领取</div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="nr-tab6">
				<div class="container">
					<div class="row">
					  <div class="col-xs-6">
						<div class="voucher-wrapper">
							<div class="voucher-tmall"></div>
							<div class="voucher-label">1000天猫购物卡</div>
						</div>
					  </div>
					  <div class="col-xs-6 text-right title status">不可领取</div>
					</div>
				</div>
			</div>
		  </div>
		  
		</div> <!-- /container -->
		
		<!--div class="information-table">
			<div class="row">
			  <div class="col-xs-3">剩余次数<br />5</div>
			  <div class="col-xs-3">待确认<br />5</div>
			  <div class="col-xs-3">已用次数<br />6</div>
			  <div class="col-xs-3">邀请<br />好友</div>
			</div>
		</div-->
		
		<div class="game-table">
			<div class="row">
				<div class="col-xs-3"><button type="button" class="btn btn-arcade">开号规则</button></div>
				<div class="col-xs-6 text-center title">第11期结果</div>
				<div class="col-xs-3 text-right"><button type="button" class="btn btn-arcade">以往结果</button></div>
			</div>
			<div class="row">
			  <div class="col-xs-12 text-center" id="result">
				<div class="result-container">
					<div class="circle five"></div>
					<div class="result-label">冠军</div>
				</div>
				<div class="result-container">
					<div class="circle two"></div>
					<div class="result-label">亚军</div>
				</div>
				<div class="result-container">
					<div class="circle one"></div>
					<div class="result-label">第三</div>
				</div>
				<div class="result-container">
					<div class="circle four"></div>
					<div class="result-label">第四</div>
				</div>
				<div class="result-container">
					<div class="circle six"></div>
					<div class="result-label">第五</div>
				</div>
				<div class="result-container">
					<div class="circle three"></div>
					<div class="result-label">第六</div>
				</div>
			  </div>
			</div>
			<div class="row">
				<div class="col-xs-12 text-center">
					<h3>第12期倒计时 <span class="clock">&nbsp;<span class="countdown"></span>&nbsp;</span></h3>
				</div>
			</div>
			
			<div class="full-width-tabs" id="bet-tabs">
			  <ul class="nav nav-tabs border-active">
				<li class="active take-all-space-you-can" rel="冠军"><a href="#bet-tab1">猜冠军</a> </li>
				<li class="take-all-space-you-can" rel="亚军"><a href="#bet-tab2">猜亚军</a></li>
				<li class="take-all-space-you-can" rel="第三"><a href="#bet-tab3">猜第三</a></li>
			  </ul>

			  <div class="tab-content div-active" ng-controller="PlaceBetCtrl">
				<div class="tab-pane active" id="bet-tab1">
					<div class="container betting-table">
						<div class="row">
						  <div class="col-xs-1"></div>
						  <div class="col-xs-11 note-cell">
						    <span class="select" rel="">请选择冠军的结果<br /></span>
							<span class="info">只能猜一个，猜对了就闯关成功，祝你好运！</span>
						  </div>
						</div>
						<div class="row">
						  <div class="col-xs-1"></div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="first_big" ng-click="radioCheckUncheck($event)"><h3>大</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="first_small" ng-click="radioCheckUncheck($event)"><h3>小</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						</div>
						<div class="row">
						  <div class="col-xs-1"></div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="first_odd" ng-click="radioCheckUncheck($event)"><h3>单</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="first_even" ng-click="radioCheckUncheck($event)"><h3>双</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="bet-tab2">
					<div class="container betting-table">
						<div class="row">
						  <div class="col-xs-1"></div>
						  <div class="col-xs-11 note-cell">
						    <span class="select" rel="">请选择亚军的结果<br /></span>
							<span class="info">只能猜一个，猜对了就闯关成功，祝你好运！</span>
						  </div>
						</div>
						<div class="row">
						  <div class="col-xs-1"></div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="second_big" ng-click="radioCheckUncheck($event)"><h3>大</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="second_small" ng-click="radioCheckUncheck($event)"><h3>小</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						</div>
						<div class="row">
						  <div class="col-xs-1"></div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="second_odd" ng-click="radioCheckUncheck($event)"><h3>单</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="second_even" ng-click="radioCheckUncheck($event)"><h3>双</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="bet-tab3">
					<div class="container betting-table">
						<div class="row">
						  <div class="col-xs-1"></div>
						  <div class="col-xs-11 note-cell">
							<span class="select" rel="">请选择第三的结果<br /></span>
							<span class="info">只能猜一个，猜对了就闯关成功，祝你好运！</span>
						  </div>
						</div>
						<div class="row">
						  <div class="col-xs-1"></div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="third_big" ng-click="radioCheckUncheck($event)"><h3>大</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="third_small" ng-click="radioCheckUncheck($event)"><h3>小</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						</div>
						<div class="row">
						  <div class="col-xs-1"></div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="third_odd" ng-click="radioCheckUncheck($event)"><h3>单</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						  <div class="col-xs-5 radio-primary">
							<div class="radio">
								<input class="invisible" type="radio" ng-model="forms.selected" ng-value="third_even" ng-click="radioCheckUncheck($event)"><h3>双</h3><i class="fa bottom-right"></i>
							</div>
						  </div>
						</div>
					</div>
				</div>
			  </div>
			  
			</div> <!-- /container -->
		</div>		

		<div class="rules-table">
			<div class="row">
			  <div class="col-xs-12">
			  游戏规则说明：<br />
			  每一分钟开奖一次，玩家可自由竞猜冠军或亚军或第三名大小单双（只能选一个下注）。<br />
			  猜对代表闯关成功，进入下一关，连续猜对次数越多，奖励越高。<br />
			  而如果猜错一次，则闯关失败，奖励清零。
			  </div>
			</div>
		</div>
	</div>
@endsection

@section('footer-javascript')
	@parent
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
	<script src="{{ asset('/client/js/arcade.js') }}"></script>
@endsection