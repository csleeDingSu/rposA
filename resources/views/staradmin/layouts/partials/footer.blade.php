<div class="icon-bar navbar-fixed-bottom">
  <div class="container mx-auto text-center">
	  <a href="{{ url('home') }}"><div class="home"></div><div class="icon_label">{{ trans('dingsu.home') }}</div></a> 
	  <a href="#"><div class="trial"></div></i><div class="icon_label">{{ trans('dingsu.try') }}</div></a> 
	  <a href="#"><div class="balance_circle">{{isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}</div><div class="balance_label">{{ trans('dingsu.balance') }}</div></a> 
	  <a href="/arcade"><div class="play"></div><div class="icon_label">{{ trans('dingsu.treasure') }}</div></a>
	  <a href="/member"><div class="member"></div><div class="icon_label">{{ trans('dingsu.profile') }}</div></a> 
	</div>
</div>