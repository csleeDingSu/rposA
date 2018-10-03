// the game itself
var game;
// the spinning wheel
var wheel; 
// can the wheel spin?
var canSpin;
// slices (prizes) placed in the wheel
var slices = 6;
// prize names, starting from 12 o'clock going clockwise
var slicePrizes = ["1", "2", "3", "4", "5", "6"];
// the prize you are about to win
var prize;
// text field where to show the prize
var prizeText;

var counterText;

window.onload = function() {
  canSpin = false;
     // creation of a 458x488 game
	game = new Phaser.Game(458, 458, Phaser.AUTO, "");
     // adding "PlayGame" state
     game.state.add("PlayGame",playGame);
     // launching "PlayGame" state
     game.state.start("PlayGame");
}

// PLAYGAME STATE
	
var playGame = function(game){};

playGame.prototype = {
     // function to be executed once the state preloads
     preload: function(){
        // preloading graphic assets
        game.load.image("wheel", "/client/images/wheel.png");
		    game.load.image("pin", "/client/images/pin.png");     
     },
     // funtion to be executed when the state is created
  	create: function(){
          // giving some color to background
  		game.stage.backgroundColor = "#ffffff";
          // adding the wheel in the middle of the canvas
  		wheel = game.add.sprite(game.width / 2, game.width / 2, "wheel");
          // setting wheel registration point in its center
          wheel.anchor.set(0.5);
          // adding the pin in the middle of the canvas
          var pin = game.add.sprite(game.width / 2, game.width / 2, "pin");
          // setting pin registration point in its center
          pin.anchor.set(0.5);
          // adding the text field
          counterText = game.add.text(game.world.centerX, game.world.centerY, "");
          // setting text field registration point in its center
          counterText.anchor.set(0.5);
          // aligning the text to center
          counterText.align = "center";
		  
		  var oneMinute = 60 * 1;
		  startTimer(oneMinute, this);
		
		  var spinInterval = oneMinute * 1000;
          // the game has just started = we can spin the wheel
          canSpin = true;

		  
			
	},
     // function to spin the wheel
     spin(){
          // can we spin the wheel?
          if(canSpin){  
               // the wheel will spin round from 2 to 4 times. This is just coreography
               var rounds = game.rnd.between(2, 4);
               // then will rotate by a random number from 0 to 360 degrees. This is the actual spin
               var degrees = parseInt(document.getElementById('degree').value);
               // before the wheel ends spinning, we already know the prize according to "degrees" rotation and the number of slices
               prize = slices - 1 - Math.floor(degrees / (360 / slices));

               // now the wheel cannot spin because it's already spinning
               canSpin = false;
               // animation tweeen for the spin: duration 3s, will rotate by (360 * rounds + degrees) degrees
               // the quadratic easing will simulate friction
               var spinTween = game.add.tween(wheel).to({
                    angle: 360 * rounds + degrees
               }, 3000, Phaser.Easing.Quadratic.Out, true);
			   console.log('spin');
			   canSpin = true;
               // once the tween is completed, call winPrize function
               //spinTween.onComplete.add(this.winPrize, this);
          }
     },
     // function to assign the prize
     winPrize(){
          // now we can spin the wheel again
          canSpin = true;
          // writing the prize you just won
          //counterText.text = slicePrizes[prize];
     }
}

function startTimer(duration, game) {
    var timer = duration, minutes, seconds;

    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 61, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        counterText.text = seconds;
        counterText.style.fill = 'white';

        if (--timer < 0) {
            timer = duration;
			      game.spin();
        }
		
    }, 1000);
}