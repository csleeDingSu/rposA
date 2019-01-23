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
            var d = new Date(value.created_at);
            var str_date =    d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + 
                                ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);

            switch(value.credit_type){
                case 'CRPNT':
                    str_type = '挖宝成功收益结算';
                    str_points = '+' + parseInt(value.credit);
                break;

                case 'DPRPO':
                    str_type = '兑换话费卡';
                    str_points = '-' + parseInt(value.debit);
                    cls_negative = 'negative';
                break;

                case 'DPBVP':
                    str_type = '兑换VIP入场卷';
                    str_points = '-' + parseInt(value.debit);
                    cls_negative = 'negative';
                break;
            }

            summary +=   '<div class="row">' +
                            '<div class="col-xs-8 column-1">' +
                                '<div class="item">'+ str_type +'</div>' +
                                '<div class="date">' + str_date + '</div>' +
                            '</div>' +
                            '<div class="col-xs-4 column-2">' +
                                '<div class="right-wrapper">' +
                                    '<div class="points ' + cls_negative +'">'+ str_points +'</div>' +
                                    '<div class="icon-coin-wrapper">' +
                                        '<div class="icon-coin"></div>' +
                                    '</div>' +
                                    
                                    '<div style="clear: both"></div>' +
                                    '<div class="balance">'+ value.balance_before +'</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            
        });            

        $('#summary').append(summary);

    }
}
