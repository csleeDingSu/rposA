@extends('layouts.default_app')

@section('top-navbar')    
@endsection

@section('title', '审核认证')

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/clientapp/css/validate_v2.css') }}" />
@endsection

@section('content')

<div class="card">
	<div class="c-header">
	    <div class="pageHeader rel">
	      <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
	     </div>
	  </div>
	<div class="img-wechat">
		<img src="{{ asset('/clientapp/images/validate/icon-wechat-verify.png') }}"/>
		<p>你还未通过微信认证！</p>
	</div>

	<div class="wechat_card">
		<div class="instructions">
			为了打击小号刷补贴，你需要通过微信认证才可以领取补贴，微信认证说明：
			<div class="highlight">①把朋友圈设置：全部可见</div>
			<div class="highlight">②加客服微信审核，上班时间：早上9点~晚上9点</div>
			仅需3分钟，审核后即可关闭朋友图。
		</div>
		
		<div class="link-part">
			<div>客服微信</div>
			<div class="wechat_id"><span id="cut">{{env('wechat_id', 'LUNLY028')}}</span></div>
			<div class="cutBtn">复制微信号</div>
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