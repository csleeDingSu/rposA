$(function () {
    var user_id = $('#hidUserId').val();
    $.getJSON( "/api/betting-history?gameid=101&memberid=" + user_id, function( data ) {

        var records = data.records;
        var length = Object.keys(records).length;
        var maxCount = parseInt(length);

        console.log(records);
        for(var r = 1; r <= maxCount; r++){
            var last = Object.keys(records)[Object.keys(records).length-1];
            var last_record = records[last];
            var history = '';

            var betCount = Object.keys(last_record).length;


            history =   '<div class="row">' +
                            '<div class="col-xs-9 column-1">';

            for(var i = 0; i < betCount; i++){

                var last_key = Object.keys(last_record)[Object.keys(last_record).length-1];
                var last_bet = last_record[last_key];
                //console.log(last_bet);
                var className = 'pass';
                var faIcon = 'fa-check';

                if(last_bet.is_win == null){
                    className = 'fail';
                    faIcon = 'fa-times';
                }

                history +=   '<div class="' + className + '">' +
                                '<span class="label"><i class="fa '+ faIcon +'"></i></span>' +
                            '</div>';

                delete last_record[last_key];
            }

            history += '<div style="clear: both"></div>' +
                            '<div class="date">2018-11-02 15:30 至 2018-11-02 15:30</div>' +
                        '</div>' +
                        '<div class="col-xs-3 column-2">' +
                            '<div class="right-wrapper">' +
                                '<div class="points">600</div>' +
                                '<div class="icon-coin-wrapper">' +
                                    '<div class="icon-coin"></div>' +
                                '</div>' +
                                
                                '<div style="clear: both"></div>' +
                                '<div class="balance">2600</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';

            $('#history').append(history);
            delete records[last];
        }
    });
});