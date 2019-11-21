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
var previous_bet = 0;
var current_bet = 0;
var game_records = null; //game setting
var result_records = null; //game history
var latest_result = null; //latest result
var last_bet = null;
var g_life = 0;
var consecutive_lose = null;
var usedlife = 0;
var max_acupoint = 12;
var min_acupoint = 6;
var g_cookies_point = 0;
var user_id = 0;
var is_app = false;
var max_retry = 3;
var nretry = 0;
var gameid = 102;

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

    var wechat_status = 0; //$('#hidWechatStatus').val(); //ignore wechat status verification
    var wechat_name = $('#hidWechatName').val();
    var max_acupoint = $('#hidMaxAcupoint').val();
    var min_acupoint = $('#hidMinAcupoint').val();
    is_app = $('#hidIsApp').val();

    if(wechat_status == 0 && wechat_name != null) {

        getToken();
        closeModal();

        ifvisible.on("wakeup", function(){
            //resetTimer();
        });

        var user_id = $('#hidUserId').val();
        if (user_id <= 0) {
            if (is_app) {
                $('.bet-box').click(function() {
                    $( '#modal-no-login' ).modal( 'show' );                
                    setTimeout(function(){
                        console.log('1111');
                        // $( '#modal-no-login' ).modal( 'hide' );
                        window.location.href = '/login';
                    }, 3000);                
                });

                $('.btn-withdraw').click(function() {
                    $( '#modal-no-login' ).modal( 'show' );                
                    setTimeout(function(){
                        console.log('1111');
                        // $( '#modal-no-login' ).modal( 'hide' );
                        window.location.href = '/login';
                    }, 3000);
                });

                $('.btn-life').click(function() {
                    $( '#modal-no-login' ).modal( 'show' );                
                    setTimeout(function(){
                        console.log('1111');
                        // $( '#modal-no-login' ).modal( 'hide' );
                        window.location.href = '/login';
                    }, 3000);
                });
            } else {
                $('.btn-withdraw').click(function() {
                    openmodel();    
                });
            }
        }


    } else {

        $(".loading").fadeOut("slow");
        return false;
    }

});

function updateResult(records){
    var bet_count = $('#hidbetting_count').val();

    if(bet_count > 0 && (!jQuery.isEmptyObject(records[0]))){
        last_bet = records[0].bet;
        $('#hidLastBet').val(last_bet);
    }
    
    var str_result = '单数';

    var length = Object.keys(records).length;
    var maxCount = 25;

    if(length < maxCount){
        maxCount = parseInt(length);
    }

    $.each(records, function(i, item) {
        var counter = i + 1;
        if(item.result % 2 === 0){
            $('.results-body').find('#result-' + counter).removeClass('odd-box').addClass('even-box');
            str_result = '双数';
        } else {
            $('.results-body').find('#result-' + counter).removeClass('even-box').addClass('odd-box');
            str_result = '单数';
        }
        $('.results-body').find('#result-' + counter).html(item.result + '<div>'+ str_result +'</div>');

    });
}

function updateHistory(records){

    var length = Object.keys(records).length;
    var maxCount = 7;

    if(length < maxCount){
        maxCount = parseInt(length);
    }

    $.each(records, function(i, item) {
        var history = '';
        var counter = i + 1;

        var strbet = "单数";
        var strwinloss = "猜对";
        var strsign = '+';
        var className = item.bet;

        if(item.is_win == null){
            strwinloss = "猜错";
            strsign = '-';
        }

        if(item.bet == 'even'){
            strbet = "双数";
        }

        //temporary 
        var _bet_amount = parseInt(item.bet_amount);

        if (_bet_amount == 10 || _bet_amount == 30 || _bet_amount == 70 || _bet_amount == 150 || _bet_amount == 310 || _bet_amount == 630) {

            _bet_amount = parseInt(item.bet_amount / 10);

        }

        history =  '选择<span class="'+ className + '">' + strbet + '</span>，投'+ _bet_amount +'挖宝币，' + strwinloss + '，' + strsign + _bet_amount +'挖宝币';

        $('.history-body').find('#row-' + counter).find('.history-number').html(length+'局');
        $('.history-body').find('#row-' + counter).find('.history').html(history);

        length--;
    });
}

function initUser(records){

    var user_id = $('#hidUserId').val();

    if (jQuery.isEmptyObject(records)) {
        $('#spanPoint').html(0);
        $('.wallet-point').html(0);
        $('.packet-point').html(0);
    } else {
        
        records = records.gameledger['102'];
        // console.log(records);
        // console.log(records.life);

        var balance = parseInt(records.balance);
        var life = parseInt((records.life == null) ? 0 : records.life);
        g_life = life;
        var point = parseInt(records.point);
        g_cookies_point = point;
        var acupoint =  parseInt((records.acupoint == null) ? 0 : records.acupoint);
        g_current_point = parseInt((records.acupoint == null) ? 0 : records.acupoint);
        var play_count = parseInt(records.play_count);
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
            $('.spanAcuPointAndBalance').html(g_current_point);
        }
        $('#hidBalance').val(balance);
        $("#nTxt").val(life);
        $(".nTxt").html(life);
        $(".spanLife").html(life);
        $(".span-play-count").html(play_count);

        $('.btn-life').html('剩'+life+'次');
        
        // setBalance();

        if(life == 0){
            if (user_id > 0) {
                closeAllModal();
                $('#reset-life-share').modal();    
            }
            html = '<div class="box" id="btn-vip-wrapper">' +
                    '<div class="btn-go-shop"></div>' +
                    '</div>';
            $('#flex-right-menu').html(html);
            $('.btn-go-shop').click(function() {
                window.top.location.href = "/main#p";
            });
        } else if (user_id > 0 && acupoint >= max_acupoint) {
            bindResetLifeButton();
            // $('#reset-life-max').modal({backdrop: 'static', keyboard: false});
            promptResetLifeModal();
            $('.btn-withdraw').click(function() {
                promptResetLifeModal()                 
            });

            return false;
        } else {
            bindButton();
        }
    }
}

