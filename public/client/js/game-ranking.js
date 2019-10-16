var gameid = 102;

$(document).ready(function () {
	$('#general').click(function() {
	    $('.icon-trophy').attr("src", '/client/images/ranking/trophy-over.png');
	    $('.icon-good-friends').attr("src", '/client/images/ranking/good-friends.png');
	});

	$('#my-friend').click(function() {
	    $('.icon-trophy').attr("src", '/client/images/ranking/trophy.png');
	    $('.icon-good-friends').attr("src", '/client/images/ranking/good-friends-over.png');
	});

	getMyRanking();
    getGlobalRanking();
    getFriendRanking();
});

function getMyRanking() {
	$.ajax({
        type: 'GET',
        url: "/api/point-earned?gameid=" + gameid + "&memberid=" + $('#hidUserId').val(),
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error);
            // $(".reload").show();
        },
        success: function(data) {
        	var status = data.success;
        	var my_rank = data.my_rank;
        	var my_rank_html = '';
        	var my_rank_num = 0;
        	var i =0;
        	var _phone = 'xxxxx';
            var my_member_id = 0;
            var _total_point = 0;

            if(status){

                // my_rank
                if (!jQuery.isEmptyObject(my_rank)) {
                    my_member_id = my_rank.member_id;
                    
                    _phone = 'xxxxx';
                    if (my_rank.phone != '' && my_rank.phone != null) {
                        // console.log(my_rank.phone);
                        _phone = my_rank.phone.substring(0,3) + '*****' + my_rank.phone.slice(-4);
                    }

                    _total_point = my_rank.totalreward;
                    my_rank_html += '<div class="col-1 ranking-number">'+my_rank.rank+'</div>' +
                                    '<div class="col-5 ranking-name">'+_phone+'</div>' +
                                    '<div class="col-3 ranking-point">'+_total_point+'</div>';
                
                    $('#my-ranking').html(my_rank_html);    
                }else {
                    // _phone = $('#hidPhone').val();
                    // _phone = _phone.substring(0,3) + '*****' + _phone.slice(-4);
                    // my_rank_html += '<div class="col-1 ranking-number">--</div>' +
                    //                 '<div class="col-5 ranking-name">'+_phone+'</div>' +
                    //                 '<div class="col-3 ranking-point">0</div>';
                    // $('#my-ranking').html(my_rank_html);
                    $('#my-ranking').css('display', 'none');
                }
                
                
            }
        }
    }); 
}

function getGlobalRanking() {
    $('.tab-content').css('background-color','#f2f3f4');
    $.ajax({
        type: 'GET',
        url: "/api/global-rank?gameid=" + gameid,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error);
            global_rank_html = '<div class="no-record">' +
                                    '<img src="/clientapp/images/no-record/ranking.png">' +
                                    '<div>暂无记录</div>' +
                                '</div>';

            $('.tab-content').css('background-color','#fff');
            $('#general-list').html(global_rank_html);
        },
        success: function(data) {
            var status = data.success;
            var global_rank = data.global_ranks.data;
            var global_rank_html = '';
            var global_rank_num = 0;
            // var i =0;
            var _phone = 'xxxxx';
            var my_member_id = 0;
            var _total_point = 0;

            if(status){

                // global_rank
                // i = 0;
                $.each(global_rank, function(i, item) {
                    if (my_member_id != item.member_id) {
                        if (item.rank == 1) {
                            global_rank_num = '<img class="icon-one" src="/client/images/ranking/1.png" />';
                        }else if (item.rank == 2) {
                            global_rank_num = '<img class="icon-one" src="/client/images/ranking/2.png" />';
                        }else if (item.rank == 3) {
                            global_rank_num = '<img class="icon-one" src="/client/images/ranking/3.png" />';
                        }else {
                            global_rank_num = item.rank;
                        }

                        _phone = 'xxxxx';
                        if (item.phone != '' && item.phone != null) {
                            // console.log(item.phone);
                            _phone = item.phone.substring(0,3) + '*****' + item.phone.slice(-4);
                        }

                        _total_point = item.totalreward;

                        global_rank_html += '<div class="row tab-content-list">' +
                                    '<div class="col-1 ranking-number">' + global_rank_num + '</div>' +
                                    '<div class="col-5 ranking-name">' + _phone + '</div>' +
                                    '<div class="col-3 ranking-point">' + _total_point + '</div>' +
                                '</div>';
                    }
                    
                });

                if (global_rank_html == '') {
                    global_rank_html += '<div class="no-record">' +
                                            '<img src="/clientapp/images/no-record/ranking.png">' +
                                            '<div>暂无记录</div>' +
                                        '</div>';
                    $('.tab-content').css('background-color','#fff');
                }
                $('#general-list').html(global_rank_html);

            }
        }
    }); 
}

function getFriendRanking() {
    $('.tab-content').css('background-color','#f2f3f4');
    $.ajax({
        type: 'GET',
        url: "/api/friends-rank?gameid=" + gameid + "&memberid=" + $('#hidUserId').val(),
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error);
            friends_rank_html = '<div class="no-record">' +
                                    '<img src="/clientapp/images/no-record/ranking.png">' +
                                    '<div>暂无邀请记录</div>' +
                                '</div>';
            $('.tab-content').css('background-color','#fff');
            $('#my-friend-list').html(friends_rank_html);

        },
        success: function(data) {
            var status = data.success;
            var friends_rank = data.friends_rank.data;
            var friends_rank_html = '';
            var friends_rank_num = 0;
            var i =0;
            var _phone = 'xxxxx';
            var my_member_id = 0;
            var _total_point = 0;

            if(status){

                // friends_rank
                i = 0;
                $.each(friends_rank, function(i, item) {

                    if (my_member_id != item.member_id) {
                        if (item.rank == 1) {
                            friends_rank_num = '<img class="icon-one" src="/client/images/ranking/1.png" />';
                        }else if (item.rank == 2) {
                            friends_rank_num = '<img class="icon-one" src="/client/images/ranking/2.png" />';
                        }else if (item.rank == 3) {
                            friends_rank_num = '<img class="icon-one" src="/client/images/ranking/3.png" />';
                        }else {
                            friends_rank_num = item.rank;
                        }

                        _phone = 'xxxxx';
                        if (item.phone != '' && item.phone != null) {
                            _phone = item.phone.substring(0,3) + '*****' + item.phone.slice(-4);
                        }

                        _total_point = item.totalreward;

                        friends_rank_html += '<div class="row tab-content-list">' +
                                    '<div class="col-1 ranking-number">' + friends_rank_num + '</div>' +
                                    '<div class="col-5 ranking-name">' + _phone + '</div>' +
                                    '<div class="col-3 ranking-point">' + _total_point + '</div>' +
                                '</div>';
                    }
                });

                if (friends_rank_html == '') {
                    friends_rank_html += '<div class="no-record">' +
                                            '<img src="/clientapp/images/no-record/ranking.png">' +
                                            '<div>暂无邀请记录</div>' +
                                        '</div>';
                    $('.tab-content').css('background-color','#fff');
                }

                $('#my-friend-list').html(friends_rank_html);

            }
        }
    }); 
}
