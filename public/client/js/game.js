var trigger = false;
var timerInterval = 0;
var update_wallet = false;
var wallet_data = null;
var update_betting_history = false;
var betting_data = null;
var token = '';
var show_win = false;
var show_lose = false;
var g_previous_point = 0;
var g_current_point = 0;

$(function () {

	$('.swiper-container').flickity({
		// options
		draggable: true,
		wrapAround: true,
		pageDots: false,
		initialIndex: 1,
		freeScroll: false,
		contain: true,
	});

	$('.swiper-container').on( 'change.flickity', function( event, index ) {
		resetTimer();
	});

	var wechat_status = $('#hidWechatId').val();
    var wechat_name = $('#hidWechatName').val();

    if(wechat_status == 0 && wechat_name != null) {

        getSocket();
        closeModal();

        ifvisible.on("wakeup", function(){
            resetTimer();
        });

    } else {
        $(".loading").fadeOut("slow");
        return false;
    }

});

function updateResult(records){
    var counter = 0;
    $.each(records, function(i, item) {
        var list = i + 1;
        $('.results-body').find('#result-' + list).html(item.result);
        counter++;
        return counter < 25;
    });
}

function updateHistory(records){

    var length = Object.keys(records).length;
    var maxCount = 7;

    if(length < maxCount){
        maxCount = parseInt(length);
    }
    //console.log(records);
    for(var r = 1; r <= maxCount; r++){
        var last = Object.keys(records)[Object.keys(records).length-1];
        var last_record = records[last];
        var history = '';

        $('.history-body').find('#row-' + r).find('.history-number').html(last);
        $('.history-body').find('#row-' + r).find('.history').html('');

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
                            '<span class="history-label">' + last_bet.result +'</span>'
                        '</div>';

            $('.history-body').find('#row-' + r).find('.history').append(history);
            delete last_record[last_key];
        }

        delete records[last];
    }
}

function initUser(records){

    var user_id = $('#hidUserId').val();

    if (jQuery.isEmptyObject(records)) {
        $('#spanPoint').html(0);
        $('.packet-point').html(0);
    } else {
        var balance = parseInt(records.balance);
        var life = records.life;
        var point = parseInt(records.point);
        var acupoint =  parseInt(records.acupoint);
        g_current_point = parseInt(records.acupoint);

        if(life == 0){
            balance = 0;
        }

        var total_balance = balance + acupoint;
        $('#spanPoint').html(total_balance);
        
        $('#hidTotalBalance').val(total_balance);
        $('.packet-point').html(point);
        if(show_win){
            show_win = false;
        } else {
            $('.spanAcuPoint').html(acupoint);
        }
        $('.packet-acupoint').html(acupoint);
        $('#hidBalance').val(balance);
        $(".nTxt").html(life);
        $(".spanLife").html(life);

        setBalance();

        if(life == 0){
            $('#reset-life-share').modal();
        } else if (user_id > 0 && acupoint >= 150) {
            bindResetLifeButton();
            $('#reset-life-max').modal({backdrop: 'static', keyboard: false});
        }
    }
}

