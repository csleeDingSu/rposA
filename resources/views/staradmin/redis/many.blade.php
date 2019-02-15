@extends('redis.master')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha256-azvvU9xKluwHFJ0Cpgtf0CYzK7zgtOznnzxV4924X1w=" crossorigin="anonymous" />
<br><input type="text" value="<?php echo $_GET['id']?>" id="auth_id">
    <p id="display">please wait..</p>

<div class="data" id="data"><ul class=""></ul></div>
@stop

@section('footer')


<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js" integrity="sha256-yr4fRk/GU1ehYJPAs8P4JlTgu0Hdsp4ZKrx8bDEDC3I=" crossorigin="anonymous"></script>

    <script>
		///game example page
        html = '';
		var url = "{{ env('APP_URL'), 'http://boge56.com' }}";		
		//var port = {{ env('REDIS_CLI_PORT'), '6001' }};
		//var url = 'http://boge56.com';
		
		//var url = 'http://192.168.1.154';
		var port = '6001';
				
		var c_url = url + ':' + port;
		var socket = io.connect(c_url+'?auth_id='+$('#auth_id').val());
		this.socket.on('connect_error', function() {
			console.log('Connection failed');
		});
		this.socket.on('reconnect_failed', function() {
			console.log('Reconnection failed');
		});
		
		//init setting Script
		this.socket.on("initsetting-" + $('#auth_id').val() + ":App\\Events\\EventGameSetting", function(data){
			console.log('user-initsetting');
			
			console.log(data);
			
		 }.bind(this));
		
		//No betting
		this.socket.on("no-betting-user-" + $('#auth_id').val() + ":App\\Events\\EventNoBetting" , function(data){
			console.log('call no-betting');
			console.log(data);
		 }.bind(this));
		
		//No betting vip
		this.socket.on("no-vipbetting-user-" + $('#auth_id').val() + ":App\\Events\\EventNoBetting" , function(data){
			console.log('call no-vip-betting');
			console.log(data);
		 }.bind(this));
		
		//betting
		this.socket.on("userbetting-" + $('#auth_id').val() + ":App\\Events\\EventBetting" , function(data){
			console.log('call userbetting');
			console.log(data);
		 }.bind(this));
		
		//betting vip
		this.socket.on("uservipbetting-" + $('#auth_id').val() + ":App\\Events\\EventVIPBetting" , function(data){
			console.log('call uservipbetting');
			console.log(data);
		 }.bind(this));
		 
		//betting history 
		this.socket.on("bettinghistory-" + $('#auth_id').val() + ":App\\Events\\EventBettingHistory", function(data){
			console.log('members recent bettinghistory');
			console.log(data);
			
		 }.bind(this));
		
		//betting VIP history -- new --
		this.socket.on("vipbettinghistory-" + $('#auth_id').val() + ":App\\Events\\EventVipBettingHistory", function(data){
			console.log('members recent Vip bettinghistory');
			console.log(data);
			
		 }.bind(this));
		
		//wallet changes -- new --
		this.socket.on("wallet-" + $('#auth_id').val() + ":App\\Events\\EventWalletUpdate", function(data){
			console.log('member wallet details');
			console.log(data);
			
		 }.bind(this));
		 
		//betting history on Event Load - no use
		this.socket.on("bettinghistory" + ":App\\Events\\EventBettingHistory" , function(data){
			console.log('members recent bettinghistory');
			console.log(data);
		 }.bind(this));
		
		//below functions are still on development		 			
		
		//Trigger on Event Load
		this.socket.on("new-betting" + ":App\\Events\\NewBettingStatus" , function(data){
			console.log('call betting status update');
			console.log(data);
		 }.bind(this));
			
		
		
    </script>
@stop