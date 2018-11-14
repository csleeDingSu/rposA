var trigger = false;

$(function () {
    var wechat_status = $('#hidWechatId', window.parent.document).val();
    var wechat_name = $('#hidWechatName', window.parent.document).val();

    if(wechat_status == 0 && wechat_name != null) {
        initGame();
    }
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
    //console.log("/api/betting-history?gameid=101&memberid=" + user_id);
    $.getJSON( "/api/betting-history?gameid=101&memberid=" + user_id, function( data ) {

        var records = data.records;
        var length = Object.keys(records).length;
        var maxCount = 8;

        if(length < maxCount){
            maxCount = parseInt(length);
        }
        //console.log(records);
        for(var r = 1; r <= maxCount; r++){
            var last = Object.keys(records)[Object.keys(records).length-1];
            var last_record = records[last];
            var history = '';

            iframe_history.find('#row-' + r).find('.number').html(last);
            iframe_history.find('#row-' + r).find('.history').html('');

            var betCount = Object.keys(last_record).length;

            for(var i = 0; i < betCount; i++){

                var last_key = Object.keys(last_record)[Object.keys(last_record).length-1];
                var last_bet = last_record[last_key];
                //console.log(last_bet);
                var className = last_bet.bet;

                if(last_bet.is_win == null){
                    className = last_bet.bet + '-fail'; 
                }

                history =  '<div class="' + className + '">' +
                                '<span class="label">' + last_bet.result +'</span>'
                            '</div>';

                iframe_history.find('#row-' + r).find('.history').append(history);
                delete last_record[last_key];
            }

            delete records[last];
        }
    });
}

function initUser(){
    var user_id = $('#hidUserId', window.parent.document).val();
    //console.log("/api/wallet-detail");
    $.post("/api/wallet-detail", { 'memberid': user_id, 'gameid': 101 }, function(data) {
        console.log(data);
        // Do something with the request
        if(data.success) {
            if (data.record.length === 0) {
                $('#divBalance', window.parent.document).html(0);
                $('#spanPoint', window.parent.document).html(0);
                $('.packet-point', window.parent.document).html(0);
            } else {
                var balance = parseInt(data.record.balance);
                var life = data.record.life;
                var point = parseInt(data.record.point);
                var acupoint =  parseInt(data.record.acupoint);

                $('#divBalance', window.parent.document).html(balance);
                $('#spanPoint', window.parent.document).html(point);
                $('.packet-point', window.parent.document).html(point);
                $('.spanAcuPoint', window.parent.document).html(acupoint);
                $('.packet-acupoint', window.parent.document).html(acupoint);
                $('#hidBalance', window.parent.document).val(balance);
                $(".balance_circle", window.parent.document).html(life);
                $(".spanLife", window.parent.document).html(life);                
                
                setBalance();

                // add points from additional life.
                /*if(user_id > 0 && balance < 630){
                    $.post("/api/resetlife", { 'memberid': user_id, 'gameid': 101, 'life': 'yes' }, function(data) {
                        console.log(data);
                        // Do something with the request
                        if(data.success) {
                            initUser();
                        }
                        
                    }, 'json');
                }*/
            }
        }
        
    }, 'json');
}

function initGame(){
    initUser();
    resetGame();
    updateResult();
    updateHistory();

    var user_id = $('#hidUserId', window.parent.document).val();
    trigger = false;
    //console.log("/api/game-setting?gameid=101&memberid=" + user_id);
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
            var previous_result = data.record.latest_result.game_result;

            $('#hidLevel', window.parent.document).val(level);
            $('#hidLevelId', window.parent.document).val(level_id);
            $('#hidLatestResult', window.parent.document).val(previous_result);

            $('.speech-bubble', window.parent.document).addClass("hide");
            $('.speech-bubble', window.parent.document).next().removeClass("done");
            
            switch (level) {
                default:
                case 1:
                    bet_amount = 10;
                    //$('.level-one', window.parent.document).removeClass("hide");
                    break;
                case 2:
                    bet_amount = 30;
                    //$('.level-two', window.parent.document).removeClass("hide");
                    $('.level-one', window.parent.document).next().addClass("done");
                    break;
                case 3:
                    bet_amount = 70;
                    //$('.level-three', window.parent.document).removeClass("hide");
                    $('.level-one', window.parent.document).next().addClass("done");
                    $('.level-two', window.parent.document).next().addClass("done");
                    break;
                case 4:
                    bet_amount = 150;
                    //$('.level-four', window.parent.document).removeClass("hide");
                    $('.level-one', window.parent.document).next().addClass("done");
                    $('.level-two', window.parent.document).next().addClass("done");
                    $('.level-three', window.parent.document).next().addClass("done");
                    break;
                case 5:
                    bet_amount = 310;
                    //$('.level-five', window.parent.document).removeClass("hide");
                    $('.level-one', window.parent.document).next().addClass("done");
                    $('.level-two', window.parent.document).next().addClass("done");
                    $('.level-three', window.parent.document).next().addClass("done");
                    $('.level-four', window.parent.document).next().addClass("done");
                    break;
                case 6:
                    bet_amount = 630;
                    //$('.level-six', window.parent.document).removeClass("hide");
                    $('.level-one', window.parent.document).next().addClass("done");
                    $('.level-two', window.parent.document).next().addClass("done");
                    $('.level-three', window.parent.document).next().addClass("done");
                    $('.level-four', window.parent.document).next().addClass("done");
                    $('.level-five', window.parent.document).next().addClass("done");
                    break;
            }

            $('.bet-container', window.parent.document).html(bet_amount);

            setBalance();

            $('#freeze_time').val(freeze_time);
            $('#draw_id').val(draw_id);

            DomeWebController.init();
            startTimer(duration, timer, freeze_time);

            bindBetButton();
            bindCalculateButton();

            //console.log("/api/get-game-result-temp?gameid=101&memberid=" + user_id + "&drawid=" + draw_id);
            $.getJSON( "/api/get-game-result-temp?gameid=101&memberid=" + user_id + "&drawid=" + draw_id, function() {
                if(data.success) {
                    //console.log(data.record);
                } else {
                    //console.log(data.message);
                }
            });

        } else {
            //$.getJSON( "/api/generateresult", function() {});
            //console.log("initGame");
            //initGame();
        }

        
    });
}

