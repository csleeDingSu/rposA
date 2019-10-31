<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="arcade-app">
    <head>
		
 @if (Config::get('app.APP_DEBUG') == '' )

<script type="text/javascript">

	window.onload = function() {
    // 阻止双击放大
    var lastTouchEnd = 0;
    document.addEventListener('touchstart', function(event) {
        if (event.touches.length > 1) {
            event.preventDefault();
        }
    });
    document.addEventListener('touchend', function(event) {
        var now = (new Date()).getTime();
        if (now - lastTouchEnd <= 300) {
            event.preventDefault();
        }
        lastTouchEnd = now;
    }, false);
 
    // 阻止双指放大
    document.addEventListener('gesturestart', function(event) {
        event.preventDefault();
    });

    document.addEventListener("contextmenu", function(e){
      e.preventDefault();
    }, false);



    document.addEventListener("keydown", function(e) {
    //document.onkeydown = function(e) {
      // "I" key
      if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
        disabledEvent(e);
      }
      // "J" key
      if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
        disabledEvent(e);
      }
      // "S" key + macOS
      if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {
        disabledEvent(e);
      }
      // "U" key
      if (e.ctrlKey && e.keyCode == 85) {
        disabledEvent(e);
      }
      // "F12" key
      if (event.keyCode == 123) {
        disabledEvent(e);
      }
    }, false);
    function disabledEvent(e){
      if (e.stopPropagation){
        e.stopPropagation();
      } else if (window.event){
        window.event.cancelBubble = true;
      }
      e.preventDefault();
      return false;
    }
  };	

  function getNumeric(value) {
  	return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
  }

</script>

@endif
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
		<!-- 	<meta name='viewport' content='width=device-width,initial-scale=1,'> -->
		<!-- <meta name="apple-mobile-web-app-capable" content="yes" /> 
		<meta name="viewport" content="width=device-width, user-scalable=0" />-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover" />
	
		<meta name="apple-mobile-web-app-status-bar-style" content="default" />

		<meta name="format-detection" content="telephone=no" />
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />

		@if (empty($title_customize))
        <title>{{env('APP_NAME')}} - @yield('title')</title>
		@else
		<title>{{$title_customize}}</title>
		@endif

		@section('top-css')
			<link href="{{ asset('/client/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}" rel="stylesheet">

			<link rel="stylesheet" type="text/css" href="{{ asset('clientapp/css/public.css')}}" />
			<link rel="stylesheet" type="text/css" href="{{ asset('clientapp/css/swiper.min.css')}}" />
			<link rel="stylesheet" type="text/css" href="{{ asset('clientapp/css/style.css?version=1.0.1')}}" />
			<link rel="stylesheet" type="text/css" href="{{ asset('clientapp/css/default_app.css')}}" />
		@show
		
		@section('top-javascript')
		<script type="text/javascript" src="{{ asset('clientapp/js/swiper.min.js')}}"></script>
		<script type="text/javascript" src="{{ asset('clientapp/js/jquery-1.9.1.js')}}"></script>
		<script type="text/javascript" src="{{ asset('clientapp/js/being.js')}}"></script>
		<script type="text/javascript" src="{{ asset('clientapp/js/default_app.js')}}"></script>

		<!-- <script type="text/javascript">
		//这个统计代码。
		var hmt = hmt || [];
		(function() {
		  var hm = document.createElement("script");
		  hm.src = "https://hm.baidu.com/hm.js?5e39d74009d8416a3c77c62c47158471";
		  var s = document.getElementsByTagName("script")[0]; 
		  s.parentNode.insertBefore(hm, s);
		})();
		</script> -->

		@if(env('THISVIPAPP',false))
		  <script>
		  	// alert('yes. i am in.');
		    if(('standalone' in window.navigator)&&window.navigator.standalone){  
			    var noddy,remotes=false;  
			    document.addEventListener('click',function(event){  
			            noddy=event.target;  
			            while(noddy.nodeName!=='A'&&noddy.nodeName!=='HTML') noddy=noddy.parentNode;  
			            if('href' in noddy&&noddy.href.indexOf('http')!==-1&&(noddy.href.indexOf(document.location.host)!==-1||remotes)){  
			                    event.preventDefault();  
			                    document.location.href=noddy.href;  
			            }  
			    },false);  
			}  
			</script>
		@endif

		@show
    </head>
    <body>
    	<section class="card">
    	@section('top-navbar')
			<div class="card-header">
		      <div class="pageHeader rel">
		        @yield('left-menu')
		        <h2>@yield('title')</h2>
		        @yield('right-menu')
		      </div>
		    </div>
		@show

		@yield('blog-tab')

		<div class="card-body over ">
		
	    	@yield('game-top-nav')
	    	<div class="loading" id="loading"></div>
	    	@if(!Request::is('login') && !Request::is('register') && !Request::is('app-login') && !Request::is('app-register'))
	    	<div class="scrolly">
	    		@yield('content')
	    	</div>
	    	@else
	    		@yield('content')
	    	@endif

	    	@yield('fix-btn')
	    
	    </div>

	    @if(!Request::is('receipt') && !Request::is('receipt/*') && !Request::is('login') && !Request::is('member/login') && !Request::is('member/login/*') && !Request::is('app-login') && !Request::is('app-register') && !Request::is('register') && !Request::is('register/*') && !Request::is('nlogin')  && !Request::is('main/product/detail') && !Request::is('external') && !Request::is('external/*') && !Request::is('youzan') && !Request::is('confirm') && !Request::is('guide/redeem') && !Request::is('tips') && !Request::is('share') && !Request::is('buy') && !Request::is('confirm') && !Request::is('recharge/type') && !Request::is('free'))

			@include('layouts/footer_app')
		@endif
		
		</section>

		@section('footer-javascript')
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

			@if(env('THISVIPAPP','false'))
				<!-- <script language="javascript" src="https://api2.pop800.com/800.js?n=569521&t=3&l=cn"></script><div style="display:none;"><a href="https://www.pop800.com">在线客服</a></div> -->
			@endif

			<script type="text/javascript">

		      document.onreadystatechange = function () {
		          var state = document.readyState
		          if (state == 'interactive') {
		          } else if (state == 'complete') {
		            setTimeout(function(){
		                document.getElementById('interactive');
		                document.getElementById('loading').style.visibility="hidden";
		                $('.loading').css('display', 'initial');
		            },100);
		          }
		        }
			  
			  resize = () => {
				  var o = $(document)
				  
				  dH = o.height()
				  $(".card-bar").css({
					top: dH - $(".card-bar").height()
				  })
				}

				$(window).resize(() => {
				  resize()
				})

				resize()
				
		    </script>
			
			@if(Request::is('profile') || Request::is('shop'))
				@include('layouts/socket')
			@endif
		@show
    </body>
</html>