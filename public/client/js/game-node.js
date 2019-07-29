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
        closeModal();

        ifvisible.on("wakeup", function(){
            //resetTimer();
        });

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

        history =  '选择<span class="'+ className + '">' + strbet + '</span>，投'+ _bet_amount +'金币，' + strwinloss + '，' + strsign + _bet_amount +'金币';

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
        var balance = parseInt(records.balance);
        var life = records.life;
        g_life = life;
        var point = parseInt(records.point);
        var acupoint =  parseInt(records.acupoint);
        g_current_point = parseInt(records.acupoint);
        var play_count = parseInt(records.play_count);
        var max_acupoint = 15;
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
        $('.packet-acupoint-to-win').html(15 - acupoint);
        $('#hidBalance').val(balance);
        $("#nTxt").val(life);
        $(".spanLife").html(life);
        $(".span-play-count").html(play_count);

        setBalance();

        if(life == 0){
            $('#reset-life-share').modal();
        } else if (user_id > 0 && acupoint >= max_acupoint) {
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
        var acupoint = parseInt($('.spanAcuPoint').html());
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
                $( this ).find('.bet_status').html('失败');

            } else if($( this ).attr('data-level') == level){
                $( this ).next().addClass('circle-border').show();
                $( this ).next().next().show();
                $( this ).addClass( "button-bet-active" );
                $( this ).unbind( "click" );

                if(level == 1)
                    $( this ).find('.bet_status').html('起步');
                else
                    $( this ).find('.bet_status').html('加倍');

                $( ".circle-border" ).click(function(){

                    if(g_life == 0){
                        $('#reset-life-share').modal();
                    } else {

                        $( this ).removeClass('circle-border').addClass('clicked-circle');
                        $( this ).prev().addClass('clicked-button-bet');
                        $( this ).next().hide();
                        $( '.DB_G_hand_2' ).show();

                        var selected = $('div.clicked').find('input:radio').val();
                        if (typeof selected == 'undefined'){
                            //$('.middle-label').html('选择单双');
                            $('.span-odd').html('请选单双').show();
                            $('.span-even').html('请选单双').show();
                            $('.shan div').addClass('clicked');
                        } else {
                            //$('.middle-label').html('开始抽奖');
                        }
                        
                        $('#btnPointer').addClass('ready');
                        showPayout();
                    }
                });
            } else {
                $( this ).find('.bet_status').html('加倍');
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

                $( this ).click(function(){

                    if (g_life > 0) {
                       var betwarningmsg = '选错提示“按倍增式投法：第'+level+'局起步'+ suggestion_bet +'元”'; //'选错提示“按倍增式投法：第'+level+'局请投'+ suggestion_bet +'元”';
                        if (level > 1) {
                            betwarningmsg = '选错提示“按倍增式投法：第'+level+'局加倍x'+ (((level-1) * level) + 1) +'”';
                        }
                        $('.spinning').html(betwarningmsg);
                        $('.spinning').css('visibility', 'visible');
                        setTimeout(function(){ 
                            $('.spinning').css('visibility', 'hidden');
                        }, 3000);    
                    } else {
                        $('#reset-life-share').modal();
                    }
                });
            }
        });

        $('#hidLevel').val(level);
        $('#hidLatestResult').val(previous_result);
        $('#hidConsecutiveLose').val(consecutive_lose);

        $('.barBox').find('li').removeClass('on');
	
		console.log('consecutive_lose'+consecutive_lose);
		console.log('life'+g_life);

        if (consecutive_lose == 'yes' && life > 0) {
            bindResetLifeButton();
            $('#reset-life-lose').modal({backdrop: 'static', keyboard: false});
        }

        setBalance();

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

        $.ajax({
            type: 'GET',
            url: "/api/get-game-result-temp?gameid=102&gametype=1&memberid=" + user_id + "&drawid=0",
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.setRequestHeader ("Authorization", "Bearer " + token);
            },
            error: function (error) { 
                console.log(error);
                $(".reload").show();
            },
            success: function(data) {

                if(data.success && data.record.bet != null){

                    var selected = data.record.bet;

                    var btn_rectangle = $("input[value='"+ selected +"']").parent();
                    btn_rectangle.addClass('clicked');
                    showPayout();

                    // $.ajax({
                    //     type: 'GET',
                    //     url: "/api/update-game-result-temp?gameid=102&gametype=1&memberid="+ user_id
                    //     + "&drawid=0" 
                    //     + "&bet="+ selected 
                    //     +"&betamt=" + bet_amount,
                    //     dataType: "json",
                    //     beforeSend: function( xhr ) {
                    //         xhr.setRequestHeader ("Authorization", "Bearer " + token);
                    //     },
                    //     error: function (error) { 
                    //         console.log(error.responseText); 
                    //         $(".reload").show();
                    //     },
                    //     success: function(data) {
                    //     }
                    // });
                }
            }
        }); // ajax get-game-result-temp

    }
    catch(err) {
      console.log(err.message);
      alert('下注失败');
      $(".reload").show();
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
                token = data.access_token;
                startGame();            
            } else {
                $(".reload").show();
            }      
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
        error: function (error) { console.log(error.responseText) },
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
        url: "/api/game-setting?gameid=102&memberid=" + id, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            //console.log(data);
            game_records = data.record.setting;
            betting_records = data.record.bettinghistory.data;
            latest_result = data.record.bettinghistory.data;
            var level = data.record.level;
            var consecutive_lose = data.record.consecutive_lose;
			console.log('consecutive_lose:'+consecutive_lose);
            initGame(game_records, level, latest_result, consecutive_lose);

            
            //console.log(data);
            updateHistory(betting_records);
            updateResult(betting_records);
            show_win = false;
            show_lose = false;
        }
    });

    $.ajax({
        type: 'POST',
        url: "/api/wallet-detail?gameid=102&memberid=" + id, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            var wallet_records = data.record;

            initUser(wallet_records);
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
    if($('#btnPointer').hasClass('ready')){
        var selected = $('div.clicked').find('input:radio').val();
        if (typeof selected == 'undefined'){
            $( '.DB_G_hand_2' ).show();
            $('.span-odd').html('请选单双').show();
            $('.span-even').html('请选单双').show();
            $('.shan div').addClass('clicked');

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
        $('.span-odd').html('请选金币').show();
        $('.span-even').html('请选金币').show();
        $('.shan div').addClass('clicked');

        $('.spinning').html('请选择金币');
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
         $('#top-corner-game-rules').modal('hide');
        $('#game-rules').modal('hide'); 
        $('#vip-modal').modal('hide'); 
    });
}

function closeWinModal() {

    $('.close-win-modal').click(function(event){
        
        if (g_current_point > g_previous_point) {
            musicPlay(1);  
            console.log('play coin mp3');  
        } 

         if(g_current_point > 15){
             g_current_point = 15;
         }
        
        $('.spanAcuPointAndBalance').html(g_current_point);
        $('.spanAcuPoint').html(g_current_point);

        $(this).off('click');
        event.stopImmediatePropagation();
        $('#win-modal').modal('hide');
        $('#lose-modal').modal('hide');
        
        $('.speech-bubble-point').css('display', 'block');
        setTimeout(function(){ 
            $('.speech-bubble-point').css('display', 'none');
        }, 5000);

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
        var acupoint = parseInt($('.spanAcuPoint').html());
        var draw_id = $('#draw_id').val();
        var consecutive_lose = $('#hidConsecutiveLose').val();

        var user_id = $('#hidUserId').val();
        if(user_id == 0){
            // window.top.location.href = "/member";
            $( '#login-intropopup' ).modal( 'show' );
        }

        if(isNaN(balance)){
            return false;
        }

        //console.log(user_id +":" + balance + ":" + life );
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
                $('#reset-life-share').modal();
        }

        if (user_id > 0 && acupoint >= 15) {
            bindResetLifeButton();
            $('#reset-life-max').modal({backdrop: 'static', keyboard: false});
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
            $('.shan div').addClass('clicked');

            if(bet_count == 0){
                $('.selection').show();
                $('.start-game').hide();
            }

            checked(level, false);
            changbar(level);

            $('#spanPoint').html(total_balance);
            $('.instruction').css('visibility', 'visible');
            $('.payout-info').addClass("hide");

            
            // $.ajax({
            //     type: 'GET',
            //     url: "/api/update-game-result-temp?gameid=102&gametype=1&memberid="+ user_id 
            //     + "&bet=&betamt=&drawid=0",
            //     dataType: "json",
            //     beforeSend: function( xhr ) {
            //         xhr.setRequestHeader ("Authorization", "Bearer " + token);
            //     },
            //     error: function (error) { 
            //         console.log(error.responseText);
            //         // window.top.location.href = "/arcade";
            //     },
            //     success: function(data) {
            //     }
            // });

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
                    $('.span-odd').removeClass('lose').addClass('ready').html('+'+bet_amount);
                    $('.span-even').addClass('ready lose').html('-'+bet_amount);
                } else {
                    $('.span-odd').addClass('ready lose').html('-'+bet_amount);
                    $('.span-even').removeClass('lose').addClass('ready').html('+'+bet_amount);
                }
            } else {
                //$('.middle-label').html('选择金币');
                $( '.DB_G_hand_2' ).hide();
                $( '.DB_G_hand_3' ).hide();
                $('.span-odd').removeClass('ready lose').html('请选金币').show();
                $('.span-even').removeClass('ready lose').html('请选金币').show();
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
                    },
                    success: function(data) {
                    }
                });

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
            $('#reset-life-share').modal();
        }
    });
}

