<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="arcade-app">
    <head>
		<meta charset="utf-8">
		
        <title>{{env('APP_NAME')}} - @yield('title')</title>
		
		@section('top-css')
			<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
			<link rel="stylesheet" href="{{ asset('/client/css/style.css') }}" />
		@show
		
		@section('top-javascript')
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-animate.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-sanitize.js"></script>
			<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.5.0.js"></script>
			<script src="{{ asset('/client/js/menu.js') }}"></script>
		@show
    </head>
    <body>
        @section('top-navbar')
            <!-- Static navbar -->
				<nav id="header" class="navbar navbar-default">
				  <div class="container-fluid">
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="col-xs-3"></div>
					<div class="col-xs-6">
					  <a class="navbar-brand" href="#">@yield('title')</a>
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

        @yield('content')
		
		@section('footer-navbar')		
		<div class="icon-bar navbar navbar-default navbar-fixed-bottom">
		  <a href="{{ url('home') }}"><div class="home"></div><div class="icon_label">{{ trans('dingsu.home') }}</div></a> 
		  <a href="#"><div class="trial"></div></i><div class="icon_label">{{ trans('dingsu.try') }}</div></a> 
		  <a href="#"><div class="balance_circle">{{isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}</div><div class="balance_label">{{ trans('dingsu.balance') }}</div></a> 
		  <a href="/arcade"><div class="play"></div><div class="icon_label">{{ trans('dingsu.treasure') }}</div></a>
		  <a href="/member"><div class="member"></div><div class="icon_label">{{ trans('dingsu.profile') }}</div></a> 
		</div>


		@show
		
		@section('footer-javascript')
			<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		@show
    </body>
</html>