
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
        } else {
        }
    });
}

function getSummary(token) {
    var user_id = $('#hidUserId').val();
    _url = "api/get-summary?type=vip&memberid=" + user_id;
    
    $.ajax({
        type: 'GET',
        url: _url,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        success: function(data) {
            showSummary(data.records);
        }
    });
}

 function showSummary(results) {
    // console.log(results);
    var length = results.length;
    var html = '';

    $.each(results, function(key, value){
        //console.log(value);
        var str_type = '';
        var str_points = '';

        var t = value.created_at.split(/[- :]/);
        var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
        var str_date =    d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + 
                            ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
        
        var txt_amount = getNumeric(value.balance_before);
        var txt_reason = '';
        var _fontcolor = '#3d3d3d';

        switch(value.credit_type){
            case 'CRPNT':
            break;
            case 'APMNT':
                str_type = '游戏收益结算';
                str_points = '+' + getNumeric(value.credit) + '元';   
                _fontcolor = '#3d3d3d';             
            break;

            case 'DPRPO':
                str_type = '兑换话费卡';
                str_points = '-' + getNumeric(value.debit) + '元';
                _fontcolor = '#12bf00';
            break;

            case 'DPBVP':
                str_type = '兑换VIP入场券';
                str_points = '-' + getNumeric(value.debit) + '元';
                _fontcolor = '#12bf00';                   
            break;

            case 'DPRBP': //redeem / buy product
                str_type = '兑奖-' + value.title;
                str_points = '-' + getNumeric(value.debit) + '元';
                _fontcolor = '#3d3d3d';
            break

            case 'APACP': //top up
                str_type = '充值挖宝币';
                str_points = '+' + getNumeric(value.credit) + '元';
                _fontcolor = '#3d3d3d';
            break

            case 'APRBP': //refund
                str_type = '退还挖宝币-' + value.reject_notes;
                str_points = '+' + getNumeric(value.credit) + '元';
                _fontcolor = '#3d3d3d';
            break
        }

        if (str_type != '') {                     

            html += '<a class="inBox">';                        
            html += '<h2><span>' +str_type+ '</span>';
            html += '<font color="'+_fontcolor+'">' + str_points + '</font>';                                    
            html += '</h2>' +
                      '<p><span>' + str_date +'</span>' +
                        '<font color="#686868">'+txt_amount+'</font>' +
                      '</p>';
            if (txt_reason != '') {
              html += '<h3>失败原因：' +txt_reason+ '</h3>';  
            }
            html += '</a>'; 

        }
        
    });            

    if (html == '' || length === 0) {

        html =   '<div class="no-record">' +
                    '<img src="/clientapp/images/no-record/summary.png">' +
                    '<div>暂无明细</div>' +
                  '</div>';

    }

    $('#summary').append(html);
    document.getElementById('loading2').style.visibility="hidden";

}

function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) + 0 : Number(parseInt(value)) + 0;
  }
