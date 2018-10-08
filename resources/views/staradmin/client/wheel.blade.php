<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style type="text/css">
        #txtCounter {
            font-size: 40px;
            color: white;
            padding-left: 18px;
            padding-top: 16px;
        }

        #wheel_container {
            left: 30px;
        }
    </style>
    <script src="{{ asset('/client/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/client/js/jquery.rotate.min.js') }}"></script>
    <script src="{{ asset('/client/js/jquery.wheelOfFortune.js') }}"></script>
    <script src="{{ asset('/client/js/wheel.js') }}"></script>
</head>

<body>
	<input id="result" type="hidden" value="6">
    <input id="freeze_time" type="hidden" value="">
    <input id="draw_id" type="hidden" value="">
    <div class="row">
        <div class="col-md-6">
            <div id="wheel_container"></div>
        </div>
    </div>
</body>
</html>