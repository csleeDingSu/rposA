var type = 'normal';
var page = 1;
var page_count = 1;

$(function () {
    getToken();    
});

function getToken(){

    var id = $('#hidUserId').val();
    var session = $('#hidSession').val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            getPosts(page, data.access_token, type);
            scrollBottom(data.access_token);

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                page = 1;
                page_count = 1;
                type = $(e.target).attr('data-type');
                getPosts(page, data.access_token, type);
                scrollBottom(data.access_token);
            });
        }     
    });
}

function scrollBottom(token){
    being.scrollBottom('.cardBody', '.container', () => { 
        page = parseInt($('#page').val());

        var max_page = parseInt($('#max_page').val());
        if(page > max_page) {
            
        }else{
            getPosts(page, token, type);
        }   
    });
}

function getPosts(page, token, type){

   var user_id = $('#hidUserId').val();
   var url ="/api/betting-history?gameid=102&memberid=" + user_id + "&page=" + page;

   if(type == 'vip'){
        url += '&vip=yes';
   }

    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            //console.log(data);
            var current_page = parseInt(data.records.current_page);
            var last_page = parseInt(data.records.last_page);
            $('#max_page').val(last_page);
            var html = showBettingHistory(data.records);

            if(current_page == 1){
                $('#' + type + '-history').html(html);
            } else {
                $('#' + type + '-history').append(html);
            }

            if(current_page == last_page){
                $(".isnext").html(end_of_result);
            }

            page++;
            $('#page').val(page);
        }
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

function reverse(data) {
    var records = data;
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

function showBettingHistory(response) {
    //window.console && console.log(response);
    var results = groupHistory(response.data);
    results = reverse(results);
    var length = results.length;
    var history = '';
    var current_page = parseInt(response.current_page);
    var last_page = parseInt(response.last_page);
    var limit = parseInt(response.per_page);
    var counter = (current_page - 1) * limit;

    if(page_count != page && current_page == page){
        return false;
    }

    console.log(page_count + ":" + current_page);
    page_count++;

     if(length === 0){
        var history =   '<div class="row">' +
                            '<div class="col-xs-12">' +
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                            '</div>' +
                        '</div>';

    } else {
        //console.log(results);
        $.each(results, function(bkey, bvalue){
            counter += 1;
            var betCount = bvalue.length;
            var winCount = 0;
            var loseCount = 0;
            var points = 0;

            history +=   '<div class="row">' +
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
                var wallet_point = parseInt(last_bet.wallet_point);

                var f = first_bet.created_at.split(/[- :]/);
                var first_date = new Date(f[0], f[1]-1, f[2], f[3], f[4], f[5]);
                var str_first_date = first_date.getFullYear() + "-" + ("0"+(first_date.getMonth()+1)).slice(-2) + "-" + ("0" + first_date.getDate()).slice(-2) + " " + 
                                ("0" + first_date.getHours()).slice(-2) + ":" + ("0" + first_date.getMinutes()).slice(-2);

                var l = last_bet.created_at.split(/[- :]/);
                var last_date = new Date(l[0], l[1]-1, l[2], l[3], l[4], l[5]);
                var str_last_date = last_date.getFullYear() + "-" + ("0"+(last_date.getMonth()+1)).slice(-2) + "-" + ("0" + last_date.getDate()).slice(-2) + " " + 
                                ("0" + last_date.getHours()).slice(-2) + ":" + ("0" + last_date.getMinutes()).slice(-2);

                history += '<div style="clear: both"></div>' +
                                '<div class="date">' + str_first_date + ' 至 ' + str_last_date + '</div>' +
                            '</div>' +
                            '<div class="col-xs-3 column-2">' +
                                '<div class="right-wrapper">' +
                                    '<div class="points">'+ points +'</div>' +
                                    '<div class="icon-coin-wrapper">' +
                                        '<div class="icon-coin"></div>' +
                                    '</div>' +
                                    
                                    '<div style="clear: both"></div>' +
                                    '<div class="balance">'+ (isNaN(wallet_point) ? '' : wallet_point) +'</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';

            }
        });
    }

    return history;
}
