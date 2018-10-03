@extends('layouts.app')

@section('title', '会员中心')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/member.css') }}" />
@endsection

@section('content')
<div class="wrapper full-height">
	<div class="container">
    <div class="row">
		<div class="card">
			<div class="text left">小小李，你已兑换的奖品价值约：</div>
			<div class="numbers left">4837.00<span class="text">元</span></div>
		</div>
	</div>
	
	<div class="row">
        <div class="square">
			<div class="content">
				<div class="table">
					<div class="table-cell">
						<div class="numbers">5</div>
						<div class="label">剩余次数</div>
					</div>
				</div>
			</div>
		</div>
		<div class="square">
			<div class="content">
				<div class="table">
					<div class="table-cell">
						<div class="numbers">6</div>
						<div class="label">待确认</div>
					</div>
				</div>
			</div>
		</div>
		<div class="square">
			<div class="content">
				<div class="table">
					<div class="table-cell">               
						<div class="numbers">20</div>
						<div class="label">兑换成功</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
        <div class="square">
			<div class="content">
				<div class="table">
					<div class="table-cell">
						<div class="numbers">99+</div>
						<div class="label">以往记录</div>
					</div>
				</div>
			</div>
		</div>
		<div class="square">
			<div class="content">
				<div class="table">
					<div class="table-cell">
						<div class="member"></div>
						<div class="label adjust-label">个人资料</div>
					</div>
				</div>
			</div>
		</div>
		<div class="square">
			<div class="content">
				<div class="table">
					<div class="table-cell">               
						<div class="password"></div>
						<div class="label adjust-label">修改密码</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
        <div class="card">
			<a href="#" class="btn btn-rectangle">
                邀请好友
            </a>
        </div>
	</div>
	
	<div class="row">
		<div class="card">
			<div class="text left">
			每邀请一个好友，你好友能获得3次的闯关机会，你也能获得3次闯关机会，次数可以累计！
			<br /><br />
			友情提示：每个人只能注册一个帐号，如果多开小号，你所有的账户会被封号。
			<br /><br />
			</div>
		</div>
	</div>
	</div>
</div>
@endsection