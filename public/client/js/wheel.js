$(function () {    
    initGame();
});

function updateResult(){

    var iframe_result = $('#ifm_result', window.parent.document).contents();

    $.getJSON( "/api/result-history/101", function( data ) {
        var records = data.records.data;

        $.each(records, function(i, item) {
            var counter = i + 1;
            iframe_result.find('#result-' + counter).html(item.result);
        });
    });
}

function updateHistory(){

    var iframe_history = $('#ifm_history', window.parent.document).contents();
    var user_id = $('#hidUserId', window.parent.document).val();

    $.getJSON( "/api/betting-history?gameid=101&memberid=" + user_id, function( data ) {
        //console.log(data.records);
        $.each(data.records, function(r, records) {
            var history = '';

            iframe_history.find('#row-' + r).find('.number').html(r);
            iframe_history.find('#row-' + r).find('.history').html('');

            $.each(records, function(i, item) {
                var className = item.bet;

                if(item.is_win == null){
                    className = item.bet + '-fail'; 
                }

                history =  '<div class="' + className + '">' +
                                '<span class="label">' + item.result +'</span>'
                            '</div>';

                iframe_history.find('#row-' + r).find('.history').append(history);
            })
        });
    });
}

function initUser(){
    var user_id = $('#hidUserId', window.parent.document).val();
    $.post("/api/wallet-detail", { 'memberid': user_id, gameid: 101 }, function(data) {
        //console.log(data);
        // Do something with the request
        if(data.success) {
            if (data.record.length === 0) {
                $('#spanBalance', window.parent.document).html(0);
                $('#divLife', window.parent.document).html(0);
                $('#divPoint', window.parent.document).html(0);
            } else {
                var balance = parseInt(data.record[0].balance);
                var life = data.record[0].life;
                var point = parseInt(data.record[0].point);

                $('#spanBalance', window.parent.document).html(balance);
                $('#divLife', window.parent.document).html(life);
                $('#divPoint', window.parent.document).html(point);
                $('#hidPoint', window.parent.document).html(point);
                
                setPoint();
            }
        }
        
    }, 'json');
}

function initGame(){
    initUser();
    updateResult();
    updateHistory();

    var user_id = $('#hidUserId', window.parent.document).val();
    $.getJSON( "/api/game-setting?gameid=101&memberid=" + user_id, function( data ) {
        //console.log(data);
        if(data.success) {
            var bet_amount = 0;
            var duration = data.record.duration;
            var timer = data.record.remaining_time;
            var freeze_time = data.record.freeze_time;
            var draw_id = data.record.drawid;
            var level = data.record.level.position;
            var level_id = data.record.level.levelid;

            $('#hidLevel', window.parent.document).val(level);
            $('#hidLevelId', window.parent.document).val(level_id);

            $('.speech-bubble', window.parent.document).addClass("hide");
            $('.speech-bubble', window.parent.document).next().removeClass("done");
            
            switch (level) {
                default:
                case 1:
                    bet_amount = 10;
                    $('.level-one', window.parent.document).removeClass("hide");
                    break;
                case 2:
                    bet_amount = 30;
                    $('.level-two', window.parent.document).removeClass("hide");
                    $('.level-one', window.parent.document).next().addClass("done").find(".label").html("x");
                    break;
                case 3:
                    bet_amount = 70;
                    $('.level-three', window.parent.document).removeClass("hide");
                    $('.level-one', window.parent.document).next().addClass("done").find(".label").html("x");
                    $('.level-two', window.parent.document).next().addClass("done").find(".label").html("x");
                    break;
                case 4:
                    bet_amount = 150;
                    $('.level-four', window.parent.document).removeClass("hide");
                    $('.level-one', window.parent.document).next().addClass("done").find(".label").html("x");
                    $('.level-two', window.parent.document).next().addClass("done").find(".label").html("x");
                    $('.level-three', window.parent.document).next().addClass("done").find(".label").html("x");
                    break;
                case 5:
                    bet_amount = 310;
                    $('.level-five', window.parent.document).removeClass("hide");
                    $('.level-one', window.parent.document).next().addClass("done").find(".label").html("x");
                    $('.level-two', window.parent.document).next().addClass("done").find(".label").html("x");
                    $('.level-three', window.parent.document).next().addClass("done").find(".label").html("x");
                    $('.level-four', window.parent.document).next().addClass("done").find(".label").html("x");
                    break;
                case 6:
                    bet_amount = 630;
                    $('.level-six', window.parent.document).removeClass("hide");
                    $('.level-one', window.parent.document).next().addClass("done").find(".label").html("x");
                    $('.level-two', window.parent.document).next().addClass("done").find(".label").html("x");
                    $('.level-three', window.parent.document).next().addClass("done").find(".label").html("x");
                    $('.level-four', window.parent.document).next().addClass("done").find(".label").html("x");
                    $('.level-five', window.parent.document).next().addClass("done").find(".label").html("x");
                    break;
            }

            $('.bet-container', window.parent.document).html(bet_amount);

            setPoint();

            $('#freeze_time').val(freeze_time);
            $('#draw_id').val(draw_id);

            DomeWebController.init();
            startTimer(duration, timer, freeze_time);
            bindBetButton();
        } else {
            $.getJSON( "/api/generateresult", function() {});

            initGame();
        }

        
    });
}

function setPoint() {
    var selected = $('div.clicked', window.parent.document).find('input:radio').val();
    if (typeof selected == 'undefined'){
        //do nothing
    } else {
        var bet_amount = parseInt($('.bet-container', window.parent.document).html());
        var point = $('#hidPoint', window.parent.document).html();
        var newpoint = point - bet_amount;
        //console.log(point + " - " + bet_amount + " = " + newpoint);
        $('#divPoint', window.parent.document).html(newpoint);
    }
}

