@php
if( !Request::is('download-app') ) { 
@endphp
<div class="cardFoot">
	<div class="navBox">
		<dl class="dbox">
			<dd class="dbox1">
				<a href="{{ url('home') }}" class="footer-icon">
					@if(Request::is('vip'))
						<img src="{{ asset('/client/images/profile-vip/icon-earn-point-active.png') }}" width="25" height="25" />
						<p class="active">抽奖换购</p>
					@else
						<img src="{{ asset('/client/images/profile-vip/icon-earn-point-non-active.png') }}" width="25" height="25" />
						<p>抽奖换购</p>
					@endif
				</a>
			</dd>

			<dd class="dbox1">
				<a href="/profile" class="footer-icon">
					@if(!Request::is('vip'))
						<img src="{{ asset('/client/images/profile-vip/icon-profile-active.png') }}" width="25" height="25" />
						<p class="active">个人中心</p>
					@else
						<img src="{{ asset('/client/images/profile-vip/icon-profile-non-active.png') }}" width="25" height="25" />
						<p>个人中心</p>
					@endif
				</a>
			</dd>
		</dl>
	</div>
</div>
<style type="text/css">
	p.active {
		color: #ff9600 !important;
	}	
</style>
@php
} 
@endphp