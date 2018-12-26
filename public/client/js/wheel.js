var trigger = false;

$(function () {
    var wechat_status = $('#hidWechatId', window.parent.document).val();
    var wechat_name = $('#hidWechatName', window.parent.document).val();

    if(wechat_status == 0 && wechat_name != null) {
        getToken();
        closeModal();
    }
    
});

function updateResult(token){

    var iframe_result = $('#ifm_result', window.parent.document).contents();

    $.ajax({
        type: 'GET',
        url: "/api/result-history/101",
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {

            var records = data.records.data;

            $.each(records, function(i, item) {
                var counter = i + 1;
                iframe_result.find('#result-' + counter).html(item.result);
            });
        }
    });
}

function updateHistory(token){

    var iframe_history = $('#ifm_history', window.parent.document).contents();
    var user_id = $('#hidUserId', window.parent.document).val();

    $.ajax({
        type: 'GET',
        url: "/api/betting-history?gameid=101&memberid=" + user_id,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {

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
        }
    });
}

function initUser(token){
    bindRulesButton(token);

    var user_id = $('#hidUserId', window.parent.document).val();

    $.ajax({
        type: 'POST',
        url: "/api/wallet-detail",
        data: { 'memberid': user_id, 'gameid': 101 },
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            console.log(data);
            // Do something with the request
            if(data.success) {
                if (data.record.length === 0) {
                    $('#spanPoint', window.parent.document).html(0);
                    $('.packet-point', window.parent.document).html(0);
                } else {
                    var balance = parseInt(data.record.balance);
                    var life = data.record.life;
                    var point = parseInt(data.record.point);
                    var acupoint =  parseInt(data.record.acupoint);

                    if(life == 0){
                        balance = 0;
                    }

                    var total_balance = balance + acupoint;
                    $('#spanPoint', window.parent.document).html(total_balance);
                    
                    $('#hidTotalBalance', window.parent.document).val(total_balance);
                    $('.packet-point', window.parent.document).html(point);
                    $('.spanAcuPoint', window.parent.document).html(acupoint);
                    $('.packet-acupoint', window.parent.document).html(acupoint);
                    $('#hidBalance', window.parent.document).val(balance);
                    $(".nTxt", window.parent.document).html(life);
                    $(".spanLife", window.parent.document).html(life);

                    setBalance();

                    if(life == 0){
                        $('#reset-life-share', window.parent.document).modal();
                    } else if (user_id > 0 && acupoint >= 150) {
                        bindResetLifeButton(token);
                        $('#reset-life-max', window.parent.document).modal({backdrop: 'static', keyboard: false});
                    }

                    $.ajax({
                        type: 'GET',
                        url: "/api/get-game-notification?gameid=101&memberid=" + user_id,
                        dataType: "json",
                        beforeSend: function( xhr ) {
                            xhr.setRequestHeader ("Authorization", "Bearer " + token);
                        },
                        error: function (error) { console.log(error.responseText) },
                        success: function(data) {
                            if(!data.record && point < 150){
                                $('.rules-bubble', window.parent.document).show();
                            }
                        }
                    });
                }
            }
            
        }
    });
}

