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
            getList(data.access_token);
        }     
    });
}

function getSummary(token) {
    var user_id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/member-referral-count?memberid=" + user_id,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            var result = data.result;
            var total = 0;
            var total_fail = 0;
            var total_pending = 0;
            var total_successful = 0;

            $.each(result, function(i, item) {

                if(item.wechat_verification_status == 0){
                    total_successful += parseInt(item.count);                    
                    total += parseInt(item.count);

                } else if (item.wechat_verification_status == 1) {
                    total_pending += parseInt(item.count);
                    total += parseInt(item.count);

                } else if (item.wechat_verification_status == 2 || item.wechat_verification_status == 3) {
                    total_fail += parseInt(item.count);
                    total += parseInt(item.count);
                }

            });

            $('#total-invite').html(total);
            $('#total-fail').html(total_fail);
            $('#total-successful').html(total_successful);
            $('#total-pending').html(total_pending);
        }
    });
}

function getList(token) {
    var user_id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/member-referral-list?memberid=" + user_id,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            console.log(data);
            var result = data.result;
            var html_pending = '';
            var html_success = '';
            var html_fail = '';

            $.each(result, function(i, item) {
                var t = item.created_at.split(/[- :]/);
                var date = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                var str_date = date.getFullYear() + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2) + " " + 
                                ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2);
                
                if(item.wechat_verification_status == 0){
                    html_success += '<div class="row">' +
                                        '<div class="col-xs-8 column-1">' +
                                            '<div class="item">' + item.phone + '</div>' +
                                            '<div class="date">' + str_date + '</div>' +
                                        '</div>' +
                                        '<div class="col-xs-4 column-2">' +
                                            '<div class="right-wrapper">' +
                                                '<div class="status">' +
                                                    '<span class="successful">验证成功</span>' +
                                                '</div>' +                                                
                                                '<div style="clear: both"></div>' +
                                                '<div class="additional">+1</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>';

                } else if (item.wechat_verification_status == 1) {
                    html_pending += '<div class="row">' +
                                        '<div class="col-xs-8 column-1">' +
                                            '<div class="item">' + item.phone + '</div>' +
                                            '<div class="date">' + str_date + '</div>' +
                                        '</div>' +
                                        '<div class="col-xs-4 column-2">' +
                                            '<div class="right-wrapper">' +
                                                '<div class="status">' +
                                                    '<span class="successful">等待验证</span>' +
                                                '</div>' +                                                
                                                '<div style="clear: both"></div>' +
                                                '<div class="additional"></div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>';

                } else {
                    html_fail += '<div class="row">' +
                                        '<div class="col-xs-8 column-1">' +
                                            '<div class="item">' + item.phone + '</div>' +
                                            '<div class="date">' + str_date + '</div>' +
                                        '</div>' +
                                        '<div class="col-xs-4 column-2">' +
                                            '<div class="right-wrapper">' +
                                                '<div class="status">' +
                                                    '<span class="successful">验证失败</span>' +
                                                '</div>' +                                                
                                                '<div style="clear: both"></div>' +
                                                '<div class="additional"></div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>';
                }

            });

            if(html_pending === '') {
                html_pending = '<div class="row">' + 
                                    '<div class="col-xs-12">' + 
                                        '<div class="empty">对不起 - 你现在还没有数据。</div>' + 
                                    '</div>' + 
                                '</div>';
            }

            if(html_success === '') {
                html_success = '<div class="row">' + 
                                    '<div class="col-xs-12">' + 
                                        '<div class="empty">对不起 - 你现在还没有数据。</div>' + 
                                    '</div>' + 
                                '</div>';
            }

            if(html_fail === '') {
                html_fail = '<div class="row">' + 
                                    '<div class="col-xs-12">' + 
                                        '<div class="empty">对不起 - 你现在还没有数据。</div>' + 
                                    '</div>' + 
                                '</div>';
            }

            $('#pending-tab').html(html_pending);
            $('#success-tab').html(html_success);
            $('#fail-tab').html(html_fail);
        }
    });
}
