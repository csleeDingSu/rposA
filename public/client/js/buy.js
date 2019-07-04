var token = '';

$(document).ready(function () {

    $('#radio-value').val('');
    $('#card-no').val('');
    $('#card-password').val('');
    $('.div-select').html('请选择购买场次');
    $('.how-to-pay').hide();

    getToken();

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

    $('.btn-open-select').click(function(){
        $('#select-modal').modal();
    });

    $('.btn-close-select').click(function(){
        $('#select-modal').modal('hide');
    });


//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
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
                //console.log(data);
                var records = data.records;
                var purchase_data = data.purchase_data;
                var html = '';
                var price = 0;

                $.each(records, function(i, item) {
                    html += '<div class="col-xs-4">';

                    if(purchase_data.length == 0 && item.package_discount_price > 0){
                        html += '<div class="promotion"><img src="/client/images/membership/promotion.png" /></div>';
                        price = Math.trunc(item.package_discount_price);
                    } else {
                        price = Math.trunc(item.package_price);
                    }

                        html += '<div class="radio" data-value="'+ item.id +'" data-price="'+price +'">' +
                                    '<div class="radio-title">'+ item.package_name +'</div><div class="radio-price">'+ price +'元充值卡</div>' +
                                '</div>' +
                            '</div>';
                    
                });

                $('.radio-group').html(html);

                $('.radio-group .radio').click(function(){
                    $(this).parent().parent().find('.radio').removeClass('selected');
                    $(this).addClass('selected');
                    var val = $(this).attr('data-value');
                    var price = Math.trunc($(this).attr('data-price'));
                    var package_name = $(this).find('.radio-title').html();
                    var div_select_html = '<div class="div-selected">开通'+ package_name +' <span class="span-selected">'+ price +'元骏网一卡通</span></div>';

                    //alert(val);
                    $('#radio-value').val(val);
                    $('.div-select').html(div_select_html);
                    $('.span-package-name').html(package_name);
                    $('.span-price').html(price);
                    $('.how-to-pay').show();
                    $('.error').hide();
                    $('#select-modal').modal('hide');
                });
            }
        }
    });
}

function purchase(){
    var id = $('#hidUserId').val();
    var card_no = $('#card-no').val();
    var card_password = $('#card-password').val();
    var packageid = $('#radio-value').val();

    if(packageid <= 0){
        $('.error').html('未选择场次无法提交，请选择场次');
        $('.error').show();
    } else if(card_no <= 0){
        $('.error').html('未输入卡号无法提交，请输入卡号');
        $('.error').show();
    } else if(card_password <= 0){
        $('.error').html('未输入卡密无法提交，请输入卡密');
        $('.error').show();
    } else {
        $.ajax({
            type: 'POST',
            url: "/api/buy-basic-package",
            data: { 'memberid': id, 'packageid': packageid, 'cardnum': card_no, 'cardpass': card_password },
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