function initGame(token){
    $( '.btn-reset-life', window.parent.document ).unbind( "click" );
    $( '.btn-reset-life-continue', window.parent.document ).unbind( "click" );
    
    var user_id = $('#hidUserId', window.parent.document).val();
    trigger = false;
    
    $.ajax({
        type: 'GET',
        url: "/api/game-setting?gameid=101&memberid=" + user_id,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            console.log(data);
            if(data.success) {
                var bet_amount = 0;
                var duration = data.record.duration;
                var timer = data.record.remaining_time;
                var freeze_time = data.record.freeze_time;
                var draw_id = data.record.drawid;
                var level = data.record.level.position;
                var level_id = data.record.level.levelid;
                var previous_result = data.record.latest_result.game_result;
                var consecutive_lose = data.record.consecutive_lose;
                var life = $(".nTxt", window.parent.document).html();
                var balance = $('#hidBalance', window.parent.document).val();
                var payout_info = '';

                $('#hidLevel', window.parent.document).val(level);
                $('#hidLevelId', window.parent.document).val(level_id);
                $('#hidLatestResult', window.parent.document).val(previous_result);
                $('#hidConsecutiveLose', window.parent.document).val(consecutive_lose);

                $('.speech-bubble', window.parent.document).addClass("hide");
                $('.speech-bubble', window.parent.document).next().removeClass("done").removeClass("active").find('.label').html('');
                
                if (consecutive_lose == 'yes' && life > 0 && balance == 0) {
                    bindResetLifeButton(token);
                    $('#reset-life-lose', window.parent.document).modal();
                }

                switch (level) {

                    default:
                    case 1:
                        bet_amount = 10;
                        payout_info = '猜中得10，赚10挖宝币。';
                        $('.barBox', window.parent.document).addClass("barBox-1");
                        $('.barBox', window.parent.document).removeClass("barBox-2");
                        $('.barBox', window.parent.document).removeClass("barBox-3");
                        $('.barBox', window.parent.document).removeClass("barBox-4");
                        $('.barBox', window.parent.document).removeClass("barBox-5");
                        $('.barBox', window.parent.document).removeClass("barBox-6");

                        $('.span-1', window.parent.document).html("10");
                        $('.span-2', window.parent.document).html("30");
                        $('.span-3', window.parent.document).html("70");
                        $('.span-4', window.parent.document).html("150");
                        $('.span-5', window.parent.document).html("310");

                        if(balance == 1200) {
                            $('.button-card', window.parent.document).click(function(){
                                $('#game-rules', window.parent.document).modal('show');
                            });    
                        }

                        break;
                    case 2:
                        bet_amount = 30;
                        payout_info = '猜中得30，扣除之前亏损10，赚20挖宝币。';
                        $('.barBox', window.parent.document).addClass("barBox-2");
                        $('.barBox', window.parent.document).removeClass("barBox-1");
                        $('.span-1', window.parent.document).html("-10");                        
                        break;
                    case 3:                    
                        bet_amount = 70;
                        payout_info = '猜中得70，扣除前2次亏损40，赚30挖宝币。';
                        $('.barBox', window.parent.document).addClass("barBox-3");
                        $('.barBox', window.parent.document).removeClass("barBox-2");
                        $('.span-1', window.parent.document).html("-10");
                        $('.span-2', window.parent.document).html("-30");
                        break;
                    case 4:
                        bet_amount = 150;
                        payout_info = '猜中得150，扣除前3次亏损110，赚40挖宝币。';
                        $('.barBox', window.parent.document).addClass("barBox-4");
                        $('.barBox', window.parent.document).removeClass("barBox-3");
                        $('.span-1', window.parent.document).html("-10");
                        $('.span-2', window.parent.document).html("-30");
                        $('.span-3', window.parent.document).html("-70");
                        break;
                    case 5:
                        bet_amount = 310;
                        payout_info = '猜中得310，扣除前4次亏损260，赚50挖宝币。';
                        $('.barBox', window.parent.document).addClass("barBox-5");
                        $('.barBox', window.parent.document).removeClass("barBox-4");
                        $('.span-1', window.parent.document).html("-10");
                        $('.span-2', window.parent.document).html("-30");
                        $('.span-3', window.parent.document).html("-70");
                        $('.span-4', window.parent.document).html("-150");
                        break;
                    case 6:
                        bet_amount = 630;
                        payout_info = '猜中得630，扣除前5次亏损570，赚60挖宝币。';
                        $('.barBox', window.parent.document).addClass("barBox-6");
                        $('.barBox', window.parent.document).removeClass("barBox-5");
                        $('.span-1', window.parent.document).html("-10");
                        $('.span-2', window.parent.document).html("-30");
                        $('.span-3', window.parent.document).html("-70");
                        $('.span-4', window.parent.document).html("-150");
                        $('.span-5', window.parent.document).html("-310");
                        break;
                }

                $('.span-balance', window.parent.document).html(balance);
                $('.payout-info', window.parent.document).html(payout_info).addClass('hide');
                $('.bet-container', window.parent.document).html(bet_amount);

                setBalance();

                $('#freeze_time').val(freeze_time);
                $('#draw_id').val(draw_id);

                DomeWebController.init();
                startTimer(duration, timer, freeze_time, token);

                bindBetButton(token);
                bindCalculateButton(token);

                $(".se-pre-con", window.parent.document).fadeOut("slow");

                $.ajax({
                    type: 'GET',
                    url: "/api/get-game-result-temp?gameid=101&gametype=1&memberid=" + user_id + "&drawid=" + draw_id,
                    dataType: "json",
                    beforeSend: function( xhr ) {
                        xhr.setRequestHeader ("Authorization", "Bearer " + token);
                    },
                    error: function (error) { console.log(error) },
                    success: function(data) {

                        if(data.success && data.record.bet != null){
                            var selected = data.record.bet;
                            var total_balance = parseInt($('#hidTotalBalance', window.parent.document).val());
                            var bet_amount = parseInt(data.record.betamt);
                            var newtotalbalance = total_balance - bet_amount;

                            var btn_rectangle = $("input[value='"+ selected +"']", window.parent.document).parent();
                            btn_rectangle.addClass('clicked');
                            btn_rectangle.find('.bet-container').show();
                            btn_rectangle.find('.bet').show();

                            $('#spanPoint', window.parent.document).html(newtotalbalance);
                            $('.instruction', window.parent.document).css('visibility', 'hidden');

                            $.ajax({
                                type: 'GET',
                                url: "/api/update-game-result-temp?gameid=101&gametype=1&memberid="+ user_id 
                                + "&drawid=" + draw_id 
                                + "&bet="+ selected 
                                +"&betamt=" + bet_amount,
                                dataType: "json",
                                beforeSend: function( xhr ) {
                                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                                },
                                error: function (error) { console.log(error.responseText) },
                                success: function(data) {
                                }
                            });
                        }
                    }
                }); // ajax get-game-result-temp
            }
        }
    });
}

