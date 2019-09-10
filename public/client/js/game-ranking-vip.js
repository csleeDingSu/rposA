
$(document).ready(function () {

	$('#general').click(function() {
	    $('.icon-trophy').attr("src", '/client/images/ranking/trophy-over.png');
	    $('.icon-good-friends').attr("src", '/client/images/ranking/good-friends.png');
	});

	$('#my-friend').click(function() {
	    $('.icon-trophy').attr("src", '/client/images/ranking/trophy.png');
	    $('.icon-good-friends').attr("src", '/client/images/ranking/good-friends-over.png');
	});

	getRankingGeneral();
});

function getRankingGeneral() {
	$.ajax({
        type: 'GET',
        url: "/api/point-earned?gameid=102",
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error);
            $(".reload").show();
        },
        success: function(data) {
        	var status = data.success;
        	var records = data.record;
        	var html = '';
        	var num = 0;

            if(status){
                $.each(records, function(i, item) {
                	if ((i + 1) == 1) {
                		num = '<img class="icon-one" src="/client/images/ranking/1.png" />';
                	}else if ((i + 1) == 2) {
                		num = '<img class="icon-one" src="/client/images/ranking/2.png" />';
                	}else if ((i + 1) == 3) {
                		num = '<img class="icon-one" src="/client/images/ranking/3.png" />';
                	}else {
                		num = (i + 1);
                	}

                	html += '<div class="row tab-content-list">' +
								'<div class="col-1 ranking-number">' + num + '</div>' +
								'<div class="col-5 ranking-name">' + item.member_id + '</div>' +
								'<div class="col-3 ranking-point">' + item.credit + '</div>' +
							'</div>';
                });

                if (html == '') {
                	html += '<div class="row tab-content-list">' +
								'<div class="col-1 ranking-number">' + num + '</div>' +
								'<div class="col-5 ranking-name">superman</div>' +
								'<div class="col-3 ranking-point">999</div>' +
							'</div>';
                }

                $('#general-list').html(html);

            }
        }
    }); 
}
