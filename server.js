
var express = require('express');
var app = express();
var server = require('http').createServer(app);
var io = require('socket.io')(server);
var Redis = require('ioredis');
var redis = new Redis();
var Request = require("request");
var socketioJwt = require('socketio-jwt');
var jwt = require('jsonwebtoken');
require('dotenv').config({path: '.env'});
var port  = process.env.REDIS_CLI_PORT;
console.log(process.env.JWT_SECRET);

var url   = process.env.APP_URL;

var aport = process.env.APP_PORT;

if (aport) {
	url = url + ':' + aport;
}
console.log(url);
var clients = {}
var port  = process.env.REDIS_CLI_PORT;

var UserID = '';

var sub = Redis.createClient(), pub = Redis.createClient();

io.on('connection', socketioJwt.authorize({
    secret: process.env.JWT_SECRET,
    timeout: 15000
}));
io.on('connect', function (socket) {
	token = socket.handshake.query.token;
	//console.log(token);
	jwt.verify(socket.handshake.query.token, process.env.JWT_SECRET, function(err, decoded) {	
	  if(err){
		  console.log('Error--Invalid token');
		  socket.disconnect();
	  }else{
		// continue with the request
	  }
	});	
		
});
io.on('authenticated', function (socket) {
    console.log('authenticated');	
	var dsub = Redis.createClient();	
	var user = socket.decoded_token;
    socket.emit('user-id', socket.decoded_token.userid);
	UserId = user.userid;	
	var vip = socket.handshake.query.vip;	
	Request.get(url+"/master-call-nobet?memberid="+UserId+'&vip='+vip, (error, response, body) => {
	});	
	clients[socket.id] = socket;
	
	redis.sadd("members", UserId);	
	
	socket.on('disconnect', function() {
		console.log('disconnect');
    	delete clients[socket.id];
  	});
		
	dsub.subscribe('userlogout');
	dsub.on("message", function (subscribed,channel, message) {	
		
		message = JSON.parse(channel);
		console.log("user logout "+message.data.id);		
		io.emit('userlogout-'+message.data.id);
		socket.disconnect();
		
	});
	
});


redis.on("error", function (err) {
      console.log("Error " + err)
});

//sub.psubscribe('initsetting-*','userlogout-*','*');
sub.psubscribe('*');

sub.on("pmessage", function (subscribed,channel, message) {
    message = JSON.parse(message);
	console.log(channel);	
	io.emit(channel + ':' + message.event, message.data);	
});

/* 
Start NodeJS server at port
*/
server.listen(port, function() {
    console.log('Server is running on port '+port);
});