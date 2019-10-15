var gameid = 103;
$(document).ready(function () {
	$('#general').click(function() {
	    $('.icon-trophy').attr("src", '/client/images/ranking/trophy-over.png');
	    $('.icon-good-friends').attr("src", '/client/images/ranking/good-friends.png');
	});

	$('#buy-product').click(function() {
	    $('.icon-trophy').attr("src", '/client/images/ranking/trophy.png');
	    $('.icon-good-friends').attr("src", '/client/images/ranking/good-friends-over.png');
	});

    getMyEarnedPoint();
	getGlobalRanking();
    getGameUsedPoint();
});

function getMyEarnedPoint() {
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
            // $(".reload2").show();
        },
        success: function(data) {
            var status = data.success;
            var my_rank = data.my_rank;
            var my_rank_html = '';
            var my_rank_num = 0;
            var i =0;
            var _phone = 'xxxxx';

            if(status){

                if (!jQuery.isEmptyObject(my_rank)) {
                    my_member_id = my_rank.member_id;
                    
                    _phone = 'xxxxx';
                    if (my_rank.phone != '' && my_rank.phone != null) {
                        console.log(my_rank.phone);
                        _phone = my_rank.phone.substring(0,3) + '*****' + my_rank.phone.slice(-4);
                    }
                    my_rank_html += '<div class="col-1 ranking-number">'+my_rank.rank+'</div>' +
                                    '<div class="col-5 ranking-name">'+_phone+'</div>' +
                                    '<div class="col-3 ranking-point">'+my_rank.balance+'</div>';
                
                    $('.tab-content-my-ranking').html(my_rank_html);    
                }else {
                    // my_rank_html += '<div class="col-1 ranking-number">--</div>' +
                    //                 '<div class="col-5 ranking-name">'+_phone+'</div>' +
                    //                 '<div class="col-3 ranking-point">0</div>';
                    $('.tab-content-my-ranking').css('display', 'none');
                }
                

            }
        }
    }); 
}

function getGlobalRanking() {
	$.ajax({
        type: 'GET',
        url: "/api/global-rank?gameid=" + gameid,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error);
            // $(".reload").show();
            // $(".reload2").show();
        },
        success: function(data) {
        	var status = data.success;
        	var global_rank = data.global_ranks.data;
        	var global_rank_html = '';
        	var global_rank_num = 0;
        	var _phone = 'xxxxx';

            if(status){

                $.each(global_rank, function(i, item) {
                	if (item.rank == 1) {
                		global_rank_num = '<img class="icon-one" src="/client/images/ranking/1.png" />';
                	}else if (item.rank == 2) {
                		global_rank_num = '<img class="icon-one" src="/client/images/ranking/2.png" />';
                	}else if (item.rank == 3) {
                		global_rank_num = '<img class="icon-one" src="/client/images/ranking/3.png" />';
                	}else {
                		global_rank_num = (item.rank);
                	}

                	_phone = 'xxxxx';
                	if (item.phone != '' && item.phone != null) {
                		_phone = item.phone.substring(0,3) + '*****' + item.phone.slice(-4);
                	}

                	global_rank_html += '<div class="row tab-content-list">' +
								'<div class="col-1 ranking-number">' + global_rank_num + '</div>' +
								'<div class="col-5 ranking-name">' + _phone + '</div>' +
								'<div class="col-3 ranking-point">' + item.balance + '</div>' +
							'</div>';
                });

                if (global_rank_html == '') {
                	global_rank_html += '<div class="no-record">' +
                                            '<img src="/clientapp/images/no-record/invitation.png">' +
                                            '<div>暂无记录</div>' +
                                        '</div>';
                }

                $('#general-list').html(global_rank_html);

            }
        }
    }); 
}

function getGameUsedPoint() {
    
    $.ajax({
        type: 'GET',
        url: "/api/game-used-point?gameid=" + gameid + "&memberid=" + $('#hidUserId').val(),
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error);
            // $(".reload").show();
            // $(".reload2").show();
        },
        success: function(data) {
            console.log(data);

            var status = data.success;
            var _data = data.point.data;
            var _html = '';
            var _num = 0;
            var i =0;
            var _phone = 'xxxxx';

            if(status){

                i = 0;
                $.each(_data, function(i, item) {
                    if ((i + 1) == 1) {
                        _num = '<img class="icon-one" src="/client/images/ranking/1.png" />';
                    }else if ((i + 1) == 2) {
                        _num = '<img class="icon-one" src="/client/images/ranking/2.png" />';
                    }else if ((i + 1) == 3) {
                        _num = '<img class="icon-one" src="/client/images/ranking/3.png" />';
                    }else {
                        _num = (i + 1);
                    }

                    _phone = 'xxxxx';
                    if (item.phone != '' && item.phone != null) {
                        _phone = item.phone.substring(0,3) + '*****' + item.phone.slice(-4);
                    }

                    _html += '<div class="row tab-content-list">' +
                                '<div class="col-1 ranking-number">' + _num + '</div>' +
                                '<div class="col-5 ranking-name">' + _phone + '</div>' +
                                '<div class="col-3 ranking-point">' + item.point + '</div>' +
                            '</div>';
                    
                });

                if (_html == '') {
                    _html += '<div class="no-record">' +
                                            '<img src="/clientapp/images/no-record/invitation.png">' +
                                            '<div>暂无换购记录</div>' +
                                        '</div>';
                }

                $('#buy-product-list').html(_html);

            }
        }
    });
}