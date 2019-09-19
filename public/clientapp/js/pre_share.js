var status = 'default';
var page = 1;
var page_count = 1;
var my_lvl_total = 0;
var next_lvl_total = 0;

$(function () {
    getToken();    
});

function getToken(){

    var id = $('#hidUserId').val();
    var session = $('#hidSession').val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            getPosts(page, data.access_token, status);
            getSummary(data.access_token);
            scrollBottom(data.access_token);

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                page = 1;
                page_count = 1;
                status = $(e.target).attr('data-status');
                // console.log(status);
                if(status.indexOf('next-lvl-') != -1){
                    status = status.replace('next-lvl-','');
                    // console.log(status);
                    if(status.indexOf('invitation') != -1){
                        status = 'default';
                    }
                    getPosts_NextLvl(page, data.access_token, status);
                } else {
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
            // var next_lvl_total = 0;
            var next_lvl_result = data.slc_count_new;
            var next_lvl_total_fail = 0;
            var next_lvl_total_pending = 0;
            var next_lvl_total_successful = 0;
            
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

            $.each(next_lvl_result, function(i, item) {

                if(item.wechat_verification_status == 0){
                    next_lvl_total_successful += parseInt(item.count);                    
                    next_lvl_total += parseInt(item.count);

                } else if (item.wechat_verification_status == 1) {
                    next_lvl_total_pending += parseInt(item.count);
                    next_lvl_total += parseInt(item.count);

                } else if (item.wechat_verification_status == 2 || item.wechat_verification_status == 3) {
                    next_lvl_total_fail += parseInt(item.count);
                    next_lvl_total += parseInt(item.count);
                }

            });

            $('#total-invite').html(my_lvl_total + next_lvl_total);
            $('#total-fail').html(total_fail);
            $('#total-successful').html(total_successful);
            $('#total-pending').html(total_pending);
            $('#my-lvl-total-invitation').html('(' + my_lvl_total + ')');
            $('#next-lvl-total-invitation').html('(' + next_lvl_total + ')');
            $('#next-lvl-total-fail').html(next_lvl_total_fail);
            $('#next-lvl-total-successful').html(next_lvl_total_successful);
            $('#next-lvl-total-pending').html(next_lvl_total_pending);
        }
    });
}

function scrollBottom(token){
    being.scrollBottom('.cardBody', '.container', () => { 
        page = parseInt($('#page').val());
        var max_page = parseInt($('#max_page').val());
        if(page > max_page) {
            
        }else{            
            if (status != 'next-lvl-invitation') {
                getPosts(page, token, status);
            } else {
                getPosts_NextLvl(page, token, status);
            } 
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
            var html = populateInvitationData(records, token, status);
            my_lvl_total = data.result.total;

            status = 'default';

            if(current_page == 1){
                $('#'+ status +'-tab').html(html);
            } else {
                $('#'+ status +'-tab').append(html);
            }

            // if(current_page == last_page){
            //     $(".isnext").html(end_of_result);
            // }

            page++;
            $('#page').val(page);
        }
    });

}

function getPosts_NextLvl(page, token, status){
 
   var user_id = $('#hidUserId').val();

    $.ajax({
        type: "GET",
        url: "/api/member-scl-referral-list?memberid=" + user_id + "&page=" + page + "&status=" + status,
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
            var html = populateInvitationData(records, token, status);

            status = 'default';

            if(current_page == 1){
                $('#next-lvl-'+ status +'-tab').html(html);
            } else {
                $('#next-lvl-'+ status +'-tab').append(html);
            }

            // if(current_page == last_page){
            //     $(".isnext").html(end_of_result);
            // }

            page++;
            $('#page').val(page);
        }
    });
}

function populateInvitationData(records, token, _status = null) {

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
                    var str_class = "verified";                    
                    
                    if (item.introducer_bonus_life > 0) {
                        str_additional = "+" + parseFloat(item.introducer_bonus_life).toFixed(1);
                    } 

                } else if (item.wechat_verification_status == 1) {
                    var str_status = "未微信认证";
                    var str_additional = "";
                    var str_class = "pending";

                } else {
                    var str_status = "认证失败";
                    var str_additional = "";
                    var str_class = "fail";
                }

                //set default
                // if (_status == 'default') {
                //     var str_class = "";
                //     var str_class_additional = "default_additional";
                // } else {
                    var str_class_additional = "additional";
                // }
           
                var _photo = !(item.profile_pic == null) ? item.profile_pic :"/client/images/avatar.png";      
                var _wechatname = !(item.wechat_name == null) ? item.wechat_name : "";      
                html += '<div class="row">' +
                            '<div class="col-xs-8 column-1">' +
                                '<img class="profile-img-circle" src="' + _photo + '">' +
                                '<div class="item">' +_wechatname + '</div>' +
                                '<div class="date">' + str_date + '</div>' +
                            '</div>' +
                            '<div class="col-xs-4 column-2">' +
                                '<div class="right-wrapper">' +
                                    '<div class="status">' +
                                        '<span class="' + str_class + '">'+ str_status +'</span>' +
                                    '</div>' +                                                
                                    '<div style="clear: both"></div>' +
                                    '<div class="' + str_class_additional + '">'+ str_additional +'</div>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
            });

            if(current_page == 1 && last_page == 1 && html === '') {
                html = '<div class="row-full">' + 
                            '<div class="col-xs-12">' + 
                                '<div class="empty">你还没邀请朋友<br><a href="/share" class="share-link">邀请好友送场次></a></div>' + 
                            '</div>' + 
                        '</div>';
            }

            return html;

}
