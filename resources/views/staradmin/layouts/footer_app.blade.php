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
    @if((Request::is('blog') || Request::is('blog/*')) && (!Request::is('blog/my-redeem')))
  		<a class="on" href="/blog">
  	@else
  		<a href="/blog">
  	@endif
        <span class="icon bar-3"></span>
        <h2>晒单</h2>
      </a></dd>
    <dd>
      
    @if((Request::is('profile') || Request::is('profile/*')) || (Request::is('blog/my-redeem') || Request::is('pre-share')))
  		<a class="on" href="/profile">
  	@else
  		<a href="/profile">
  	@endif
        <span class="icon bar-4"></span>
        <h2>我的</h2>
      </a></dd>
  </dl>
</div>
	  
	  @if( Agent::is('OS X') )   
      <style>
      .card-bar
        {
          margin-bottom: 0px !important;
          position: fixed;
          left: 0;
          bottom: 0;
          width: 100%;
          padding-bottom: env(safe-area-inset-bottom);
          position: sticky; 
          position: -webkit-sticky;
          position: -moz-sticky;
          position: -o-sticky;
        }   
		  
		.footer_mb
		{
		  margin-bottom: 3px !important;
		}
      </style>
    @endif


<script type="text/javascript">
    	
(function(){

  // Really basic check for the ios platform
  // https://stackoverflow.com/questions/9038625/detect-if-device-is-ios
  var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

  // Get the device pixel ratio
  var ratio = window.devicePixelRatio || 1;

  // Define the users device screen dimensions
  var screen = {
    width : window.screen.width * ratio,
    height : window.screen.height * ratio
  };

  // iPhone X Detection
  if (iOS && screen.width == 1125 && screen.height === 2436) {
    $(".card-bar").addClass("footer_mb");
  }
})();

    </script>