function initGame(data, level, latest_result, consecutive_lose){
try {
    
    var user_id = $('#hidUserId').val();
    trigger = false;

        var bet_amount = 0;
        var duration = 10;
        var timer = 10;
        var freeze_time = 1;
        var draw_id = data.drawid;
        var level = level.position;
        var previous_result = 1;
        var consecutive_lose = consecutive_lose;
        var life = $("#nTxt").val();
        var balance = $('#hidBalance').val();
        var payout_info = '';
        var acupoint = parseInt($('.spanAcuPointAndBalance').html());
        var suggestion_bet = 1;
        switch (level){

            default:
            case 1:
                suggestion_bet = 1;
            break;

            case 2:
                suggestion_bet = 3;
            break;

            case 3:
                suggestion_bet = 7;
            break;

            case 4:
                suggestion_bet = 15;
            break;

            case 5:
                suggestion_bet = 31;
            break;

            case 6:
                suggestion_bet = 63;
            break;
        }

        if(usedlife == 0){

            //countDownLife();

        } else {
            
            $('.first-life').hide();
        }

        if(latest_result.length > 0){
            previous_result = latest_result[0].result;
            $('.middle-label').html('<div style="font-size:0.6rem;padding-top:0.25rem">'+previous_result+'</div>');
        }

        $( ".button-bet-default" ).each(function() {
            $( this ).next().hide();
            $( this ).next().removeClass('clicked-circle');
            $( this ).next().next().hide();
            $( this ).removeClass( "button-bet-inactive" );
            $( this ).removeClass( "button-bet-active" );
            $( this ).removeClass( "clicked-button-bet" );

            if($( this ).attr('data-level') < level){
                $( this ).addClass( "button-bet-inactive" );
                $( this ).unbind( "click" );
                $( this ).find('.bet_status').html('亏损');

            } else if($( this ).attr('data-level') == level){
                $( this ).next().addClass('circle-border').show();
                $( this ).next().next().show();
                $( this ).addClass( "button-bet-active" );
                $( this ).unbind( "click" );

                if(level == 1)
                    $( this ).find('.bet_status').html('投币');
                else
                    $( this ).find('.bet_status').html('加倍');

                $( ".circle-border" ).click(function(e){

                    if(g_life == 0){
                        if (user_id > 0) {
                            closeAllModal();
                            $('#reset-life-share').modal();    
                        }
                    } else { 
                        musicPlay(1, level);
                        $( this ).removeClass('circle-border').addClass('clicked-circle');
                        $( this ).prev().addClass('clicked-button-bet');
                        $( this ).prev().find('.bet_status').html('已投');
                        $( this ).prev().add(anp(e, level, suggestion_bet));
                        $( this ).next().hide();
                        $( '.DB_G_hand_2' ).show();

                        var selected = $('div.clicked').find('input:radio').val();
                        if (typeof selected == 'undefined'){
                            //$('.middle-label').html('选择单双');
                            $('.span-odd').html('请选单双').show();
                            $('.span-even').html('请选单双').show();
                            $('.shan div').addClass('clicked').removeClass('lose');
                        } else {
                            //$('.middle-label').html('开始抽奖');
                        }
                        
                        $('#btnPointer').addClass('ready');
                        showPayout();
                    }
                });

                $( ".DB_G_hand_1" ).click(function(){
                    $('.circle-border[style*="display: block"]').trigger("click");
                });
                
            } else {
                $( this ).find('.bet_status').html('加倍');

                $( this ).click(function(){

                    if (g_life > 0) {
                       var betwarningmsg = '第'+level+'局请选投币'+ suggestion_bet +'元'; //'选错提示“按倍增式投法：第'+level+'局请投'+ suggestion_bet +'元”';
                        if (level > 1) {
                            betwarningmsg = '第'+level+'局加倍X'+ suggestion_bet;
                        }
                        $('.spinning').html(betwarningmsg);
                        $('.spinning').css('visibility', 'visible');
                        setTimeout(function(){ 
                            $('.spinning').css('visibility', 'hidden');
                        }, 3000);    
                    } else {
                        if (user_id > 0) {
                            closeAllModal();
                            $('#reset-life-share').modal();    
                        }
                    }
                });
            }
        });

        $('#hidLevel').val(level);
        $('#hidLatestResult').val(previous_result);
        $('#hidConsecutiveLose').val(consecutive_lose);

        $('.barBox').find('li').removeClass('on');
    
        // console.log('consecutive_lose'+consecutive_lose);
        // console.log('life'+g_life);

        if (consecutive_lose == 'yes' && life > 0) {
            bindResetLifeButton();
            $('#reset-life-lose').modal({backdrop: 'static', keyboard: false});
        }

        // setBalance();

        $('#freeze_time').val(freeze_time);
        $('#draw_id').val(draw_id);

        DomeWebController.init();
        trigger = false;
        clearInterval(parent.timerInterval);
        //startTimer(duration, timer, freeze_time);

        var show_game_rules = Cookies.get('show_game_rules');

        if (balance == 120 && acupoint == 0) {
            bindBetButton();
        } else {
            Cookies.remove('show_game_rules');
            bindBetButton();
        }

        bindCalculateButton();
        bindTriggerButton();

        $(".loading").fadeOut("slow");

        // $.ajax({
        //     type: 'GET',
        //     url: "/api/get-game-result-temp?gameid=102&gametype=1&memberid=" + user_id + "&drawid=0",
        //     dataType: "json",
        //     beforeSend: function( xhr ) {
        //         xhr.setRequestHeader ("Authorization", "Bearer " + token);
        //     },
        //     error: function (error) { 
        //         console.log(error);
        //         console.log(1);
        //         $(".reload2").show();
        //     },
        //     success: function(data) {

        //         if(data.success && data.record.bet != null){

        //             var selected = data.record.bet;

        //             var btn_rectangle = $("input[value='"+ selected +"']").parent();
        //             btn_rectangle.addClass('clicked');
        //             showPayout();
        //         }
        //     }
        // }); // ajax get-game-result-temp

    }
    catch(err) {
      console.log(err.message);
      // alert('下注失败');
    // alert(err.message);
    console.log(2);
    $(".reload2").show();
    }
}

function getToken(){
    var username = $('#hidUsername').val();
    var session = $('#hidSession').val();
    var id = $('#hidUserId').val();

    //login user
    if (id > 0) {
        $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
            //console.log(data);
            if(data.success) {
                nretry = 0;
                token = data.access_token;
                startGame();            
            } else {
                console.log(err.message);
                // alert(err.message);
                console.log(3);
                // $(".reload2").show();
                nretry++;
                if (nretry < max_retry) {
                    for (i = nretry; i <= max_retry; i++) {
                      getToken();
                    }    
                } else {
                    console.log('retry exist');
                    $(".reload2").show();
                }
            }      
        });

        socketIOConnectionUpdate('Requesting JWT Token from Laravel');

        $.ajax({
            url: '/token'
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            htm = '<p class="text-warning">Unauthorized.</p>';
            socketIOConnectionUpdate( htm);
        })
        .done(function (result, textStatus, jqXHR) {

            socketIOConnectionUpdate('Response from Laravel');

            var c_url = url + ':' + port;
            
            console.log('connecting URL: '+c_url);
            
            //Output have userid , token and username 
            
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
                socketIOConnectionUpdate('Connected to SocketIO, Authenticating')
                console.log('Token: '+result.token);
                socket.emit('authenticate', {token: result.token});
            });

            /* 
            If token authenticated successfully then here will get message 
            */
            socket.on('authenticated', function () {
                htm = '<p class="text-success">Authenticated.</p>';
                socketIOConnectionUpdate(htm);
            });

            /* 
            If token unauthorized then here will get message 
            */
            socket.on('unauthorized', function (data) {
                socketIOConnectionUpdate('Unauthorized, error msg: ' + data.message);
            });

            /* 
            If disconnect socketio then here will get message 
            */
            socket.on('disconnect', function () {
                console.log('disconnect--');
                htm = '<p class="text-danger">Disconnected.</p>';
                socketIOConnectionUpdate(htm);
            });

            socket.on(prefix+ id + "-topup-notification" + ":App\\Events\\EventDynamicChannel" , function(data){
                getNotification(data.data, true);
            });

            if (is_app) {
                socket.on(prefix+gameid+"-rank-list" + ":App\\Events\\EventDynamicChannel", function(data) {
                    console.log(data);
                    getMyRanking();
                    getGlobalRanking();
                    getFriendRanking();

                });    
            }

            socket.on(prefix+ id + "-ledger" + ":App\\Events\\EventLedger" , function(data){
                console.log(prefix+ id + "-ledger" + ":App\\Events\\EventLedger");
                console.log(data.data);
                var gameid = data.data.game_id;

                if (gameid == 102) {
                  var updated_102_point = data.data.point;
                  var updated_102_life = data.data.life;

                  if (updated_102_life <= 0) {
                    closeAllModal();
                    $('#reset-life-share').modal();
                  }

                }
            });
            
        });

    } else {
        //non-logged in user
        $('#hidLatestResult').val(1);
        DomeWebController.init();
        bindBetButton();
        $(".loading").fadeOut("slow");
    }
    
}

