<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="arcade-app">
    <head>
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="90">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		
        <title>{{env('APP_NAME')}} - @yield('title')</title>
		
		@section('top-css')
			<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

			<link rel="stylesheet" href="{{ asset('/test/main/css/public.css') }}" />
			<link rel="stylesheet" href="{{ asset('/test/main/css/module.css') }}" />
			<link rel="stylesheet" href="{{ asset('/test/main/css/style.css') }}" />
			<link rel="stylesheet" href="{{ asset('/client/css/default.css') }}" />
			<link rel="stylesheet" href="{{ asset('/client/css/footer.css') }}" />
			
		@show
		
		@section('top-javascript')

		@show
    </head>
    <body>
        @section('top-navbar')
            <!-- Static navbar -->
				<nav id="header" class="navbar navbar-default">
				  <div class="container-fluid">
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="col-xs-3">
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
			<script src="{{ asset('/client/js/bootstrap.min.js') }}"></script>
			<script type="text/javascript" src="{{ asset('/test/main/js/being.js') }}" ></script>
		@show
    </body>
</html>