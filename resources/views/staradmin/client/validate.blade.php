@php
    if (env('THISVIPAPP','false')) {
        $default = 'layouts.default_app';
    } else {
        $default = 'layouts.default';
    }
@endphp

@extends($default)

@if(env('THISVIPAPP','false'))
    <!-- top nav -->
    @section('left-menu')
      <a class="returnBtn" href="javascript:history.back();"><img src="{{ asset('clientapp/images/returnIcon.png') }}"><span>返回</span></a>
    @endsection

    @section('title', '认证说明')

    @section('right-menu')
    @endsection
    <!-- top nav end-->

@else
    @section('title', '认证说明')

    @section('left-menu')
	    <a href="/profile" class="back">
	        <img src="{{ asset('/client/images/back.png') }}" width="11" height="20" />&nbsp;返回
	    </a>
	@endsection

@endif

@section('top-css')
    @parent
	<link rel="stylesheet" href="{{ asset('/client/css/validate.css') }}" />
@endsection

@section('content')

@if(!env('THISVIPAPP','false'))
<div class="full-height">
	<div class="container">
@endif
		<div class="card">
			<div class="instructions">为了防止开小号领福利，你需要通过微信认证才可以享受网站福利。我们是通过查看你的朋友圈，判断你是真实的用户还是虚假用户。
			<div class="highlight">只要您的微信是正常账号即可审核通过。</div>
			请复制下面的微信号，添加好友后，让他审核。
			</div>

			<div class="wechat_card">
				<img class="img-wechat" src="{{ asset('/client/images/wechat.png') }}" width="70" height="66" />
				<div>微信号：<span id="cut" class="wechat_id">{{env('wechat_id', 'LUNLY028')}}</span></div>
				<div class="cutBtn">点击复制</div>
			</div>
		</div>
@if(!env('THISVIPAPP','false'))
	</div>    
</div>
@endif

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