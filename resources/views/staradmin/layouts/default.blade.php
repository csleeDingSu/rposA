<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="arcade-app">
    <head>
		
 @if (Config::get('app.APP_DEBUG') == '' ) 
<script type="text/javascript">

  window.onload = function() {
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
</script>

@endif
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		
        <title>{{env('APP_NAME')}} - @yield('title')</title>
		
		@section('top-css')
			<link href="{{ asset('/client/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}" rel="stylesheet">
			<link rel="stylesheet" href="{{ asset('/client/fontawesome-free-5.5.0-web/css/all.css') }}" >

			<link rel="stylesheet" href="{{ asset('/test/main/css/public.css') }}" />
			<link rel="stylesheet" href="{{ asset('/test/main/css/module.css') }}" />
			<link rel="stylesheet" href="{{ asset('/test/main/css/style.css') }}" />
			<link rel="stylesheet" href="{{ asset('/client/css/default.css') }}" />
			<link rel="stylesheet" href="{{ asset('/client/css/footer.css') }}" />
			
		@show
		
		@section('top-javascript')

		<script type="text/javascript">
		    //这里是微信和qq遮罩提示层
		    function isPIA(){
		        var u = navigator.userAgent, app = navigator.appVersion;
		        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
		        var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
		        if(isiOS) {return 1;}
		        if(isAndroid) {return 2};
		    }
		    var bg;
		    if (isPIA() == 1) {
		        bg = window.location.origin + "/vwechat/images/ios_wx.jpg";
		    }else if (isPIA() == 2) {
		        bg = window.location.origin + "/vwechat/images/android_wx.jpg";
		    }
		    // document.writeln("<div id=\"weixinTips\" style=\"display:none;background:rgba(255, 255, 255,1);width:100%;height:100%;position:fixed;left:0;top:0;z-index:9999\"><div id=\"weixinTipsImg\" style=\"background:url("+bg+") top center no-repeat;background-size:100%;width:100%;height:100%\"><\/div><\/div>");
		    var ua = navigator.userAgent.toLowerCase();
		    //alert(ua);
		    function checkDownload() {
		        if (ua.indexOf("micromessenger") > -1 || ua.indexOf("qq/") > -1) {
		            document.writeln("<div id=\"weixinTips\" style=\"display:block;background:rgba(255, 255, 255,1);width:100%;height:100%;position:fixed;left:0;top:0;z-index:9999\"><div id=\"weixinTipsImg\" style=\"background:url("+bg+") top center no-repeat;background-size:100%;width:100%;height:100%\"><\/div><\/div>");

		            // document.getElementById("weixinTips").style.display = "block";
		            document.title="请在浏览器中打开...";
		            // return false;
		        }else{

		        	var wabao666_domain = "<?php Print(env('wabao666_domain', 'www.wabao666.com'));?>";
		            var sCurrentPathName = window.location.pathname;
		            var sNewPathName = sCurrentPathName; //sCurrentPathName.replace("vvregister", "register");
		            if (window.location.hostname != wabao666_domain) {
		            	window.location.href = window.location.protocol + "//" + wabao666_domain + sNewPathName;	
		            }
		            // window.location.href = "https://www.wabao666.com" + sNewPathName;
		            // var href_ = "https://www.wabao666.com" + sNewPathName;

		        }

		    }
		    checkDownload();
		</script>

		<script type="text/javascript" src="//js.users.51.la/19985793.js"></script>

		@show
    </head>
    <body>
        @section('top-navbar')
            <!-- Static navbar -->
				<nav id="header" class="navbar navbar-default">
				  <div class="container-fluid">
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="col-xs-3 left-menu">
						@yield('left-menu')
					</div>
					<div class="col-xs-6">
						<div class="navbar-title">
						  <div class="navbar-brand">@yield('title')</div>
						</div>
					</div>
				
					<div class="col-xs-3">
					  	<div class="menu-wrapper">
					  		@yield('menu')
					  	</div>
					</div>
				  </div>
				  <!-- /.container-fluid -->
				</nav>
			<!-- End Static navbar -->
        @show

        <section class="cardFull card-flex">
			<div class="cardBody">
        		@yield('content')
			</div>

			@include('layouts/footer')
		</section>

		@section('footer-javascript')
			<script src="{{ asset('/client/js/jquery-1.11.1.min.js') }}"></script>
			<script src="{{ asset('/client/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>
			<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
		@show
    </body>
</html>