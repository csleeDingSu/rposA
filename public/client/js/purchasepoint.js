var token = '';

$(document).ready(function () {

    getPackagePurchasePoint();

    $('.button-submit').click(function(){
        purchasePoint();
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
    var records = [{"id":1,"package_name":"10挖宝币","package_price":"10.00"},{"id":2,"package_name":"20挖宝币","package_price":"20.00"},{"id":3,"package_name":"50挖宝币","package_price":"50.00"},{"id":4,"package_name":"100挖宝币","package_price":"100.00"},{"id":5,"package_name":"200挖宝币","package_price":"200.00"},{"id":6,"package_name":"500挖宝币","package_price":"500.00"},{"id":7,"package_name":"1000挖宝币","package_price":"1000.00"},{"id":8,"package_name":"2000挖宝币","package_price":"2000.00"},{"id":9,"package_name":"其他数额","package_price":""}];
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
        $('#radio-value').val(val);
        $('#point').val(price);

        if (price > 0) {
            $('#point').prop('readonly', true);
            $('._point').html(price);
            $('#point').attr('style', 'width: ' + (($('#point').val().length * 5) - 4) + '%;');
        } else {
            $('._point').html(0);
            $('#point').focus();  
            $('#point').prop('readonly', false);
            $('#point').attr('style', 'width: 31%');
        }

    });        
}

function purchasePoint(){
    var id = $('#hidUserId').val();
    var txt_name = null; //$('#txt_name').val();
    var packageid = $('#radio-value').val();
    var pay_amount = $('#point').val();

    if(packageid <= 0){
        $('.error').html('未选择金额无法提交，请选择金额');
        $('.error').show();
    } else {

        var url = '/payment';
        var form = $('<form action="' + url + '" method="post">' +
          '<input type="text" name="type" value="purchasepoint" />' +
          '<input type="text" name="member_id" value="' + id + '" />' +
          '<input type="text" name="packageid" value="' + packageid + '" />' +
          '<input type="text" name="pay_amount" value="' + pay_amount + '" />' +
          '</form>');
        $('body').append(form);
        form.submit();

    }
}
