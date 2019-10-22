var token = '';
var gameid=103;
var is_app = true;

$(document).ready(function () {

    is_app = $('#hid_THISVIPAPP').val();

    $('.back').click(function(){
        $( "#frm_buy" ).submit();
    });

    $('.btn-confirm').click(function(){
        $(this).attr("disabled", true);
        purchase();
    });

    $('.close-modal').click(function(){
        $('#modal-successful').modal('hide');
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
        
        var price = parseInt($('.lbl_price').html());
        var quantity = parseInt($(this).val());
        var total =  quantity * price;
        var wallet_point = parseFloat($('#hid_wallet_point').val()).toFixed(2);
        if (total > wallet_point) {
            $('.btn-confirm').html('挖宝币不足');    
        } else {
            $('.btn-confirm').html('确认兑换');    
        }

        $('.span_price').html(total);        
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

function purchase() {
    var id = $('#hidUserId').val();
    var packageid = $('#hid_package_id').val();
    var quantity = $('#txt_quantity').val();
    var address = $('#txt_address').val();
    var receiver_name = $('#txt_name').val();
    var contact_number = $('#txt_mobile').val();
    var city = $('#txt_city').val();

    $.ajax({
        type: 'POST',
        url: "/api/buy-product",
        data: { 
            'memberid': id, 
            'packageid': packageid, 
            'quantity': quantity, 
            'address': address, 
            'receiver_name': receiver_name, 
            'contact_number': contact_number,
            'city': city, 
            'zip': '',
            'gameid': gameid
        },
        dataType: "json",
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            console.log(data);
            if(data.success) {
                
                if (is_app) {
                    window.top.location.href = "/redeem-vip-new";
                } else {
                    window.top.location.href = "/redeem/history";    
                }
                
            } else {
                // $('.error').html(data.message);
                // $('.error').show();
                $('.error-msg').html(data.message);
                $('#modal-error-msg').modal();
                setTimeout(function(){ 
                    $('#modal-error-msg').modal('hide');
                }, 3000); 
            }
        }
    });
}