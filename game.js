var app = require('http').createServer(handler);
var io = require('socket.io')(app);
var Redis = require('ioredis');
var redis = new Redis();
var Request = require("request");
var UserId = 0;

var url = "http://boge56.com:8088/";
var userNotification = {};
var port = 6001;
app.listen(port, function() {
    console.log('Server is running!');
});

function handler(req, res) {
    res.writeHead(200);
    res.end('');
}
redis.psubscribe('*', function(err, count) {});			

//Whenever Event run this function will get trigger
redis.on('pmessage', function(subscribed, channel, message) {	
		
	console.log(channel);
	message = JSON.parse(message);
	
	io.emit(channel + ':' + message.event, message.data);
});

//On page load this function will get trigger
io.on('connection', function(socket, channel, message) { 
	
	UserId = socket.handshake.query.auth_id;	
	
	console.log('Connected -'+UserId);
		
	//call member betting function
	Request.get(url+"master-call-nobet?memberid="+UserId, (error, response, body) => {
		//console.log(response);
		//console.log(body);
	});			
	
	//Call betting history
	//Request.get(url+"userbetting", (error, response, body) => {		
	//});	
	
	
	
	socket.on('disconnect', function () {

      socket.emit('disconnected');
      //online = online - 1;

  });
	
	
	
		
});


/***
 ** Betting History
 ***/
var BHredis = new Redis();	
BHredis.subscribe('bettinghistory');

BHredis.on('message', function(channel, message) {
    
	io.emit(channel + ':' + channel, message);
});

/***
 ** END
 ***/


redis.on("error", function (err) {
    console.log(err);
});

