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
		//resetTimer();
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
        $('.wallet-point').html(0);
        $('.packet-point').html(0);
    } else {
        var balance = parseInt(records.balance);
        var life = records.life;
        var point = parseInt(records.point);
        var acupoint =  parseInt(records.acupoint);
        g_current_point = parseInt(records.acupoint);
        //g_current_point = parseInt(records.balance) + parseInt(records.acupoint);

        if(life == 0){
            balance = 0;
        }

        var total_balance = balance + acupoint;
        $('#spanPoint').html(total_balance);
        
        $('#hidTotalBalance').val(total_balance);
        $('.wallet-point').html(point);
        $('.packet-point').html(point);
        if(show_win){
            
        } else {
            $('.spanAcuPoint').html(acupoint);
            $('.spanAcuPointAndBalance').html(acupoint);
        }
        $('.packet-acupoint').html(acupoint);
        $('#hidBalance').val(balance);
        $(".nTxt").html(life);
        $(".spanLife").html(life);

        setBalance();

        if(acupoint == 50 || acupoint == 100){
            $('.speech-bubble-point').html('已赚了'+ acupoint +'金币大约可换'+ acupoint/10 +'元').fadeIn(1000).delay(2000).fadeOut(400);
        }

        if(life == 0){
            $('#reset-life-share').modal();
        } else if (user_id > 0 && acupoint >= 150) {
            bindResetLifeButton();
            $('#reset-life-max').modal({backdrop: 'static', keyboard: false});
        }
    }
}