function getToken(){
    var id = $('#hidUserId', window.parent.document).val();
    var session = $('#hidSession', window.parent.document).val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            $('#hidToken', window.parent.document).val(data.access_token);
            initUser(data.access_token);
            resetGame();
            updateResult(data.access_token);
            updateHistory(data.access_token);
            initGame(data.access_token);
        } else {
            return false;
        }      
    });
}

function resetGame() {
    $('div.clicked', window.parent.document).find('.bet').hide();
    $('div.clicked', window.parent.document).removeClass('clicked').find('.bet-container').hide();
    $('.instruction', window.parent.document).css('visibility', 'visible');
}

function setBalance() {
    var selected = $('div.clicked', window.parent.document).find('input:radio').val();
    if (typeof selected == 'undefined'){
        //do nothing
    } else {
        var bet_amount = parseInt($('.bet-container', window.parent.document).html());
        var total_balance = parseInt($('#hidTotalBalance', window.parent.document).val());
        var balance = parseInt($('#hidBalance', window.parent.document).val());
        var acupoint = parseInt($('.spanAcuPoint', window.parent.document).html());

        var newbalance = balance - bet_amount;
        var newtotalbalance = total_balance - bet_amount;
        //console.log(balance + " - " + bet_amount + " = " + newbalance);
        if(newbalance < 0){

        } else {
            $('#spanPoint', window.parent.document).html(newtotalbalance);
        }
    }
}