function initGame(data, level, latest_result, consecutive_lose){

    var user_id = $('#hidUserId').val();
    trigger = false;

        var bet_amount = 0;
        var duration = data.duration;
        var timer = data.remaining_time;
        var freeze_time = data.freeze_time;
        var draw_id = data.drawid;
        var level = level.position;
        var level_id = level.levelid;
        var previous_result = latest_result.game_result;
        var consecutive_lose = consecutive_lose;
        var life = $(".nTxt").html();
        var balance = $('#hidBalance').val();
        var payout_info = '';
        var acupoint = parseInt($('.spanAcuPoint').html());

        $('#hidLevel').val(level);
        $('#hidLevelId').val(level_id);
        $('#hidLatestResult').val(previous_result);
        $('#hidConsecutiveLose').val(consecutive_lose);

        $('.barBox').find('li').removeClass('on');

        if (consecutive_lose == 'yes' && life > 0) {
            showProgressBar(false);
            bindResetLifeButton();
            $('#reset-life-lose').modal({backdrop: 'static', keyboard: false});
        }

        showProgressBar(false);

        setBalance();

        $('#freeze_time').val(freeze_time);
        $('#draw_id').val(draw_id);

        DomeWebController.init();
        trigger = false;
        clearInterval(parent.timerInterval);
        startTimer(duration, timer, freeze_time);

        var show_game_rules = Cookies.get('show_game_rules');

        if (timer <= freeze_time) {
            $('.radio-primary').unbind('click');
        } else if (balance == 1200 && acupoint == 0) {
            bindBetButton();
        } else {
            Cookies.remove('show_game_rules');
            bindBetButton();
        }

        bindCalculateButton();

        $(".loading").fadeOut("slow");

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

                    showProgressBar(true);

                    var selected = data.record.bet;
                    var total_balance = parseInt($('#hidTotalBalance').val());
                    var bet_amount = parseInt(data.record.betamt);
                    var newtotalbalance = total_balance - bet_amount;

                    var btn_rectangle = $("input[value='"+ selected +"']").parent();
                    btn_rectangle.addClass('clicked');
                    btn_rectangle.find('.bet-container').show();
                    btn_rectangle.find('.bet').show();

                    //$('#spanPoint').html(newtotalbalance);
                    $('.instruction').css('visibility', 'hidden');

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

function getSocket(){
            
    var c_url = url + ':' + port;

    var user_id = $('#hidUserId').val();

        $.ajax({
            url: '/token'
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            if(errorThrown == 'Unauthorized'){
                $(".loading").fadeOut("slow");
                $('#red-packet-modal').modal({backdrop: 'static', keyboard: false});
            }
        })
        .done(function (result, textStatus, jqXHR) {
            console.log('connecting URL: '+c_url);
            var socket = new io.connect(c_url, {
                'reconnection': true,
                'reconnectionDelay': 1000,
                'reconnectionDelayMax' : 5000,
                'reconnectionAttempts': 2,
                 query: 'token='+result.token
            });

            /* 
            connect with socket io
            */
            socket.on('connect', function () {
                console.log('Connected to SocketIO, Authenticating');
                //console.log('Token: '+result.token);
                socket.emit('authenticate', {token: result.token});
            });

            /* 
            If token authenticated successfully then here will get message 
            */
            socket.on('authenticated', function () {
                console.log('Authenticated');
                $(".loading").fadeOut("slow");
            });

            /* 
            If token unauthorized then here will get message 
            */
            socket.on('unauthorized', function (data) {
                console.log('Unauthorized, error msg: ' + data.message);
                $(".reload").show();
            });

            /* 
            If disconnect socketio then here will get message 
            */
            socket.on('disconnect', function () {
                console.log('Disconnected');
                $(".reload").show();
            });

            //On user logout
            socket.on('userlogout-' + user_id, function (data) {
                console.log('user-logout');
            });

            //on page load game setting Script
            socket.on("loadsetting-" + user_id + ":App\\Events\\EventGameSetting", function(data){
                console.log('load user game setting-on page load');
                console.log(data);

                var game_records = data.data.gamesetting;
                var level = data.data.level;
                var latest_result = data.data.latest_result;
                var consecutive_lose = data.data.consecutive_lose;
                var result_records = data.data.gamehistory.data;
                var wallet_records = data.data.wallet;
                var betting_records = groupHistory(data.data.bettinghistory.data);
                var isFirstLifeWin = data.data.IsFirstLifeWin;
                
                if(isFirstLifeWin == 'yes'){
                    $('.btn-rules-normal').html('游戏规则说明').addClass('padding-left');
                    $('.btn-vip-modal').on('click', showGameRules);
                } else {
                    $('.btn-vip-modal').click(function(){
                        $('#vip-modal').modal('show');
                    });
                }
                
                var id = $('#hidUserId').val();
                var session = $('#hidSession').val();

                $.ajax({
                    type: 'GET',
                    url: "/api/gettoken?id=" + id + "&token=" + session,
                    dataType: "json",
                    error: function (error) { $(".reload").show(); },
                    success: function(data) {
                        token = data.access_token;
                        initUser(wallet_records);
                        initGame(game_records, level, latest_result, consecutive_lose);
                        updateResult(result_records);
                        updateHistory(betting_records);
                    }
                });

             });

            //init setting Script
            socket.on("initsetting-" + user_id + ":App\\Events\\EventGameSetting", function(data){
                console.log('user-initsetting');
                console.log(data);

                resetGame();
                var game_records = data.data.gamesetting;
                var level = data.data.level;
                var latest_result = data.data.latest_result;
                var consecutive_lose = data.data.consecutive_lose;
                var result_records = data.data.gamehistory.data;
                
                var id = $('#hidUserId').val();
                var session = $('#hidSession').val();

                initGame(game_records, level, latest_result, consecutive_lose);
                updateResult(result_records);

                if(update_wallet){
                    initUser(wallet_data);
                    update_wallet = false;
                }

                if(update_betting_history){
                    updateHistory(betting_data);
                    update_betting_history = false;
                }
             });

            //No betting
            socket.on("no-betting-user-" + user_id + ":App\\Events\\EventNoBetting" , function(data){
                console.log('call no-betting');
                console.log(data);

                $('#result').val(data.data.game_result);
                triggerResult();
            });

            //betting
            socket.on("userbetting-" + user_id + ":App\\Events\\EventBetting" , function(data){
                console.log('call userbetting');
                console.log(data);

                if(data.data.status == 'win'){
                    var level = parseInt($('#hidLevel').val());
                    var win_amount = level * 10;

                    $('.instruction').html('恭喜你猜对了，赚了'+ win_amount +'金币！');

                    if(data.data.IsFirstLifeWin == 'yes'){
                        show_win = true;
                        showWinModal();
                    }

                } else if (data.data.status == 'lose') {
                    var level = parseInt($('#hidLevel').val());
                    var chance = 6 - level;

                    $('.instruction').html('很遗憾猜错了，你还有'+ chance +'次机会！');

                    if(data.data.IsFirstLifeWin == 'yes'){
                        show_lose = true;
                        showLoseModal();
                    }
                }

                $('#result').val(data.data.game_result);
                triggerResult();
            });

            //wallet changes -- new --
            socket.on("wallet-" + user_id + ":App\\Events\\EventWalletUpdate", function(data){
                console.log('member wallet details');
                console.log(data);

                g_previous_point = parseInt($('.spanAcuPoint').html());
                wallet_data = data.data;
                update_wallet = true;
                
            });

            //betting history 
            socket.on("bettinghistory-" + user_id + ":App\\Events\\EventBettingHistory", function(data){
                console.log('members recent bettinghistory');
                console.log(data);

                betting_data = groupHistory(data.data.data);
                update_betting_history = true;

            });          
        });
}

function groupHistory(records) {

    var newOptions = [];
    var prev_level = 0;
    var counter = 0;

    if (records.length > 0)
    {
        $.each(records, function(i, item) {
            var level = item.player_level;

            if(prev_level == level) {
                counter++;
            } else {
                counter = 0;
                newOptions[level] = [];
                prev_level = item.player_level;
            }

            newOptions[level][counter] = item;
        });       
    }

    return newOptions;
}

function resetTimer(){
    var user_id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/game-setting?gameid=101&memberid=" + user_id,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            var duration = data.record.duration;
            var timer = data.record.remaining_time;
            var freeze_time = data.record.freeze_time;

            trigger = false;
            clearInterval(parent.timerInterval);
            startTimer(duration, timer, freeze_time);
        }
    });
}