function bindTriggerButton(){
    $('.btn-trigger').click(function( event ){
        if (g_life > 0) {
            event.stopImmediatePropagation();
            checkSelection();
        } else {
            $('#reset-life-share').modal();
        }
    });
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
                data: { 'memberid': user_id, 'gameid': 102, 'life': 'yes' },
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { console.log(error.responseText) },
                success: function(data) {
                    if(data.success){
                        Cookies.set('previous_point', previous_point);
                        // window.parent.location.href = "/redeem";
                        window.parent.location.href = "/profile";
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
                data: { 'memberid': user_id, 'gameid': 102, 'life': 'yes' },
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

function showContent(level) {
    var content = '';

    switch (level) {

        default:
        case 1:
            content = '这局请投1金币';
        break;

        case 2:
            content = '上局亏了1金币，这局请投3金币';
        break;

        case 3:
            content = '上局亏了3金币，这局请投7金币';
        break;

        case 4:
            content = '上局亏了7金币，这局请投15金币';
        break;

        case 5:
            content = '上局亏了15金币，这局请投31金币';
        break;

        case 6:
            content = '上局亏了31金币，这局请投63金币';
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
            info = '前0局猜错<span class="highlight">亏损0元</span><br />第1局猜对<span class="highlight-green">奖励1元</span><br />最终赚了1元，<span class="highlight-red">换到了1元</span><br />满15元可兑换红包';
            image = '/client/images/progress-bar/10.png';
            html += '<span class="packet-sign">+</span>1<span class="packet-currency">元</span>';
            remain = 15 - (g_previous_point) - 1;
            instructions = '您已赢到1元，';
        break;

        case 2:
            info = '前1局猜错<span class="highlight">亏损1元</span><br />第2局猜对<span class="highlight-green">奖励3元</span><br />最终赚了2元，<span class="highlight-red">换到了2元</span><br />满15元可兑换红包';
            image = '/client/images/progress-bar/30.png';
            html += '<span class="packet-sign">+</span>2<span class="packet-currency">元</span>';
            remain = 15 - (g_previous_point) - 2;
            instructions = '您已赢到2元，';        
        break;

        case 3:
            info = '前2局猜错<span class="highlight">亏损4元</span><br />第3局猜对<span class="highlight-green">奖励7元</span><br />最终赚了3元，<span class="highlight-red">换到了3元</span><br />满15元可兑换红包';
            image = '/client/images/progress-bar/70.png';
            html += '<span class="packet-sign">+</span>3<span class="packet-currency">元</span>';
            remain = 15 - (g_previous_point) - 3;
            instructions = '您已赢到3元，';
        break;

        case 4:
            info = '前3局猜错<span class="highlight">亏损11元</span><br />第4局猜对<span class="highlight-green">奖励15元</span><br />最终赚了4元，<span class="highlight-red">换到了4元</span><br />满15元可兑换红包';
            image = '/client/images/progress-bar/150.png';
            html += '<span class="packet-sign">+</span>4<span class="packet-currency">元</span>';
            remain = 15 - (g_previous_point) - 4;
            instructions = '您已赢到4元，';
        break;

        case 5:
            info = '前4局猜错<span class="highlight">亏损26元</span><br />第5局猜对<span class="highlight-green">奖励31元</span><br />最终赚了5元，<span class="highlight-red">换到了5元</span><br />满15元可兑换红包';
            image = '/client/images/progress-bar/310.png';
            html += '<span class="packet-sign">+</span>5<span class="packet-currency">元</span>';
            remain = 15 - (g_previous_point) - 5;
            instructions = '您已赢到5元，';
        break;

        case 6:
            info = '前5局猜错<span class="highlight">亏损57元</span><br />第6局猜对<span class="highlight-green">奖励63元</span><br />最终赚了6元，<span class="highlight-red">换到了6元</span><br />满15元可兑换红包';
            image = '/client/images/progress-bar/630.png';
            html += '<span class="packet-sign">+</span>6<span class="packet-currency">元</span>';
            remain = 15 - (g_previous_point) - 6;
            instructions = '您已赢到6元，';
        break;

    }

    if(remain < 0){
        remain = 0;
    }

    $('.modal-progress-bar').attr("src", image);
    $('#win-modal .packet-value').html(html);
    $('#win-modal .packet-info').html(info);
    $('#win-modal .instructions').html(instructions+'还差'+remain+'元可兑换');

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
            instruction = '前1局没抽中，<span class="highlight-grey">总亏损1元</span>，第2局将<span class="highlight-green">加倍✕3</span>，抽中得3元，减去亏损的1元还能赚2元。';
            image = '/client/images/progress-bar/lose_10.png';
            html += '<div class="modal-win-title">差点抽中...再来一次...</div><div class="modal-result">下局奖励2元红包</div>'; 
            result_info = '5次内猜对奖励加倍';
        break;

        case 2:
            // instruction = '前2局猜错，<span class="highlight-green">总亏损4元</span>，根据倍增式玩法，第3局<span class="highlight-orange">将押注7元</span>，如猜对能获得7元奖励，减去亏损的40还能赚3元。<br />赚到的元自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            // instruction = '前2局猜错，<span class="highlight-grey">总亏损4元</span>，根据倍增式玩法，第3局将<span class="highlight-green">押注7元</span>，猜对能获得7元奖励，减去亏损的40还能赚3元。<br /><span class="highlight-red">赚到的元可兑换红包，1元兑换1元。</span>';
            instruction = '前2局没抽中，<span class="highlight-grey">总亏损4元</span>，第3局将<span class="highlight-green">加倍✕7</span>，抽中得7元，减去亏损的4元还能赚3元。';
            image = '/client/images/progress-bar/lose_30.png';
            html += '<div class="modal-win-title">差点抽中...再来一次...</div><div class="modal-result">下局奖励3元红包</div>'; 
            result_info = '4次内猜对奖励加倍';
        break;

        case 3:
            // instruction = '前3局猜错，<span class="highlight-green">总亏损11元</span>，根据倍增式玩法，第4局<span class="highlight-orange">将押注15元</span>，如猜对能获得15元奖励，减去亏损的11还能赚4元。<br />赚到的元自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            // instruction = '前3局猜错，<span class="highlight-grey">总亏损11元</span>，根据倍增式玩法，第4局将<span class="highlight-green">押注15元</span>，猜对能获得15元奖励，减去亏损的11还能赚4元。<br /><span class="highlight-red">赚到的元可兑换红包，1元兑换1元。</span>';
            instruction = '前3局没抽中，<span class="highlight-grey">总亏损11元</span>，第4局将<span class="highlight-green">加倍✕15</span>，抽中得15元，减去亏损的11元还能赚4元。';
            image = '/client/images/progress-bar/lose_70.png';
            html += '<div class="modal-win-title">差点抽中...再来一次...</div><div class="modal-result">下局奖励4元红包</div>'; 
            result_info = '3次内猜对奖励加倍';
        break;

        case 4:
            // instruction = '前4局猜错，<span class="highlight-green">总亏损26元</span>，根据倍增式玩法，第5局<span class="highlight-orange">将押注31元</span>，如猜对能获得31元奖励，减去亏损的260还能赚5元。<br />赚到的元自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            // instruction = '前4局猜错，<span class="highlight-grey">总亏损26元</span>，根据倍增式玩法，第5局将<span class="highlight-green">押注31元</span>，猜对能获得31元奖励，减去亏损的260还能赚5元。<br /><span class="highlight-red">赚到的元可兑换红包，1元兑换1元。</span>';
            instruction = '前4局没抽中，<span class="highlight-grey">总亏损26元</span>，第5局将<span class="highlight-green">加倍✕31</span>，抽中得31元，减去亏损的26元还能赚5元。';
            image = '/client/images/progress-bar/lose_150.png';
            html += '<div class="modal-win-title">差点抽中...再来一次...</div><div class="modal-result">下局奖励5元红包</div>'; 
            result_info = '2次内猜对奖励加倍';
        break;

        case 5:
            // instruction = '前5局猜错，<span class="highlight-green">总亏损57元</span>，根据倍增式玩法，第6局<span class="highlight-orange">将押注63元</span>，如猜对能获得63元奖励，减去亏损的57还能赚6元。<br />赚到的元自动成为金币，可兑换红包！<br /><div class="highlight-link">>查看倍增式玩法说明<</div>';
            // instruction = '前5局猜错，<span class="highlight-grey">总亏损57元</span>，根据倍增式玩法，第6局将<span class="highlight-green">押注63元</span>，猜对能获得63元奖励，减去亏损的57还能赚6元。<br /><span class="highlight-red">赚到的元可兑换红包，1元兑换1元。</span>';
            instruction = '前5局没抽中，<span class="highlight-grey">总亏损57元</span>，第6局将<span class="highlight-green">加倍✕63</span>，抽中得63元，减去亏损的57元还能赚6元。';
            image = '/client/images/progress-bar/lose_310.png';
            html += '<div class="modal-win-title">差点抽中...再来一次...</div><div class="modal-result">下局奖励6元红包</div>'; 
            result_info = '1次内猜对奖励加倍';
        break;

    }

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
        g_previous_point = parseInt($('.spanAcuPoint').html());

        $.ajax({
            type: 'POST',
            url: "/api/get-betting-result?gameid=102&memberid=" + id, 
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.setRequestHeader ("Authorization", "Bearer " + token);
            },
            error: function (error) { 
                console.log(error); 
                alert('等待网络');
                // $(".reload").show();
                window.top.location.href = "/arcade";
            },
            success: function(data) {
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
            },
            timeout: 10000 // sets timeout to 10 seconds
        });

    }
    catch(err) {
      console.log(err.message);
      alert('下注失败');
      $(".reload").show();
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
}

//load audio - start
var audioElement = document.createElement('audio');
audioElement.setAttribute('src', '/client/audio/coin.mp3');
// var audioElement_win = document.createElement('audio');
// audioElement_win.setAttribute('src', '/client/audio/win.mp3');

function musicPlay(music) {    

    //solve ios autoload issue
    // document.body.addEventListener('touchstart', musicInBrowserHandler(music)); 

    // function musicInBrowserHandler(music) {
        if (music == 1) {  
            // audioElement.setAttribute('src', '/client/audio/coin.mp3');              
            audioElement.play();
            
        } else if (music == 2) {
            // audioElement.setAttribute('src', '/client/audio/win.mp3');
            // audioElement_win.play();
        } else if (music == 22) {
            // audioElement_win.pause();
        } else {        
            //do nothing
            // audioElement.setAttribute('src', '/client/audio/coin.mp3');              
        }

        // console.log(music);
        // if (music == 22) {
        //     console.log('pause');
        //     audioElement.pause();
        // } else {
        //     console.log('play');
        //     audioElement.play();    
        // }
        
        // document.body.removeEventListener('touchstart', musicInBrowserHandler(music));
    // }    

    // document.getElementById('music_win').play();
    // alert("test!");

}
//load audio - end