function resetTimer(){
    var user_id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/game-setting?gameid=102&memberid=" + user_id,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error);
            // alert(error.message);
            console.log(4);
            // $(".reload2").show();
            resetTimer();
        },
        success: function(data) {
            var duration = data.record.duration;
            var timer = data.record.remaining_time;
            var freeze_time = data.record.freeze_time;

            trigger = false;
            clearInterval(parent.timerInterval);
            //startTimer(duration, timer, freeze_time);
        }
    });
}

function startGame() {

    initShowModal();
    var id = $('#hidUserId').val();

    $.ajax({
        type: 'POST',
        url: "/api/wallet-detail?gameid=102&memberid=" + id, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) {
            console.log(error);
            alert(error.message);
            console.log(5);
            // $(".reload2").show();
            startGame();
        },
        success: function(data) {
            var wallet_records = data.record;

            initUser(wallet_records);
        }
    });

    $.ajax({
        type: 'GET',
        url: "/api/game-setting?gameid=102&memberid=" + id, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error);
            // alert(error.message);
            console.log(6);
            // $(".reload2").show();
            startGame();
        },
        success: function(data) {
            //console.log(data);
            usedlife = data.record.usedlife;
            game_records = data.record.setting;
            betting_records = data.record.bettinghistory.data;
            latest_result = data.record.bettinghistory.data;
            var level = data.record.level;
            var consecutive_lose = data.record.consecutive_lose;
            // console.log('consecutive_lose:'+consecutive_lose);
            initGame(game_records, level, latest_result, consecutive_lose);

            
            //console.log(data);
            updateHistory(betting_records);
            updateResult(betting_records);
            show_win = false;
            show_lose = false;

            if (betting_records.length <= 0 && g_life > 0) { //is newbie or not
                $('#modal-newbie').modal();    
            }
        }
    });

}

function resetGame() {
    $('div.clicked').find('.bet').hide();
    $('div.clicked').removeClass('clicked').find('.bet-container').hide();
    $('.payout-info').addClass('hide');
    $('.spinning').css('visibility', 'hidden');
    $('#btnPointer').removeClass('ready');
    $('.radio-primary').unbind('click');
    $('.small-border').removeClass('fast-rotate');

    $('.shan span').hide();
    $('.shan div').removeClass('clicked');
    startGame();
}

function initShowModal(){

    if(show_win){
        $('#win-modal').modal({backdrop: 'static', keyboard: false});
        closeWinModal();
    }

    if(show_lose){
        $('#lose-modal').modal({backdrop: 'static', keyboard: false});
        closeWinModal();
    }
}

function setBalance() {
    var selected = $('div.clicked').find('input:radio').val();
    if (typeof selected == 'undefined'){
        //do nothing
    } else {
        var bet_amount = parseInt($('#hidBet').val());
        var total_balance = parseInt($('#hidTotalBalance').val());
        var balance = parseInt($('#hidBalance').val());
        var acupoint = parseInt($('.spanAcuPointAndBalance').html());

        var newbalance = balance - bet_amount;
        var newtotalbalance = total_balance - bet_amount;
        //console.log(balance + " - " + bet_amount + " = " + newbalance);
        if(newbalance < 0){

        } else {
            //$('#spanPoint').html(newtotalbalance);
        }
    }
}

function checkSelection() {
    if($('#btnPointer').hasClass('ready')){
        var selected = $('div.clicked').find('input:radio').val();
        if (typeof selected == 'undefined'){
            $( '.DB_G_hand_2' ).show();
            $('.span-odd').html('请选单双').show();
            $('.span-even').html('请选单双').show();
            $('.shan div').addClass('clicked').removeClass('lose');

            $('.spinning').html('请选择单数或选择双数<br />再点击“开始抽奖”进行抽奖');
             $('.spinning').css('visibility', 'visible');
            setTimeout(function(){ 
                $('.spinning').css('visibility', 'hidden');
            }, 3000);
        } else {
            //$('.middle-label').html('正在抽奖');
            $('.DB_G_hand_3').hide();
            $('.radio-primary').unbind('click');
            $('.btn-trigger').unbind('click');
            bindSpinningButton();
            startTimer(5, 5, 1);
        }
    } else {
        //$('.middle-label').html('选择金币');
        $('.span-odd').html('请选挖宝币').show();
        $('.span-even').html('请选挖宝币').show();
        $('.shan div').addClass('clicked');

        $('.spinning').html('请选择挖宝币');
        $('.spinning').css('visibility', 'visible');
        setTimeout(function(){ 
            $('.spinning').css('visibility', 'hidden');
        }, 3000);
    }
}

function closeModal() {
    $('.close-modal').click(function(){
        $('#reset-life-play').modal('hide');
        $('#reset-life-lose').modal('hide');
        $('#game-rules').modal('hide'); 
    });
}

function closeWinModal() {

    $('.close-win-modal').click(function(event){
        // console.log(g_current_point);
        // console.log(g_previous_point);
        
        if (g_current_point > g_previous_point) {
            musicPlay(2);
        } 

         if(g_current_point > max_acupoint){
             g_current_point = max_acupoint;
         }
        
        $('.spanAcuPointAndBalance').html(g_current_point);
        $('.spanAcuPoint').html(g_current_point);

        $(this).off('click');
        event.stopImmediatePropagation();
        $('#win-modal').modal('hide');
        $('#lose-modal').modal('hide');
        
    });
}

function bindSpinningButton() {
    $('.radio-primary').click(function( event ){
        $('.spinning').html('转盘转动中，请等待结果。');
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
        var life = $("#nTxt").val();
        var acupoint = parseInt($('.spanAcuPointAndBalance').html());
        var draw_id = $('#draw_id').val();
        var consecutive_lose = $('#hidConsecutiveLose').val();

        var user_id = $('#hidUserId').val();
        if(user_id == 0){
            // window.top.location.href = "/member";
            if (is_app) {
                $( '#modal-no-login' ).modal( 'show' );                
                setTimeout(function(){
                    console.log('1111');
                    // $( '#modal-no-login' ).modal( 'hide' );
                    window.location.href = '/login';
                }, 3000);
            } else {
                $( '#login-intropopup' ).modal( 'show' );    
            }
        }

        // if(isNaN(balance)){
        //     console.log('balance ' + balance);
        //     return false;
        // }

        // console.log(user_id +":" + balance + ":" + life );
        if(user_id > 0 && life > 0){

            if(balance < 63) {
                if(consecutive_lose == 'yes'){
                    bindResetLifeButton();
                    $('#reset-life-lose').modal({backdrop: 'static', keyboard: false});
                } else {
                    bindResetLifeButton();
                    $('#reset-life-start').modal();
                }

            }

        } else if(user_id > 0 && life == 0){
                closeAllModal();
                $('#reset-life-share').modal();
        }

        if (user_id > 0 && acupoint >= max_acupoint) {
            bindResetLifeButton();
            $('#reset-life-max').modal();
            return false;
        }


        $('.radio-primary').not(this).find('.radio').removeClass('clicked');
        $('.radio-primary').not(this).find('.bet-container').hide();
        $('.radio-primary').not(this).find('.bet').hide();

        $(this).find('.bet-container').toggle();
        $(this).find('.bet').toggle();
        $(this).find('.radio').toggleClass('clicked');

        showPayout();
    });
}

