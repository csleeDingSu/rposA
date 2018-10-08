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
			<div class="text left">{{ $member->username }}，你已兑换的奖品价值约：</div>
			<div class="numbers left">{{ number_format($member->current_balance, 2) }}<span class="text">元</span></div>
		</div>
	</div>
	<div class="row">
        <div class="square">
			<div class="content">
				<div class="table">
					<div class="table-cell">
						<div class="numbers">{{isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}</div>
						<div class="label">剩余次数</div>
					</div>
				</div>
			</div>
		</div>
		<div class="square">
			<div class="content">
				<div class="table">
					<div class="table-cell">
						<div class="numbers">{{ $member->pending }}</div>
						<div class="label">待确认</div>
					</div>
				</div>
			</div>
		</div>
		<div class="square">
			<div class="content">
				<div class="table">
					<div class="table-cell">               
						<div class="numbers">{{ $member->success }}</div>
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
						<div class="numbers">{{ $member->history > 99 ? '99+' : $member->history }}</div>
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
		<a href="member/password-reset">
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
		</a>
	</div>

	

	
	<a class="skype social-icon" href="https://web.skype.com/share?url={{$member->invitation_link}}&text=I wanted you to see this site" target="_blank" title="Skype"><i class="fa fa-skype fa-lg"></i></a>
   <a class="sms social-icon" href="sms://&body={{$member->invitation_link}}" target="_blank" title="SMS"><i class="fa fa-mobile fa-lg"></i></a>
<a class="whatsapp social-icon" href="whatsapp://send?text={{$member->invitation_link}}" target="_blank" title="whatsapp"><i class="fa fa-mobile fa-lg"></i></a>


	<div id="test">

	<div class="row">
        <div class="card">
            <button @click="invitationLink" class="btn btn-rectangle">邀请好友</button>
        </div>
	</div>
		
    <p>this is test @{{ message }}</p>
    <input type = "text" id="input" v-model="message">
    <li v-for="s in sample1"> @{{s}}</li>

	<input type = "text" id="input" v-model="newMessage">
    <button v-on:click="add">Add</button>
	</div>

	<div id="root">
		<task></task>
		<task>go to 2</task>

	</div>


	<script src="https://unpkg.com/vue@2.5.17/dist/vue.js"></script>
	<script src="test.js"></script>
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