function resetGame() {
    $('.radio-primary').unbind('click');
    $('div.clicked').find('.bet').hide();
    $('div.clicked').removeClass('clicked').find('.bet-container').hide();
    $('.payout-info').addClass('hide');
    $('.instruction').css('visibility', 'visible');
    $('.spinning').css('visibility', 'hidden');

    if(show_win){
        $('#win-modal').modal({backdrop: 'static', keyboard: false});
        closeWinModal();
    }

    if(show_lose){
        $('#win-modal').modal({backdrop: 'static', keyboard: false});
        show_lose = false;
        closeWinModal();
    }
}

function setBalance() {
    var selected = $('div.clicked').find('input:radio').val();
    if (typeof selected == 'undefined'){
        //do nothing
    } else {
        var bet_amount = parseInt($('.bet-container').html());
        var total_balance = parseInt($('#hidTotalBalance').val());
        var balance = parseInt($('#hidBalance').val());
        var acupoint = parseInt($('.spanAcuPoint').html());

        var newbalance = balance - bet_amount;
        var newtotalbalance = total_balance - bet_amount;
        //console.log(balance + " - " + bet_amount + " = " + newbalance);
        if(newbalance < 0){

        } else {
            //$('#spanPoint').html(newtotalbalance);
        }
    }
}

function closeModal() {
    $('.close-modal').click(function(){
        $('#reset-life-play').modal('hide');
        $('#reset-life-lose').modal('hide');
    });
}

