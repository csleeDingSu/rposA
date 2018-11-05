@extends('layouts.default')

@section('title', '个人中心')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/member.css') }}" />
@endsection

@section('content')
<div class="full-height">
	<div class="container">
		<div class="box">
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
				  	<a href="#"><span class="button">兑换奖品</span></a>
				  </div>
				  <div class="col-xs-4 middle-border">
				  	正在进行中<br />
				  	<span class="balance numbers">{{ number_format($wallet->current_balance, 0, '.', '') }}</span><br />
				  	<a href="/arcade"><span class="button">继续挖宝</span></a>
				  </div>
				  <div class="col-xs-4">
				  	剩余次数<br />
				  	<span class="life numbers">{{ $wallet->current_life }}</span><br />
				  	<a href="/arcade"><span class="button">马上增加</span></a>
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
				<li class="list-group-item first-item">
					<div class="icon-wrapper">
						<div class="icon-play"></div>
					</div>
					<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
					我的奖品
				</li>

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

				<li class="list-group-item">
					<div class="icon-wrapper">
						<div class="icon-withdraw"></div>
					</div>
					<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
					挖宝攻略
				</li>
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

				<li class="list-group-item">
					<div class="icon-wrapper">
						<div class="icon-customer"></div>
					</div>
					<div class="glyphicon glyphicon-menu-right" aria-hidden="true"></div>
					联系客服
				</li>

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