function initGame(data, level, latest_result, consecutive_lose){
try {
 
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
        var expiry_time = data.expiry_time.replace(' ', 'T');
// console.log('_expiry_time ' + expiry_time);
        expiry_time = new Date(expiry_time);
        var requested_time = new Date(data.requested_time.date.replace(' ', 'T'));
        var current_time = (new Date().format('Y-m-d H:i:s')).toString().replace(' ', 'T');            
// console.log('_current_time ' + current_time);
        current_time = new Date(current_time);
        var diff = (expiry_time - current_time); 
        timer = (diff / 1000).toString();
        if (timer > duration) {
            timer = duration;
        }
        // console.log('diff' + diff);
        // console.log('requested_time ' + requested_time);
        // console.log('current_time ' + current_time);
        // console.log('expiry_time ' + expiry_time);
         // console.log('new timer ' + timer);

        $('#hidLevel').val(level);
        $('#hidLevelId').val(level_id);
        $('#hidLatestResult').val(previous_result);
        $('#hidConsecutiveLose').val(consecutive_lose);

        $('.barBox').find('li').removeClass('on');

        if (consecutive_lose == 'yes' && life > 0) {
            if(show_lose !== true && show_win !== true){
                showProgressBar(false);
            }
            bindResetLifeButton();
            $('#reset-life-lose').modal({backdrop: 'static', keyboard: false});
        }

        if(show_lose !== true && show_win !== true){
            console.log("Show Lose: " + show_lose + " Show Win: "+ show_win);
            showProgressBar(false);
        }

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
            error: function (error) { 
                console.log(error);
                window.top.location.href = "/arcade";
            },
            success: function(data) {

                if(data.success && data.record.bet != null){

                    if(show_lose !== true && show_win !== true){
                        console.log("Show Lose: " + show_lose + " Show Win: "+ show_win);
                        showProgressBar(true);
                    }

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
    catch(err) {
      console.log(err.message);
      $(".reload").show();
    }
}

function getSocket(){
            
    var c_url = url + ':' + port;

    var user_id = $('#hidUserId').val();

        $.ajax({
            url: '/token'
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            /*if(errorThrown == 'Unauthorized'){
                $(".loading").fadeOut("slow");
                $('#red-packet-modal').modal({backdrop: 'static', keyboard: false});
            }*/
        })
        .done(function (result, textStatus, jqXHR) {
            console.log('connecting URL: '+c_url);
            var socket = new io.connect(c_url, {
                'reconnection': true,
                'reconnectionDelay': 1000, //1 sec
                'reconnectionDelayMax' : 5000,
                'reconnectionAttempts': 2,
                'transports': ['websocket'],
                'timeout' : 10000, //1 min
                'force new connection' : true,
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
                //temp log            
                bet_log = "/api/update-game-result-temp?gameid=101&gametype=1&memberid=" + user_id + "&drawid=&bet=&betamt=&error=userlogout";
                var data = new FormData();
                data.append("data" , bet_log);
                var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
                xhr.open( 'post', '/api/temp_log', true );
                xhr.send(data);

                window.top.location.href = "/arcade";
            });

            /* 
            If disconnect socketio then here will get message 
            */
            socket.on('disconnect', function () {
                console.log('Disconnected');
                //$(".reload").show();

                //temp log            
                bet_log = "/api/update-game-result-temp?gameid=101&gametype=1&memberid=" + user_id + "&drawid=&bet=&betamt=&error=Disconnected";
                var data = new FormData();
                data.append("data" , bet_log);
                var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
                xhr.open( 'post', '/api/temp_log', true );
                xhr.send(data);

                window.top.location.href = "/arcade";
            });

            //On user logout
            socket.on('userlogout-' + user_id, function (data) {
                console.log('user-logout');
                //temp log            
                bet_log = "/api/update-game-result-temp?gameid=101&gametype=1&memberid=" + user_id + "&drawid=&bet=&betamt=&error=userlogout";
                var data = new FormData();
                data.append("data" , bet_log);
                var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
                xhr.open( 'post', '/api/temp_log', true );
                xhr.send(data);

                window.top.location.href = "/";
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
                    $('.btn-vip-modal').removeClass('btn-vip-wrapper').addClass('btn-normal-wrapper');
                    $('.btn-vip-modal .btn-rules-vip').html('规则说明');
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
                initShowModal();
                var game_records = data.data.gamesetting;
                var level = data.data.level;
                var latest_result = data.data.latest_result;
                var consecutive_lose = data.data.consecutive_lose;
                // var result_records = data.data.gamehistory.data;
                
                var id = $('#hidUserId').val();
                var session = $('#hidSession').val();

                initGame(game_records, level, latest_result, consecutive_lose);
                // updateResult(result_records);

                // if(update_wallet){
                //     initUser(wallet_data);
                //     update_wallet = false;
                // }

                // if(update_betting_history){
                //     updateHistory(betting_data);
                //     update_betting_history = false;
                // }

                show_win = false;
                show_lose = false;
             });

            //No betting
            socket.on("no-betting-user-" + user_id + ":App\\Events\\EventNoBetting" , function(data){
                console.log('call no-betting');
                console.log(data);

                $('#result').val(data.data.game_result);
                // console.log('timer ' + $('#txtCounter').html());
                // console.log('freeze_time ' + $('#freeze_time').val());
                if ($('#txtCounter').html() <= $('#freeze_time').val()) {
                    // console.log($('#txtCounter').html() <= $('#freeze_time').val());
                    triggerResult();    
                }
                
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

                    if(data.data.IsFirstLifeWin == 'yes' && level < 6){
                        show_lose = true;
                        showLoseModal();
                    }
                }

                $('#result').val(data.data.game_result);
                // console.log('timer ' + $('#txtCounter').html());
                // console.log('freeze_time ' + $('#freeze_time').val());
                if ($('#txtCounter').val() <= $('#freeze_time').val()) {
                    // console.log($('#txtCounter').html() <= $('#freeze_time').val());
                    triggerResult();    
                }
            });

            //wallet changes -- new --
            socket.on("wallet-" + user_id + ":App\\Events\\EventWalletUpdate", function(data){
                console.log('member wallet details');
                console.log(data);

                //g_previous_point = parseInt($('.spanAcuPoint').html());
                g_previous_point = parseInt($('.spanAcuPointAndBalance').html());
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

            //on page load activedraw Script
            socket.on("activedraw-" + user_id + ":App\\Events\\EventDynamicChannel", function(data){
                console.log('load activedraw member page load');
                console.log(data);
                // initWheel(data.data);
             });

            //on page load activedraw Script
            socket.on("activedraw:App\\Events\\EventDynamicChannel", function(data){
                console.log('load activedraw page load');
                console.log(data);
                
                // resetGame();
                // initShowModal();
                var result_records = data.data.gamehistory.data;
                
                var id = $('#hidUserId').val();
                var session = $('#hidSession').val();

                updateResult(result_records);

                if(update_wallet){
                    initUser(wallet_data);
                    update_wallet = false;
                }

                if(update_betting_history){
                    updateHistory(betting_data);
                    update_betting_history = false;
                }

                // show_win = false;
                // show_lose = false;

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
}

function initShowModal(){
    if(show_win){
        $('#win-modal').modal({backdrop: 'static', keyboard: false});
        closeWinModal();
    }

    if(show_lose){
        $('#win-modal').modal({backdrop: 'static', keyboard: false});
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
    $('.close-win-modal').click(function(event){
        $(this).off('click');
        event.stopImmediatePropagation();
        $('#win-modal').modal('hide');

         if(g_current_point > 150){
             g_current_point = 150;
         }

        console.log("closeWinModal");
        //$('.spanAcuPoint')
        $('.spanAcuPointAndBalance')
          .prop('number', g_previous_point)
          .animateNumber(
            {
              number: g_current_point
            },
            1000
          );

        console.log("Show Lose: " + show_lose + " Show Win: "+ show_win);
        setTimeout(function () {
            showProgressBar(false);
        }, 500);
        
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
                    alert('下注失败');
                    //temp log            
                    bet_log = "/api/update-game-result-temp?gameid=101&gametype=1&memberid="+ user_id 
                                + "&drawid=" + draw_id 
                                + "&bet=&betamt=&error=" + error.responseText;
                    var data = new FormData();
                    data.append("data" , bet_log);
                    var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
                    xhr.open( 'post', '/api/temp_log', true );
                    xhr.send(data);

                    // window.top.location.href = "/arcade";
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

            // //temp log            
            // bet_log = "/api/update-game-result-temp?gameid=101&gametype=1&memberid="+ user_id 
            //             + "&drawid=" + draw_id 
            //             + "&bet="+ selected 
            //             + "&betamt=" + bet_amount
            //             + "&level=" + level;
            // var data = new FormData();
            // data.append("data" , bet_log);
            // var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
            // xhr.open( 'post', '/api/temp_log', true );
            // xhr.send(data);

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
                        console.log('memberid: ' + user_id + ', 下注失败'); 
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

                        alert('下注失败');
                    },
                    success: function(data) {
                        // alert('下注成功');
                    }
                });
            }

            var temp = "";

            $('.payout-info').removeClass("hide");
            if (selected == "odd") {
                temp = "[单数]";
            } else {
                temp = "[双数]";
            }
            $('.caption_bet').text(temp);

            // $(".payout-info").text(function () {
            //     return $(this).text().replace("[单数]", temp); 
            // });
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
    var balance = parseInt($('#hidBalance').val());
    var bet_amount = 0;
    var payout_info = '';
    var span_balance = 1200;
    var result_info ='';

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
        $('.spanAcuPointAndBalance').html(0);
        
        result_info = '剩余<span style="text-decoration:underline">'+ balance +'</span>游戏积分&nbsp;';
        $('.result-info').html(result_info);


        
        
        checked(7, false);
        changbar(7);
    } else {

        switch (level) {

            default:
            case 1:
                bet_amount = 10;

                payout_info = '<span class=\'caption_bet\'>[单数]</span>押注10积分，猜对+10，猜错-10。';//'您选择<span class=\'caption_bet\'>[单数]</span>，猜中赚10金币，可兑换1元。';//'猜中得10，赚10金币。';
                $('.span-1').html("10");
                $('.span-2').html("30");
                $('.span-3').html("70");
                $('.span-4').html("150");
                $('.span-5').html("310");
                $('.span-6').html("630");

                result_info = '本轮还有6次机会。';

                break;
            case 2:
                bet_amount = 30;
                span_balance = 1190;
                result_info = '本轮错了1次，还剩5次。';

                payout_info = '<span class=\'caption_bet\'>[单数]</span>押注30积分，猜对+30，猜错-30。';//'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得30，赚20金币。';//'猜中得30，扣除之前亏损10，赚20金币。';
                $('.span-1').html("-10");                        
                break;
            case 3:                    
                bet_amount = 70;
                span_balance = 1160;
                result_info = '本轮错了2次，还剩4次。';

                payout_info = '<span class=\'caption_bet\'>[单数]</span>押注70积分，猜对+70，猜错-70。'; //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得70，赚30金币。';//'猜中得70，扣除前2次亏损40，赚30金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                break;
            case 4:
                bet_amount = 150;
                span_balance = 1090;
                result_info = '本轮错了3次，还剩3次。';

                payout_info = '<span class=\'caption_bet\'>[单数]</span>押注150积分，猜对+150，猜错-150。'; //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得150，赚40金币。';//'猜中得150，扣除前3次亏损110，赚40金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                $('.span-3').html("-70");
                break;
            case 5:
                bet_amount = 310;
                span_balance = 940;
                result_info = '本轮错了4次，还剩2次。';

                payout_info = '<span class=\'caption_bet\'>[单数]</span>押注310积分，猜对+310，猜错-310。'; //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得310，赚50金币。';//'猜中得310，扣除前4次亏损260，赚50金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                $('.span-3').html("-70");
                $('.span-4').html("-150");
                break;
            case 6:
                bet_amount = 630;
                span_balance = 630;
                result_info = '本轮剩1次机会，猜错清零。';                

                payout_info = '<span class=\'caption_bet\'>[单数]</span>押注630积分，猜对+630，猜错-630。'; //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得630，赚60金币。';//'猜中得630，扣除前5次亏损570，赚60金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                $('.span-3').html("-70");
                $('.span-4').html("-150");
                $('.span-5').html("-310");
                break;
        }

        result_info = '剩余<span style="text-decoration:underline">'+ span_balance +'</span>游戏积分&nbsp;';

        $('.span-balance').html(span_balance);
        $('.bet-container').html(bet_amount);
        $('.result-info').html(result_info);

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
    var result_info = '本轮还有6次机会。';

    switch (level) {

        case 1:
            instruction = '第1局<span class="highlight-orange">猜对奖励10积分</span>，最终本轮赚了10积分。<br />赚到的10积分自动换成金币，可兑换红包。根据配赠式玩法，猜中后返回10积分开始押注。<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';           
            image = '/client/images/progress-bar/10.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+10积分</div>';
        break;

        case 2:
            instruction = '前1局猜错<span class="highlight-green">亏损了10积分</span>，而第2局<span class="highlight-orange">猜对奖励30积分</span>，最终<span class="highlight-orange">还赚了20积分</span>。<br />赚到的20积分自动换成金币，可兑换红包。根据配赠式玩法，猜中后返回10积分开始押注。<br><div class="highlight-link">>查看倍增式玩法说明<</div>';
            image = '/client/images/progress-bar/30.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+30积分</div>';            
        break;

        case 3:
            instruction = '前2局猜错<span class="highlight-green">亏损了40积分</span>，而第3局<span class="highlight-orange">猜对奖励70积分</span>，最终<span class="highlight-orange">还赚了30积分</span>。<br />赚到的30积分自动换成金币，可兑换红包。根据配赠式玩法，猜中后返回10积分开始押注。<br><div class="highlight-link">>查看倍增式玩法说明<</div>';
            image = '/client/images/progress-bar/70.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+70积分</div>';
        break;

        case 4:
            instruction = '前3局猜错<span class="highlight-green">亏损了110积分</span>，而第4局<span class="highlight-orange">猜对奖励150积分</span>，最终<span class="highlight-orange">还赚了40积分</span>。<br />赚到的40积分自动换成金币，可兑换红包。根据配赠式玩法，猜中后返回10积分开始押注。<br><div class="highlight-link">>查看倍增式玩法说明<</div>';
            image = '/client/images/progress-bar/150.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+150积分</div>';
        break;

        case 5:
            instruction = '前4局猜错<span class="highlight-green">亏损了260积分</span>，而第5局<span class="highlight-orange">猜对奖励310积分</span>，最终<span class="highlight-orange">还赚了50积分</span>。<br />赚到的50积分自动换成金币，可兑换红包。根据配赠式玩法，猜中后返回10积分开始押注。<br><div class="highlight-link">>查看倍增式玩法说明<</div>';
            image = '/client/images/progress-bar/310.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+310积分</div>';
        break;

        case 6:
            instruction = '前5局猜错<span class="highlight-green">亏损了570积分</span>，而第6局<span class="highlight-orange">猜对奖励630积分</span>，最终<span class="highlight-orange">还赚了60积分</span>。<br />赚到的60积分自动换成金币，可兑换红包。根据配赠式玩法，猜中后返回10积分开始押注。<br><div class="highlight-link">>查看倍增式玩法说明<</div>';
            image = '/client/images/progress-bar/630.png';
            html += '<div class="modal-win-title">恭喜你猜对了</div><div class="modal-result">+630积分</div>';            
        break;

    }

    $('.modal-progress-bar').attr("src", image);
    $('.modal-win-header').html(html);
    $('.modal-instruction').html(instruction);
    $('.modal-redeem-button').html('领取奖励');
    
    $('.highlight-link').click(function(){
        $('#game-rules').modal();
    });

    $('.btn-rules-close').click(function(){
        $('#game-rules').modal('hide');
    });

    $('.btn-rules-timer').click(function(){
        $('#game-rules').modal('hide');
    });
}

function showLoseModal(){
    var level = parseInt($('#hidLevel').val());
    var html = '';
    var image = '';
    var result_info = '本轮还有6次机会。';

    switch (level) {

        case 1:
            instruction = '前1局猜错，<span class="highlight-green">总亏损10积分</span>，根据倍增式玩法，第2局<span class="highlight-orange">将押注30积分</span>，如猜对能获得30积分奖励，减去亏损的10还能赚20积分。<br />赚到的积分自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            image = '/client/images/progress-bar/lose_10.png';
            html += '<div class="modal-win-title">本局猜错了</div><div class="modal-lose-result">-10积分</div>';
            result_info = '本轮错了1次，还剩5次。';
        break;

        case 2:
            instruction = '前2局猜错，<span class="highlight-green">总亏损40积分</span>，根据倍增式玩法，第3局<span class="highlight-orange">将押注70积分</span>，如猜对能获得70积分奖励，减去亏损的40还能赚30积分。<br />赚到的积分自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            image = '/client/images/progress-bar/lose_30.png';
            html += '<div class="modal-win-title">本局猜错了</div><div class="modal-lose-result">-30积分</div>';
            result_info = '本轮错了2次，还剩4次。';
        break;

        case 3:
            instruction = '前3局猜错，<span class="highlight-green">总亏损110积分</span>，根据倍增式玩法，第4局<span class="highlight-orange">将押注150积分</span>，如猜对能获得150积分奖励，减去亏损的110还能赚40积分。<br />赚到的积分自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';            
            image = '/client/images/progress-bar/lose_70.png';
            html += '<div class="modal-win-title">本局猜错了</div><div class="modal-lose-result">-70积分</div>';
            result_info = '本轮错了3次，还剩3次。';
        break;

        case 4:
            instruction = '前4局猜错，<span class="highlight-green">总亏损260积分</span>，根据倍增式玩法，第5局<span class="highlight-orange">将押注310积分</span>，如猜对能获得310积分奖励，减去亏损的260还能赚50积分。<br />赚到的积分自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            image = '/client/images/progress-bar/lose_150.png';
            html += '<div class="modal-win-title">本局猜错了</div><div class="modal-lose-result">-150积分</div>';
            result_info = '本轮错了4次，还剩2次。';
        break;

        case 5:
            instruction = '前5局猜错，<span class="highlight-green">总亏损570积分</span>，根据倍增式玩法，第6局<span class="highlight-orange">将押注630积分</span>，如猜对能获得630积分奖励，减去亏损的570还能赚60积分。<br />赚到的积分自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            image = '/client/images/progress-bar/lose_310.png';
            html += '<div class="modal-win-title">本局猜错了</div><div class="modal-lose-result">-310积分</div>';
            result_info = '本轮剩1次机会，猜错清零。';
        break;

    }

    $('.modal-progress-bar').attr("src", image);
    $('.modal-win-header').html(html);
    $('.modal-instruction').html(instruction);
    $('.modal-redeem-button').html('知道了');
    
    $('.highlight-link').click(function(){
        $('#game-rules').modal();
    });

    $('.btn-rules-close').click(function(){
        $('#game-rules').modal('hide');
    });

    $('.btn-rules-timer').click(function(){
        $('#game-rules').modal('hide');
    });

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

          // console.log('timer' + timer);
         // console.log('trigger_time ' + trigger_time);
            
        if (timer == 0) {
            clearInterval(parent.timerInterval);
            $( "#txtCounter" ).html('<span style="font-size: 18px; padding: 5px;">等候</span>');
            // timer = duration;
            // resetGame();

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
    // console.log(freeze_time);

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
            'buttonImg': "/client/images/pointer.png",//开始按钮图片
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

    var game_name = $('#game-name').val();
    $( ".span-read" ).html('返回幸运转盘');

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

// function initWheel(data) {

//     var duration = data.duration;
//     var timer = data.remaining_time;
//     var freeze_time = data.freeze_time;
//     var draw_id = data.drawid;
//     var expiry_time = data.expiry_time.replace(' ', 'T');
//     expiry_time = new Date(expiry_time);
//     var requested_time = new Date(data.requested_time.date.replace(' ', 'T'));
//     var current_time = (new Date().format('Y-m-d H:i:s')).toString().replace(' ', 'T');            
//     current_time = new Date(current_time);
//     var diff = (expiry_time - current_time); 
//     timer = (diff / 1000).toString();
//     if (timer > duration) {
//         timer = duration;
//     }

//     $('#freeze_time').val(freeze_time);
//     $('#draw_id').val(draw_id);

// // console.log('trigger ' + trigger);
// // trigger = true;
//     DomeWebController.init();
//     clearInterval(parent.timerInterval);
//     startTimer(duration, timer, freeze_time);
//     // triggerResult();
// }