function closeWinModal() {
    $('.close-win-modal').click(function(){
        $(this).off('click');
        event.stopImmediatePropagation();
        $('#win-modal').modal('hide');

        if(g_current_point > 150){
            g_current_point = 150;
        }

        console.log("closeWinModal");
        $('.spanAcuPoint')
          .prop('number', g_previous_point)
          .animateNumber(
            {
              number: g_current_point
            },
            1000
          );
    });
}

function bindSpinningButton() {
    $('.radio-primary').click(function( event ){
        $('.spinning').css('visibility', 'visible');
        setTimeout(function(){ 
            $('.spinning').css('visibility', 'hidden');
        }, 3000);
    });
}

function bindBetButton(){

    $('.radio-primary').click(function( event ){
        event.stopImmediatePropagation();

        var balance = parseInt($('#hidBalance').val());
        var total_balance = parseInt($('#hidTotalBalance').val());
        var level = parseInt($('#hidLevel').val());
        var life = $(".nTxt").html();
        var acupoint = parseInt($('.spanAcuPoint').html());
        var draw_id = $('#draw_id').val();
        var consecutive_lose = $('#hidConsecutiveLose').val();

        var user_id = $('#hidUserId').val();
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
                    bindResetLifeButton();
                    $('#reset-life-lose').modal({backdrop: 'static', keyboard: false});
                } else {
                    bindResetLifeButton();
                    $('#reset-life-start').modal();
                }

            }

        } else if(user_id > 0 && life == 0){
                $('#reset-life-share').modal();
        }

        if (user_id > 0 && acupoint >= 150) {
            bindResetLifeButton();
            $('#reset-life-max').modal({backdrop: 'static', keyboard: false});
        }


        $('.radio-primary').not(this).find('.radio').removeClass('clicked');
        $('.radio-primary').not(this).find('.bet-container').hide();
        $('.radio-primary').not(this).find('.bet').hide();

        $(this).find('.bet-container').toggle();
        $(this).find('.bet').toggle();
        $(this).find('.radio').toggleClass('clicked');

        var selected = $('div.clicked').find('input:radio').val();

        if (typeof selected == 'undefined'){

            checked(level, false);
            changbar(level);

            $('#spanPoint').html(total_balance);
            $('.instruction').css('visibility', 'visible');
            $('.payout-info').addClass("hide");
            //$('.span-balance').html(balance);
            
            $.ajax({
                type: 'GET',
                url: "/api/update-game-result-temp?gameid=101&gametype=1&memberid="+ user_id 
                + "&drawid=" + draw_id 
                + "&bet=&betamt=",
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { 
                    console.log(error.responseText);
                    //temp log            
                    bet_log = "/api/update-game-result-temp?gameid=101&gametype=1&memberid="+ user_id 
                                + "&drawid=" + draw_id 
                                + "&bet=&betamt=&error=" + error.responseText;
                    var data = new FormData();
                    data.append("data" , bet_log);
                    var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
                    xhr.open( 'post', '/api/temp_log', true );
                    xhr.send(data);

                    window.top.location.href = "/arcade";
                },
                success: function(data) {
                }
            });

        } else {

            checked(level, true);
            changbar(level);

            var bet_amount = parseInt($('.bet-container').html());
            var newbalance = balance - bet_amount;
            var newtotalbalance = total_balance - bet_amount;

            //temp log            
            bet_log = "/api/update-game-result-temp?gameid=101&gametype=1&memberid="+ user_id 
                        + "&drawid=" + draw_id 
                        + "&bet="+ selected 
                        + "&betamt=" + bet_amount
                        + "&level=" + level;
            var data = new FormData();
            data.append("data" , bet_log);
            var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
            xhr.open( 'post', '/api/temp_log', true );
            xhr.send(data);

            if(newbalance < 0){
                 $('div.clicked').find('.bet').hide();
                $('div.clicked').removeClass('clicked').find('.bet-container').hide();
                return false;
            } else {
                //$('#spanPoint').html(newtotalbalance);
                $('.instruction').css('visibility', 'hidden');

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
                    error: function (error) { 
                        console.log(error.responseText);
                        // alert('下注失败');
                        //temp log            
                        bet_log = "/api/update-game-result-temp?gameid=101&gametype=1&memberid="+ user_id 
                                    + "&drawid=" + draw_id 
                                    + "&bet="+ selected 
                                    + "&betamt=" + bet_amount
                                    + "&level=" + level
                                    + "&error=" + error.responseText;
                        var data = new FormData();
                        data.append("data" , bet_log);
                        var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
                        xhr.open( 'post', '/api/temp_log', true );
                        xhr.send(data);

                        window.top.location.href = "/arcade";
                    },
                    success: function(data) {
                        // alert('下注成功');
                    }
                });
            }

            $('.payout-info').removeClass("hide");
            //$('.span-balance').html(newbalance);
        }

    });
}

