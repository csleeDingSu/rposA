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
var g_vip_point = 0;
var previous_bet = 0;
var current_bet = 0;
var game_records = null; //game setting
var result_records = null; //game history
var latest_result = null; //latest result
var last_bet = null;
var g_ratio = 1;
var g_w_ratio = 2;
var show_default = true;
var g_betting_history_total = 0;
var play_count = 0;
var bet_count = 0;
var gameid = 103;
var g_bet_amount = 0;
var max_retry = 3;
var nretry = 0;
var touchmoved;

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

        getToken();
        getProduct();
        closeModal();
        initNotification();

        ifvisible.on("wakeup", function(){
            //resetTimer();
        });

    } else {
        $(".loading").fadeOut("slow");
        return false;
    }
});

function updateResult(records){

    var str_result = '单数';

    var length = Object.keys(records).length;
    var maxCount = 20;
    bet_count = length;

    if(bet_count > 0 && (!jQuery.isEmptyObject(records[0]))){
        last_bet = records[0].bet;
        $('#hidLastBet').val(last_bet);
    }

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

    if(bet_count == 0 && g_vip_point > 0) {
        $('.speech-bubble-chips').show();
        $('.speech-bubble-clear').show();
    }
}

function updateHistory(records){

    var length = g_betting_history_total;//Object.keys(records).length;
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
        var bet_amt = getNumeric(item.bet_amount);
        var loseOrReward = item.reward > 0 ? getNumeric(item.reward) : bet_amt;

        if(item.is_win == null){
            strwinloss = "猜错";
            strsign = '-';
        }

        if(item.bet == 'even'){
            strbet = "双数";
        }

        history =  '选择<span class="'+ className + '">' + strbet + '</span>，投'+ bet_amt +'挖宝币' + strwinloss + '，' + strsign + loseOrReward +'挖宝币';

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
        
        records = records.gameledger['103'];

        $('.wallet-point').html(0);
        $('.packet-point').html(0);
        var balance = getNumeric(records.point);
        console.log('balance ' + balance);
        console.log(records);
        var life = records.life;
        var point = getNumeric(records.point);
        var acupoint =  getNumeric(records.acupoint);
        g_current_point = getNumeric(records.acupoint);
        play_count = parseInt(records.play_count);
        
        var vip_point =  getNumeric(records.point);
        var vip_life =  parseInt(records.vip_life);
        g_vip_point = getNumeric(point);

        if(vip_life == 0){
            vip_point = 0;
        }

        var total_balance = vip_point;

        $('#spanPoint').html(total_balance);
        
        $('#hidTotalBalance').val(total_balance);
        $('.wallet-point').html(point);
        $('.packet-point').html(point);
        if(show_win){
            
        } else {
            $('.spanAcuPoint').html(point);
            if ($('.spanAcuPointAndBalance').html() <= 0) {
                console.log($('.spanAcuPointAndBalance').html());
                $('.spanAcuPointAndBalance').html(get2Decimal(point));    
            }
        }
        $('.packet-acupoint').html(acupoint);
        $('.packet-acupoint-to-win').html(15 - acupoint);
        $('#hidBalance').val(balance);
        $(".nTxt").html(life);
        $(".spanVipLife").html(vip_life);
        $(".spanLife").html(life);
        $(".span-play-count").html(play_count);  
    }
}

