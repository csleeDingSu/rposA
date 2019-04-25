var status = 'default';
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
            getSummary(data.access_token);
            getPosts(page, data.access_token, status);
            scrollBottom(data.access_token);

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                page = 1;
                page_count = 1;
                status = $(e.target).attr('data-status');
                // console.log(status);
                if (status != 'next-lvl-invitation') {
                    getPosts(page, data.access_token, status);    
                }                
            });
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
            var next_lvl_total = data.slc_count;
            var next_lvl_result = data.slc_data;
            var next_lvl_total_fail = 0;
            var next_lvl_total_pending = 0;
            var next_lvl_total_successful = 0;
            var html = '';
            var html_success = '';
            var html_pending = '';
            var html_fail = '';

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
            $('#my-lvl-total-invitation').html('(' + total + ')');
            $('#next-lvl-total-invitation').html('(' + next_lvl_total + ')');

            $.each(next_lvl_result, function(i, item) {

                var t = item.created_at.split(/[- :]/);
                var date = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                var str_date = date.getFullYear() + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2) + " " + 
                                ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2);
                
                if(item.wechat_verification_status == 0){
                    next_lvl_total_successful += 1;
                    var str_status = "认证成功";
                    var str_additional = "+1";
                    var str_class = "verified";
                    
                } else if (item.wechat_verification_status == 1) {
                    next_lvl_total_pending += 1;
                    var str_status = "未微信认证";
                    var str_additional = "";
                    var str_class = "pending";
                    
                } else if (item.wechat_verification_status == 2 || item.wechat_verification_status == 3) {
                    next_lvl_total_fail += 1;
                    var str_status = "认证失败";
                    var str_additional = "";
                    var str_class = "fail";
                } else {
                    var str_status = "认证失败";
                    var str_additional = "";
                    var str_class = "fail";
                }

                html = '<div class="row">' +
                            '<div class="col-xs-8 column-1">' +
                                '<div class="item">' + item.phone.substring(0,3) + '&#10033;&#10033;&#10033;&#10033;' + item.phone.substring((item.phone.length - 4),item.phone.length) + '</div>' +
                                '<div class="date">' + str_date + '</div>' +
                            '</div>' +
                            '<div class="col-xs-4 column-2">' +
                                '<div class="right-wrapper">' +
                                    '<div class="status">' +
                                        '<span class="' + str_class + '">'+ str_status +'</span>' +
                                    '</div>' +                                                
                                    '<div style="clear: both"></div>' +
                                    '<div class="additional">'+ str_additional +'</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';

                if (str_class == "verified") {
                    html_success += html;
                    status="next-lvl-" + str_class;
                    $('#'+ status +'-tab').append(html_success);

                }else if(str_class == "pending") {
                    html_pending += html;
                    status="next-lvl-" + str_class;
                    $('#'+ status +'-tab').append(html_pending);
                }else {
                    html_fail += html;
                    status="next-lvl-" + str_class;
                    $('#'+ status +'-tab').append(html_fail);
                }
                    
            });

            $('#next-lvl-total-fail').html(next_lvl_total_fail);
            $('#next-lvl-total-successful').html(next_lvl_total_successful);
            $('#next-lvl-total-pending').html(next_lvl_total_pending);

            if(next_lvl_total_successful <= 0) {
                html = '<div class="row">' + 
                            '<div class="col-xs-12">' + 
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' + 
                            '</div>' + 
                        '</div>';
                $('#next-lvl-verified-tab').append(html);
            }
            if(next_lvl_total_pending <= 0) {
                html = '<div class="row">' + 
                            '<div class="col-xs-12">' + 
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' + 
                            '</div>' + 
                        '</div>';
                $('#next-lvl-pending-tab').append(html);
            }
            if(next_lvl_total_fail <= 0) {
                html = '<div class="row">' + 
                            '<div class="col-xs-12">' + 
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' + 
                            '</div>' + 
                        '</div>';
                $('#next-lvl-failed-tab').append(html);
            }
            
        }
    });
}

function scrollBottom(token){
    being.scrollBottom('.cardBody', '.container', () => { 
        page = parseInt($('#page').val());
        var max_page = parseInt($('#max_page').val());
        if(page > max_page) {
            
        }else{
            getPosts(page, token, status);
        }   
    });
}

function getPosts(page, token, status){
 
   var user_id = $('#hidUserId').val();

    $.ajax({
        type: "GET",
        url: "/api/member-referral-list?memberid=" + user_id + "&page=" + page + "&status=" + status,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            //console.log(data);
            var current_page = parseInt(data.result.current_page);
            var last_page = parseInt(data.result.last_page);
            $('#max_page').val(last_page);
            var records = data.result;
            var html = populateInvitationData(records, token);

            if(current_page == 1){
                $('#'+ status +'-tab').html(html);
            } else {
                $('#'+ status +'-tab').append(html);
            }

            if(current_page == last_page){
                $(".isnext").html(end_of_result);
            }

            page++;
            $('#page').val(page);
        }
    });
}

function populateInvitationData(records, token) {

            var current_page = parseInt(records.current_page);
            var last_page = parseInt(records.last_page);
            var limit = parseInt(records.per_page);
            var counter = (current_page - 1) * limit;
            var result = records.data;
            var html = '';

            if(page_count != page && current_page == page){
                return false;
            }

            console.log(page_count + ":" + current_page);
            page_count++;

            $.each(result, function(i, item) {
                counter += 1;

                var t = item.created_at.split(/[- :]/);
                var date = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                var str_date = date.getFullYear() + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2) + " " + 
                                ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2);
                
                if(item.wechat_verification_status == 0){
                    var str_status = "认证成功";
                    var str_additional = "+1";
                    var str_class = "successful";

                } else if (item.wechat_verification_status == 1) {
                    var str_status = "未微信认证";
                    var str_additional = "";
                    var str_class = "pending";

                } else {
                    var str_status = "认证失败";
                    var str_additional = "";
                    var str_class = "fail";
                }
                
                html += '<div class="row">' +
                            '<div class="col-xs-8 column-1">' +
                                '<div class="item">' + item.phone.substring(0,3) + '&#10033;&#10033;&#10033;&#10033;' + item.phone.substring((item.phone.length - 4),item.phone.length) + '</div>' +
                                '<div class="date">' + str_date + '</div>' +
                            '</div>' +
                            '<div class="col-xs-4 column-2">' +
                                '<div class="right-wrapper">' +
                                    '<div class="status">' +
                                        '<span class="' + str_class + '">'+ str_status +'</span>' +
                                    '</div>' +                                                
                                    '<div style="clear: both"></div>' +
                                    '<div class="additional">'+ str_additional +'</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            });

            if(current_page == 1 && last_page == 1 && html === '') {
                html = '<div class="row">' + 
                            '<div class="col-xs-12">' + 
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' + 
                            '</div>' + 
                        '</div>';
            }

            return html;

}