function bindCalculateButton(){
    $('.btn-calculate').click( function() {
        $('#reset-life-play').modal({backdrop: 'static', keyboard: false});
    });

    /*$('.btn-calculate').click(function( event ){
        event.stopImmediatePropagation();

        var acupoint = $('.spanAcuPoint').html();
        var selected = $('div.clicked').find('input:radio').val();
        var level = parseInt($('#hidLevel').val());
        var consecutive_lose = $('#hidConsecutiveLose').val();

        if (typeof selected == 'undefined'){
            if (acupoint == 0 || level > 1) {
                $('#reset-life-play').modal();
            } else if (level == 1 && consecutive_lose == 'yes') {
                bindResetLifeButton();
                $('#reset-life-lose').modal({backdrop: 'static', keyboard: false});
            } else if(acupoint > 0 && acupoint < 150) {
                bindResetLifeButton();
                $('#reset-life-play').modal();
            } else if (acupoint >= 150) {
                bindResetLifeButton();
                $('#reset-life-max').modal();
            }
        } else {
            $('#reset-life-play').modal();
        }
    });*/
}

function bindResetLifeButton(){
    $( '.btn-reset-life' ).click( function( event ){
        $(this).off('click');
        event.stopImmediatePropagation();

        var user_id = $('#hidUserId').val();
        var previous_point = $('.packet-point').html();

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
                        Cookies.set('previous_point', previous_point);
                        window.parent.location.href = "/redeem";
                    }
                }
            });
        }
    });

    $( '.btn-reset-life-continue' ).click( function( event ){
        $(this).off('click');
        event.stopImmediatePropagation();

        var user_id = $('#hidUserId').val();

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
                        $('#reset-life-max').modal('hide');
                        $('#reset-life-play').modal('hide');
                        $('#reset-life-lose').modal('hide');
                        $('#reset-life-start').modal('hide');
                        resetGame();
                    }
                }
            });
        }
    });
}

function showProgressBar(bol_show){
    var level = parseInt($('#hidLevel').val());
    var consecutive_lose = $('#hidConsecutiveLose').val();
    var bet_amount = 0;
    var payout_info = '';
    var span_balance = 1200;

    if(consecutive_lose == 'yes') {
        $('.span-1').html("-10");
        $('.span-2').html("-30");
        $('.span-3').html("-70");
        $('.span-4').html("-150");
        $('.span-5').html("-310");
        $('.span-6').html("-630");
        $('.span-balance').html(0);

        $('.payout-info').html(payout_info).addClass('hide');
        $('.spanAcuPoint').html(0);
        checked(7, false);
        changbar(7);
    } else {
        switch (level) {

            default:
            case 1:
                bet_amount = 10;

                payout_info = '猜中得10，赚10金币。';
                $('.span-1').html("10");
                $('.span-2').html("30");
                $('.span-3').html("70");
                $('.span-4').html("150");
                $('.span-5').html("310");
                $('.span-6').html("630");

                break;
            case 2:
                bet_amount = 30;
                span_balance = 1190;

                payout_info = '猜中得30，扣除之前亏损10，赚20金币。';
                $('.span-1').html("-10");                        
                break;
            case 3:                    
                bet_amount = 70;
                span_balance = 1160;

                payout_info = '猜中得70，扣除前2次亏损40，赚30金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                break;
            case 4:
                bet_amount = 150;
                span_balance = 1090;

                payout_info = '猜中得150，扣除前3次亏损110，赚40金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                $('.span-3').html("-70");
                break;
            case 5:
                bet_amount = 310;
                span_balance = 940;

                payout_info = '猜中得310，扣除前4次亏损260，赚50金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                $('.span-3').html("-70");
                $('.span-4').html("-150");
                break;
            case 6:
                bet_amount = 630;
                span_balance = 630;

                payout_info = '猜中得630，扣除前5次亏损570，赚60金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                $('.span-3').html("-70");
                $('.span-4').html("-150");
                $('.span-5').html("-310");
                break;
        }

        $('.span-balance').html(span_balance);
        $('.bet-container').html(bet_amount);

        if(bol_show) {
            $('.payout-info').html(payout_info).removeClass('hide');
            checked(level, true);
            changbar(level);
        } else {
            $('.payout-info').html(payout_info).addClass('hide');
            checked(level, false);
            changbar(level);
        }
    }
}

