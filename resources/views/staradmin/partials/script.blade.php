	
<script type="text/javascript">	
	var url    = "{{ env('APP_URL')}}";		
	var port   = "{{ env('REDIS_CLI_PORT'), '3000' }}";
	
	var perfix = "{{ config('app.REDIS_PREFIX') }}";
	
	$(document).ready(function () {
        socketIOConnectionUpdate('<span class="text-info">@lang("dingsu.requesting_token")</span>');

        $.ajax({
            url: '/admintoken'
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            htm = '<span class="text-warning">@lang("dingsu.unauthorized").</span>';
			socketIOConnectionUpdate( htm);
        })
        .done(function (result, textStatus, jqXHR) {

			socketIOConnectionUpdate('<span class="text-info">@lang("dingsu.response_from_server")</span>');

			var c_url = url + ':' + port;
			
			console.log('connecting URL: '+c_url);
			
			//Output have userid , token and username 
			
			var socket = new io.connect(c_url, {
                'reconnection': true,
                'reconnectionDelay': 1000, //1 sec
                'reconnectionDelayMax' : 5000,
                'reconnectionAttempts': 10,
				'transports': ['websocket'],
				'timeout' : 900000, //90 min
				'force new connection' : true,
				 query: 'token='+result.token
            });
			
			socket.on('connect_failed', function(){
				console.log('Connection Failed');
				socketIOConnectionUpdate('<span class="text-danger">@lang("dingsu.connection_failed")</span>');
			});
			
			socket.on('connect_error', function(){
				console.log('Connection Failed');
				socketIOConnectionUpdate('<span class="text-danger">@lang("dingsu.connection_failed")</span>');
			});

            /* 
            connect with socket io
            */
            socket.on('connect', function () {
                socketIOConnectionUpdate('<span class="text-info">@lang("dingsu.connected_authenticating")</span>')
                console.log('Token: '+result.token);
				console.log('perfix: '+perfix);
				
				socket.emit('authenticate', {token: result.token});
            });

            /* 
            If token authenticated successfully then here will get message 
            */
            socket.on('authenticated', function () {
				htm = '<span class="text-success">@lang("dingsu.yes")</span>';
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
				htm = '<span class="text-danger">@lang("dingsu.disconnected").</span>';
                socketIOConnectionUpdate(htm);
            });
			
			@section('socket')
			
			
			@show
        });
    });
		
		
		
/* 
    Function for print connection message
    */
    function socketIOConnectionUpdate(str) {
        $('#socketconnection').html(str);
    }	
		
		
		socketIOConnectionUpdate('<span class="text-info">Waiting</span>');
</script>

<script src="{{ asset('staradmin/vendors/js/vendor.bundle.base.js') }}"></script>
  
<script src="{{ asset('staradmin/vendors/js/vendor.bundle.addons.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{ asset('staradmin/js/off-canvas.js') }}"></script>
  <script src="{{ asset('staradmin/js/misc.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->

@section('bottom_js')
			
@show



<button onclick="topFunction()" id="gototopbtn" title="Go to top"><i class="icon-arrow-up "></i></button>

<script language="javascript">

	$( ".pagination" ).addClass( "rounded-flat" );
	
	
	//To top
	// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("gototopbtn").style.display = "block";
		
		$( "#gototopbtn" ).addClass( "btn btn-icons btn-inverse-secondary  btn-rounded btn-outline-secondary " );
		
    } else {
        document.getElementById("gototopbtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    //document.body.scrollTop = 0; // For Safari
    //document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
	
	$('html, body').animate({scrollTop:0}, 'slow');
	
}
</script>