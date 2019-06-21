@extends('layouts.default_membership_buy_vip')

@section('title', '支付页面')

@section('left-menu')
    <a href="/profile" class="back">
        <img src="{{ asset('/client/images/back_white.png') }}" width="11" height="20" />&nbsp;返回
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/membership_buy_vip.css') }}" />

@endsection

@section('top-javascript')
    @parent
@endsection

@section('content')
<div class="full-height">

    <input id="hidUserId" type="hidden" value="{{isset(Auth::Guard('member')->user()->id) ? Auth::Guard('member')->user()->id : 0}}" />
    <input id="hidSession" type="hidden" value="{{isset(Auth::Guard('member')->user()->active_session) ? Auth::Guard('member')->user()->active_session : null}}" />
    <input id="hidUsername" type="hidden" value="{{isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : null}}" />

    <div class="modal-content">
    	<div class="img_alipay">
		    <img src="{{ asset('/client/images/membership/alipay.png') }}"  />
		    微信支付
		</div>
        <div class="information-table">
			<span class="label-title">支付金额</span><br />
			<div class="label-amount"><span class="sign">¥</span><span class="spanPrice">{{empty($pay_final_amount) ? 0 : $pay_final_amount}}</span></div><br />
			<span class="label-description">微信自助场次充值</span>
			<div id="showqr"></div>
			<span class="label-warn">请付必支付正确的金额，以免造成充值失败</span>
			<img class="img_flow" src="{{ asset('/client/images/membership/flow_alipay.png') }}"  />
			<div class="label-step">
				<span class="label-step1">长按二维码<br/>进入微信账号</span>
				<span class="label-step2">通过微信<br/>支付正确金额</span>
				<span class="label-step3">返回平台<br/>进入VIP场</span>
			</div>
		</div>

		<div class="time">
            <span class="minute green">4</span>&nbsp;分&nbsp;<span class="second green">59</span>&nbsp;秒
        </div>

    </div>
</div>

@endsection

@section('footer-javascript')
    @parent
    <script src="https://api.nx908.com/statics/js/qrcode.min.js"></script>
    <script src="{{ asset('/client/js/membership_buy_vip.js') }}" ></script>
    <script type="text/javascript">
    	var _qrcode = "<?php Print(empty($qrcode) ? '' : $qrcode);?>";
		var qrcode = new QRCode(document.getElementById("showqr"), {
		    text: _qrcode,
		    width: 200,
		    height: 200,
		    colorDark: "#000000",
		    colorLight: "#ffffff",
		    correctLevel: QRCode.CorrectLevel.H
		});

		var _status = "<?php Print(empty($status) ? '' : $status);?>";
		if (_status == 'error') {
		    alert("订单出现异常,请勿支付,请重新发起订单！");
		    window.history.go(-1);
		}
    </script>
    
@endsection