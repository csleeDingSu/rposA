var token = '';

$(document).ready(function () {

    getPackagePurchasePoint();

    $('.button-submit').click(function(){
        purchase();
    });

    var clipboard = new ClipboardJS('.cutBtn', {
        target: function () {
            return document.querySelector('#cut');
        }
    });

    clipboard.on('success', function (e) {
        $('.cutBtn').addClass('copy-success').html('复制成功');
    });

    clipboard.on('error', function (e) {
        $('.cutBtn').addClass('copy-success').html('复制成功');
    });

}); 

function getPackagePurchasePoint() {
    var id = $('#hidUserId').val();
    var records = [{"id":1,"package_name":"10金币","package_price":"10.00"},{"id":2,"package_name":"20金币","package_price":"20.00"},{"id":3,"package_name":"50金币","package_price":"50.00"},{"id":4,"package_name":"100金币","package_price":"100.00"},{"id":5,"package_name":"200金币","package_price":"200.00"},{"id":6,"package_name":"500金币","package_price":"500.00"},{"id":7,"package_name":"1000金币","package_price":"1000.00"},{"id":8,"package_name":"2000金币","package_price":"2000.00"},{"id":9,"package_name":"其他数额","package_price":""}];
    var html = '';
    var price = 0;
   
    $.each(records, function(i, item) {
        console.log(item);
        html += '<div class="col-xs-4">';        
        price = Math.trunc(item.package_price);
        package_price = item.package_price;
        html += '<div class="radio" data-value="'+ item.id +'" data-price="'+price +'" package-price="' + package_price + '">';
        if (item.package_name == '其他数额') {
            html +='<div class="other-title">';
        } else {
            html +='<div class="radio-title">';
        }
         html += item.package_name +'</div>' +
                    '</div>' +
                '</div>';
        
    });

    $('.radio-group').html(html);

    $('.radio-group .radio').click(function(){
        $(this).parent().parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
        var val = $(this).attr('data-value');
        // var price = Math.trunc($(this).attr('data-price'));
        var price = $(this).attr('package-price');
        //alert(val);
        $('#radio-value').val(val);
        $('.point').html(price +'元');
        $('._point').html(price);
    });        
}

function purchase(){
    var id = $('#hidUserId').val();
    var txt_name = null; //$('#txt_name').val();
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
                    $('.error').hide();
                    $('#modal-successful').modal();
                    setTimeout(function(){ 
                        $('#modal-successful').modal('hide');
                        window.location.href = "/round";
                    }, 2000);
                } else {
                    $('.error').html(data.message);
                    $('.error').show();
                }
            }
        });
    }
}