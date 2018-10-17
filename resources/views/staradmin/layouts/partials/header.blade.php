<div class="container navbar text-center">
	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="col left div-icon">
		@if (isset(Auth::Guard('member')->user()->username))
		<a href="/member"><i class="fas fa-user"></i> {{ Auth::Guard('member')->user()->username }}</a>
		@else
	  	<a href="/register"><i class="fas fa-user-plus"></i>注册</a>
	  	@endif
	</div>
	
	  <a href="/home">
		<img src="/client/images/wabao_logo.png" alt="{{env('APP_NAME')}}" class = "landscape"/>
	  </a>
	
	<div class="col right div-icon">
		 <a href="#"><i class="fas fa-rss"></i>关注</a>		  
	</div>

</div>