function showPayout(){
    var selected = $('div.clicked').find('input:radio').val();
    var balance = parseInt($('#hidBalance').val());
    var total_balance = parseInt($('#hidTotalBalance').val());
    var level = parseInt($('#hidLevel').val());
    var user_id = $('#hidUserId').val();

    var bet_amount = parseInt($('#hidBet').val());
    var newbalance = balance - bet_amount;
    var newtotalbalance = total_balance - bet_amount;
    var bet_count = $('#hidbetting_count').val();


        if (typeof selected == 'undefined'){
            if($('#btnPointer').hasClass('ready')){
                $( '.DB_G_hand_2' ).show();
                $( '.DB_G_hand_3' ).hide();
            } else {
                $( '.DB_G_hand_2' ).hide();
                $( '.DB_G_hand_3' ).hide();
            }
            //$('.middle-label').html('选择单双');
            $('.span-odd').removeClass('ready lose').html('请选单双').show();
            $('.span-even').removeClass('ready lose').html('请选单双').show();
            $('.shan div').addClass('clicked').removeClass('lose');

            if(bet_count == 0){
                $('.selection').show();
                $('.start-game').hide();
            }

            checked(level, false);
            changbar(level);

            $('#spanPoint').html(total_balance);
            $('.instruction').css('visibility', 'visible');
            $('.payout-info').addClass("hide");

        } else {
            

            if(selected == 'odd'){
                $('.div-odd').removeClass('lose');
                $('.div-even').addClass('lose');
            } else {
                $('.div-odd').addClass('lose');
                $('.div-even').removeClass('lose');
            }

            if($('#btnPointer').hasClass('ready')){
                //$('.middle-label').html('开始抽奖');
                $( '.DB_G_hand_2' ).hide();
                $( '.DB_G_hand_3' ).show();
                if(selected == 'odd'){
                    $('.span-odd').removeClass('lose').addClass('ready').html('<img src="/client/images/wheel/miniicon.png" class="miniicon" />' + bet_amount + '挖宝币');
                    $('.span-even').addClass('ready lose').html('谢谢参与');
                } else {
                    $('.span-odd').addClass('ready lose').html('谢谢参与');
                    $('.span-even').removeClass('lose').addClass('ready').html('<img src="/client/images/wheel/miniicon.png" class="miniicon" />' + bet_amount + '挖宝币');
                }
            } else {
                //$('.middle-label').html('选择金币');
                $( '.DB_G_hand_2' ).hide();
                $( '.DB_G_hand_3' ).hide();
                $('.span-odd').removeClass('ready lose').html('请选挖宝币').show();
                $('.span-even').removeClass('ready lose').html('请选挖宝币').show();
                $('.shan div').addClass('clicked');

            }

            checked(level, true);
            changbar(level);

            if(bet_count == 0){
                $('.selection').hide();
                $('.start-game').show();
            }

            if(newbalance < 0){
                 $('div.clicked').find('.bet').hide();
                $('div.clicked').removeClass('clicked').find('.bet-container').hide();
                return false;
            } else {
                //$('#spanPoint').html(newtotalbalance);
                $('.instruction').css('visibility', 'hidden');


                if(selected == 'odd'){
                    $('.odd-sign').html('+');
                    $('.even-sign').html('-');
                } else {
                    $('.odd-sign').html('-');
                    $('.even-sign').html('+');
                }
                
            }

            //$('.payout-info').removeClass("hide");

        }

    
}

function bindCalculateButton(){
    $('.btn-redeemcash').click( function() {
        if (g_life > 0) {
            //$('#reset-life-play').modal({backdrop: 'static', keyboard: false});
            $('#game-rules').modal();
        } else {
            if (user_id > 0) {
                closeAllModal();
                $('#reset-life-share').modal();    
            }
        }
    });

    $('.banner-rules').click(function() {
        $('#game-rules').modal();
    });
}

function bindTriggerButton(){
    $('.btn-trigger').click(function( event ){
        user_id = $('#hidUserId').val();
        if (g_life > 0) {
            event.stopImmediatePropagation();
            checkSelection();
        } else {
           if (user_id > 0) {
            closeAllModal();
                $('#reset-life-share').modal();    
            } else {
                if (is_app) {
                    $( '#modal-no-login' ).modal( 'show' );                
                    setTimeout(function(){
                        console.log('1111');
                        // $( '#modal-no-login' ).modal( 'hide' );
                        window.location.href = '/login';
                    }, 3000);                 
                }
            }
        }
    });

    $( ".DB_G_hand_3" ).click(function(){
        $('.btn-trigger').trigger("click");
    });
}

