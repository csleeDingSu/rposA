@extends('layouts.default')

@section('title', '认证说明')

@section('left-menu')
    <a href="/profile" class="back">
        <img src="{{ asset('/client/images/back.png') }}" width="11" height="20" />&nbsp;返回
    </a>
@endsection

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/validate.css') }}" />
@endsection

@section('content')

<div class="full-height">
	<div class="container">
		<div class="card">
			<div class="title">微信认证</div>

			<div class="instructions">为了防止开小号领福利，你需要通过微信认证才可以享受网站福利。我们是通过查看你的朋友圈，判断你是真实的用户还是虚假用户。</div>

			<div class="sub-title">认证流程</div>

			<div><span class="step">第一步：</span>将朋友圈设置为<span class="highlight">全部可见</span>(认证完毕后可关闭)</div>

			<img class="img-settings" src="{{ asset('/client/images/settings.png') }}" width="290" height="172" />

			<div><span class="step">第二步：</span>加客服微信，发送你的<span class="highlight">会员帐号</span>给客服。</div>

			<div class="wechat_card">
				<img class="img-wechat" src="{{ asset('/client/images/wechat.png') }}" width="70" height="66" />
				<div>微信号：<span id="cut" class="wechat_id">WABAO666</span></div>
				<div class="cutBtn">点击复制</div>
			</div>

			<div><span class="step">第三步：</span>完成操作，等待客服认证即可！</div>
		</div>
	</div>    
</div>

@endsection

@section('footer-javascript')
	@parent
	<script src="{{ asset('/test/main/js/clipboard.min.js') }}" ></script>
	
	<script type="text/javascript">
		$(document).ready(function () {
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
		});	
	</script>
@endsection