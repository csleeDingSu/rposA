<!-- socket start-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.4.8/socket.io.js"></script>
<script type="text/javascript">
	
	var url    = "{{ env('APP_URL')}}";		
	var port   = "{{ env('REDIS_CLI_PORT'), '3000' }}";
	var prefix = "{{ env('REDIS_PREFIX', 'C') }}";

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

		    @section('socket')
			@show
		    
		});


		function socketIOConnectionUpdate(err)
		{
		    console.log(err);
		}
	});

</script>
<!-- socket end-->
