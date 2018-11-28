$(function () {
    getToken();    
});

function getToken(){
    
    var username = $('#hidUsername', window.parent.document).val();
    var session = $('#hidSession', window.parent.document).val();

    $.getJSON( "/api/gettoken?username=" + username + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            getBettingHistory(data.access_token);
        }     
    });
}

function getBettingHistory(token) {
    var user_id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/betting-history?gameid=101&memberid=" + user_id,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {

            var records = data.records;
            var length = Object.keys(records).length;
            var maxCount = parseInt(length);

            //console.log(records);

            if(length === 0){
                history =   '<div class="row">' +
                                '<div class="col-xs-12">' +
                                    '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                                '</div>' +
                            '</div>';

                $('#history').append(history);

            } else {

                for(var r = 1; r <= maxCount; r++){
                    var last = Object.keys(records)[Object.keys(records).length-1];
                    var last_record = records[last];
                    var history = '';

                    var betCount = Object.keys(last_record).length;
                    var winCount = 0;
                    var loseCount = 0;
                    var points = 0;

                    history =   '<div class="row">' +
                                    '<div class="col-xs-9 column-1">';


                    var first_bet = null;

                    for(var i = 0; i < betCount; i++){

                        var last_key = Object.keys(last_record)[Object.keys(last_record).length-1];
                        var last_bet = last_record[last_key];

                        if (i == 0) {
                            first_bet = last_record[betCount - 1];    
                        }                    

                        //console.log(last_bet);
                        var className = 'pass';
                        var faIcon = 'fa-check';

                        if(last_bet.is_win == null){
                            className = 'fail';
                            faIcon = 'fa-times';
                            loseCount++;
                        } else {
                            winCount++;                        
                        }

                        history +=   '<div class="' + className + '">' +
                                        '<span class="label"><i class="fa '+ faIcon +'"></i></span>' +
                                    '</div>';
                        
                        delete last_record[last_key];
                    }

                    if(winCount) {
                        points = (winCount + loseCount) * 10;
                    }

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

                    $('#history').append(history);
                    delete records[last];
                }
            }
        }
    });
}