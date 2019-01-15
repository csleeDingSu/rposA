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

            $.each(result, function(i, item) {
                
                if(item.wechat_verification_status == 0){
                    $('#total-successful').html(item.count);
                    total += parseInt(item.count);

                } else if (item.wechat_verification_status == 1) {
                    $('#total-pending').html(item.count);
                    total += parseInt(item.count);

                } else if (item.wechat_verification_status == 2 || item.wechat_verification_status == 3) {
                    total_fail += parseInt(item.count);
                    total += parseInt(item.count);
                }

            });

            $('#total-invite').html(total);
            $('#total-fail').html(total_fail);
        }
    });
}