function closeModal() {
    $('.close-modal', window.parent.document).click(function(){
        $('#reset-life-play', window.parent.document).modal('hide');
        $('#reset-life-bet', window.parent.document).modal('hide');
        $('#reset-life-lose', window.parent.document).modal('hide');
    });
}

function bindBetButton(token){
    $('.radio-primary', window.parent.document).click(function(){
        var balance = parseInt($('#hidBalance', window.parent.document).val());
        var total_balance = parseInt($('#hidTotalBalance', window.parent.document).val());
        var level = parseInt($('#hidLevel', window.parent.document).val());
        var life = $(".nTxt", window.parent.document).html();
        var acupoint = parseInt($('.spanAcuPoint', window.parent.document).html());
        var draw_id = $('#draw_id').val();
        var consecutive_lose = $('#hidConsecutiveLose', window.parent.document).val();

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
                if(consecutive_lose == 'yes'){
                    bindResetLifeButton(token);
                    $('#reset-life-lose', window.parent.document).modal();
                } else {
                    bindResetLifeButton(token);
                    $('#reset-life-start', window.parent.document).modal();
                }

            }

        } else if(user_id > 0 && life == 0){
                $('#reset-life-share', window.parent.document).modal();
        }

        if (user_id > 0 && acupoint >= 150) {
            bindResetLifeButton(token);
            $('#reset-life-max', window.parent.document).modal();
        }


        $('.radio-primary', window.parent.document).not(this).find('.radio').removeClass('clicked');
        $('.radio-primary', window.parent.document).not(this).find('.bet-container').hide();
        $('.radio-primary', window.parent.document).not(this).find('.bet').hide();
        $('.speech-bubble', window.parent.document).addClass("hide");

        $(this).find('.bet-container').toggle();
        $(this).find('.bet').toggle();
        $(this).find('.radio').toggleClass('clicked');

        var selected = $('div.clicked', window.parent.document).find('input:radio').val();
        if (typeof selected == 'undefined'){

            $('#spanPoint', window.parent.document).html(total_balance);
            $('.instruction', window.parent.document).css('visibility', 'visible');
            $('.payout-info', window.parent.document).addClass("hide");
            $('.span-balance', window.parent.document).html(balance);
            
            $.ajax({
                type: 'GET',
                url: "/api/update-game-result-temp?gameid=101&gametype=1&memberid="+ user_id 
                + "&drawid=" + draw_id 
                + "&bet=&betamt=",
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { console.log(error.responseText) },
                success: function(data) {
                }
            });

        } else {

            var bet_amount = parseInt($('.bet-container', window.parent.document).html());
            var newbalance = balance - bet_amount;
            var newtotalbalance = total_balance - bet_amount;

            if(newbalance < 0){
                 $('div.clicked', window.parent.document).find('.bet').hide();
                $('div.clicked', window.parent.document).removeClass('clicked').find('.bet-container').hide();
                return false;
            } else {
                $('#spanPoint', window.parent.document).html(newtotalbalance);
                $('.instruction', window.parent.document).css('visibility', 'hidden');

                $.ajax({
                    type: 'GET',
                    url: "/api/update-game-result-temp?gameid=101&gametype=1&memberid="+ user_id 
                    + "&drawid=" + draw_id 
                    + "&bet="+ selected 
                    + "&betamt=" + bet_amount
                    + "&level=" + level,
                    dataType: "json",
                    beforeSend: function( xhr ) {
                        xhr.setRequestHeader ("Authorization", "Bearer " + token);
                    },
                    error: function (error) { console.log(error.responseText) },
                    success: function(data) {
                    }
                });
            }

            $('.payout-info', window.parent.document).removeClass("hide");
            $('.span-balance', window.parent.document).html(newbalance);
        }

    });
}

