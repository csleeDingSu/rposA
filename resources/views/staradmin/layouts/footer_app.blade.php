<div class="card-bar">
  <dl class="bar">
    <dd>
	@if(Request::is('main') || Request::is('main/*'))
  		<a class="on" href="/main">
  	@else
  		<a href="/main">
  	@endif
        <span class="icon bar-1"></span>
        <h2>首页</h2>
      </a>
    </dd>
    <dd>
	@if(Request::is('shop') || Request::is('shop/*'))
  		<a class="on" href="/shop">
  	@else
  		<a href="/shop">
  	@endif
        <span class="icon bar-2"></span>
        <h2>商城</h2>
      </a></dd>
    <dt>
    @if(Request::is('arcade') || Request::is('arcade/*'))
  		<a class="on" href="/arcade">
  	@elseif(Request::is('vip') || Request::is('vip/*'))
  		<a class="on" href="/vip">
  	@else
  		<a href="/arcade">
  	@endif
        <span class="icon bar-center">
          <img src="{{ asset('clientapp/images/bar-m.png') }}">
        </span>
        <h2>抽奖</h2>
      </a></dt>
    <dd>
    @if(Request::is('blog') || Request::is('blog/*'))
  		<a class="on" href="/blog">
  	@else
  		<a href="/blog">
  	@endif
        <span class="icon bar-3"></span>
        <h2>晒单</h2>
      </a></dd>
    <dd>
    @if(Request::is('profile') || Request::is('profile/*'))
  		<a class="on" href="/profile">
  	@else
  		<a href="/profile">
  	@endif
        <span class="icon bar-4"></span>
        <h2>我的</h2>
      </a></dd>
  </dl>
</div>