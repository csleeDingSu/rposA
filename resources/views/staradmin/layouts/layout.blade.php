<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="arcade-app">
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		
        <title>{{env('APP_NAME')}} - @yield('title')</title>
		
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
		  <div class="container mx-auto text-center">
		  <a href="{{ url('home') }}"><div class="home"></div><div class="icon_label">{{ trans('dingsu.home') }}</div></a> 
		  <!-- <a href="#"><div class="trial"></div></i><div class="icon_label">{{ trans('dingsu.try') }}</div></a>  -->
		  <a href="#"><div class="balance_circle">{{isset(Auth::Guard('member')->user()->current_life) ? Auth::Guard('member')->user()->current_life : 0}}</div><div class="balance_label">{{ trans('dingsu.balance') }}</div></a> 
		  <a href="/arcade"><div class="play"></div><div class="icon_label">{{ trans('dingsu.treasure') }}</div></a>
		  <!-- <a href="/member"><div class="member"></div><div class="icon_label">{{ trans('dingsu.profile') }}</div></a>  -->
		</div>
	</div>

		@show
		
		@section('footer-javascript')
			<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		@show
    </body>
</html>