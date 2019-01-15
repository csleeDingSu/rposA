$(function () {
    getToken();    
});

function getToken(){

    var id = $('#hidUserId').val();
    var session = $('#hidSession').val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            getSummary(data.access_token);
        }     
    });
}

function getSummary(token) {
    var user_id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/member-point-list?memberid=" + user_id,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            console.log(data);
            //showSummary(results);
        }
    });
}

 function showSummary(results) {
    var length = results.length;

    //$('#summary').html('');

     if(length === 0){
        var summary =   '<div class="row">' +
                            '<div class="col-xs-12">' +
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                            '</div>' +
                        '</div>';

        //$('#summary').append(summary);

    } else {
        //console.log(results);
        $.each(results, function(bkey, bvalue){
            var summary = '';

            var betCount = bvalue.length;
            var winCount = 0;
            var loseCount = 0;
            var points = 0;

            summary =   '<div class="row">' +
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

                summary +=   '<div class="' + className + '">' +
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
                summary += '<div style="clear: both"></div>' +
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

                //$('#summary').append(summary);
            }
        });
    }
}