function initGame(data, level, latest_result, consecutive_lose){
try {
 
    var user_id = $('#hidUserId').val();
    trigger = false;

        var bet_amount = 0;
        g_bet_amount = bet_amount;
        var duration = 10;
        var timer = 10;
        var freeze_time = 1;
        var draw_id = data.drawid;
        //var level = level.position;
        var previous_result = 1;
        var consecutive_lose = consecutive_lose;
        var life = $(".nTxt").html();
        var balance = $('#hidBalance').val();
        var payout_info = '';
        var acupoint = parseInt($('.spanAcuPoint').html());
        var previous_bet_amount = 0;
        var previous_reward = 0;

        if(latest_result.length > 0){
            previous_result = latest_result[0].result;
            previous_bet_amount = latest_result[0].bet_amount;
            previous_reward = latest_result[0].reward;
            $('.middle-label').html('<div style="font-size:0.6rem;padding-top:0.25rem">'+previous_result+'</div>');
        }

        //$('#hidLevel').val(level);
        $('#hidLatestResult').val(previous_result);   
        $('#hidLastBetAmount').val(previous_bet_amount);
        $('#hidLastReward').val(previous_reward);     
        $('#hidConsecutiveLose').val(consecutive_lose);

        $('.barBox').find('li').removeClass('on');

        $('#freeze_time').val(freeze_time);
        $('#draw_id').val(draw_id);

        DomeWebController.init();
        trigger = false;
        clearInterval(parent.timerInterval);

        bindBetButton();

        bindCalculateButton();
        bindTriggerButton();

        $(".loading").fadeOut("slow");

        // $.ajax({
        //     type: 'GET',
        //     url: "/api/get-game-result-temp?gameid=103&gametype=1&memberid=" + user_id + "&drawid=0",
        //     dataType: "json",
        //     beforeSend: function( xhr ) {
        //         xhr.setRequestHeader ("Authorization", "Bearer " + token);
        //     },
        //     error: function (error) { 
        //         console.log(error);
        //         // $(".reload2").show();
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
      $('.spinning').html('等待网络');
        $('.spinning').css('visibility', 'visible');
        setTimeout(function(){ 
            $('.spinning').css('visibility', 'hidden');
        }, 3000);
      $(".reload2").show();
    }
}

