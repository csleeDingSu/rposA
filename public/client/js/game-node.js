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

    var str_result = '单数';

    var length = Object.keys(records).length;
    var maxCount = 20;

    if(length < maxCount){
        maxCount = parseInt(length);
    }

    $.each(records, function(i, item) {
        var counter = i + 1;
        if(item.result % 2 === 0){
            $('.results-body').find('#result-' + counter).addClass('even-box');
            str_result = '双数';
        } else {
            $('.results-body').find('#result-' + counter).removeClass('even-box');
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

        history =  '选择<span class="'+ className + '">' + strbet + '</span>，投'+ parseInt(item.bet_amount) +'金币，' + strwinloss + '，' + strsign + parseInt(item.bet_amount) +'金币';

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
            $('.spanAcuPointAndBalance').html(acupoint/10);
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
        var duration = 10;
        var timer = 10;
        var freeze_time = 1;
        var draw_id = data.drawid;
        var level = level.position;
        var previous_result = 1;
        var consecutive_lose = consecutive_lose;
        var life = $(".nTxt").html();
        var balance = $('#hidBalance').val();
        var payout_info = '';
        var acupoint = parseInt($('.spanAcuPoint').html());

        if(latest_result.length > 0){
            previous_result = latest_result[0].result;
        }

        $('#hidLevel').val(level);
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
            showProgressBar(false);
        }

        setBalance();

        $('#freeze_time').val(freeze_time);
        $('#draw_id').val(draw_id);

        DomeWebController.init();
        trigger = false;
        clearInterval(parent.timerInterval);
        //startTimer(duration, timer, freeze_time);

        var show_game_rules = Cookies.get('show_game_rules');

        if (balance == 1200 && acupoint == 0) {
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
            },
            success: function(data) {

                if(data.success && data.record.bet != null){

                    if(show_lose !== true && show_win !== true){
                        showProgressBar(false);
                    }

                    var selected = data.record.bet;

                    var btn_rectangle = $("input[value='"+ selected +"']").parent();
                    btn_rectangle.addClass('clicked');
                    showPayout();

                    $.ajax({
                        type: 'GET',
                        url: "/api/update-game-result-temp?gameid=102&gametype=1&memberid="+ user_id
                        + "&drawid=0" 
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

function getToken(){
    var username = $('#hidUsername').val();
    var session = $('#hidSession').val();
    var id = $('#hidUserId').val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            token = data.access_token;
            startGame();            
        }      
    });
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
    $('.middle-label').html('开始竞猜');
    $('.radio-primary').unbind('click');

    startGame();
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
    if (typeof selected == 'undefined'){
        $('.spinning').html('请先选择单数或选择双数<br />再点击“开始抽奖”进行抽奖');
         $('.spinning').css('visibility', 'visible');
        setTimeout(function(){ 
            $('.spinning').css('visibility', 'hidden');
        }, 3000);
    } else {
        $('.middle-label').html('正在抽奖');
        $('.DB_G_hand').hide();
        $('.radio-primary').unbind('click');
        $('#btnWheel').unbind('click');
        bindSpinningButton();
        startTimer(5, 5, 1);
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

        $('.spanAcuPointAndBalance')
          .prop('number', g_previous_point/10)
          .animateNumber(
            {
              number: g_current_point/10
            },
            500
          );
            
        $('.spanAcuPoint').html(g_current_point);

        setTimeout(function () {
            showProgressBar(false);
        }, 500);
        
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

    switch (level) {
        case 1:
            //previous_bet = 0;
        break;

        case 2:
            previous_bet = 10;
        break;

        case 3:
            previous_bet = 30;
        break;

        case 4:
            previous_bet = 70;
        break;

        case 5:
            previous_bet = 150;
        break;

        case 6:
            previous_bet = 310;
        break;

    }

        if (typeof selected == 'undefined'){

            checked(level, false);
            changbar(level);

            $('#spanPoint').html(total_balance);
            $('.instruction').css('visibility', 'visible');
            $('.payout-info').addClass("hide");

            $('.odd-payout')
                  .prop('number', bet_amount)
                  .animateNumber(
                    {
                      number: previous_bet
                    },
                    1000
                  );

            $('.even-payout')
              .prop('number', bet_amount)
              .animateNumber(
                {
                  number: previous_bet
                },
                1000
              );

            setTimeout(function(){
                if(level == 1) {
                    $('.odd-sign').html('');
                    $('.even-sign').html('');
                } else {
                    $('.odd-sign').html('-');
                    $('.even-sign').html('-');
                }
            }, 1000);
            
            $.ajax({
                type: 'GET',
                url: "/api/update-game-result-temp?gameid=102&gametype=1&memberid="+ user_id 
                + "&bet=&betamt=&drawid=0",
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { 
                    console.log(error.responseText);
                    // window.top.location.href = "/arcade";
                },
                success: function(data) {
                }
            });

        } else {

            checked(level, true);
            changbar(level);


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

                $('.odd-payout')
                      .prop('number', previous_bet)
                      .animateNumber(
                        {
                          number: bet_amount
                        },
                        1000
                      );

                $('.even-payout')
                  .prop('number', previous_bet)
                  .animateNumber(
                    {
                      number: bet_amount
                    },
                    1000
                  );

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
    $('.btn-calculate').click( function() {
        $('#reset-life-play').modal({backdrop: 'static', keyboard: false});
    });
}

function bindTriggerButton(){
    $('#btnWheel').click( function() {
        checkSelection();
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

function showProgressBar(bol_show){
    var level = parseInt($('#hidLevel').val());
    var consecutive_lose = $('#hidConsecutiveLose').val();
    var balance = parseInt($('#hidBalance').val());
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
                previous_bet = current_bet;
                current_bet = 10;                

                payout_info = '押注10积分，猜对+10，猜错-10。';
                //payout_info = '<span class=\'caption_bet\'>[单数]</span>押注10积分，猜对+10，猜错-10。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中赚10金币，可兑换1元。';//'猜中得10，赚10金币。';
                $('.span-1').html("10");
                $('.span-2').html("30");
                $('.span-3').html("70");
                $('.span-4').html("150");
                $('.span-5').html("310");
                $('.span-6').html("630");

                result_info = '本轮还有6次机会。';

                break;
            case 2:
                current_bet = 30;
                previous_bet = 10;
                span_balance = 1190;
                result_info = '本轮错了1次，还剩5次。';

                payout_info = '押注30积分，猜对+30，猜错-30。';
                //payout_info = '<span class=\'caption_bet\'>[单数]</span>押注30积分，猜对+30，猜错-30。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得30，赚20金币。';//'猜中得30，扣除之前亏损10，赚20金币。';
                $('.span-1').html("-10");                        
                break;
            case 3:                    
                current_bet = 70;
                previous_bet = 30;
                span_balance = 1160;
                result_info = '本轮错了2次，还剩4次。';

                payout_info = '押注70积分，猜对+70，猜错-70。';
                // payout_info = '<span class=\'caption_bet\'>[单数]</span>押注70积分，猜对+70，猜错-70。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得70，赚30金币。';//'猜中得70，扣除前2次亏损40，赚30金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                break;
            case 4:
                current_bet = 150;
                previous_bet = 70;
                span_balance = 1090;
                result_info = '本轮错了3次，还剩3次。';

                payout_info = '押注150积分，猜对+150，猜错-150。';
                //payout_info = '<span class=\'caption_bet\'>[单数]</span>押注150积分，猜对+150，猜错-150。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得150，赚40金币。';//'猜中得150，扣除前3次亏损110，赚40金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                $('.span-3').html("-70");
                break;
            case 5:
                current_bet = 310;
                previous_bet = 150;
                span_balance = 940;
                result_info = '本轮错了4次，还剩2次。';

                payout_info = '押注310积分，猜对+310，猜错-310。';
                //payout_info = '<span class=\'caption_bet\'>[单数]</span>押注310积分，猜对+310，猜错-310。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得310，赚50金币。';//'猜中得310，扣除前4次亏损260，赚50金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                $('.span-3').html("-70");
                $('.span-4').html("-150");
                break;
            case 6:
                current_bet = 630;
                previous_bet = 310;
                span_balance = 630;
                result_info = '本轮剩1次机会，猜错清零。';                

                payout_info = '押注630积分，猜对+630，猜错-630。';
                // payout_info = '<span class=\'caption_bet\'>[单数]</span>押注630积分，猜对+630，猜错-630。';
                //'您选择<span class=\'caption_bet\'>[单数]</span>，猜中得630，赚60金币。';//'猜中得630，扣除前5次亏损570，赚60金币。';
                $('.span-1').html("-10");
                $('.span-2').html("-30");
                $('.span-3').html("-70");
                $('.span-4').html("-150");
                $('.span-5').html("-310");
                break;
        }

        result_info = '剩余<span style="text-decoration:underline">'+ span_balance +'</span>游戏积分&nbsp;';

        $('.span-balance').html(span_balance);
        $('#hidBet').val(current_bet);
        $('.result-info').html(result_info);
        $('.odd-payout').html(previous_bet);
        $('.even-payout').html(previous_bet);

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
    var selected = $('div.clicked').find('input:radio').val();
    var trigger_time = freeze_time - 1;
    var id = $('#hidUserId').val();
    var level = parseInt($('#hidLevel').val());
    $('.small-border').addClass('slow-rotate');
    setTimeout(function(){ 
        $('.small-border').addClass('medium-rotate');
    }, 500);
    setTimeout(function(){ 
        $('.small-border').addClass('fast-rotate');
    }, 2000);
    g_previous_point = parseInt($('.spanAcuPoint').html());

    $.ajax({
        type: 'POST',
        url: "/api/add-betting?gameid=102&memberid=" + id + "&betto=" + selected, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            $.ajax({
                type: 'POST',
                url: "/api/get-betting-result?gameid=102&memberid=" + id, 
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { console.log(error) },
                success: function(data) {

                    $('#result').val(data.game_result);
                    if(data.status == 'win'){
                        show_win = true;
                        showWinModal();
                    } else if(data.status == 'lose' && level < 6) {
                        show_lose = true;
                        showLoseModal();
                    }
                    triggerResult();
                }
            });
        }
    });
}

function triggerResult(){
    $('.small-border').removeClass('slow-rotate medium-rotate fast-rotate');
    trigger = true;
    //console.log(data);
    var freeze_time = 5;
    var result = $('#result').val();
    // console.log(freeze_time);

    //Trigger the wheel
    DomeWebController.getEle("$wheelContainer").wheelOfFortune({
        'items': {1: [360, 360], 2: [60, 60], 3: [120, 120], 4: [180, 180], 5: [240, 240], 6: [300, 300]},//奖品角度配置{键:[开始角度,结束角度],键:[开始角度,结束角度],......}
        'pAngle': 0,//指针图片中的指针角度(x轴正值为0度，顺时针旋转 默认0)
        'type': 'w',//旋转指针还是转盘('p'指针 'w'转盘 默认'p')
        'fluctuate': 0.5,//停止位置距角度配置中点的偏移波动范围(0-1 默认0.8)
        'rotateNum': 3,//转多少圈(默认12)
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