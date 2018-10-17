<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{{env('APP_NAME')}} - @yield('title')</title>
	
	@section('top-css')
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		<link rel="stylesheet" href="{{ asset('/client/css/layout.css') }}" />
	@show
	
	@section('top-javascript')
		<!-- <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.js"></script> -->
		<!-- <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-animate.js"></script> -->
		<!-- <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-sanitize.js"></script> -->
		<!-- <script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.5.0.js"></script> -->
	@show

</head>