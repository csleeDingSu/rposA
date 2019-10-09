var page = 1;
var page_count = 1;
var page_nextlvl = 1;
var page_count_nextlvl = 1;

var my_lvl_total = 0;
var next_lvl_total = 0;

var token = $('#hidSession').val();
var earned_play_times = 0;
var earned_point = 0;

$(function () {

    getToken();

    $('.tab-my-list').addClass('on');
    $('.tab-friend-list').removeClass('on');
    $('.my-list').css({'display': 'block'});
    $('.friend-list').css({'display': 'none'});

    $('.tab-my-list').click(function() {
        getPosts(page, token);
      $('.tab-my-list').addClass('on');
      $('.tab-friend-list').removeClass('on');
      $('.my-list').css({'display': 'block'});
      $('.friend-list').css({'display': 'none'});
    });

    $('.tab-friend-list').click(function() {
        getPosts_NextLvl(page_nextlvl, token);
      $('.tab-my-list').removeClass('on');
      $('.tab-friend-list').addClass('on');
      $('.my-list').css({'display': 'none'});
      $('.friend-list').css({'display': 'block'});
    });
        
});

function getToken(){

    var id = $('#hidUserId').val();
    var session = $('#hidSession').val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            token = data.access_token
            getPosts(page, data.access_token);
            getPosts_NextLvl(page, data.access_token);
            // scrollBottom(data.access_token);
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

function getPosts(page, token){
 
   var user_id = $('#hidUserId').val();

    $.ajax({
        type: "GET",
        url: "/api/member-referral-list?memberid=" + user_id + "&page=" + page + "&status=default",
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
            var html = populateInvitationData(records, token, 'my');
            my_lvl_total = data.result.total;

            if (html != '') {
                if(current_page == 1){
                    $('.my-list').html(html);
                } else {
                    $('.my-list').append(html);
                }
            }

            page++;
            $('#page').val(page);
        }
    });

}

function getPosts_NextLvl(page_nextlvl, token){
 
   var user_id = $('#hidUserId').val();

    $.ajax({
        type: "GET",
        url: "/api/member-scl-referral-list?memberid=" + user_id + "&page=" + page_nextlvl + "&status=default",
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            // console.log(data);
            var current_page = parseInt(data.result.current_page);
            var last_page = parseInt(data.result.last_page);
            $('#max_page_nextlvl').val(last_page);
            var records = data.result;
            var html = populateInvitationData(records, token, 'friend');

            if (html != '') {
                if(current_page == 1){
                    $('.friend-list').html(html);
                } else {
                    $('.friend-list').append(html);
                }
            }

            page_nextlvl++;
            $('#page_nextlvl').val(page_nextlvl);
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

            if (_status == 'my') {
                if(page_count != page && current_page == page){
                    return false;
                }

                // console.log(page_count + ":" + current_page);
                page_count++;    
            } else {
                // console.log(page_count_nextlvl != page_nextlvl && current_page == page_nextlvl);
                if(page_count_nextlvl != page_nextlvl && current_page == page_nextlvl){
                    return false;
                }

                console.log(page_count_nextlvl + ":" + current_page);
                page_count_nextlvl++;
            }
            

            $.each(result, function(i, item) {
                counter += 1;

                var t = item.created_at.split(/[- :]/);
                var date = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                var str_date = date.getFullYear() + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2) + " " + 
                                ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2);
                
                if(item.wechat_verification_status == 0){
                    var str_status = '<font color="#fe5c5c">认证成功</font>';
                    earned_play_times++;

                } else if (item.wechat_verification_status == 1) {
                    var str_status = '<font color="#5c86fe">未微信认证</font>';

                } else {
                    var str_status = '<font color="#333333">认证失败</font>';
                }
               var _phone = (item.phone === null) ? '*****' : (item.phone.substring(0,3) + '*****' + item.phone.slice(-4));

                html += '<li>' +
                        '<div class="line-1">' +
                          '<h2>'+_phone+'</h2>' +
                          '<span style="font-size: 0.28rem;">' + str_status + '</span>' +
                        '</div>' +
                        '<div class="line-2">' +
                          '<p>'+str_date+'</p>' +
                        '</div>' +
                      '</li>';
            });

            if(current_page == 1 && last_page == 1 && html === '') {
                // html = '<li>' +
                //         '<div class="line-1">' +
                //           '<h2>112****8887</h2>' +
                //           '<span>' +
                //             '<font color="#fe5c5c">认证失败</font>' +
                //           '</span>' +
                //         '</div>' +
                //         '<div class="line-2">' +
                //           '<p>2019-02-02 16:05</p>' +
                //         '</div>' +
                //       '</li>';
            }

            $('.earned_play_times').html(earned_play_times);
            earned_point = earned_play_times * 12;
            $('.earned_point').html(earned_point);

            return html;

}
