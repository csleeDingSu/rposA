var page = 1;
var page_count = 1;

$(document).ready(function () {

    getToken();  

});

function getToken(){
    var username = $('#hidUsername', window.parent.document).val();
    var session = $('#hidSession', window.parent.document).val();
    var id = $('#hidUserId', window.parent.document).val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            getPosts(page, data.access_token);
            scrollBottom(data.access_token);
        }      
    });
}

function scrollBottom(token){
    being.scrollBottom('.cardBody', '.container', () => { 
        page = parseInt($('#page').val());
        var max_page = parseInt($('#max_page').val());
        if(page > max_page) {
            
        }else{
            getPosts(page, token);
        }   
    });
}

function getPosts(page, token){

    var member_id = $('#hidUserId').val();

    $.ajax({
        type: "GET",
        url: "/api/redeem-history?memberid=" + member_id + "&page=" + page, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            var current_page = parseInt(data.records.current_page);
            var last_page = parseInt(data.records.last_page);
            $('#max_page').val(last_page);
            var records = data.records;
            var html = populateHistoryData(records, token);

            if(current_page == 1){
                $('#redeem-history').html(html);
            } else {
                $('#redeem-history').append(html);
            }

            if(current_page == last_page){
                $(".isnext").html(end_of_result);
            }

            page++;
            $('#page').val(page);
        }
     });
}

function populateHistoryData(records, token) {
    var data = records.data;
    var current_page = parseInt(records.current_page);
    var limit = parseInt(records.per_page);

    var html = '';
    var htmlmodel = '';
    var counter = (current_page - 1) * limit;
    var str_date = '';

    if(page_count != page && current_page == page){
        return false;
    }

    console.log(page_count + ":" + current_page);
    page_count++;

    if(data.length === 0){
        $('.isnext').hide();

        html += '<div>' +
                    '<div class="col-xs-12">' +
                        '<img src="/client/images/membership/no-record.png" />' +
                    '</div>' +
                '</div>';
    } else {

        $.each(data, function(i, item) {
            counter += 1;

            if(item.request_at){
                var t = item.request_at.split(/[- :]/);
                var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                str_date =    d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + 
                            ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
            }

            if (item.type == 'vip') {
                html += '<div class="history-row">' +
                    '<div class="col-xs-9 column-5">' +
                        '<div class="description">'+ item.product_name + ' ' + (item.used_point + '金币' || '') + '</div>' +
                        '<div class="balance">购买时间:'+ str_date +'</div>' +
                    '</div>';

                if(item.redeem_state == 1) { // Pending
                    html += '<div class="col-xs-3 column-6">' +
                                '<div class="btn-pending-vip">等待开通</div>' +
                            '</div>' + 
                        '</div>';

                } else if (item.redeem_state == 2) { // Confirmed
                    html += '<div class="col-xs-3 column-6">' +
                                '<div class="btn-card-vip" data-toggle="collapse" data-target="#content-p-' + item.id + '">查看密码</div>' +
                            '</div>' + 
                        '</div>' +
                    '<div id="content-p-' + item.id + '" class="collapse">' +
                        '<div class="card-wrapper">VIP场密码：<span class="codes-vip">' + item.passcode + '</span>' +
                        '&nbsp;&nbsp;<button class="btn-vip" data-id="'+item.passcode+'" onClick="confirmredeemvip(\''+ token +'\', \''+ item.id +'\', \''+ item.passcode +'\')"  >进入VIP场</button></div>' +
                    '</div>';

                    htmlmodel += '<!-- Modal starts -->' +
                                    '<div class="modal fade col-lg-12" id="enter-vip-modal-' + item.id + '" tabindex="-1" style="z-index: 9999">' +
                                        '<div class="modal-dialog" role="document">' +
                                            '<div class="modal-content enter-vip-content">' +
                                                '<div class="modal-body">' +
                                                    '<div class="modal-row">' +
                                                        '<div class="vip-label">' +
                                                            'VIP专场游戏密码' +
                                                        '</div>' +
                                                        '<div class="vip-code">' +
                                                            item.passcode +
                                                        '</div>' +
                                                        '<a href="/vip">' +
                                                            '<div class="btn-enter-vip">' +
                                                                '进入专场' +
                                                            '</div>' +
                                                        '</a>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<!-- Modal Ends -->';

                } else if (item.redeem_state == 3) { // Redeemed
                    html += '<div class="col-xs-3 column-6">' +
                                '<a href="/vip"><div class="btn-pending">正在使用</div></a>' +
                            '</div>' + 
                        '</div>';
                } else if (item.redeem_state == 4) { // Used
                    html += '<div class="col-xs-3 column-6">' +
                                '<div class="btn-used-wrapper">' +
                                    '<div class="btn-used"><img src="/client/images/vip/vip-used.png" width="50" height="50" /></div>' +
                                '</div>' + 
                            '</div>' + 
                        '</div>';
                } else {
                    html += '</div>';
                }

            }

        });

        $( ".cardFull" ).after( htmlmodel);
    }

    return html;

}

function redeemVip(token, package_id){

    var member_id = $('#hidUserId').val();
    
    $.ajax({
        type: 'POST',
        url: "/api/request-vip-upgrade",
        data: { 'memberid': member_id, 'packageid': package_id },
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            if(data.success) {
                window.location.href = "/redeem/history";
            } else {
                $('#error-' + package_id).html(data.message);
            }
        }
    });
}

function requestVip(token, package_id, type, index){

    var member_id = $('#hidUserId').val();

    if(type == 'single') {
        var card_no = $('#txt_cardno').val();
        var password = $('#txt_password').val();
        var card = card_no + ' ' + password;
    } else {
        var card = $('#txa_card').val();
    }

    $.ajax({
        type: 'POST',
        url: "/api/request-vip-upgrade",
        data: { 'memberid': member_id, 'packageid': package_id, 'card': card },
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            if(data.success){
                window.location.href = "/redeem/history";
            }
        }
    });
}

function confirmredeemvip(token,id,code)
{
	var member_id = $('#hidUserId').val();
    
	$.ajax({
        type: 'POST',
        url: "/api/redeem-vip",
        data: { 'memberid': member_id, 'passcode': code },
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText);},
        success: function(data) {
            if(data.success){
                $('#enter-vip-modal-' + id).modal('show');
            } else {
                $('#using-vip-modal').modal('show');

                $('.btn-close-modal').click(function() {
                    $('#using-vip-modal').modal('hide');
                });
            }
        }
    });
	
	
}
        