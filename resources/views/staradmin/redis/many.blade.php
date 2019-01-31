@extends('redis.master')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha256-azvvU9xKluwHFJ0Cpgtf0CYzK7zgtOznnzxV4924X1w=" crossorigin="anonymous" />

    <p id="display">please wait..</p>

<div class="data" id="data"><ul class=""></ul></div>
@stop

@section('footer')
<input type="text" value="<?php echo $_GET['id']?>" id="auth_id">

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js" integrity="sha256-yr4fRk/GU1ehYJPAs8P4JlTgu0Hdsp4ZKrx8bDEDC3I=" crossorigin="anonymous"></script>

    <script>
		///socket5
         html = '';
		//var socket = io.connect('http://127.0.0.1:6001/?auth_id='+$('#auth_id').val());
		
		var url = {{ env('APP_URL'), 'http://192.168.1.154' }};
		var port = {{ env('REDIS_CLI_PORT'), '6001' }};
		
		var c_url = url + ':' + port;
		var socket = io.connect(c_url+'?auth_id='+$('#auth_id').val());
		//var socket = io.connect('http://192.168.1.154:6001/?auth_id='+$('#auth_id').val());
		
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
		
		//betting
		this.socket.on("userbetting-" + $('#auth_id').val() + ":App\\Events\\EventBetting" , function(data){
			console.log('call userbetting');
			console.log(data);
		 }.bind(this));
		
		
		//Trigger On page load & Event Load
		this.socket.on("bettinghistory" + ":App\\Events\\EventBettingHistory" , function(data){
			console.log('call bettinghistory');
			console.log(data);
		 }.bind(this));
		
		/*
		
		//Trigger On page load & Event Load
		this.socket.on("new-betting" + ":App\\Events\\NewBetting" , function(data){
			console.log('call bettinghistory');
			console.log(data);
		 }.bind(this));
			
		*/
		
    </script>
@stop