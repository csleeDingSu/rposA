<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="{{ asset('/client/css/wheel.css') }}" />
    <script src="{{ asset('/client/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/client/js/jquery.rotate.min.js') }}"></script>
    <script src="{{ asset('/client/js/jquery.wheelOfFortune.js') }}"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="{{ asset('/client/js/js.cookie.js') }}"></script>
    <script src="{{ asset('/client/js/ifvisible.js') }}"></script>
    <script src="{{ asset('/client/js/wheel-vip.js') }}"></script>
</head>

<body>
	<input id="result" type="hidden" value="6">
    <input id="freeze_time" type="hidden" value="">
    <input id="draw_id" type="hidden" value="">
    <div class="wrapper">
        <div id="wheel_container"></div>
    </div>
</body>
</html>