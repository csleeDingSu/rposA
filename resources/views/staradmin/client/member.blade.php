@extends('layouts.default')

@section('title', '个人主页')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/member.css') }}" />
@endsection

@section('content')
<div class="full-height">
	<div class="container">
		<!-- member id -->
		<div class="card left">
			<div class="name">{{ $member->username }}</div>
			<div class="icon-verified-wrapper">
				<div class="icon-verified"></div>
			</div>
			<div class="verified">已通过实名认证</div>
			<div style="clear: both;"></div>
			
			<div class="member-id">账号:{{ $member->id }}</div>
		</div>
		<!-- end member id -->

		<!-- member details -->
		<div class="information-table">
			  <div class="col-xs-4">
			  	红包余额<br />
			  	<span class="point numbers">{{ number_format($wallet->current_point, 2, '.', '') }}</span><br />
			  	<a href="#"><span class="button">提现到支付宝</span></a>
			  </div>
			  <div class="col-xs-4 middle-border">
			  	奖励金币<br />
			  	<span class="balance numbers">{{ number_format($wallet->current_balance, 0, '.', '') }}</span><br />
			  	<a href="/arcade"><span class="button">兑换成红包</span></a>
			  </div>
			  <div class="col-xs-4">
			  	剩余次数<br />
			  	<span class="life numbers">{{ $wallet->current_life }}</span><br />
			  	<a href="/arcade"><span class="button">马上去挖宝</span></a>
			  </div>
		</div>
		<!-- end member details -->

		<!-- member listing -->
		<div class="listing-table">
			<ul class="list-group">
				<li class="list-group-item">
					<a href = "/share">
						<div class="icon-wrapper">
							<div class="icon-add-friend"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
					邀请好友一起挖宝 <div class="note">邀请1个好友，奖励3次挖宝机会。</div>
					</a>
				</li>
				<li class="list-group-item">
					<div class="icon-wrapper">
						<div class="icon-play"></div>
					</div>
					<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
					挖宝次数明细
				</li>
				<li class="list-group-item">
					<div class="icon-wrapper">
						<div class="icon-play-history"></div>
					</div>
					<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
					挖宝记录
				</li>
				
				<li class="list-group-item">
					<a href="/redeem">
						<div class="icon-wrapper">
							<div class="icon-redeem"></div>
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						兑换红包记录
					</a>
				</li>

				<li class="list-group-item">
					<div class="icon-wrapper">
						<div class="icon-withdraw"></div>
					</div>
					<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
					提现记录
				</li>
				<li class="list-group-item">
					<div class="icon-wrapper">
						<div class="icon-faq"></div>
					</div>
					<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
					常见问题回答
				</li>
				<li class="list-group-item">
					<div class="icon-wrapper">
						<div class="icon-customer"></div>
					</div>
					<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
					联系客服
				</li>
				<li class="list-group-item">
					<a href = "/logout">
						<div class="icon-wrapper" style="padding: 0px 5px 5px 6px">
							<i class="fa fa-sign-out-alt"></i>						
						</div>
						<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
						{{ trans('dingsu.logout') }}
					</a>
				</li>
			</ul>
		 </div>
		<!-- end member listing -->
	</div>
</div>

@endsection
