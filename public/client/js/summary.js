var this_vip_app = false;

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
    this_vip_app = $('#this_vip_app').val();
    var _url = "/api/member-point-list?memberid=" + user_id;
    if (this_vip_app) {
        _url = "api/get-summary?type=vip&memberid=" + user_id;
    }

    $.ajax({
        type: 'GET',
        url: _url,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        success: function(data) {
            if (this_vip_app) {
                showSummary(data.records);
            } else {
                showSummary(data.result);
            }
        }
    });
}

 function showSummary(results) {
    // console.log(results);
    var length = results.length;

    $('#summary').html('');

     if(length === 0){
        var summary =   '<div class="row-full">' +
                            '<div class="col-xs-12">' +
                                '<div class="empty">你还没兑换奖品<br><a href="/arcade" class="share-link">去换奖品></a></div>' +
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
                    str_points = '+' + getNumeric(value.credit) + '元';                
                break;

                case 'DPRPO':
                    str_type = '兑换话费卡';
                    str_points = '-' + getNumeric(value.debit) + '元';
                    cls_negative = 'negative';
                break;

                case 'DPBVP':
                    str_type = '兑换VIP入场券';
                    str_points = '-' + getNumeric(value.debit) + '元';
                    cls_negative = 'negative';
                break;

                case 'DPRBP':
                    str_type = '兑奖-' + value.title;
                    str_points = '-' + getNumeric(value.debit) + '元';
                    cls_negative = 'new_poins';
                break

                case 'APACP':
                    str_type = '充值金币';
                    str_points = '+' + getNumeric(value.credit) + '元';
                    cls_negative = 'new_poins';
                break
            }

            if (!this_vip_app) {
                //skip/ignore data - credit 0 point
                if (value.credit_type == 'CRPNT' && value.credit <= 0) {
                    return true;
                }    
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
                                    '<div class="balance">'+ getNumeric(value.balance_before) +'</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            
        });            

        $('#summary').append(summary);

    }
}

function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) + 0 : Number(parseInt(value)) + 0;
  }