function showWinModal(){
    var level = parseInt($('#hidLevel').val());
    var html = '';
    var image = '';

    switch (level) {

        case 1:
            instruction = '游戏原始积分1200，你前0次都猜错了，亏损<span class="modal-minus">0积分</span>，第1次猜对，赚了<span class="modal-add">+10积分</span>。<br />所以最终赚到10积分（10-0=10）';
            image = '/client/images/progress-bar/10.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+10金币</div>大约可兑换现金￥1元';
        break;

        case 2:
            instruction = '游戏原始积分1200，你前1次都猜错了，亏损<span class="modal-minus">-10积分</span>，第2次猜对，赚了<span class="modal-add">+30积分</span>。<br />所以最终赚到20积分（30-10=20）';
            image = '/client/images/progress-bar/30.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+20金币</div>大约可兑换现金￥2元';
        break;

        case 3:
            instruction = '游戏原始积分1200，你前2次都猜错了，亏损<span class="modal-minus">-40积分</span>，第3次猜对，赚了<span class="modal-add">+70积分</span>。<br />所以最终赚到30积分（70-40=30）';
            image = '/client/images/progress-bar/70.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+30金币</div>大约可兑换现金￥3元';
        break;

        case 4:
            instruction = '游戏原始积分1200，你前3次都猜错了，亏损<span class="modal-minus">-110积分</span>，第4次猜对，赚了<span class="modal-add">+150积分</span>。<br />所以最终赚到40积分（150-110=40）';
            image = '/client/images/progress-bar/150.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+40金币</div>大约可兑换现金￥4元';
        break;

        case 5:
            instruction = '游戏原始积分1200，你前4次都猜错了，亏损<span class="modal-minus">-260积分</span>，第5次猜对，赚了<span class="modal-add">+310积分</span>。<br />所以最终赚到50积分（310-260=50）';
            image = '/client/images/progress-bar/310.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+50金币</div>大约可兑换现金￥5元';
        break;

        case 6:
            instruction = '游戏原始积分1200，你前5次都猜错了，亏损<span class="modal-minus">-570积分</span>，第6次猜对，赚了<span class="modal-add">+630积分</span>。<br />所以最终赚到60积分（630-570=60）';
            image = '/client/images/progress-bar/630.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+60金币</div>大约可兑换现金￥6元';
        break;

    }

    $('.modal-progress-bar').attr("src", image);
    $('.modal-win-header').html(html);
    $('.modal-instruction').html(instruction);
    $('.modal-redeem-button').html('领取奖励');
}

function showLoseModal(){
    var level = parseInt($('#hidLevel').val());
    var html = '';
    var image = '';

    switch (level) {

        case 1:
            instruction = '游戏原始积分1200，你猜错1次，亏损了10积分，下次下注30积分，如果猜中就能得到30积分。减去亏损的10积分，还赚20积分，6次里猜中一次，就能赚积分！';
            image = '/client/images/progress-bar/lose_10.png';
            html += '<div class="modal-win-title">很遗憾你猜错了</div><div class="modal-result">你还有5次机会</div>6次内猜中 就能获得奖励';
        break;

        case 2:
            instruction = '游戏原始积分1200，你猜错2次，亏损了40积分，下次下注70积分，如果猜中就能得到70积分。减去亏损的40积分，还赚30积分，6次里猜中一次，就能赚积分！';
            image = '/client/images/progress-bar/lose_30.png';
            html += '<div class="modal-win-title">很遗憾你猜错了</div><div class="modal-result">你还有4次机会</div>6次内猜中 就能获得奖励';
        break;

        case 3:
            instruction = '游戏原始积分1200，你猜错3次，亏损了110积分，下次下注150积分，如果猜中就能得到150积分。减去亏损的110积分，还赚40积分，6次里猜中一次，就能赚积分！';
            image = '/client/images/progress-bar/lose_70.png';
            html += '<div class="modal-win-title">很遗憾你猜错了</div><div class="modal-result">你还有3次机会</div>6次内猜中 就能获得奖励';
        break;

        case 4:
            instruction = '游戏原始积分1200，你猜错4次，亏损了260积分，下次下注310积分，如果猜中就能得到310积分。减去亏损的260积分，还赚50积分，6次里猜中一次，就能赚积分！';
            image = '/client/images/progress-bar/lose_150.png';
            html += '<div class="modal-win-title">很遗憾你猜错了</div><div class="modal-result">你还有2次机会</div>6次内猜中 就能获得奖励';
        break;

        case 5:
            instruction = '游戏原始积分1200，你猜错5次，亏损了570积分，下次下注630积分，如果猜中就能得到630积分。减去亏损的570积分，还赚60积分，6次里猜中一次，就能赚积分！';
            image = '/client/images/progress-bar/lose_310.png';
            html += '<div class="modal-win-title">很遗憾你猜错了</div><div class="modal-result">你还有1次机会</div>6次内猜中 就能获得奖励';
        break;

    }

    $('.modal-progress-bar').attr("src", image);
    $('.modal-win-header').html(html);
    $('.modal-instruction').html(instruction);
    $('.modal-redeem-button').html('知道了');

}

