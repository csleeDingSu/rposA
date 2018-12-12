<div class="cardFoot">
	<div class="navBox">
		<dl class="dbox">
			<dd class="dbox1">
				<a href="{{ url('home') }}">
					<i class="homeIcon"></i>
					<p>首页</p>
				</a>
			</dd>


			<dt class="dbox0">
				<a href="/arcade">
					@if(isset(Auth::Guard('member')->user()->vip_life) and Auth::Guard('member')->user()->vip_life > 0)
						<i class="nVip"></i>
						<p>剩余闯关</p>
					@else
						<i class="nTxt">{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? ((Auth::Guard('member')->user()->wechat_verification_status == 0) ? Auth::Guard('member')->user()->current_life : 0) : 0}}</i>
						<p>剩余闯关</p>
					@endif
				</a>
			</dt>
			<dd class="dbox1">
				<a href="/member">
					<i class="userIcon"></i>
					<p>个人中心</p>
				</a>
			</dd>
		</dl>
	</div>
</div>