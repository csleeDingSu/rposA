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
        success: function(data) {
            showSummary(data.result);
        }
    });
}

 function showSummary(results) {
    //console.log(results);
    var length = results.length;

    $('#summary').html('');

     if(length === 0){
        var summary =   '<div class="row">' +
                            '<div class="col-xs-12">' +
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                            '</div>' +
                        '</div>';

        $('#summary').append(summary);

    } else {
        var summary = '';
        $.each(results, function(key, value){
            //console.log(value);
            var str_type = '';
            var str_points = '';
            var cls_negative = '';

            var t = value.created_at.split(/[- :]/);
            var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
            var str_date =    d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + 
                                ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);

            switch(value.credit_type){
                case 'CRPNT':
                case 'APMNT':
                    str_type = '游戏收益结算';
                    str_points = '+' + parseInt(value.credit)/10 + '元';                
                break;

                case 'DPRPO':
                    str_type = '兑换话费卡';
                    str_points = '-' + parseInt(value.debit)/10 + '元';
                    cls_negative = 'negative';
                break;

                case 'DPBVP':
                    str_type = '兑换VIP入场券';
                    str_points = '-' + parseInt(value.debit)/10 + '元';
                    cls_negative = 'negative';
                break;
            }

            //skip/ignore data - credit 0 point
            if (value.credit_type == 'CRPNT' && value.credit <= 0) {
                return true;
            }

            summary +=   '<div class="row">' +
                            '<div class="col-xs-8 column-1">' +
                                '<div class="item">'+ str_type +'</div>' +
                                '<div class="date">' + str_date + '</div>' +
                            '</div>' +
                            '<div class="col-xs-4 column-2">' +
                                '<div class="right-wrapper">' +
                                    '<div class="points ' + cls_negative +'">'+ str_points +'</div>' +
                                    // '<div class="icon-coin-wrapper">' +
                                    //     '<div class="icon-coin"></div>' +
                                    // '</div>' +
                                    
                                    '<div style="clear: both"></div>' +
                                    '<div class="balance">'+ parseInt(value.balance_before)/10 +'</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            
        });            

        $('#summary').append(summary);

    }
}