function bindCalculateButton(token){
    $('.btn-calculate', window.parent.document).click(function(){
        var acupoint = $('.spanAcuPoint', window.parent.document).html();
        var selected = $('div.clicked', window.parent.document).find('input:radio').val();
        var level = parseInt($('#hidLevel', window.parent.document).val());
        var consecutive_lose = $('#hidConsecutiveLose', window.parent.document).val();

        if (typeof selected == 'undefined'){
            if (acupoint == 0 || level > 1) {
                $('#reset-life-bet', window.parent.document).modal();
            } else if (level == 1 && consecutive_lose == 'yes') {
                bindResetLifeButton(token);
                $('#reset-life-lose', window.parent.document).modal();
            } else if(acupoint > 0 && acupoint < 150) {
                bindResetLifeButton(token);
                $('#reset-life-play', window.parent.document).modal();
            } else if (acupoint >= 150) {
                bindResetLifeButton(token);
                $('#reset-life-max', window.parent.document).modal();
            }
        } else {
            $('#reset-life-bet', window.parent.document).modal();
        }
    });
}

function bindResetLifeButton(token){
    $( '.btn-reset-life', window.parent.document ).click( function(){
        var user_id = $('#hidUserId', window.parent.document).val();

        // add points from additional life.
        if(user_id > 0){
            $.ajax({
                type: 'POST',
                url: "/api/resetlife",
                data: { 'memberid': user_id, 'gameid': 101, 'life': 'yes' },
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { console.log(error.responseText) },
                success: function(data) {
                    if(data.success){
                        window.parent.location.href = "/redeem";
                    }
                }
            });
        }
    });

    $( '.btn-reset-life-continue', window.parent.document ).click( function(){
        var user_id = $('#hidUserId', window.parent.document).val();

        // add points from additional life.
        if(user_id > 0){
            $.ajax({
                type: 'POST',
                url: "/api/resetlife",
                data: { 'memberid': user_id, 'gameid': 101, 'life': 'yes' },
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { console.log(error.responseText) },
                success: function(data) {
                    if(data.success){
                        $('#reset-life-max', window.parent.document).modal('hide');
                        $('#reset-life-play', window.parent.document).modal('hide');
                        $('#reset-life-lose', window.parent.document).modal('hide');
                        $('#reset-life-start', window.parent.document).modal('hide');
                        getToken();
                    }
                }
            });
        }
    });
}

function bindRulesButton(token){

    $('.btn-rules', window.parent.document).click(function(){
        var user_id = $('#hidUserId', window.parent.document).val();

        // add points from additional life.
        if(user_id > 0){
            $.ajax({
                type: 'POST',
                url: "/api/change-game-notification",
                data: { 'memberid': user_id, 'gameid': 101, 'flag': 0 },
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { console.log(error.responseText) },
                success: function(data) {
                    $('.rules-bubble', window.parent.document).hide();
                }
            });
        }
    });
}

function startTimer(duration, timer, freeze_time, token) {

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
            getToken();

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

                $.ajax({
                    type: 'POST',
                    url: "/api/update-game-result",
                    data: { 
                        gameid : 101, 
                        memberid : user_id, 
                        drawid : draw_id, 
                        bet : selected, 
                        betamt : bet_amount,
                        level : level_id
                    }, 
                    dataType: "json",
                    beforeSend: function( xhr ) {
                        xhr.setRequestHeader ("Authorization", "Bearer " + token);
                    },
                    error: function (error) { console.log(error.responseText) },
                    success: function(data) {
                        var freeze_time = $('#freeze_time').val();
                        var result = data.game_result;
                        $('#result').val(result);

                        if(data.status == 'win'){
                            var level = parseInt($('#hidLevel', window.parent.document).val());
                            var win_amount = level * 10;

                            $('.instruction', window.parent.document).html('恭喜你猜对了，赚了'+ win_amount +'挖宝币！');
                        } else if (data.status == 'lose') {
                            var level = parseInt($('#hidLevel', window.parent.document).val());
                            var chance = 6 - level;

                            $('.instruction', window.parent.document).html('很遗憾猜错了，你还有'+ chance +'次机会！');
                        }

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
                    }
                });
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