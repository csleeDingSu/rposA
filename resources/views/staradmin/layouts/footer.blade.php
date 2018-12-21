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
					<div id="footer-life">
						@if(Request::is('vip'))
							<i class="nVip">&nbsp;</i>
							<p class="vip-life">VIP专场 剩余<span class="spanVipLife">&nbsp;</span>次</p>
						@else
							<i class="nTxt">{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? ((Auth::Guard('member')->user()->wechat_verification_status == 0) ? Auth::Guard('member')->user()->current_life : 0) : 0}}</i>
							<p>剩余闯关</p>
						@endif
					</div>
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