<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="arcade-app">
    <head>
		<meta charset="utf-8">
	    <meta http-equiv="refresh" content="90">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		
        <title>{{env('APP_NAME')}} - @yield('title')</title>
		
		@section('top-css')
			<link href="{{ asset('/client/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}" rel="stylesheet">
			<link rel="stylesheet" href="{{ asset('/client/fontawesome-free-5.5.0-web/css/all.css') }}">
			<link rel="stylesheet" href="{{ asset('/test/main/css/public.css') }}" />
			<link rel="stylesheet" href="{{ asset('/test/main/css/module.css') }}" />
			<link rel="stylesheet" href="{{ asset('/test/main/css/style.css') }}" />
			<link rel="stylesheet" href="{{ asset('/client/css/style.css') }}" />
			<link rel="stylesheet" href="{{ asset('/client/css/footer.css') }}" />
			<style type="text/css">
				
					.div-icon {
						position: relative;
						border: 2px solid #ADB2C9;
						border-radius: 20px;
						text-align: center;
						padding:4px;
						margin: 8px;
						width: 60px;

					}

					.div-icon > a {						
						color: #ADB2C9;
						text-decoration: none;
					}

					.div-icon > a:hover {
					  color: white;
					  
					}

					.nav, .navbar-title {
						position: relative;
						/*border: 2px solid #ADB2C9;*/
						/*border-radius: 20px;*/
						/*text-align: center;*/
						padding:6px;
						/*margin: 8px;*/
						/*width: 60px;*/
					}


			</style>

		@show
		
		@section('top-javascript')
			<script src="{{ asset('/client/js/angular.js') }}"></script>
			<script src="{{ asset('/client/js/angular-animate.js') }}"></script>
			<script src="{{ asset('/client/js/angular-sanitize.js') }}"></script>
			<script src="{{ asset('/client/js/ui-bootstrap-tpls-2.5.0.js') }}"></script>
			<script src="{{ asset('/client/js/menu.js') }}"></script>
			<script>
			//这个统计代码。
			var hmt = hmt || [];
			(function() {
			  var hm = document.createElement("script");
			  hm.src = "https://hm.baidu.com/hm.js?5e39d74009d8416a3c77c62c47158471";
			  var s = document.getElementsByTagName("script")[0]; 
			  s.parentNode.insertBefore(hm, s);
			})();
			</script>

		@show
    </head>
    <body>    	
        @section('top-navbar')
            <!-- Static navbar -->
				<nav id="header" class="navbar navbar-default">
				  <div class="container-fluid">
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="col-xs-3">
						<div class="col div-icon">
						  	<a href="/register"><i class="fa fa-user-plus"></i>注册</a>					  	
						</div>						
					</div>
					
					<div class="col-xs-6">
						<div class="navbar-title">
						  <a class="navbar-brand" href="#">@yield('title')</a>
						</div>
					</div>
				
					<div class="col-xs-3">
					  <ul class="nav">
						<li class="dropdown" uib-dropdown>				
						  <a href="#" uib-dropdown-toggle role="button"><div class="menu-wrapper"><div class="menu"></div></div></a>
							<ul class="dropdown-menu dropdown-menu-right" uib-dropdown-menu role="menu">
								<li role="menuitem"><a href="#">{{ isset(Auth::Guard('member')->user()->username) ? Auth::Guard('member')->user()->username : '' }} 你好</a></li>
								@if (isset(Auth::Guard('member')->user()->username))
								<li class="divider"></li>
								<li role="menuitem"><a href="#">{{ trans('dingsu.mines_history') }}</a></li>
								<li class="divider"></li>
								<li role="menuitem"><a href="#">已兑换</a></li>
								<li class="divider"></li>
								<li role="menuitem"><a href="#">邀请列表</a></li>
								<li class="divider"></li>
								<li role="menuitem"><a href="{{ url('profile') }}">{{ trans('dingsu.profile') }}</a></li>
								<li class="divider"></li>
								<li role="menuitem"><a href="{{ url('logout') }}">{{ trans('dingsu.logout') }}</a></li>
								@endif
							</ul>				
						</li>
					  </ul>
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