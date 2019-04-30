var token = '';

$(document).ready(function () {

    getToken();

    $('.button-submit').click(function(){

        var txt_name = $('#txt_name').val();
        if(txt_name == ''){
            $('.error').html('未输入姓名无法提交，请填写真实姓名');
            $('.error').show();
        } else {
            purchase();
        }
    });

    var clipboard = new ClipboardJS('.cutBtn', {
        target: function () {
            return document.querySelector('#cut');
        }
    });

    clipboard.on('success', function (e) {
        $('.cutBtn').addClass('copy-success').html('复制成功 打开支付宝');
    });

    clipboard.on('error', function (e) {
        $('.cutBtn').addClass('copy-success').html('复制成功 打开支付宝');
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
    var id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/basic-package-list?memberid="+id,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            if(data.success) {
                console.log(data);
                var records = data.records;
                var purchase_data = data.purchase_data;
                var html = '';
                var price = 0;

                $.each(records, function(i, item) {
                    html += '<div class="col-xs-4">';

                    if(purchase_data.length == 0 && item.package_discount_price > 0){
                        html += '<div class="promotion"><img src="/client/images/membership/promotion.png" /></div>';
                        price = item.package_discount_price;
                    } else {
                        price = item.package_price;
                    }

                        html += '<div class="radio" data-value="'+ item.id +'" data-price="'+price +'">' +
                                    '<div class="radio-title">'+ item.package_name +'</div><div>售价'+ price +'元</div>' +
                                '</div>' +
                            '</div>';
                    
                });

                $('.radio-group').html(html);

                $('.radio-group .radio').click(function(){
                    $(this).parent().parent().find('.radio').removeClass('selected');
                    $(this).addClass('selected');
                    var val = $(this).attr('data-value');
                    var price = $(this).attr('data-price');
                    //alert(val);
                    $('#radio-value').val(val);
                    $('.point').html('¥'+ price +'元');
                });
            }
        }
    });
}

function purchase(){
    var id = $('#hidUserId').val();
    var txt_name = $('#txt_name').val();
    var packageid = $('#radio-value').val();

    if(packageid <= 0){
        $('.error').html('未选择场次无法提交，请选择场次');
        $('.error').show();
    } else {
        $.ajax({
            type: 'POST',
            url: "/api/buy-basic-package",
            data: { 'memberid': id, 'packageid': packageid, 'ref_note': txt_name },
            dataType: "json",
            beforeSend: function( xhr ) {
                xhr.setRequestHeader ("Authorization", "Bearer " + token);
            },
            error: function (error) { console.log(error.responseText) },
            success: function(data) {
                if(data.success) {
                    console.log(data);
                    $('.error').hide();
                    $('#modal-successful').modal();
                    setTimeout(function(){ 
                        $('#modal-successful').modal('hide');
                        window.location.href = "/round";
                    }, 2000);
                } else {
                    $('.error').html(data.message);
                }
            }
        });
    }
}