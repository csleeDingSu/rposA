<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="arcade-app">
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		
        <title>{{env('APP_NAME')}} - @yield('title')</title>
		
		@section('top-css')
			
			<link href="{{ asset('/client/bootstrap-3.3.7-dist/css/bootstrap.min.css') }}" rel="stylesheet">
			<link rel="stylesheet" href="{{ asset('/client/fontawesome-free-5.5.0-web/css/all.css') }}" >

			<!-- <link rel="stylesheet" href="{{ asset('/client/css/sweetalert2.min.css') }}"/> -->
        
        <link rel="stylesheet" href="{{ asset('/test/main/css/public.css') }}" />
			<link rel="stylesheet" href="{{ asset('/test/main/css/module.css') }}" />
			<!-- <link rel="stylesheet" href="{{ asset('/test/main/css/style.css') }}" /> -->
			<!-- <link rel="stylesheet" href="{{ asset('/client/css/default.css') }}" /> -->
			<!-- <link rel="stylesheet" href="{{ asset('/client/css/footer.css') }}" /> -->
			<link rel="stylesheet" href="{{ asset('/test/main/css/share.css') }}" />
			
		@show
		
		@section('top-javascript')

		@show
    </head>
    <body>
        @section('top-navbar')            
        @show

        <section class="cardFull card-flex">
			<div class="cardBody">
        		@yield('content')
			</div>

			@include('layouts/footer')
		</section>        

        
        @section('footer-javascript')

				<script src="{{ asset('/client/js/clipboard.min.js') }}"></script>
		<script src="{{ asset('/client/js/sweetalert2.all.min.js') }}"></script>
		<!-- <script src="{{ asset('/client/bootstrap-3.3.7-dist/js/bootstrap.min.js') }}"></script>			 -->
		<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
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
        
        @yield('modelcontent')
    </body>
</html>