function bindBetButton(){
    //console.log('bindBetButton');
    $('.radio-primary', window.parent.document).click(function(){
        var point = parseInt($('#hidPoint', window.parent.document).html());

        if(point < 10){
            return false;
        }

        $('.radio-primary', window.parent.document).not(this).find('.radio').removeClass('clicked');
        $('.radio-primary', window.parent.document).not(this).find('.bet-container').hide();

        $(this).find('.bet-container').toggle();
        $(this).find('.radio').toggleClass('clicked');

        var selected = $('div.clicked', window.parent.document).find('input:radio').val();
        if (typeof selected == 'undefined'){
            $('#divPoint', window.parent.document).html(point);
        } else {

            var bet_amount = parseInt($('.bet-container', window.parent.document).html());
            var newpoint = point - bet_amount;
            $('#divPoint', window.parent.document).html(newpoint);
        }

    });
}

function startTimer(duration, timer, freeze_time) {

    var trigger_time = freeze_time - 1;
    var timerInterval = setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 61, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        $( "#txtCounter" ).html(seconds);

        --timer;

        if (timer < 0) {
            timer = duration;

            clearInterval(timerInterval);
            initGame();

        } else if (timer == trigger_time) {
            //Lock the selection
            $('.radio-primary', window.parent.document).unbind('click');

            //Get selected option
            var selected = $('div.clicked', window.parent.document).find('input:radio').val();
            var bet_amount = $('.bet-container', window.parent.document).html();
            var draw_id = $('#draw_id').val();
            var user_id = $('#hidUserId', window.parent.document).val();
            var level_id = $('#hidLevelId', window.parent.document).val();

            //console.log("Selected: "+selected+ " Bet Amount: "+bet_amount+ " Draw Id:"+draw_id+" User Id: "+user_id);   
            $.post("/api/update-game-result", { 
                gameid : 101, 
                memberid : user_id, 
                drawid : draw_id, 
                bet : selected, 
                betamt : bet_amount,
                level : level_id
            }, 
            function(data) {
                console.log(data);
                var freeze_time = $('#freeze_time').val();
                var result = data.game_result;
                $('#result').val(result);

                //Trigger the wheel
                DomeWebController.getEle("$wheelContainer").wheelOfFortune({
                    'items': {1: [331, 389], 2: [31, 89], 3: [91, 149], 4: [151, 209], 5: [211, 269], 6: [271, 329]},//奖品角度配置{键:[开始角度,结束角度],键:[开始角度,结束角度],......}
                    'pAngle': 0,//指针图片中的指针角度(x轴正值为0度，顺时针旋转 默认0)
                    'type': 'w',//旋转指针还是转盘('p'指针 'w'转盘 默认'p')
                    'fluctuate': 0.5,//停止位置距角度配置中点的偏移波动范围(0-1 默认0.8)
                    'rotateNum': 12,//转多少圈(默认12)
                    'duration': freeze_time * 1000,//转一次的持续时间(默认5000)
                    'click': function () {
                        if(1==1){}
                        var key = result;
                        DomeWebController.getEle("$wheelContainer").wheelOfFortune('rotate', key);
                    },//点击按钮的回调
                    'rotateCallback': function (key) {
                        //alert("左:" + key);
                    }//转完的回调
                });

                $( "#btnWheel" ).trigger( "click" );
            }, 'json');
        }
        
    }, 1000);
}

DomeWebController = {
    pool: {
        element: {}
    },
    getEle: function (k) {
        return DomeWebController.pool.element[k];
    },
    setEle: function (k, v) {
        DomeWebController.pool.element[k] = v;
    },
    init: function () {
        var that = DomeWebController;
        that.inits.element();
        that.inits.event();
        that.build();
    },
    inits: {
        element: function () {
            var that = DomeWebController;
            that.setEle("$wheelContainer", $('#wheel_container'));

        },
        event: function () {
            var that = DomeWebController;

        }
    },
    build: function () {
        var that = DomeWebController;
        var result = $('#result').val();
        var freeze_time = $('#freeze_time').val();

        that.getEle("$wheelContainer").wheelOfFortune({
            'wheelImg': "/client/images/wheel.png",//转轮图片
            'pointerImg': "/client/images/pointer.png",//指针图片
            'buttonImg': "/client/images/button.png",//开始按钮图片
            'wSide': 400,//转轮边长(默认使用图片宽度)
            'pSide': 150,//指针边长(默认使用图片宽度)
            'bSide': 80,//按钮边长(默认使用图片宽度)
            'items': {1: [331, 389], 2: [31, 89], 3: [91, 149], 4: [151, 209], 5: [211, 269], 6: [271, 329]},//奖品角度配置{键:[开始角度,结束角度],键:[开始角度,结束角度],......}
            'pAngle': 0,//指针图片中的指针角度(x轴正值为0度，顺时针旋转 默认0)
            'type': 'w',//旋转指针还是转盘('p'指针 'w'转盘 默认'p')
            'fluctuate': 0.5,//停止位置距角度配置中点的偏移波动范围(0-1 默认0.8)
            'rotateNum': 12,//转多少圈(默认12)
            'duration': freeze_time * 1000,//转一次的持续时间(默认5000)
            'startKey' : 1,
            'click': function () {
                if(1==1){}
                var key = result;
                that.getEle("$wheelContainer").wheelOfFortune('rotate', key);
            },//点击按钮的回调
            'rotateCallback': function (key) {
                //alert("左:" + key);
            }//转完的回调
        });
    }
};