function bindResetLifeButton(){

    $( '.btn-reset-life' ).click( function( event ){
        $(this).off('click');
        event.stopImmediatePropagation();

        var wechat_status = 0; //$('#hidWechatStatus').val(); //ignore wechat status verification
        var user_id = $('#hidUserId').val();
        var previous_point = g_cookies_point;

        // add points from additional life.
        if(user_id > 0){
            if (wechat_status == 0) {
                $.ajax({
                    type: 'POST',
                    url: "/api/resetlife",
                    data: { 'memberid': user_id, 'gameid': 102, 'life': 'yes' },
                    dataType: "json",
                    beforeSend: function( xhr ) {
                        xhr.setRequestHeader ("Authorization", "Bearer " + token);
                    },
                    error: function (error) { 
                        console.log(error.responseText) 
                        console.log(error);
                        // alert(error.message);
                        window.parent.location.href = "/profile";
                    },
                    success: function(data) {
                        if(data.success){
                            Cookies.set('previous_point', previous_point);
                            window.parent.location.href = "/redeem";
                            // window.parent.location.href = "/profile";
                        }
                    }
                });
            } else {
                $('.modal').modal('hide');
                $('.modal-backdrop').remove(); 
                if (is_app) {
                    $('#wechat-verification-modal').modal();    
                } else {
                    $('#csModal').modal();    
                }
            }
            
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
                data: { 'memberid': user_id, 'gameid': 102, 'life': 'yes' },
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { 
                    console.log(error.responseText)
                    console.log(error);
                    // alert(error.message);
                    console.log(8);
                    $(".reload2").show();
                },
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

function showContent(level) {
    var content = '';

    switch (level) {

        default:
        case 1:
            content = '这局请投1挖宝币';
        break;

        case 2:
            content = '上局亏了1挖宝币，这局请投3挖宝币';
        break;

        case 3:
            content = '上局亏了3挖宝币，这局请投7挖宝币';
        break;

        case 4:
            content = '上局亏了7挖宝币，这局请投15挖宝币';
        break;

        case 5:
            content = '上局亏了15挖宝币，这局请投31挖宝币';
        break;

        case 6:
            content = '上局亏了31挖宝币，这局请投63挖宝币';
        break;
    }

    $('.span-content').html(content);
}

function showProgressBar(bol_show){
    var level = parseInt($('#hidLevel').val());
    var consecutive_lose = $('#hidConsecutiveLose').val();
    var balance = parseInt($('#hidBalance').val());
    var payout_info = '';
    var span_balance = 120;
    var result_info ='';

    if(consecutive_lose == 'yes') {
        $('.span-1').html("-1");
        $('.span-2').html("-3");
        $('.span-3').html("-7");
        $('.span-4').html("-15");
        $('.span-5').html("-31");
        $('.span-6').html("-63");
        $('.span-balance').html(0);
    
        $('.payout-info').html(payout_info).addClass('hide');
        $('.spanAcuPoint').html(0);
        $('.spanAcuPointAndBalance').html(0);
        
        result_info = '剩余<span style="text-decoration:underline">'+ balance +'</span>元体验金&nbsp;';
        $('.result-info').html(result_info);


        
        
        checked(7, false);
        changbar(7);
    } else {

        switch (level) {

            default:
            case 1:
                previous_bet = 1;
                current_bet = 1;                

                payout_info = '押注1元，猜对+1，猜错-1。';
                //payout_info = '<span class=\'caption_bet\'>[单数]</span>押注10积分，猜对+10，猜错-10。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中赚10金币，可兑换1元。';//'猜中得10，赚10金币。';
                $('.span-1').html("1");
                $('.span-2').html("3");
                $('.span-3').html("7");
                $('.span-4').html("15");
                $('.span-5').html("31");
                $('.span-6').html("63");

                result_info = '本轮还有6次机会。';

                break;
            case 2:
                current_bet = 3;
                previous_bet = 1;
                span_balance = 119;
                result_info = '本轮错了1次，还剩5次。';

                payout_info = '押注3元，猜对+3，猜错-3。';
                //payout_info = '<span class=\'caption_bet\'>[单数]</span>押注30积分，猜对+30，猜错-30。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得30，赚20金币。';//'猜中得30，扣除之前亏损10，赚20金币。';
                $('.span-1').html("-1");                        
                break;
            case 3:                    
                current_bet = 7;
                previous_bet = 3;
                span_balance = 116;
                result_info = '本轮错了2次，还剩4次。';

                payout_info = '押注7元，猜对+7，猜错-7。';
                // payout_info = '<span class=\'caption_bet\'>[单数]</span>押注70积分，猜对+70，猜错-70。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得70，赚30金币。';//'猜中得70，扣除前2次亏损40，赚30金币。';
                $('.span-1').html("-1");
                $('.span-2').html("-3");
                break;
            case 4:
                current_bet = 15;
                previous_bet = 7;
                span_balance = 109;
                result_info = '本轮错了3次，还剩3次。';

                payout_info = '押注15元，猜对+15，猜错-15。';
                //payout_info = '<span class=\'caption_bet\'>[单数]</span>押注150积分，猜对+150，猜错-150。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得150，赚40金币。';//'猜中得150，扣除前3次亏损110，赚40金币。';
                $('.span-1').html("-1");
                $('.span-2').html("-3");
                $('.span-3').html("-7");
                break;
            case 5:
                current_bet = 31;
                previous_bet = 15;
                span_balance = 94;
                result_info = '本轮错了4次，还剩2次。';

                payout_info = '押注31元，猜对+31，猜错-31。';
                //payout_info = '<span class=\'caption_bet\'>[单数]</span>押注310积分，猜对+310，猜错-310。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得310，赚50金币。';//'猜中得310，扣除前4次亏损260，赚50金币。';
                $('.span-1').html("-1");
                $('.span-2').html("-3");
                $('.span-3').html("-7");
                $('.span-4').html("-15");
                break;
            case 6:
                current_bet = 63;
                previous_bet = 31;
                span_balance = 63;
                result_info = '本轮剩1次机会，猜错清零。';                

                payout_info = '押注63元，猜对+63，猜错-63。';
                // payout_info = '<span class=\'caption_bet\'>[单数]</span>押注630积分，猜对+630，猜错-630。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得630，赚60金币。';//'猜中得630，扣除前5次亏损570，赚60金币。';
                $('.span-1').html("-1");
                $('.span-2').html("-3");
                $('.span-3').html("-7");
                $('.span-4').html("-15");
                $('.span-5').html("-31");
                break;
        }

        result_info = '剩余<span style="text-decoration:underline">'+ span_balance +'</span>元体验金&nbsp;';

        $('.span-balance').html(span_balance);
        $('#hidBet').val(current_bet);
        $('.result-info').html(result_info);
        $('.odd-payout').html(0);
        $('.even-payout').html(0);

        if(bol_show) {
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
            info = '本局抽中<span class="highlight-green">1挖宝币</span><br /><span class="highlight-red">最终赚1挖宝币=兑换1元。</span>';
            image = '/client/images/progress-bar/10.png';
            html += '+1挖宝币';
            remain = 15 - (g_previous_point) - 1;
            instructions = '你已赚到' + (g_previous_point + 1) + '元，';
        break;

        case 2:
            info = '本局抽中<span class="highlight-green">3挖宝币</span><br />前1局没抽中<span class="highlight">亏损1挖宝币</span><br /><span class="highlight-red">最终赚2挖宝币=兑换2元。</span>';
            image = '/client/images/progress-bar/30.png';
            html += '+3挖宝币';
            remain = 15 - (g_previous_point) - 2;
            instructions = '你已赚到' + (g_previous_point + 2) + '元，';   
        break;

        case 3:
            info = '本局抽中<span class="highlight-green">7挖宝币</span><br />前2局没抽中<span class="highlight">亏损4挖宝币</span><br /><span class="highlight-red">最终赚3挖宝币=兑换3元。</span>';
            image = '/client/images/progress-bar/70.png';
            html += '+7挖宝币';
            remain = 15 - (g_previous_point) - 3;
            instructions = '你已赚到' + (g_previous_point + 3) + '元，';
        break;

        case 4:
            info = '本局抽中<span class="highlight-green">15挖宝币</span><br />前3局没抽中<span class="highlight">亏损11挖宝币</span><br /><span class="highlight-red">最终赚4挖宝币=兑换4元。</span>';
            image = '/client/images/progress-bar/150.png';
            html += '+15挖宝币';
            remain = 15 - (g_previous_point) - 4;
            instructions = '你已赚到' + (g_previous_point + 4) + '元，';
        break;

        case 5:
            info = '本局抽中<span class="highlight-green">31挖宝币</span><br />前4局没抽中<span class="highlight">亏损26挖宝币</span><br /><span class="highlight-red">最终赚5挖宝币=兑换5元。</span>';
            image = '/client/images/progress-bar/310.png';
            html += '+31挖宝币';
            remain = 15 - (g_previous_point) - 5;
            instructions = '你已赚到' + (g_previous_point + 5) + '元，';
        break;

        case 6:
            info = '本局抽中<span class="highlight-green">63挖宝币</span><br />前5局没抽中<span class="highlight">亏损57挖宝币</span><br /><span class="highlight-red">最终赚6挖宝币=兑换6元。</span>';
            image = '/client/images/progress-bar/630.png';
            html += '+63挖宝币';
            remain = 15 - (g_previous_point) - 6;
            instructions = '你已赚到' + (g_previous_point + 6) + '元，';
        break;

    }

    if(remain < 0){
        remain = 0;
    }

    $('.modal-progress-bar').attr("src", image);
    $('#win-modal .packet-value').html(html);
    $('#win-modal .packet-info').html(info);

    $('.highlight-link').click(function(){
        $('#game-rules').modal();
    });

    $('.btn-rules-close').click(function(){
        $('#game-rules').modal('hide');
    });

    $('.btn-rules-timer').click(function(){
        $('#game-rules').modal('hide');
    });

    // console.log('standby play win mp3');
    // setTimeout(function(){
    //     console.log('play win mp3');
    //     musicPlay(2);
    // }, 9000);

}

function showLoseModal(){
    var level = parseInt($('#hidLevel').val());
    var html = '';
    var image = '';
    var result_info = '6次内猜对奖励加倍';

    switch (level) {

        case 1:
            // instruction = '前1局猜错，<span class="highlight-green">总亏损1元</span>，根据倍增式玩法，第2局<span class="highlight-orange">将押注3元</span>，如猜对能获得3元奖励，减去亏损的1还能赚2元。<br />赚到的元自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            // instruction = '前1局猜错，<span class="highlight-grey">总亏损1元</span>，根据倍增式玩法，第2局将<span class="highlight-green">押注3元</span>，猜对能获得3元奖励，减去亏损的1还能赚2元。<br /><span class="highlight-red">赚到的元可兑换红包，1元兑换1元。</span>';
            instruction = '前1局没抽中，<span class="highlight-grey">总亏损1挖宝币</span>，第2局将<span class="highlight-green">加倍✕3</span>，抽中得3挖宝币，减去亏损的1挖宝币还能赚2挖宝币。';
            image = '/client/images/progress-bar/lose_10.png';
            html += '<div class="modal-win-title">差点抽中...再来一次...</div><div class="modal-result">下局奖励加倍</div>'; 
            result_info = '5次内猜对奖励加倍';
        break;

        case 2:
            // instruction = '前2局猜错，<span class="highlight-green">总亏损4元</span>，根据倍增式玩法，第3局<span class="highlight-orange">将押注7元</span>，如猜对能获得7元奖励，减去亏损的40还能赚3元。<br />赚到的元自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            // instruction = '前2局猜错，<span class="highlight-grey">总亏损4元</span>，根据倍增式玩法，第3局将<span class="highlight-green">押注7元</span>，猜对能获得7元奖励，减去亏损的40还能赚3元。<br /><span class="highlight-red">赚到的元可兑换红包，1元兑换1元。</span>';
            instruction = '前2局没抽中，<span class="highlight-grey">总亏损4挖宝币</span>，第3局将<span class="highlight-green">加倍✕7</span>，抽中得7挖宝币，减去亏损的4挖宝币还能赚3挖宝币。';
            image = '/client/images/progress-bar/lose_30.png';
            html += '<div class="modal-win-title">差点抽中...再来一次...</div><div class="modal-result">下局奖励加倍</div>'; 
            result_info = '4次内猜对奖励加倍';
        break;

        case 3:
            // instruction = '前3局猜错，<span class="highlight-green">总亏损11元</span>，根据倍增式玩法，第4局<span class="highlight-orange">将押注15元</span>，如猜对能获得15元奖励，减去亏损的11还能赚4元。<br />赚到的元自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            // instruction = '前3局猜错，<span class="highlight-grey">总亏损11元</span>，根据倍增式玩法，第4局将<span class="highlight-green">押注15元</span>，猜对能获得15元奖励，减去亏损的11还能赚4元。<br /><span class="highlight-red">赚到的元可兑换红包，1元兑换1元。</span>';
            instruction = '前3局没抽中，<span class="highlight-grey">总亏损11金币</span>，第4局将<span class="highlight-green">加倍✕15</span>，抽中得15金币，减去亏损的11挖宝币还能赚4金币。';
            image = '/client/images/progress-bar/lose_70.png';
            html += '<div class="modal-win-title">差点抽中...再来一次...</div><div class="modal-result">下局奖励加倍</div>'; 
            result_info = '3次内猜对奖励加倍';
        break;

        case 4:
            // instruction = '前4局猜错，<span class="highlight-green">总亏损26元</span>，根据倍增式玩法，第5局<span class="highlight-orange">将押注31元</span>，如猜对能获得31元奖励，减去亏损的260还能赚5元。<br />赚到的元自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            // instruction = '前4局猜错，<span class="highlight-grey">总亏损26元</span>，根据倍增式玩法，第5局将<span class="highlight-green">押注31元</span>，猜对能获得31元奖励，减去亏损的260还能赚5元。<br /><span class="highlight-red">赚到的元可兑换红包，1元兑换1元。</span>';
            instruction = '前4局没抽中，<span class="highlight-grey">总亏损26金币</span>，第5局将<span class="highlight-green">加倍✕31</span>，抽中得31金币，减去亏损的26挖宝币还能赚5金币。';
            image = '/client/images/progress-bar/lose_150.png';
            html += '<div class="modal-win-title">差点抽中...再来一次...</div><div class="modal-result">下局奖励加倍</div>'; 
            result_info = '2次内猜对奖励加倍';
        break;

        case 5:
            // instruction = '前5局猜错，<span class="highlight-green">总亏损57元</span>，根据倍增式玩法，第6局<span class="highlight-orange">将押注63元</span>，如猜对能获得63元奖励，减去亏损的57还能赚6元。<br />赚到的元自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            // instruction = '前5局猜错，<span class="highlight-grey">总亏损57元</span>，根据倍增式玩法，第6局将<span class="highlight-green">押注63元</span>，猜对能获得63元奖励，减去亏损的57还能赚6元。<br /><span class="highlight-red">赚到的元可兑换红包，1元兑换1元。</span>';
            instruction = '前5局没抽中，<span class="highlight-grey">总亏损57挖宝币</span>，第6局将<span class="highlight-green">加倍✕63</span>，抽中得63挖宝币，减去亏损的57挖宝币还能赚6挖宝币。';
            image = '/client/images/progress-bar/lose_310.png';
            html += '<div class="modal-win-title">差点抽中...再来一次...</div><div class="modal-result">下局奖励加倍</div>'; 
            result_info = '1次内猜对奖励加倍';
        break;

    }

    html = '<div class="modal-win-title">差点抽中...再来一次...</div><div class="modal-result">下局奖励加倍</div>'; 

    $('.modal-progress-bar').attr("src", image);
    $('#lose-modal .modal-win-header').html(html);
    $('#lose-modal .modal-instruction').html(instruction);
    
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

    try {

        var selected = $('div.clicked').find('input:radio').val();
        var trigger_time = freeze_time - 1;
        var id = $('#hidUserId').val();
        var level = parseInt($('#hidLevel').val());
        $('.small-border').addClass('fast-rotate');
        g_previous_point = parseInt($('.spanAcuPointAndBalance').html());
        bet_amount = parseInt($('#hidBet').val());

        //update bet
        $.ajax({
            type: 'GET',
            url: "/api/update-game-result-temp?gameid=102&gametype=1&memberid="+ user_id
            + "&drawid=0" 
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
                console.log(error);
                // alert(error.message);
                console.log(7);
                // $(".reload2").show();
                showPayout();
            },
            success: function(data) {
                //get result
                $.ajax({
                    type: 'POST',
                    url: "/api/get-betting-result?gameid=102&memberid=" + id, 
                    dataType: "json",
                    beforeSend: function( xhr ) {
                        xhr.setRequestHeader ("Authorization", "Bearer " + token);
                    },
                    error: function (error) { 
                        console.log(error);
                        // alert(error.message);
                        console.log(9);
                        // $(".reload2").show();
                        // window.top.location.href = "/arcade";
                        startTimer(duration, timer, freeze_time);
                    },
                    success: function(data) {
                        _success = data.success;
                        if (_success) {
                            nretry = 0;
                            $('.small-border').removeClass('fast-rotate');
                            $('#result').val(data.game_result);
                            if(data.status == 'win'){
                                show_win = true;
                                showWinModal();
                            } else if(data.status == 'lose' && level < 6) {
                                show_lose = true;
                                showLoseModal();
                            }
                            triggerResult();
                        } else {
                            nretry++;
                            if (nretry < max_retry) {
                                for (i = nretry; i <= max_retry; i++) {
                                  startTimer(duration, timer, freeze_time);
                                }    
                            } else {
                                console.log('retry exist');
                                $(".reload2").show();
                            }
                        }
                    },
                    timeout: 10000 // sets timeout to 10 seconds
                });
            }
        });

    }
    catch(err) {
      // alert('下注失败');
      console.log(err);
       // alert(err.message);
       console.log(10);
    $(".reload2").show();
    }
}

function triggerResult(){
    trigger = true;
    //console.log(data);
    var freeze_time = 10;
    var result = $('#result').val();
    // console.log(freeze_time);

    //Trigger the wheel
    DomeWebController.getEle("$wheelContainer").wheelOfFortune({
        'items': {1: [360, 360], 2: [60, 60], 3: [120, 120], 4: [180, 180], 5: [240, 240], 6: [300, 300]},//奖品角度配置{键:[开始角度,结束角度],键:[开始角度,结束角度],......}
        'pAngle': 0,//指针图片中的指针角度(x轴正值为0度，顺时针旋转 默认0)
        'type': 'w',//旋转指针还是转盘('p'指针 'w'转盘 默认'p')
        'fluctuate': 0.5,//停止位置距角度配置中点的偏移波动范围(0-1 默认0.8)
        'rotateNum': 6,//转多少圈(默认12)
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

    $( "#btnPointer" ).trigger( "click" );

    setTimeout(function(){
        $('.middle-label').html('<div style="font-size:0.6rem;padding-top:0.25rem">'+result+'</div>');              
    
    }, (freeze_time - 1) * 1000);

    setTimeout(function(){
        // if (show_win) {
        //     musicPlay(2);   
        // }
        resetGame();
    }, freeze_time * 1000);
    
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
        var freeze_time = 5;
        var startKey = $('#hidLatestResult').val();
        var lastBet = $('#hidLastBet').val();

        that.getEle("$wheelContainer").wheelOfFortune({
            'wheelImg': "/client/images/wheel.png",//转轮图片
            'pointerImg': "/client/images/wheel/pointer-default.png",//指针图片
            'buttonImg': "/client/images/wheel/pointer-default.png",//开始按钮图片
            'wSide': 200,//转轮边长(默认使用图片宽度)
            'pSide': 100,//指针边长(默认使用图片宽度)
            'bSide': 50,//按钮边长(默认使用图片宽度)
            'items': {1: [360, 360], 2: [60, 60], 3: [120, 120], 4: [180, 180], 5: [240, 240], 6: [300, 300]},//奖品角度配置{键:[开始角度,结束角度],键:[开始角度,结束角度],......}
                    
            'pAngle': 0,//指针图片中的指针角度(x轴正值为0度，顺时针旋转 默认0)
            'type': 'w',//旋转指针还是转盘('p'指针 'w'转盘 默认'p')
            'fluctuate': 0.5,//停止位置距角度配置中点的偏移波动范围(0-1 默认0.8)
            'rotateNum': 1,//转多少圈(默认12)
            'duration': freeze_time * 1000,//转一次的持续时间(默认5000)
            'startKey' : startKey,
            'lastBet' : lastBet,
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

//load audio - start
var audioElement = document.createElement('audio');
audioElement.setAttribute('src', '/client/audio/coin.mp3');
var audioElement_win = document.createElement('audio');
audioElement_win.setAttribute('src', '/client/audio/angpao.wav');

function musicPlay(music, lv = null) {    

        if ((music == 1) && ($('#hidLevel').val() == lv)) {  
            // audioElement.setAttribute('src', '/client/audio/coin.mp3');              
            audioElement.play();
            
        } else if (music == 2) {
            // audioElement.setAttribute('src', '/client/audio/angpao.wav');
            audioElement_win.play();
        } else if (music == 22) {
            // audioElement_win.pause();
        } else {        
            //do nothing
            // audioElement.setAttribute('src', '/client/audio/coin.mp3');              
        }
}
//load audio - end

function countDownLife(){
    // Set the date we're counting down to
    var created_date = $('#hidCreatedAt').val();
    var countDownDate = new Date(created_date);
    countDownDate.setDate( countDownDate.getDate() + 1 );
    countDownDate.getTime();

    // Get today's date and time
    var now = new Date().getTime();
        
    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    if (distance > 0) {
        $('.first-life').show();
        $('.span-life').html(15-g_current_point);
        $('.banner-rules').hide();
    }
    
    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();
        
      // Find the distance between now and the count down date
      var distance = countDownDate - now;
        
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = pad(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
      var minutes = pad(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
      var seconds = pad(Math.floor((distance % (1000 * 60)) / 1000));
        
      // Output the result in an element with id="demo"
      $(".div-time").html('<span class="span-time">'+hours+'</span>小时<span class="span-time">'+minutes+'</span>分<span class="span-time">'+seconds+'</span>秒后到期');
        
      // If the count down is over, write some text 
      if (distance < 0) {
        clearInterval(x);
        $('.first-life').hide();
        checkFirstLifePurgeStatus();
        $('banner-rules').show();
      }
    }, 1000);
}

function pad(value) {
    if(value < 10) {
        return '0' + value;
    } else {
        return value;
    }
}

function checkFirstLifePurgeStatus(){
    var user_id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/first-life-purge?memberid=102&memberid=" + user_id,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            console.log(data);
            // if (data.success) {

            // }
            window.top.location.href = "/arcade";
        }
    });
}


//betting animate number
function anp(e, lv, bet){
    // console.log(lv);
    // console.log($('#hidLevel').val());
    if ($('#hidLevel').val() == lv) {
        //var n=Math.round(Math.random()*10);
        // var n = (lv == 1) ? 1 : ((lv == 2) ? 3 : ((lv == 3) ? 7 : ((lv == 4) ? 15 : ((lv == 5) ? 31 : ((lv == 6) ? 63 : lv)))));
        var n=bet;
        var $i=$("<b>").text("成功投币+"+n);
        var x=e.pageX,y=e.pageY;
        // $i.css({top:y-20,left:x,position:"absolute",color:"#E94F06"});
        $i.css({top:"4.1rem",left:"3.1rem",position:"absolute",color:"#E94F06"});
        $("body").append($i);
        // $i.animate({top:y-180,opacity:0,"font-size":"1.4em"},1500,function(){
        //     $i.remove();
        // });
        $i.animate({top:"0rem",left:"3.1rem",opacity:0,"font-size":"1.4em"},1500,function(){
            $i.remove();
        });
        e.stopPropagation();    
    }    
}

function bindButton () {
     $( '.btn-go-withdraw' ).click( function( event ){
        event.stopImmediatePropagation();
        var wechat_status = 0; //$('#hidWechatStatus').val(); //ignore wechat status verification
        var user_id = $('#hidUserId').val();
        var previous_point = g_cookies_point;

        // add points from additional life.
        if(user_id > 0){
            if (wechat_status == 0) {   
            $(this).off('click');              
                $.ajax({
                    type: 'POST',
                    url: "/api/resetlife",
                    data: { 'memberid': user_id, 'gameid': 102, 'life': 'yes' },
                    dataType: "json",
                    beforeSend: function( xhr ) {
                        xhr.setRequestHeader ("Authorization", "Bearer " + token);
                    },
                    error: function (error) { 
                        console.log(error.responseText) 
                        console.log(error);
                        // alert(error.message);
                        window.parent.location.href = "/redeem";
                    },
                    success: function(data) {
                        if(data.success){
                            Cookies.set('previous_point', previous_point);
                            window.parent.location.href = "/redeem";
                            // window.parent.location.href = "/profile";
                        }
                    }
                });
            } else {
                $('.modal').modal('hide');
                $('.modal-backdrop').remove(); 
                if (is_app) {
                    $('#wechat-verification-modal').modal();    
                } else {
                    $('#csModal').modal();    
                }                
            }
        } else {
            if (is_app) {
                $( '#modal-no-login' ).modal( 'show' );                
                setTimeout(function(){
                    console.log('1111');
                    // $( '#modal-no-login' ).modal( 'hide' );
                    window.location.href = '/login';
                }, 3000);
            }else{
                openmodel();    
            }
        }
    });

     $('.btn-withdraw').click(function() {
        var win_coin_max = Number($('#hidMaxAcupoint').val());
        var win_coin_min = Number($('#hidMinAcupoint').val());
        var _point = Number($('.spanAcuPointAndBalance').html());
        var user_id = $('#hidUserId').val();
        if ((user_id <= 0)) {
            console.log(user_id);
            if (is_app) {
                $( '#modal-no-login' ).modal( 'show' );                
                setTimeout(function(){
                    console.log('1111');
                    // $( '#modal-no-login' ).modal( 'hide' );
                    window.location.href = '/login';
                }, 3000);
            }else{
                openmodel();    
            }            
        } else {
            if (g_life <= 0) {
                // $('#reset-life-share').modal();
                window.top.location.href = "/pre-share";  
             } else {
                if (_point < win_coin_min) {
                    $('.withdraw-value').html(_point);
                    $('#modal-withdraw-insufficient').modal();
                // } else if ((_point >= win_coin_min) && (_point <= win_coin_max)) {
                } else if ((_point >= win_coin_min) && (_point < 10)) {
                    if (is_app) {
                        $('.withdraw-value').html(6);
                        $('.drawn').html(_point);
                        $('#modal-withdraw').modal();
                    } else {
                        if ($('#hidAlipayAccount').val() == 0) {
                            showAliPayForm(); 
                        } else {
                            $('.withdraw-value').html(6);
                            $('.drawn').html(_point);
                            $('#modal-withdraw').modal();
                        }    
                    }

                } else if ((_point >= win_coin_min) && (_point >= 10)) {
                    if (is_app) {
                        $('.withdraw-value').html(10);
                        $('.drawn').html(_point);
                        $('#modal-withdraw').modal();
                    } else {
                        if ($('#hidAlipayAccount').val() == 0) {
                            showAliPayForm();
                        } else {
                            $('.withdraw-value').html(10);
                            $('.drawn').html(_point);
                            $('#modal-withdraw').modal();
                        }
                    }
                } else if (_point >= win_coin_max) {
                    promptResetLifeModal();
                    return false;
                } else {
                    $('.withdraw-value').html(_point);
                    $('#modal-withdraw-insufficient').modal();
                }
            }
        }
    }); 

    $('.btn-life').click(function () {
        var user_id = $('#hidUserId').val();
        if ((user_id <= 0)) {
            if (is_app) {
                $( '#modal-no-login' ).modal( 'show' );                
                setTimeout(function(){
                    console.log('1111');
                    // $( '#modal-no-login' ).modal( 'hide' );
                    window.location.href = '/login';
                }, 3000);
            }else{
                openmodel();    
            }            
        } else {
            window.top.location.href = "/pre-share"; 
            // if (g_life <= 0) {
            //     // $('#reset-life-share').modal();
            //     window.top.location.href = "/pre-share"; 
            //  } else {
            //     window.top.location.href = "/profile";
            //  }
        }

    });    
}

function socketIOConnectionUpdate(err)
{
    console.log(err);
}

function getNotification(data, isSocket = false){
    console.log('get topup notifications');
    console.log(data);
    var notifications = data;
    var notifications_count = notifications.count;
    var _gameid = notifications.gameid;

    if (_gameid == gameid) { //if game id is 102
        if(notifications_count == 0){
            return false;
        }

        var records = notifications.records;

        if ((typeof records[0].ledger.balance_after != 'undefined') || (records[0].ledger.balance_after > 0)) {
            if (isSocket) {
                
                if (records[0].ledger.ledger_type == 'ALLAA') {
                    $('.btn-life').html('剩' + parseInt(records[0].ledger.balance_after) + '次');
                }  
            }
        } 
    }

}

function showAliPayForm() {
    window.location.href = '/alipay/form';
    // $('#alipayform').modal({backdrop: 'static', keyboard: false});
    //fix / prevent ios keyboard from pushing the view off screen
    // document.ontouchmove = function(e){
    //   e.preventDefault();
    // }
    // $('#alipayaccount').onfocus = function () {
    //     window.scrollTo(0, 0);
    //     document.body.scrollTop = 0;
    // }
    
    // $('#alipayaccount').focus();


    // var _originalSize = $(window).width() + $(window).height()
    // alert('testing');
    //   $(window).resize(function(){
    //     alert('testing - resize');
    //     if($(window).width() + $(window).height() != _originalSize){
    //       $("#alipayform").css("position","relative");  
    //       alert("keyboard show up");
    //     }else{
    //       alert("keyboard closed");
    //       $("#alipayform").css("position","fixed");  
    //     }
    //   });


}

function closeAllModal() {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
}

function promptResetLifeModal() {
    closeAllModal();
    if (is_app) {
        $('#reset-life-max').modal();  
    } else {
        if ($('#hidAlipayAccount').val() == 0) {
            showAliPayForm();            
        } else {
            $('#reset-life-max').modal();    
        } 
    }
}