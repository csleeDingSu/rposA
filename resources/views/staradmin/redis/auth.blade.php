<!doctype html>
<html lang="en">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.js"></script>

</head>
<body>

<h1>Connection Status: <span id="connection">Connecting....</span></h1>
<h1>Login name: <span id="name"></span></h1>	
<h1>Login User Id: <span id="userid"></span></h1>
<input type="text" value="<?php echo $_GET['id']?>" id="auth_id">
<script type="text/javascript">
	
	//var socket = io.connect('http://localhost:6001');
	/*
	var url  = 'http://localhost';
	var port = '6001';

	var c_url = url + ':' + port;
	var socket = io.connect(c_url+'?auth_id='+$('#auth_id').val());
	*/
	var url  = "{{ env('APP_URL'), 'http://boge56.com' }}";		
	var port = "{{ env('REDIS_CLI_PORT'), '6001' }}";
	
	var prefix = "{{ env('REDIS_PREFIX'), 'BOG' }}";
	
	$(document).ready(function () {
        socketIOConnectionUpdate('Requesting JWT Token from Laravel');

        $.ajax({
            url: '/token'
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            htm = '<p class="text-warning">Unauthorized.</p>';
			socketIOConnectionUpdate( htm);
        })
        .done(function (result, textStatus, jqXHR) {

			socketIOConnectionUpdate('Response from Laravel');
			
			
			//var url = 'http://boge56.com';

			//var url = 'http://192.168.1.154';
			//var port = '6001';

			var c_url = url + ':' + port;
			
			console.log('connecting URL: '+c_url);
			
			//Output have userid , token and username 
			
			var socket = new io.connect(c_url, {
                'reconnection': true,
                'reconnectionDelay': 1000, //1 sec
                'reconnectionDelayMax' : 5000,
                'reconnectionAttempts': 2,
				'transports': ['websocket'],
				'timeout' : 10000, //1 min
				'force new connection' : true,
				 query: 'token='+result.token
            });

            /* 
            connect with socket io
            */
            socket.on('connect', function () {
                socketIOConnectionUpdate('Connected to SocketIO, Authenticating')
                console.log('Token: '+result.token);
				socket.emit('authenticate', {token: result.token});
            });

            /* 
            If token authenticated successfully then here will get message 
            */
            socket.on('authenticated', function () {
				htm = '<p class="text-success">Authenticated.</p>';
                socketIOConnectionUpdate(htm);
            });

            /* 
            If token unauthorized then here will get message 
            */
            socket.on('unauthorized', function (data) {
                socketIOConnectionUpdate('Unauthorized, error msg: ' + data.message);
            });

            /* 
            If disconnect socketio then here will get message 
            */
            socket.on('disconnect', function () {
				console.log('disconnect--');
				htm = '<p class="text-danger">Disconnected.</p>';
                socketIOConnectionUpdate(htm);
            });

            /* 
            Get Userid by server side emit
            */
            socket.on('user-id', function (data) {
                $('#userid').html(data);
            });

            /* 
            Get Email by server side emit
            */
            socket.on('user-name', function (data) {
                $('#name').html(data);
            });
			//On user logout
			socket.on(prefix+'userlogout-' +$('#auth_id').val(), function (data) {
                console.log('user-logout');
				socketIOConnectionUpdate('user-logout');	
            });
			
			//on page load game setting Script
			socket.on(prefix+"loadsetting-" + $('#auth_id').val() + ":App\\Events\\EventGameSetting", function(data){
				console.log('load user game setting-on page load');

				console.log(data);

			 });
			
			//init setting Script
			socket.on(prefix+"initsetting-" + $('#auth_id').val() + ":App\\Events\\EventGameSetting", function(data){
				console.log('user-initsetting');

				console.log(data);

			 });

			//No betting
			socket.on(prefix+"no-betting-user-" + $('#auth_id').val() + ":App\\Events\\EventNoBetting" , function(data){
				console.log('call no-betting');
				console.log(data);
			 });

			//No betting vip
			socket.on(prefix+"no-vipbetting-user-" + $('#auth_id').val() + ":App\\Events\\EventNoBetting" , function(data){
				console.log('call no-vip-betting');
				console.log(data);
			  });

			//betting
			socket.on(prefix+"userbetting-" + $('#auth_id').val() + ":App\\Events\\EventBetting" , function(data){
				console.log('call userbetting');
				console.log(data);
			  });

			//betting vip
			socket.on(prefix+"uservipbetting-" + $('#auth_id').val() + ":App\\Events\\EventVIPBetting" , function(data){
				console.log('call uservipbetting');
				console.log(data);
			  });

			//betting history 
			socket.on(prefix+"bettinghistory-" + $('#auth_id').val() + ":App\\Events\\EventBettingHistory", function(data){
				console.log('members recent bettinghistory');
				console.log(data);

			  });

			//betting VIP history -- new --
			socket.on(prefix+"vipbettinghistory-" + $('#auth_id').val() + ":App\\Events\\EventVipBettingHistory", function(data){
				console.log('members recent Vip bettinghistory');
				console.log(data);

			 });

			//wallet changes -- new --
			socket.on(prefix+"wallet-" + $('#auth_id').val() + ":App\\Events\\EventWalletUpdate", function(data){
				console.log('member wallet details');
				console.log(data);

			  });

			//betting history on Event Load - no use
			socket.on(prefix+"bettinghistory" + ":App\\Events\\EventBettingHistory" , function(data){
				console.log('members recent bettinghistory');
				console.log(data);
			  });

			//below functions are still on development		 			

			//Trigger on Event Load
			socket.on(prefix+"new-betting" + ":App\\Events\\NewBettingStatus" , function(data){
				console.log('call betting status update');
				console.log(data);
			  });
			
			socket.on(prefix+"activedraw" + ":App\\Events\\EventDynamicChannel" , function(data){
				console.log('members activedraw');
				console.log(data);
			  });
			
			socket.on(prefix+$('#auth_id').val() + "topup-notification" + ":App\\Events\\EventDynamicChannel" , function(data){
				console.log('members activedraw');
				console.log(data);
			  });


            /* 
            Get receive my message by server side emit
            */
            socket.on('receive-my-message', function (data) {
                $('#receive-my-message').html(data);
            });
        });
    });
	
    /* 
    Function for print connection message
    */
    function socketIOConnectionUpdate(str) {
        $('#connection').html(str);
    }
</script>
</body>
</html>