function resetGame() {
    $('div.clicked', window.parent.document).removeClass('clicked').find('.bet-container').hide();
    $('.instruction', window.parent.document).css('visibility', 'visible');
}

function setBalance() {
    var selected = $('div.clicked', window.parent.document).find('input:radio').val();
    if (typeof selected == 'undefined'){
        //do nothing
    } else {
        var bet_amount = parseInt($('.bet-container', window.parent.document).html());
        var balance = $('#hidBalance', window.parent.document).val();
        var newbalance = balance - bet_amount;
        //console.log(balance + " - " + bet_amount + " = " + newbalance);
        if(newbalance < 0){

        } else {
            $('#divBalance', window.parent.document).html(newbalance);
        }
    }
}

function bindBetButton(){
    //console.log('bindBetButton');
    $('.radio-primary', window.parent.document).click(function(){
        var balance = $('#hidBalance', window.parent.document).val();
        var level = parseInt($('#hidLevel', window.parent.document).val());
        var life = $(".balance_circle", window.parent.document).html();
        var acupoint = $('.spanAcuPoint', window.parent.document).html();
        var draw_id = $('#draw_id').val();

        var user_id = $('#hidUserId', window.parent.document).val();
        if(user_id == 0){
            window.top.location.href = "/member";
        }

        if(isNaN(balance)){
            return false;
        }

        //console.log(user_id +":" + balance + ":" + life );
        if(user_id > 0 && life > 0){

            if(balance < 630) {

                bindResetLifeButton();
                $('#reset-life-lose', window.parent.document).modal();
                return false;

            }
        } else if(user_id > 0 && life == 0){

            if(balance < 630) {

                bindResetLifeButton();
                $('#reset-life-share', window.parent.document).modal();
                return false;

            }
        }


        $('.radio-primary', window.parent.document).not(this).find('.radio').removeClass('clicked');
        $('.radio-primary', window.parent.document).not(this).find('.bet-container').hide();
        $('.speech-bubble', window.parent.document).addClass("hide");

        $(this).find('.bet-container').toggle();
        $(this).find('.radio').toggleClass('clicked');

        var selected = $('div.clicked', window.parent.document).find('input:radio').val();
        if (typeof selected == 'undefined'){

            $('#divBalance', window.parent.document).html(balance);
            $('.instruction', window.parent.document).css('visibility', 'visible');

            //console.log("/api/update-game-result-temp?gameid=101&memberid="+ user_id + "&drawid=" + draw_id + "&bet=&betamt=");
            $.getJSON( "/api/update-game-result-temp?gameid=101&memberid="+ user_id + "&drawid=" + draw_id + "&bet=&betamt=", function( data ) {
                //console.log(data);
            });

        } else {

            var bet_amount = parseInt($('.bet-container', window.parent.document).html());
            var newbalance = balance - bet_amount;

            if(newbalance < 0){
                var selected = $('div.clicked', window.parent.document).removeClass('clicked').find('.bet-container').hide();
                return false;
            } else {
                $('#divBalance', window.parent.document).html(newbalance);
                $('.instruction', window.parent.document).css('visibility', 'hidden');

                //console.log("/api/update-game-result-temp?gameid=101&memberid="+ user_id + "&drawid=" + draw_id + "&bet="+ selected +"&betamt=" + bet_amount);
                $.getJSON( "/api/update-game-result-temp?gameid=101&memberid="+ user_id + "&drawid=" + draw_id + "&bet="+ selected +"&betamt=" + bet_amount, function( data ) {
                    //console.log(data);
                });
            }

            switch (level) {
                default:
                case 1:
                    $('.level-one', window.parent.document).removeClass("hide");
                    break;
                case 2:
                    $('.level-two', window.parent.document).removeClass("hide");
                    break;
                case 3:
                    $('.level-three', window.parent.document).removeClass("hide");
                    break;
                case 4:
                    $('.level-four', window.parent.document).removeClass("hide");
                    break;
                case 5:
                    $('.level-five', window.parent.document).removeClass("hide");
                    break;
                case 6:
                    $('.level-six', window.parent.document).removeClass("hide");
                    break;
            }
        }

    });
}

