var trigger = false;
var timerInterval = 0;
var update_wallet = false;
var wallet_data = null;
var update_betting_history = false;
var betting_data = null;
var token = '';

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

    if (records.length === 0) {
        $('#spanPoint').html(0);
        $('.packet-point').html(0);
    } else {
        var balance = parseInt(records.balance);
        var life = records.life;
        var point = parseInt(records.point);
        var acupoint =  parseInt(records.acupoint);

        var vip_point =  parseInt(records.vip_point);
        var vip_life =  parseInt(records.vip_life);

        if(vip_life == 0){
            vip_point = 0;
        }

        var total_balance = vip_point;

        $('#spanPoint').html(vip_point);                    
        $('#hidTotalBalance').val(total_balance);
        $('.packet-point').html(point);
        $('.spanAcuPoint').html(acupoint);
        $('.packet-acupoint').html(acupoint);
        $('#hidBalance').val(balance);
        $(".nTxt").html(life);
        $(".spanVipLife").html(vip_life);
        $(".spanLife").html(life);
    }
}

function initGame(data, level, latest_result, consecutive_lose){

    var user_id = $('#hidUserId').val();
    trigger = false;
    

        var bet_amount = 0;
        var span_balance = 1200;
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

        $('#hidLevel').val(level);
        $('#hidLevelId').val(level_id);
        $('#hidLatestResult').val(previous_result);

        $('.barBox').find('li').removeClass('on');
        
        showProgressBar(false);

        $('#freeze_time').val(freeze_time);
        $('#draw_id').val(draw_id);

        DomeWebController.init();
        trigger = false;
        clearInterval(parent.timerInterval);
        startTimer(duration, timer, freeze_time);

        if (timer <= freeze_time) {
            $('.radio-primary').unbind('click');
        } else {
            bindBetButton();
        }

        bindCalculateButton();

        $(".loading").fadeOut("slow");

        $.ajax({
            type: 'GET',
            url: "/api/get-game-result-temp?gameid=101&gametype=2&memberid=" + user_id + "&drawid=" + draw_id,
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.setRequestHeader ("Authorization", "Bearer " + token);
            },
            error: function (error) { console.log(error.responseText) },
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
                        url: "/api/update-game-result-temp?gameid=101&gametype=2&memberid="+ user_id 
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
        })
        .done(function (result, textStatus, jqXHR) {
            //console.log('connecting URL: '+c_url);
            var socket = new io.connect(c_url, {
                'reconnection': true,
                'reconnectionDelay': 1000, //1 sec
                'reconnectionDelayMax' : 5000,
                'reconnectionAttempts': 2,
                'transports': ['websocket'],
                'timeout' : 10000, //1 min
                'force new connection' : true,
                 query: 'token='+result.token+'&vip=yes'
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
            });

            /* 
            If disconnect socketio then here will get message 
            */
            socket.on('disconnect', function () {
                console.log('Disconnected');
                //$(".reload").show();

                //temp log            
                bet_log = "/api/update-game-result-temp?gameid=101&gametype=2&memberid=" + user_id + "&drawid=&bet=&betamt=&error=Disconnected";
                var data = new FormData();
                data.append("data" , bet_log);
                var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
                xhr.open( 'post', '/api/temp_log', true );
                xhr.send(data);

                window.top.location.href = "/vip";
            });

            //On user logout
            socket.on('userlogout-' + user_id, function (data) {
                console.log('user-logout');
            });

            //on page load game setting Script
            socket.on("loadsetting-" + user_id + ":App\\Events\\EventGameSetting", function(data){
                console.log('load user game setting-on page load');

                //console.log(data);

                var game_records = data.data.gamesetting;
                var level = data.data.viplevel;
                var latest_result = data.data.latest_result;
                var consecutive_lose = data.data.vip_consecutive_lose;
                var result_records = data.data.gamehistory.data;
                
                var wallet = false;
                 if(typeof(data.data.wallet) !== 'undefined'){
                    var wallet_records = data.data.wallet;
                    wallet = true;
                }

                var betting_history = false;
                if(typeof(data.data.vipbethistory) !== 'undefined'){
                    var betting_records = groupHistory(data.data.vipbethistory.data);
                    betting_history = true;
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
                        initGame(game_records, level, latest_result, consecutive_lose);
                        updateResult(result_records);

                        if(wallet){
                            initUser(wallet_records);
                        }

                        if(betting_history){
                            updateHistory(betting_records);
                        }
                    }
                });

                $('#hidFee').val(data.data.wabaofee);
                $('.spanFee').html(data.data.wabaofee);

             });

            //init setting Script
            socket.on("initsetting-" + user_id + ":App\\Events\\EventGameSetting", function(data){
                console.log('user-initsetting');
                console.log(data);

                resetGame();
                var game_records = data.data.gamesetting;
                var level = data.data.viplevel;
                var latest_result = data.data.latest_result;
                var result_records = data.data.gamehistory.data;
                var consecutive_lose = $('#hidConsecutiveLose').val();

                var id = $('#hidUserId').val();
                var session = $('#hidSession').val();

                initGame(game_records, level, latest_result, consecutive_lose);
                updateResult(result_records);

                if(update_wallet && consecutive_lose == ""){
                    initUser(wallet_data);
                    update_wallet = false;
                }

                if(update_betting_history){
                    updateHistory(betting_data);
                    update_betting_history = false;
                }

                $('#hidFee').val(data.data.wabaofee);
                $('.spanFee').html(data.data.wabaofee);

             });

            //No betting vip
            socket.on("no-vipbetting-user-" + user_id + ":App\\Events\\EventNoBetting" , function(data){
                //console.log('call no-vip-betting');
                //console.log(data);

                $('#result').val(data.data.game_result);
                triggerResult();
            });

            //betting vip
            socket.on("uservipbetting-" + user_id + ":App\\Events\\EventVIPBetting" , function(data){
                console.log('call uservipbetting');
                console.log(data);

                $('#hidConsecutiveLose').val(data.data.consecutive_loss);
                $('#hidMergePoint').val(data.data.mergepoint);

                if(data.data.status == 'win'){
                    var level = parseInt($('#hidLevel').val());
                    var win_amount = level * 10;

                    $('.instruction').html('恭喜你猜对了，赚了'+ win_amount +'金币！');
                } else if (data.data.status == 'lose') {
                    var level = parseInt($('#hidLevel').val());
                    var chance = 6 - level;

                    $('.instruction').html('很遗憾猜错了，你还有'+ chance +'次机会！');
                }

                $('#result').val(data.data.game_result);
                triggerResult();
            });

            //wallet changes -- new --
            socket.on("wallet-" + user_id + ":App\\Events\\EventWalletUpdate", function(data){
                console.log('member wallet details');
                console.log(data);

                wallet_data = data.data;
                update_wallet = true;

              });

            //betting VIP history -- new --
            socket.on("vipbettinghistory-" + user_id + ":App\\Events\\EventVipBettingHistory", function(data){
                console.log('members recent Vip bettinghistory');
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
}

function closeModal() {
    $('.close-modal').click(function(){
        $('.redeem-error').html('你猜的游戏正在进行中');
        $('#reset-life-bet').modal('hide');
        $('#reset-life-lose').modal('hide');
    });

    $('.modal-message-manual').click(function(){
        $('#reset-life-manual').modal();
    });

    $('.modal-manual-button').click(function(){
        $('#reset-life-manual').modal('hide');
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
    $('.radio-primary').click(function(event){
        event.stopImmediatePropagation();

        var balance = parseInt($('#hidBalance').val());
        var total_balance = parseInt($('#hidTotalBalance').val());
        var level = parseInt($('#hidLevel').val());
        var life = $(".nTxt").html();
        var acupoint = parseInt($('.spanAcuPoint').html());
        var draw_id = $('#draw_id').val();

        var user_id = $('#hidUserId').val();
        if(user_id == 0){
            window.top.location.href = "/member";
        }

        if(isNaN(balance)){
            return false;
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

            //$('#spanPoint').html(total_balance);
            $('.instruction').css('visibility', 'visible');
            $('.payout-info').addClass("hide");
            //$('.span-balance').html(balance);

            $.ajax({
                type: 'GET',
                url: "/api/update-game-result-temp?gameid=101&gametype=2&memberid="+ user_id 
                + "&drawid=" + draw_id 
                + "&bet=&betamt=",
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { 
                    console.log(error.responseText);
                    //temp log            
                    // bet_log = "/api/update-game-result-temp?gameid=101&gametype=2&memberid="+ user_id 
                    //             + "&drawid=" + draw_id 
                    //             + "&bet=&betamt=&error=" + error.responseText;
                    // var data = new FormData();
                    // data.append("data" , bet_log);
                    // var xhr = (window.XMLHttpRequest) ? new XMLHttpRequest() : new activeXObject("Microsoft.XMLHTTP");
                    // xhr.open( 'post', '/api/temp_log', true );
                    // xhr.send(data);

                    window.top.location.href = "/vip";

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
            // bet_log = "/api/update-game-result-temp?gameid=101&gametype=2&memberid="+ user_id 
            //         + "&drawid=" + draw_id 
            //         + "&bet="+ selected 
            //         + "&betamt=" + bet_amount
            //         + "&level=" + level;
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
                    url: "/api/update-game-result-temp?gameid=101&gametype=2&memberid="+ user_id 
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
                        //temp log            
                        bet_log = "/api/update-game-result-temp?gameid=101&gametype=2&memberid="+ user_id 
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

                        // window.top.location.href = "/vip";
                        alert('下注失败');
                    },
                    success: function(data) {
                    }
                });
            }

            $('.payout-info').removeClass("hide");
            //$('.span-balance').html(newbalance);
        }

    });
}

function bindCalculateButton(){
    $('.btn-calculate-vip').click(function( event ){
        event.stopImmediatePropagation();

        var user_id = $('#hidUserId').val();
        var selected = $('div.clicked').find('input:radio').val();
        var level = parseInt($('#hidLevel').val());

        if (typeof selected == 'undefined' && level == 1) {
            $.ajax({
                type: 'POST',
                url: "/api/check-redeem",
                data: { 'memberid': user_id },
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { console.log(error.responseText) },
                success: function(data) {
                    console.log(data);
                    if(data.success){
                        var point = data.wabao_point;
                        var vip_point = data.vip_point;
                        var fee = $('#hidFee').val();
                        var net_vip_point = parseInt(vip_point) - parseInt(fee);

                        $('.spanVipPoint').html(vip_point);
                        $('.spanNetVip').html(net_vip_point);
                        $('.packet-point').html(point);

                        $('#reset-life-max').modal();
                            
                        bindResetLifeButton();
                        $('#btn-close-max').click(function(){
                            $('#reset-life-max').modal('hide');
                        });

                    } else {
                        $('.redeem-error').html(data.message);
                        $('#reset-life-bet').modal();
                    }
                }
            });
        } else {
            $('#reset-life-bet').modal();
        }
    });
}

function bindResetLifeButton(){
    $( '.btn-reset-life' ).click( function(event){
        event.stopImmediatePropagation();
        var user_id = $('#hidUserId').val();
        var previous_point = $('.packet-point').html();
        
        // add points from additional life.
        if(user_id > 0){
            $.ajax({
                type: 'POST',
                url: "/api/reset-vip",
                data: { 'memberid': user_id, 'gameid': 101 },
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { console.log(error.responseText) },
                success: function(data) {
                    console.log(data);
                    if(data.success){
                        Cookies.set('previous_point', previous_point);
                        window.parent.location.href = "/redeem";
                    }
                }
            });
        }
    });

    $( '.btn-reset-life-continue' ).click( function(event){
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
                        $('#reset-life-lose').modal('hide');
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
    var mergepoint = $('#hidMergePoint').val();
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
        $('#spanPoint').html(mergepoint);
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

        if (timer <= 0) {

            if(timer == 0){
                var consecutive_loss = $('#hidConsecutiveLose').val();
                var mergepoint = parseInt($('#hidMergePoint').val()) || 0;
                var previous_point = $('.packet-point').html();
                var fee = $('#hidFee').val();
                var net_vip_point = parseInt(mergepoint); // No charging fee;

                if(net_vip_point < 0) {
                    net_vip_point = 0;
                }

                if (consecutive_loss == 'yes') {
                    showProgressBar(false);
                    $('.spanVipPoint').html(mergepoint);
                    $('.spanNetVip').html(net_vip_point);

                    $('#div-fee').hide();
                    $('#spanPoint').html(mergepoint);

                    $('#reset-life-lose').modal({backdrop: 'static', keyboard: false});

                    $('.btn-reset-life').click(function(){
                        Cookies.set('previous_point', previous_point);
                        window.top.location.href = "/redeem";
                    });
                }
            } else {            
                timer = duration;
                resetGame();
            }

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