function socketIOConnectionUpdate(err)
{
    console.log(err);
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
                $('.icon-newcoin').unbind('click');
                getNotification(data.data, true);
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

function getNotification(data, isSocket = false){
    console.log('get topup notifications');
    console.log(data);
    var notifications = data;

    var notifications_count = notifications.count;
    console.log('notifications.gameid --- ' + notifications.gameid);
    var _gameid = (typeof notifications.gameid == 'undefined') ? gameid : notifications.gameid;

    if (_gameid == gameid) { //if game id is 103
        if(notifications_count == 0){
            $('.icon-red').html(notifications_count).hide();
            return false;
        } else if (notifications_count > 9){
            notifications_count = 'N';
        }

        $('.icon-red').html(notifications_count).show();

        var records = notifications.records;

        // if ((typeof records[0].ledger.balance_after != 'undefined') || (records[0].ledger.balance_after > 0)) {
        if (records[0].ledger.ledger_type == 'APPAA'){
            if (isSocket) {
                console.log('g_vip_point --- ' + g_vip_point);
                console.log('g_bet_amount --- ' + g_bet_amount);
                console.log('spanAcuPointAndBalance --- ' + $('.spanAcuPointAndBalance').html());
                console.log('ledger.balance_after --- ' + records[0].ledger.balance_after);
                $('.spanAcuPointAndBalance').html(get2Decimal(getNumeric(records[0].ledger.balance_after) - getNumeric(g_bet_amount)));
                g_vip_point = records[0].ledger.balance_after; 
                $('#hidBalance').val(records[0].ledger.balance_after); 
            }
        } 

        $('.icon-newcoin').click(function(){
        $('.span-topup').html(records[0].ledger.credit);
        $('.span-before').html(records[0].ledger.balance_before);
        $('.span-after').html(records[0].ledger.balance_after);
        

        var updated_at = records[0].ledger.updated_at.split(" ");//dateTime[0] = date, dateTime[1] = time
        var date = updated_at[0].split("-");
        var time = updated_at[1].split(":");
        $('.span-updated').html(date[0]+'年'+date[1]+'月'+date[2]+'日'+time[0]+'点'+time[1]+'分');

        $('#modal-notification').modal();
        
        $( this ).unbind( "click" );

            $.ajax({
                type: 'POST',
                url: "/api/notification-mark-as-read?id="+ records[0].id+"&memberid=" + $('#hidUserId').val() + "&gameid=" + gameid,
                dataType: "json",
                error: function (error) { 
                    console.log(error.responseText);
                    $(".reload2").show();
                },
                success: function() {
                    var new_data = data;
                    new_data.records.shift();
                    new_data.count = new_data.records.length;
                    console.log(new_data.count);
                    if(new_data.count > 0){
                        getNotification(new_data, false);
                    } else {
                        $('.icon-red').html(notifications_count).hide();
                    }
                }
            });

        });

        $('.modal-notification-button').click(function(){
            $('#modal-notification').modal('hide');
        }); 

    }

}

function getProduct(){
    $.getJSON( "/api/get-product-list?limit=6", function( data ) {
        // console.log(data);

        var html = '<form id="frm_buy" method="post" action="/buy">' +
                        '<input id="hid_package_id" name="hid_package_id" type="hidden" value="">';

        $.each(data.records, function(i, item) {
            if(i % 2 === 0){
                html += '<div class="redeem-prize redeem-button" rel="'+ item.id +'">' + 
                            '<div class="left-box">' +
                            '<div class="prize-box">' +
                                '<div class="image-wrapper">' +
                                    '<img class="redeem-img" rel="'+ item.id +'" src="'+ item.picture_url +'">' +
                                '</div>' +
                                '<div class="redeem-product">'+ item.name +'</div>' +
                                '<div class="redeem-price">'+ Math.ceil(item.point_to_redeem) +' <span class="redeem-currency">挖宝币</span></div>' +
                            '</div>' +
                        '</div>';
            } else {
                html += '<div class="redeem-prize redeem-button" rel="'+ item.id +'">' + 
                            '<div class="right-box">' +
                            '<div class="prize-box">' +
                                '<div class="image-wrapper">' +
                                    '<img class="redeem-img" rel="'+ item.id +'" src="'+ item.picture_url +'">' +
                                '</div>' +
                                '<div class="redeem-product">'+ item.name +'</div>' +
                                '<div class="redeem-price">'+ Math.ceil(item.point_to_redeem) +' <span class="redeem-currency">挖宝币</span></div>' +
                            '</div>' +
                        '</div>';
            }
            html += '<input id="hid_price_'+ item.id +'" name="hid_price_'+ item.id +'" type="hidden" value="'+item.point_to_redeem+'">';
        });

        html += '</form>';

        $('.redeem-prize-wrapper').html(html);
        $('.redeem-button').on('click', function(){

            var user_id = $('#hidUserId').val();
            if(user_id == 0){
                // window.top.location.href = "/member";
                // $( '#login-intropopup' ).modal( 'show' );
                // $( '#nonloginmodal' ).modal( 'show' );
                $( '#modal-no-login' ).modal( 'show' );
                return false;
            } else {

                $( "#hid_package_id" ).val($(this).attr('rel'));
                console.log($(this).attr('rel'));
                var price = getNumeric($("#hid_price_"+ $(this).attr('rel')).val());
                // console.log(price);
                // console.log(g_vip_point);
                console.log(getNumeric(price) > getNumeric(g_vip_point));
                if (getNumeric(price) > getNumeric(g_vip_point)) {
                    console.log(1);
                    $('#modal-insufficient-point').modal();
                    setTimeout(function(){ 
                        $('#modal-insufficient-point').modal('hide');
                    }, 3000);   
                    return false;         
                } else {
                    console.log(2);
                    // $( "#frm_buy" ).submit();
                    $('#modal-go-shop').modal();
                    setTimeout(function(){ 
                        $('#modal-go-shop').modal('hide');
                    }, 3000); 
                    return false;   
                }

            }
            
        });

    });
}

function resetTimer(){
    var user_id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/game-setting?gameid=103&memberid=" + user_id,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error.responseText) 
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
        type: 'GET',
        url: "/api/game-setting?gameid=103&memberid=" + id, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error); 
        },
        success: function(data) {
            console.log(data);
            game_records = data.record.setting;
            betting_records = data.record.bettinghistory.data;
            latest_result = data.record.bettinghistory.data;
            g_betting_history_total = data.record.bettinghistory.total;
            var level = data.record.level;
            var consecutive_lose = data.record.consecutive_lose;
            g_ratio = getNumeric(data.record.setting.win_ratio);
            g_w_ratio = g_ratio; //g_ratio + 1;
            initGame(game_records, level, latest_result, consecutive_lose);
            
            //console.log(data);
            updateHistory(betting_records);
            updateResult(betting_records);
            show_win = false;
            show_lose = false;

            //get wallet
            $.ajax({
                type: 'POST',
                url: "/api/wallet-detail?gameid=" + gameid + "&memberid=" + id, 
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { console.log(error) },
                success: function(data) {
                    var wallet_records = data.record;
                    initUser(wallet_records);

                    //lock wheel
                    lockWheel();
                }
            });

        }
    });    
}

