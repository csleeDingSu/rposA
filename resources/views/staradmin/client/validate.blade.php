@extends('layouts.app')

@section('title', '微信认证')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/validate.css') }}" />
	
@endsection

@section('content')
<div class="wrapper full-height">

		@include('layouts.partials.notification')

	<form action="member_update_wechatname" method="post" name="wechatform" id="wechatform">
		@csrf

		<div class="" id="validation-errors"></div>

@if(Session::has('success'))
<div style="display: none;">
@else
<div>
@endif
	    <div class="row">
			<div class="card">
				<div class="title">第一步：提交真实姓名</div>
			</div>
		</div>

		    <div class="row">
				<div class="card">
					

					<input type="hidden" id="memberid", name="memberid" value="{{ Auth::Guard('member')->user()->id }}"/>

					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-address-card"></i></span>
						<input name="wechat_name" id="wechat_name" type="text"  placeholder="@lang('dingsu.ph_username')" value="" >
					</div>

					<!-- <div class="input-group">
						<span class="input-group-addon"><i class="fab fa-weixin"></i></span>
						<input id="wechat_name" name="wechat_name" type="text" placeholder="请输入真实姓名" />
						<div class="name"></div>
					</div>
 -->
				</div>
			</div>
			
			<div class="row">
		        <div class="card">
		            <button class="btn btn-primary btn-rectangle">@lang('dingsu.submit')</button>
		        </div>
			</div>
</div>


			<div class="row">
				<div class="card">
					<div class="card-margin">
						<div class="title">第二步：加客服微信审核</div>
					</div>
					<img src="/client/images/wabao666_qrcode.JPG" alt="validate" class="img-validate" />
				</div>
			</div>

	</form>
</div>
@endsection