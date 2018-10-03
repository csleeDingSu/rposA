<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="arcade-app">
    <head>
		<meta charset="utf-8">
		
        <title>闯关夺宝 - @yield('title')</title>
		
		@section('top-css')
			<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
			<link rel="stylesheet" href="{{ asset('/client/css/layout.css') }}" />
		@show
		
		@section('top-javascript')
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-animate.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-sanitize.js"></script>
			<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.5.0.js"></script>
		@show
    </head>
    <body>
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