function resetGame() {
    $('div.clicked').find('.bet').hide();
    $('div.clicked').removeClass('clicked').find('.bet-container').hide();
    $('.payout-info').addClass('hide');
    $('.spinning').css('visibility', 'hidden');
    $('.radio-primary').unbind('click');
    $('.radio-primary').unbind('touchend');    
    $('.button-bet').unbind('click');
    $('.button-bet').unbind('touchend');    
    $('.button-bet-clear').unbind('click');
    $('.button-bet-all').unbind('click');
    $(".span-bet").unbind('focus');
    $('.small-border').removeClass('medium-rotate');
    $('.span-bet').val(0);
    $('.speech-bubble-clear').hide();
    previous_bet = 0;

    $('.shan span').hide();
    $('.shan div').removeClass('clicked-vip');    
    $('.btn-trigger').unbind('click');
    g_previous_point = $('#hidBalance').val();
    g_bet_amount = 0;
    g_vip_point = $('#hidBalance').val();
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

function checkSelection() {
    var selected = $('div.clicked').find('input:radio').val();

    if (parseInt($('.span-bet').val()) == 0) {
        $('.spinning').html('请投入竞猜挖宝币<br />再点击“开始抽奖”进行抽奖');
         $('.spinning').css('visibility', 'visible');
        setTimeout(function(){ 
            $('.spinning').css('visibility', 'hidden');
        }, 3000);
    } else if (typeof selected == 'undefined'){
        $('.spinning').html('请先选择单数或选择双数<br />再点击“开始抽奖”进行抽奖');
         $('.spinning').css('visibility', 'visible');
        setTimeout(function(){ 
            $('.spinning').css('visibility', 'hidden');
        }, 3000);
    } else {
        //$('.middle-label').html('正在抽奖');
        $('.DB_G_hand').hide();
        $('.radio-primary').unbind('click');
        $('.radio-primary').unbind('touchend');
        $('.btn-trigger').unbind('click');

        $('.button-bet').unbind('click');
        $('.button-bet').unbind('touchend');
        $('.button-bet-clear').unbind('click');
        $('.button-bet-all').unbind('click');
        
        startTimer(5, 5, 1);
        bindSpinningButton();
    }
}

function closeModal() {
    $('.close-modal').click(function(){
        $('.redeem-error').html('你猜的游戏正在进行中');
    });

    $('.modal-message-manual').click(function(){
        $('#reset-life-manual').modal();
    });

    $('.modal-manual-button').click(function(){
        $('#reset-life-manual').modal('hide');
    });
}

function closeWinModal() {

    $('.close-win-modal').click(function(event){
        // console.log(g_vip_point);
        // console.log(g_previous_point);
        if (g_vip_point > g_previous_point) {
            musicPlay(1);  
            // console.log('play coin mp3');

           // setTimeout(function(){
                var decimal_places = 2;
                var decimal_factor = decimal_places === 0 ? 1 : Math.pow(10, decimal_places);

                $('.spanAcuPointAndBalance')
              .prop('number', g_previous_point * decimal_factor)
              .animateNumber(
                {
                  number: g_vip_point * decimal_factor,

                  numberStep: function(now, tween) {
                    var floored_number = Math.floor(now) / decimal_factor,
                        target = $(tween.elem);

                    if (decimal_places > 0) {
                      // force decimal places even if they are 0
                      floored_number = floored_number.toFixed(decimal_places);

                      // replace '.' separator with ','
                      floored_number = floored_number.toString();
                    }

                    target.text(floored_number);
                  }
                },
                1000);
          // }, 1000);
            
        }
        
        // setTimeout(function(){
        //     $('.spanAcuPointAndBalance').html(get2Decimal(g_vip_point));
        //     $('.spanAcuPoint').html(g_vip_point);
        // }, 2300);

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

    $('.btn-trigger').click(function( event ){
        $('.spinning').html('转盘转动中，请等待结果。');
        $('.spinning').css('visibility', 'visible');
        setTimeout(function(){ 
            $('.spinning').css('visibility', 'hidden');
        }, 3000);
    });

    $('.button-bet').click(function( event ){
        $('.spinning').html('转盘转动中，请等待结果。');
        $('.spinning').css('visibility', 'visible');
        setTimeout(function(){ 
            $('.spinning').css('visibility', 'hidden');
        }, 3000);
    });

    $('.button-bet-clear').click(function( event ){
        $('.spinning').html('转盘转动中，请等待结果。');
        $('.spinning').css('visibility', 'visible');
        setTimeout(function(){ 
            $('.spinning').css('visibility', 'hidden');
        }, 3000);
    });
}

function bindBetButton(){

    $(".span-bet").focus(function(){
        document.activeElement.blur();  // 阻止弹出系统软键盘
        var _cliss = $(this).attr("class");

        $('body').keyboard({
            defaults:'number',    //键盘显示类型   English 字母  number 数字  symbol 符号
            inputClass:_cliss,        //输入框Class
            caseSwitch:'toLowerCase', //英文大小写  toLowerCase 小写  toUpperCase 大写
        });

        $('#keycontent').bind('remove', function() {
            var final_bet = parseInt($('.span-bet').val());

            if(final_bet <= g_vip_point){
                $('.span-bet').val(final_bet);
                previous_bet = final_bet;
            } else {
                if (isLock()) {
                    showUnLockModal();
                } else {
                    $( '#modal-isnewbie' ).modal( 'show' );    
                }
                
                $('.span-bet').val(getNumeric(g_vip_point));
                previous_bet = g_vip_point;
            }

            showPayout();

        });
    });

    $('.button-bet').on('touchend', function(event){
        if (touchmoved) {
            return false;
        }
// event.stopImmediatePropagation();
        $('.speech-bubble-chips').hide();
         var user_id = $('#hidUserId').val();
        if(user_id == 0){
            $( '#modal-no-login' ).modal( 'show' );
            return false;
        } else {

            if (g_vip_point < 1) {
                // $( '#modal-isnewbie' ).modal( 'show' );
                if (isLock()) {
                    showUnLockModal();
                } else {
                    $('#modal-insufficient-point-new').modal();
                }
                
                console.log('111');
                return false;
            } else {

                var add_bet = parseInt($(this).html());
                var initial_bet = parseInt($('.span-bet').val());
                var final_bet = add_bet + initial_bet;

                if(final_bet <= g_vip_point){
                    $('.span-bet').val(final_bet);
                    previous_bet = final_bet;
                } else {
                    // $('.spinning').html('金币不足 请充值');
                    //  $('.spinning').css('visibility', 'visible');
                    // setTimeout(function(){ 
                    //     $('.spinning').css('visibility', 'hidden');
                    // }, 3000);
                    $('.span-bet').val(getNumeric(g_vip_point));
                    previous_bet = g_vip_point;
                    $('#modal-insufficient-point-new').modal();
                    console.log('222');
                }
                showPayout();

            }

        }

    }).on('touchmove', function(e){
        touchmoved = true;
    }).on('touchstart', function(){
        touchmoved = false;
    });

    $('.button-bet-clear').click(function(){
        $('.speech-bubble-clear').hide();
        $('.span-bet').val(0);
        showPayout();
        previous_bet = 0;
    });

    $('.button-bet-all').click(function(){
        $('.span-bet').val(g_vip_point);
        showPayout();
        previous_bet = g_vip_point;
    });

    $('.radio-primary').on('touchend', function(event){
        if (touchmoved) {
            return false;
        }

        event.stopImmediatePropagation();

        var balance = parseInt($('#hidBalance').val());
        var life = $(".nTxt").html();
        var acupoint = parseInt($('.spanAcuPoint').html());
        var draw_id = $('#draw_id').val();
        var consecutive_lose = $('#hidConsecutiveLose').val();

        var user_id = $('#hidUserId').val();
        if(user_id == 0){
            // window.top.location.href = "/member";
            // $( '#login-intropopup' ).modal( 'show' );
            // $( '#nonloginmodal' ).modal( 'show' );
            $( '#modal-no-login' ).modal( 'show' );
            return false;
        }

        if (g_vip_point < 1) {
            // $( '#modal-isnewbie' ).modal( 'show' );
            if (isLock()) {
                showUnLockModal();
            } else {
                $('#modal-insufficient-point-new').modal();
            }
            console.log('333');
            return false;
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

        showPayout();
    }).on('touchmove', function(e){
        touchmoved = true;
    }).on('touchstart', function(){
        touchmoved = false;
    });

     var user_id = $('#hidUserId').val();

    if(user_id == 0){

        $('#btn-redeemcash').on('touchend', function() {
            if (touchmoved) {
                return false;
            }

            $('#modal-no-login').modal('show');
            return false;
        }).on('touchmove', function(e){
            touchmoved = true;
        }).on('touchstart', function(){
            touchmoved = false;
        });
            
    } else {
        if (g_betting_history_total > 0) {
            if ($('#isIOS').val() == 'true') {
                // alert(11);
                document.getElementById("btn-redeemcash").addEventListener("touchend", function(evt) {
                    var a = document.createElement('a');
                    a.setAttribute("href", $('#topupurl').val());
                    a.setAttribute("target", "_blank");
                    var dispatch = document.createEvent("HTMLEvents");
                    dispatch.initEvent("click", true, true);
                    a.dispatchEvent(dispatch);
                }, false);
            }else if ($('#isIOS').val() == 'AndroidOS'){
                // alert(22);

                // document.getElementById("btn-redeemcash").addEventListener('tap',function(){
                //     plus.runtime.openURL($('#topupurl').val());
                // });

                var urlStr = encodeURI($('#topupurl').val());
                $('#btn-redeemcash').on('touchend', function() {
                    plus.runtime.openURL(urlStr);
                });                

            } else {

                // alert(33);
                // window.location.href = $('#topupurl').val();
                $('#btn-redeemcash').on('touchend', function() {
                    window.open($('#topupurl').val(), '_blank'); 
                });

            }
            
        } else {
            $('#btn-redeemcash').on('touchend', function() {
                showUnLockModal();
                return false;
            });
        }
    }   
}

function showPayout(){
    var selected = $('div.clicked').find('input:radio').val();
    var balance = parseInt($('#hidBalance').val());
    var total_balance = parseInt($('#hidTotalBalance').val());
    var level = parseInt($('#hidLevel').val());
    var user_id = $('#hidUserId').val();

    var bet_amount = parseInt($('.span-bet').val());
    var newbalance = balance - bet_amount;
    var newtotalbalance = total_balance - bet_amount;
    var bet_count = $('#hidbetting_count').val();

        if (typeof selected == 'undefined'){

            //$('.middle-label').html('选择单双');
            $('.span-odd').removeClass('ready-vip lose-vip').html("<strong>"+bet_amount+"挖宝币</strong><br /><span class='span-ratio'>×"+g_w_ratio+"<br /></span>").css('display', 'inline-block');
            $('.span-even').removeClass('ready-vip lose-vip').html("<strong>"+bet_amount+"挖宝币</strong><br /><span class='span-ratio'>×"+g_w_ratio+"<br /></span>").css('display', 'inline-block');
            $('.shan div').addClass('clicked-vip').removeClass('lose-vip');

            if(bet_count == 0){
                $('.selection').show();
                $('.start-game').hide();
            }

            checked(level, false);
            changbar(level);

            $('#spanPoint').html(total_balance);
            $('.instruction').css('visibility', 'visible');
            $('.payout-info').addClass("hide");
            $('.odd-payout').html(bet_amount);
            $('.even-payout').html(bet_amount);

            $('.spanAcuPointAndBalance').html(get2Decimal(getNumeric(Number(g_vip_point) - Number(bet_amount))));
            g_bet_amount = bet_amount;

            if(bet_amount > 0){

            } else {
                //$('.middle-label').html('选择金币');
                $('.span-odd').hide();
                $('.span-even').hide();
                $('.shan div').removeClass('clicked-vip');
            }
            
        } else {

            if(selected == 'odd'){
                $('.div-odd').removeClass('lose-vip');
                $('.div-even').addClass('lose-vip');
            } else {
                $('.div-odd').addClass('lose-vip');
                $('.div-even').removeClass('lose-vip');
            }

            if(bet_amount > 0){
                //$('.middle-label').html('开始抽奖');
                if(selected == 'odd'){
                    $('.span-odd').removeClass('lose-vip line-through').addClass('ready-vip').html("<strong>"+bet_amount+"挖宝币</strong><br /><span class='span-ratio'>×"+g_w_ratio+"<br /></span>").css('display', 'inline-block');
                    $('.span-even').addClass('ready-vip lose-vip line-through').html('<strong>'+bet_amount+'挖宝币</strong>');
                    // $('.span-even').addClass('ready-vip lose-vip').html('谢谢参与');

                } else {
                    // $('.span-odd').addClass('ready-vip lose-vip').html('谢谢参与');
                    $('.span-odd').addClass('ready-vip lose-vip line-through').html('<strong>'+bet_amount+'挖宝币</strong>');
                    $('.span-even').removeClass('lose-vip line-through').addClass('ready-vip').html("<strong>"+bet_amount+"挖宝币</strong><br /><span class='span-ratio'>×"+g_w_ratio+"<br /></span>").css('display', 'inline-block');
                }
                $('.shan div').addClass('clicked-vip');

            } else {
                //$('.middle-label').html('选择金币');
                $('.span-odd').removeClass('ready-vip lose-vip').html('请选挖宝币').css('display', 'inline-block');
                $('.span-even').removeClass('ready-vip lose-vip').html('请选挖宝币').css('display', 'inline-block');
                $('.shan div').addClass('clicked-vip');
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

                

                $('.spanAcuPointAndBalance').html(get2Decimal(getNumeric(Number(g_vip_point) - Number(bet_amount))));

                $.ajax({
                    type: 'GET',
                    url: "/api/update-game-result-temp?gameid=103&gametype=1&memberid="+ user_id
                    + "&drawid=0" 
                    + "&bet="+ selected 
                    + "&betamt=" + (bet_amount)
                    + "&level=" + level,
                    dataType: "json",
                    beforeSend: function( xhr ) {
                        xhr.setRequestHeader ("Authorization", "Bearer " + token);
                    },
                    error: function (error) {
                        console.log('memberid: ' + user_id + ', 下注失败'); 
                        console.log(error.responseText);
                        $('.spinning').html('下注失败<br/>请重新选择');
                        $('.spinning').css('visibility', 'visible');
                        setTimeout(function(){ 
                            $('.spinning').css('visibility', 'hidden');
                        }, 3000);
                        resetGame();
                        $(".reload2").show();
                    },
                    success: function(data) {
                    }
                });

            }

        }

    
}

function bindCalculateButton(){
    // $('.btn-calculate-vip').click(function( event ){
        
    //     event.stopImmediatePropagation();

    // });
}

function bindTriggerButton(){
    $('.btn-trigger').click(function( event ){
        var user_id = $('#hidUserId').val();
        if(user_id == 0){
            $( '#modal-no-login' ).modal( 'show' );
        }else {

            if (g_vip_point < 1) {
                // $( '#modal-isnewbie' ).modal( 'show' );
                if (isLock()) {
                    showUnLockModal();
                } else {
                    $('#modal-insufficient-point-new').modal();
                }
                console.log('444');
            } else {            
                event.stopImmediatePropagation();
                checkSelection();
            }
        }
        
    });
}

function showProgressBar(bol_show){}

function showWinModal(){
    var level = parseInt($('#hidLevel').val());
    var html = '';
    var image = '';
    var info = '';
    var remain = 0;

    var bet_amount = getNumeric(getNumeric($('.span-bet').val()) * g_w_ratio);
    g_previous_point = getNumeric($('.spanAcuPointAndBalance').html());
    g_vip_point = getNumeric(Number(g_previous_point) + Number(bet_amount));
    var instructions = '您已抽中'+ g_vip_point +'挖宝币';
    html += bet_amount;

    if(remain < 0){
        remain = 0;
    }

    $('.modal-progress-bar').attr("src", image);
    $('#win-modal .packet-value').html(html);
    //$('#win-modal .packet-info').html(info);
    $('#win-modal .instructions').html(instructions);

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
    var html = '<div class="modal-win-title">很遗憾猜错了</div>';
    var image = '';
    var result_info = '6次内猜对奖励加倍';

    var balance = getNumeric($('#hidBalance').val());
    var bet_amount = getNumeric($('.span-bet').val());
    var newbalance = getNumeric(balance - bet_amount);
    var instruction = '这局亏损'+ bet_amount +'挖宝币，继续加油哦';

    //$('.modal-progress-bar').attr("src", image);
    $('#lose-modal .modal-instruction').html(instruction);
    
}

function startTimer(duration, timer, freeze_time) {

    try {

        var selected = $('div.clicked').find('input:radio').val();
        var trigger_time = freeze_time - 1;
        var id = $('#hidUserId').val();
        var level = parseInt($('#hidLevel').val());
        $('.small-border').addClass('medium-rotate');
        g_previous_point = getNumeric($('.spanAcuPoint').html());

        $.ajax({
            type: 'POST',
            url: "/api/get-betting-result?gameid=103&memberid=" + id, 
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.setRequestHeader ("Authorization", "Bearer " + token);
            },
            error: function (error) { 
                console.log(error); 
                $('.spinning').html('等待网络');
                $('.spinning').css('visibility', 'visible');
                setTimeout(function(){ 
                    $('.spinning').css('visibility', 'hidden');
                }, 3000);
                // window.top.location.href = "/arcade";
                $(".reload2").show();
            },
            success: function(data) {
                _success = data.success;
                console.log(data);
                if (_success) {
                    nretry = 0;
                    $('.small-border').removeClass('medium-rotate');
                    $('#result').val(data.game_result);
                    if(data.status == 'win'){
                        show_win = true;
                        showWinModal();
                    } else if(data.status == 'lose') {
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
    catch(err) {
      console.log(err.message);
      $('.spinning').html('等待网络');
        $('.spinning').css('visibility', 'visible');
        setTimeout(function(){ 
            $('.spinning').css('visibility', 'hidden');
        }, 3000);
        resetGame();
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
            'pointerImg': "/client/images/pointer.png",//指针图片
            'buttonImg': "/client/images/pointer.png",//开始按钮图片
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
function musicPlay(music) {    
    if (music == 1) {  
        // audioElement.setAttribute('src', '/client/audio/coin.mp3');              
        audioElement.play();
        
    }
}
//load audio - end

function get_today_profit() {
    var username = $('#hidUsername').val();
    var session = $('#hidSession').val();
    var id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/today-play_statistics",
        data: { 'memberid': id, 'gameid': 103 },
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + session);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            // console.log(data.record);
            if(data.success){
                if(data.record && data.record !="") {

                    $('.profit').html(getNumeric(getNumeric(data.record.total_win) - getNumeric(data.record.total_lose)));    
                } else {
                    $('.profit').html(0);
                }                
            } else {
                $('.profit').html(0);
            }
        }
    });
}

function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
    // console.log(parseFloat(value).toFixed(2));
    // return parseFloat(value).toFixed(2);
  }

function get2Decimal(value) {
    // return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
    // console.log(parseFloat(value).toFixed(2));
    return parseFloat(value).toFixed(2);
}

function lockWheel() {
    if (isLock()) {
        _img = '<a href="javascript:showHowToUnLock();"><div id="btn-how-to-unlock">&nbsp;</div></a>';
        _img += '<div id="wheel_banner"><img src="/clientapp/images/vip-node/wheel-newbie.png"></div>';
        $('.frame-wrapper').html(_img);
        // $('#wheel_container').css('visibility', 'hidden');
    }
}

function isLock() {
    var id = $('#hidUserId').val();
    res = false;
    if (id > 0) {// login
        if (g_betting_history_total > 0) {
            res = false;
        } else {
            res = (g_vip_point > 0) ? false : true; 
        }    
    }
    
    // console.log(g_betting_history_total);
    // console.log(g_vip_point);
    // console.log(res);
    return res;
}

function showUnLockModal() {
    $('#modal-unlock').modal();
    setTimeout(function(){ 
        $('.modal').modal('hide');
        $('.modal-backdrop').remove(); 
    }, 3000);
}

function showHowToUnLock() {
    $('#modal-how-to-unlock').modal();
    $('.btn-close').on('click', function() {
        $('.modal').modal('hide');
        $('.modal-backdrop').remove();
    });
    $('.btn-go-topup').click(function() {
        $('#btn-go-topup').trigger("click");
    });
    $('.btn-go-redeem').click(function() {
        window.location.href = '/redeem';
    }); 
}

function initNotification() {
    var user_id = $('#hidUserId').val();
    $.ajax({
        type: 'GET',
        url: "/api/get-notifications?memberid=" + user_id + "&gameid=" + gameid,
        dataType: "json",
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            console.log(data);
            getNotification(data, false);
        }
    });
}