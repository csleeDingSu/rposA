var token = '';

$(document).ready(function () {

    $('.close-modal').click(function(){
        $('#modal-successful').modal('hide');
    });

    getToken();

    $('.button-submit').click(function(){

        var txt_name = $('#txt_name').val();
        if(txt_name == ''){
            $('.error').show();
        } else {
            request_vip();
        }
    });

    var clipboard = new ClipboardJS('.cutBtn', {
        text: function (trigger) {
            return $('#cut').val();
        }
    });

    clipboard.on('success', function (e) {
        $('.cutBtn').html('复制成功 打开支付宝');
    });

    clipboard.on('error', function (e) {
        //$('.cutBtn').addClass('cutBtn-fail').html('<i class="far fa-times-circle"></i>复制失败');
        $('.cutBtn').html('复制成功 打开支付宝');
    });
}); 

function getToken(){
    var username = $('#hidUsername').val();
    var session = $('#hidSession').val();
    var id = $('#hidUserId').val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            token = data.access_token;
            getPackage();
        }      
    });
}

function getPackage() {
    $.ajax({
        type: 'GET',
        url: "/api/package-list",
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            if(data.success) {
                console.log(data);
                var package_id = data.records[0].package_id;
                var price = data.records[0].package_price;

                $('#package_id').val(package_id);
                $('.spanPrice').html(price);
            }
        }
    });
}

function request_vip(){
    var id = $('#hidUserId').val();
    var txt_name = $('#txt_name').val();
    var packageid = $('#package_id').val();

    $.ajax({
        type: 'POST',
        url: "/api/request-vip-upgrade",
        data: { 'memberid': id, 'packageid': packageid, 'ref_note': txt_name },
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            if(data.success) {
                $('.error').hide();
                $('#modal-successful').modal();
            } else {
                $('.error').html(data.message);
            }
        }
    });
}