function startTimer(duration, timer, freeze_time) {

    var trigger_time = freeze_time - 1;
    parent.timerInterval = setInterval(function () {

        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 61, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        $( "#txtCounter" ).html(seconds);
        $( ".span-timer" ).html(seconds);

        --timer;

        if (timer < 0) {
            timer = duration;

            resetGame();

        } else if (timer <= trigger_time) {
            //Lock the selection
            $('.radio-primary').unbind('click');
            bindSpinningButton();

            if (trigger == false) {
                triggerResult();
            }
        }
        
    }, 1000);
}

function triggerResult(){
    trigger = true;
    //console.log(data);
    var freeze_time = $('#freeze_time').val();
    var result = $('#result').val();

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
        var startKey = $('#hidLatestResult').val();

        that.getEle("$wheelContainer").wheelOfFortune({
            'wheelImg': "/client/images/wheel.png",//转轮图片
            'pointerImg': "/client/images/pointer.png",//指针图片
            'buttonImg': "/client/images/button.png",//开始按钮图片
            'wSide': 200,//转轮边长(默认使用图片宽度)
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

function checked(number, selected){
    let bar = $('.barBox');
    let i=number;

    if (selected) {
      //已选择
      bar.find('ul').children('li').eq(i-1).addClass('on');
      bar.find('h2').fadeIn(150);
      bar.find('.barIn').addClass('on');
    } else {
      //未选择
      bar.find('li').removeClass('on');
      bar.find('h2').fadeOut(0);
      bar.find('.barIn').removeClass('on');
    }
}

function changbar(number){
    let bar = $('.barBox');
    let i=number;
    bar.removeClass();
    bar.addClass('barBox barBox-'+i);
}

function showGameRules( event ){
    event.stopImmediatePropagation();
    $('.button-card').off('click', showGameRules);

    var bet_count = $('#hidbetting_count').val();

    $( ".txtTimer" ).removeClass('hide');
    $('#game-rules').modal({backdrop: 'static', keyboard: false});

    $( ".span-read" ).html('进入挖宝');

    $('.btn-rules-close').click(function(){
        $('#game-rules').modal('hide');
        bindBetButton();
    });

    $('.btn-rules-timer').click(function(){
        $('#game-rules').modal('hide');
    });

    /*if(bet_count > 0) {
        $('.btn-rules-close').click(function(){
            $('#game-rules').modal('hide');
            Cookies.set('show_game_rules', false);
            bindBetButton();
        });
    } else {
        var counter = 11;
        var interval = setInterval(function() {
            --counter;
            seconds = counter;
            
            if(counter <= 0){
                seconds = '';
            } else if(counter < 10) {
                seconds = "0" + counter;
            }

            // Display 'counter' wherever you want to display it.
            $( ".txtTimer" ).html("(" + seconds + ")");

            if (counter <= 0) {
                // Display a login box
                $( ".txtTimer" ).addClass('hide');
                $( ".span-read" ).html('进入挖宝');
                clearInterval(interval);
            }

        }, 1000);

        setTimeout(function(){ 

            $('.btn-rules-timer').click(function(){
                $('#game-rules').modal('hide');
                Cookies.set('show_game_rules', false);
            });

            bindBetButton();
        }, 11000);
    }*/
}