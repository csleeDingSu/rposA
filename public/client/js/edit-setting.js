var token = '';

$(document).ready(function () {
    getToken();
    $('.button-submit').click(function(){
        updatePhone();
    });

}); 

function updatePhone(){
    var memberid = $('#hidUserId').val();
    var phone = $('#phone').val();

    if(phone <= 0){
        $('.error').html('未填写手机号码无法提交，请填写手机号');
        $('.error').show();
    } else {
        $.ajax({
            type: 'POST',
            url: "/api/update-phone",
            data: { 'memberid': memberid, 'phone': phone},
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { console.log(error.responseText) },
                success: function(data) {
                    if(data.success){
                        // window.parent.location.href = "/profile";
                        $('#modal-successful').modal( 'show' );
                        $('.error').hide();
                    }
                }
            });

    }
}

function getToken(){
    var username = $('#hidUsername').val();
    var session = $('#hidSession').val();
    var id = $('#hidUserId').val();

    //login user
    if (id > 0) {
        $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
            //console.log(data);
            if(data.success) {
                token = data.access_token;
            } else {
                window.top.location.href = "/profile";                
            }   
        });
    } else {

        window.top.location.href = "/profile";
    }
    
}