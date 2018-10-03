<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="arcade-app">
    <head>
		<meta charset="utf-8">
		
        <title>闯关夺宝 - @yield('title')</title>
		
		@section('top-css')
			<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
			<link rel="stylesheet" href="{{ asset('/css/style.css') }}" />
		@show
		
		@section('top-javascript')
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-animate.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-sanitize.js"></script>
			<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.5.0.js"></script>
			<script src="{{ asset('/js/menu.js') }}"></script>
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
						  <a href="#" uib-dropdown-toggle role="button">菜单</a>
							<ul class="dropdown-menu dropdown-menu-right" uib-dropdown-menu role="menu">
								<li role="menuitem"><a href="#">李小梅你好</a></li>
								<li class="divider"></li>
								<li role="menuitem"><a href="#">闯关历史</a></li>
								<li class="divider"></li>
								<li role="menuitem"><a href="#">已兑换</a></li>
								<li class="divider"></li>
								<li role="menuitem"><a href="#">邀请列表</a></li>
								<li class="divider"></li>
								<li role="menuitem"><a href="#">个人资料</a></li>
								<li class="divider"></li>
								<li role="menuitem"><a href="#">退出</a></li>
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
		  <a href="/"><div class="home"></div><div class="icon_label">首页</div></a> 
		  <a href="#"><div class="trial"></div></i><div class="icon_label">试用</div></a> 
		  <a href="#"><div class="balance_circle">25</div><div class="balance_label">剩余次数</div></a> 
		  <a href="/arcade"><div class="play"></div><div class="icon_label">闯关</div></a>
		  <a href="/member"><div class="member"></div><div class="icon_label">个人中心</div></a> 
		</div>

		@show
		
		@section('footer-javascript')
			<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		@show
    </body>
</html>