function bindCalculateButton(){
    $('.btn-calculate', window.parent.document).click(function(){
        var acupoint = $('.spanAcuPoint', window.parent.document).html();
        if(acupoint < 150) {
            bindResetLifeButton();
            $('#reset-life-play', window.parent.document).modal();
        } else if (acupoint >= 150) {
            bindResetLifeButton();
            $('#reset-life-max', window.parent.document).modal();
        }
    });
}

function bindResetLifeButton(){

    $('.btn-reset-life', window.parent.document).click(function(){
        var balance = $('#hidBalance', window.parent.document).val();
        var life = $(".balance_circle", window.parent.document).html();
        var user_id = $('#hidUserId', window.parent.document).val();
        var acupoint = $('.spanAcuPoint', window.parent.document).html();

        // add points from additional life.
        if(user_id > 0){
            $.post("/api/resetlife", { 'memberid': user_id, 'gameid': 101, 'life': 'yes' }, function(data) {
                console.log(data);
                // Do something with the request
                if(data.success) {
                    $('#reset-life-lose', window.parent.document).modal('hide');
                    $('#reset-life-max', window.parent.document).modal('hide');
                    initUser();
                }
                
            }, 'json');
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

        } else if (timer <= trigger_time) {
            //Lock the selection
            $('.radio-primary', window.parent.document).unbind('click');

            if (trigger == false) {
                var freeze_time = timer + 1;
                $('#freeze_time').val(freeze_time);

                //Get selected option
                var selected = $('div.clicked', window.parent.document).find('input:radio').val();
                var bet_amount = $('.bet-container', window.parent.document).html();
                var draw_id = $('#draw_id').val();
                var user_id = $('#hidUserId', window.parent.document).val();
                var level_id = $('#hidLevelId', window.parent.document).val();

                //console.log("Selected: "+selected+ " Bet Amount: "+bet_amount+ " Draw Id:"+draw_id+" User Id: "+user_id);   
                console.log("/api/update-game-result");
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
                        'items': {1: [360, 360], 2: [60, 60], 3: [120, 120], 4: [180, 180], 5: [240, 240], 6: [300, 300]},//奖品角度配置{键:[开始角度,结束角度],键:[开始角度,结束角度],......}
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
                    trigger = true;
                }, 'json');
            }
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
        var startKey = $('#hidLatestResult', window.parent.document).val();

        that.getEle("$wheelContainer").wheelOfFortune({
            'wheelImg': "/client/images/wheel.png",//转轮图片
            'pointerImg': "/client/images/pointer.png",//指针图片
            'buttonImg': "/client/images/button.png",//开始按钮图片
            'wSide': 260,//转轮边长(默认使用图片宽度)
            'pSide': 100,//指针边长(默认使用图片宽度)
            'bSide': 50,//按钮边长(默认使用图片宽度)
            'items': {1: [360, 360], 2: [60, 60], 3: [120, 120], 4: [180, 180], 5: [240, 240], 6: [300, 300]},//奖品角度配置{键:[开始角度,结束角度],键:[开始角度,结束角度],......}
                    
            'pAngle': 0,//指针图片中的指针角度(x轴正值为0度，顺时针旋转 默认0)
            'type': 'w',//旋转指针还是转盘('p'指针 'w'转盘 默认'p')
            'fluctuate': 0.5,//停止位置距角度配置中点的偏移波动范围(0-1 默认0.8)
            'rotateNum': 12,//转多少圈(默认12)
            'duration': freeze_time * 1000,//转一次的持续时间(默认5000)
            'startKey' : startKey,
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