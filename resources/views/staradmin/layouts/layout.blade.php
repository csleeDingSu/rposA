<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="arcade-app">
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		
        <title>{{env('APP_NAME')}} - @yield('title')</title>
		
		@section('top-css')
			<link href="{{ asset('/client/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}" rel="stylesheet">
			<link rel="stylesheet" href="{{ asset('/client/fontawesome-free-5.5.0-web/css/all.css') }}" >
			<link rel="stylesheet" href="{{ asset('/client/css/layout.css') }}" />
			<link rel="stylesheet" href="{{ asset('/client/css/footer.css') }}" />
		@show
		
		@section('top-javascript')
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-animate.js"></script>
			<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-sanitize.js"></script>
			<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.5.0.js"></script>
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
        @yield('content')
		
		@section('footer-navbar')
			@include('layouts/footer')
		@show
		
		@section('footer-javascript')
			<!-- <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
			<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
			<script src="{{ asset('/client/js/jquery-1.11.1.min.js') }}"></script>
			<script src="{{ asset('/client/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>
			
		@show
    </body>
</html>