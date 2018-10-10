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

    $.getJSON( "/api/betting-history/101", function( data ) {
        //console.log(data.records);
        /*var records = data.records.data;

        $.each(records, function(i, item) {
            var counter = i + 1;
            iframe_result.find('#result-' + counter).html(item.result);
        });*/
    });
}

function initUser(){
    var user_id = $('#hidUserId', window.parent.document).val();
    $.post("/api/wallet-detail", { 'memberid': user_id, gameid: 101 }, function(data) {
        console.log(data);
        // Do something with the request
        if(data.success) {
            if (data.record.length === 0) {
                $('#spanBalance', window.parent.document).html(0);
                $('#divLife', window.parent.document).html(0);
                $('#divPoint', window.parent.document).html(0);
            } else {
                var bet_amount = 0;
                var balance = parseInt(data.record[0].balance);
                var level = data.record[0].level;
                var life = data.record[0].life;
                var point = parseInt(data.record[0].point);

                $('#spanBalance', window.parent.document).html(balance);
                $('#divLife', window.parent.document).html(life);
                $('#divPoint', window.parent.document).html(point);
                $('#hidPoint', window.parent.document).html(point);
                $('#hidLevel', window.parent.document).val(level);

                $('.speech-bubble', window.parent.document).hide();
                
                switch (level) {
                    case 1:
                        bet_amount = 10;
                        $('.level-one', window.parent.document).show();
                        break;
                    case 2:
                        bet_amount = 30;
                        $('.level-two', window.parent.document).show();
                        break;
                    case 3:
                        bet_amount = 70;
                        $('.level-three', window.parent.document).show();
                        break;
                    case 4:
                        bet_amount = 150;
                        $('.level-four', window.parent.document).show();
                        break;
                    case 5:
                        bet_amount = 310;
                        $('.level-five', window.parent.document).show();
                        break;
                    case 6:
                        bet_amount = 630;
                        $('.level-six', window.parent.document).show();
                        break;
                }

                $('.bet-container', window.parent.document).html(bet_amount);
            }
        }
        
    }, 'json');
}

function initGame(){
    initUser();
    bindBetButton();
    updateResult();
    updateHistory();

    $.getJSON( "/api/game-play-time/101", function( data ) {
        if(data.success) {
            var duration = data.record.duration;
            var timer = data.record.remaining_time;
            var freeze_time = data.record.freeze_time;
            var draw_id = data.record.drawid;

            $('#freeze_time').val(freeze_time);
            $('#draw_id').val(draw_id);

            DomeWebController.init();
            startTimer(duration, timer, freeze_time);
        } else {
            $.getJSON( "/api/generateresult", function() {});

            initGame();
        }

        
    });
}

function bindBetButton(){

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

            //console.log("Selected: "+selected+ " Bet Amount: "+bet_amount+ " Draw Id:"+draw_id+" User Id: "+user_id);   
            $.post("/api/update-game-result", { 
                gameid : 101, 
                memberid : user_id, 
                drawid : draw_id, 
                bet : selected, 
                betamt : bet_amount 
            }, 
            function(data) {
                console.log(data.game_result);
                var freeze_time = $('#freeze_time').val();
                var result = data.game_result;
                $('#result').val(result);

                //Trigger the wheel
                DomeWebController.getEle("$wheelContainer").wheelOfFortune({
                    'items': {3: [1, 59], 4: [61, 119], 5: [121, 179], 6: [181, 239], 1: [241, 299], 2: [301, 359]},//奖品角度配置{键:[开始角度,结束角度],键:[开始角度,结束角度],......}
                    'pAngle': 270,//指针图片中的指针角度(x轴正值为0度，顺时针旋转 默认0)
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
            'items': {3: [1, 59], 4: [61, 119], 5: [121, 179], 6: [181, 239], 1: [241, 299], 2: [301, 359]},//奖品角度配置{键:[开始角度,结束角度],键:[开始角度,结束角度],......}
            'pAngle': 270,//指针图片中的指针角度(x轴正值为0度，顺时针旋转 默认0)
            'type': 'w',//旋转指针还是转盘('p'指针 'w'转盘 默认'p')
            'fluctuate': 0.5,//停止位置距角度配置中点的偏移波动范围(0-1 默认0.8)
            'rotateNum': 12,//转多少圈(默认12)
            'duration': freeze_time * 1000,//转一次的持续时间(默认5000)
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