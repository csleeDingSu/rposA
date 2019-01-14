$(function () {
    getToken();    
});

function getToken(){

    var id = $('#hidUserId').val();
    var session = $('#hidSession').val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            getNormalBettingHistory(data.access_token);
            getVipBettingHistory(data.access_token);
        }     
    });
}

function getNormalBettingHistory(token) {
    var user_id = $('#hidUserId').val();

        var container = $('#normal-pagination');

        var options = {
          dataSource: function(done) {
            $.ajax({
                type: 'GET',
                url: "/api/betting-history?gameid=101&memberid=" + user_id,
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                success: function(data) {
                    //console.log(data);
                    var results = reverse(data);
                    //console.log(results);
                    done(results);
                }
            });
          },
          callback: function (response, pagination) {
            showBettingHistory(response, 'normal');
          }
        };

        container.pagination(options);

}

function getVipBettingHistory(token) {
    var user_id = $('#hidUserId').val();

        var container = $('#vip-pagination');

        var options = {
          dataSource: function(done) {
            $.ajax({
                type: 'GET',
                url: "/api/betting-history?gameid=101&vip=yes&memberid=" + user_id,
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                success: function(data) {
                    //console.log(data);
                    var results = reverse(data);
                    //console.log(results);
                    done(results);
                }
            });
          },
          callback: function (response, pagination) {
            showBettingHistory(response, 'vip');
          }
        };

        container.pagination(options);

}

function reverse(data) {
    var records = data.records;
    var arr = [];
    var results = [];

    for( var name in records ) {
        arr[name] = records[name];
    }

    var len = arr.length;
    while( len-- ) {
        if( arr[len] !== undefined ) {
            results.push(arr[len]);
        }
    }

    return results;
}

function showBettingHistory(response, type) {
    //window.console && console.log(response, pagination);
    var length = response.length;

    $('#'+ type + '-history').html('');

     if(length === 0){
        var history =   '<div class="row">' +
                            '<div class="col-xs-12">' +
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                            '</div>' +
                        '</div>';

        $('#'+ type + '-history').append(history);

    } else {
        //console.log(response);
        $.each(response, function(bkey, bvalue){
            var history = '';

            var betCount = bvalue.length;
            var winCount = 0;
            var loseCount = 0;
            var points = 0;

            history =   '<div class="row">' +
                            '<div class="col-xs-9 column-1">';


            var first_bet = null;
            var last = null;
            var loopCount = 0;

            while( betCount-- ) {
                if(loopCount == 0) {
                    first_bet = bvalue[betCount];
                }

                var className = 'pass';
                var faIcon = 'fa-check';

                if(bvalue[betCount].is_win == null){
                    className = 'fail';
                    faIcon = 'fa-times';
                    loseCount++;
                } else {
                    winCount++;                        
                }

                history +=   '<div class="' + className + '">' +
                                '<span class="label"><i class="fa '+ faIcon +'"></i></span>' +
                            '</div>';

                loopCount++;

                if(betCount == 0){
                    last_bet = bvalue[betCount];
                }
            }

            if(winCount) {
                points = (winCount + loseCount) * 10;
            }

            if(betCount == -1){
                history += '<div style="clear: both"></div>' +
                                '<div class="date">' + first_bet.created_at + ' 至 ' + last_bet.created_at + '</div>' +
                            '</div>' +
                            '<div class="col-xs-3 column-2">' +
                                '<div class="right-wrapper">' +
                                    '<div class="points">'+ points +'</div>' +
                                    '<div class="icon-coin-wrapper">' +
                                        '<div class="icon-coin"></div>' +
                                    '</div>' +
                                    
                                    '<div style="clear: both"></div>' +
                                    '<div class="balance">'+ last_bet.wallet_point +'</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';

                $('#'+ type + '-history').append(history);
            }
        });
    }
}
