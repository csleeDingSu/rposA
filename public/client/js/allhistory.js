$(function () {
    getToken();    
});

function getToken(){
    
    var username = $('#hidUsername', window.parent.document).val();
    var session = $('#hidSession', window.parent.document).val();

    $.getJSON( "/api/gettoken?username=" + username + "&token=" + session, function( data ) {
        console.log(data);
        if(data.success) {
            getBettingHistory(data.access_token);
        }     
    });
}

function getBettingHistory(token) {
    var user_id = $('#hidUserId').val();


        var container = $('#pagination');

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
                    //console.log(results);
                    done(results);
                }
            });
          },
          callback: function (response, pagination) {
            window.console && console.log(response, pagination);
            var length = response.length;

            $('#history').html('');

             if(length === 0){
                var history =   '<div class="row">' +
                                    '<div class="col-xs-12">' +
                                        '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                                    '</div>' +
                                '</div>';

                $('#history').append(history);

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

                    $.each(bvalue, function(key, val){
                        

                        if(key == 0) {
                            first_bet = val;
                        }

                        var className = 'pass';
                        var faIcon = 'fa-check';

                        if(val.is_win == null){
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

                        if(betCount == loopCount){
                            last_bet = val;
                        }
                    });

                    if(winCount) {
                        points = (winCount + loseCount) * 10;
                    }

                    if(betCount == loopCount){
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
                    }
                });
            }
          }
        };

        container.pagination(options);

}
   