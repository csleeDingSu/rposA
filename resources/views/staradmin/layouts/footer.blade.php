<div class="cardFoot">
	<div class="navBox">
		<dl class="dbox">
			<dd class="dbox1">
				<a href="{{ url('home') }}" class="footer-icon">
					@if(Request::is('cs/*'))
						<img src="{{ asset('/client/images/icon-home-active.png') }}" width="25" height="25" />
						<p class="active">首页</p>
					@else
						<img src="{{ asset('/client/images/icon-home.png') }}" width="25" height="25" />
						<p>首页</p>
					@endif
				</a>
			</dd>


			<dt class="dbox0">
				@if(Request::is('vip') || Request::is('arcade') || Request::is('arcade_node') || Request::is('arcade_old'))

					@if(Request::is('vip'))
						<a href="/vip">
					@elseif(Request::is('share_product'))
						<a href="/member/login/register">
					@else
						<a href="/arcade">
					@endif
						<div id="footer-life">
							@if(Request::is('vip'))
								<i class="nVip">&nbsp;</i>
								<!-- <p class="vip-life">VIP专场 剩余<span class="spanVipLife">&nbsp;</span>次</p> -->
								<p class="vip-life">VIP专场</p>
							@else
								<!-- <i class="nTxt">{{isset(Auth::Guard('member')->user()->wechat_verification_status) ? ((Auth::Guard('member')->user()->wechat_verification_status == 0) ? Auth::Guard('member')->user()->current_life : 0) : 0}}</i> -->
								<i class="nTxt">{{ isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}</i>
								<p>剩余次数</p>
							@endif
						</div>
					</a>
				@else
					<a href="/intro" class="main-footer">
						<div id="footer-life">
							<i class="nTxt_default"></i>
							<p style="margin-top:-0.075rem">我要拿红包</p>
						</div>
					</a>
				@endif
			</dt>
			<dd class="dbox1">
				<a href="/member" class="footer-icon">
					@if(Request::is('profile'))
						<img src="{{ asset('/client/images/icon-user-active.png') }}" width="25" height="25" />
						<p class="active">个人中心</p>
					@else
						<img src="{{ asset('/client/images/icon-user.png') }}" width="25" height="25" />
						<p>个人中心</p>
					@endif
				</a>
			</dd>
		</dl>
	</div>
</div>