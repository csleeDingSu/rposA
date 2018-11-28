$(document).ready(function () {
    $('.tab').click(function(){
        var title = $(this).html();
        $('.navbar-brand').html(title); 
    });

    getToken();
});

function getToken(){
    var username = $('#hidUsername', window.parent.document).val();
    var session = $('#hidSession', window.parent.document).val();

    $.getJSON( "/api/gettoken?username=" + username + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            getProductList(data.access_token);
            redeemHistory(data.access_token);
        }      
    });
}

function getProductList(token) {
    var member_id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/product-list?memberid=" + member_id, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {

            $('.wabao-coin').html(data.current_point);

            var records = data.records.data;
            var html = '';
             var htmlmodel = '';

            if(records.length === 0){

                html += '<div class="history-row">' +
                            '<div class="col-xs-12">' +
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                            '</div>' +
                        '</div>';

                $('#prize').html(html);

            } else {
                $.each(records, function(i, item) {
                    var available_quantity = item.available_quantity;
                    var used_quantity = item.used_quantity;
                    var reserved_quantity = item.reserved_quantity;

                    if(available_quantity === null){
                        available_quantity = 0;
                    }

                    if(used_quantity === null){
                        used_quantity = 0;
                    }

                    if(reserved_quantity === null){
                        reserved_quantity = 0;
                    }

                    var total_used = parseInt(used_quantity) + parseInt(reserved_quantity);

                    html += '<div class="row">' +
                                '<div class="col-xs-3 column-1">' +
                                    '<img class="img-voucher" src="'+ item.product_picurl +'" alt="'+item.product_name+'">' +
                                '</div>' +
                                '<div class="col-xs-6 column-2">' +
                                    '<div class="description">' + item.product_name + '</div>' +
                                    '<div class="note">您还剩' + parseInt(data.current_point) + '挖宝币</div>' +
                                    '<div class="icon-coin-wrapper">' +
                                        '<div class="icon-coin"></div>' +
                                    '</div>' +
                                    '<div class="w-coin">'+ item.min_point +'</div>' +
                                    '<div style="clear: both;"></div>' +
                                    '<div class="remaining">剩余 '+ available_quantity +' 张 已兑换 '+ total_used +' 张</div>' +
                                '</div>' +
                                '<div class="col-xs-3 column-3">' +
                                    '<div class="btn-redeem openeditmodel'+ i +'">兑换</div>' +
                                '</div>' +
                            '</div>';

                    htmlmodel += '<!-- Modal starts -->' +
                            '<div class="modal fade col-lg-12" id="viewvouchermode'+ i +'" tabindex="-1" >' +
                                '<div class="modal-dialog modal-sm" role="document">' +
                                    '<div class="modal-content">' +
                                        '<div class="modal-body">' +
                                            '<div class="modal-row">' +
                                                '<div class="modal-img-voucher">' +
                                                    '<img src="' + item.product_picurl +'" alt="alipay voucher 50" class="img-voucher" />' +
                                                '</div>' +

                                                '<div class="wrapper modal-full-height">' +
                                                    '<div class="modal-card">' +
                                                        '<div class="modal-center">' +
                                                            '兑换本产品需要消耗:' +
                                                        '</div>' +
                                                    '</div>' +

                                                    '<div class="modal-card">' +
                                                            '<div class="icon-coin-wrapper modal-icon">' +
                                                                '<div class="icon-coin"></div>' +
                                                            '</div>' +
                                                            '<div class="wabao-price">'+ item.min_point +'挖宝币</div>' +
                                                    '</div>' +

                                                    '<div class="modal-card">' +
                                                        '<div class="wabao-balance">您当前拥有 '+ parseInt(data.current_point) +' 挖宝币</div>' +
                                                    '</div>' +

                                                    '<div id="error-'+ item.id + '" class="error"></div>';

                                                    if (item.min_point <= parseInt(data.current_point)) {

                                                        htmlmodel += '<div id="redeem-'+ item.id +'" onClick="redeem(\''+ token +'\', \''+ item.id +'\');">' +
                                                        '<a class="btn btn_submit" >确定兑换</a>' +
                                                        '</div>' +
                                                        '<div>' +
                                                            '<a href="#" class="btn btn_cancel" data-dismiss="modal">暂不兑换</a>' +
                                                        '</div>';
                                                    } else {
                                                        htmlmodel += '<div>' +
                                                            '<a href="#" class="btn btn_cancel" data-dismiss="modal">暂不能兑换</a>' +
                                                        '</div>';
                                                    }

                                                     htmlmodel += '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' + 
                            '<!-- Modal Ends -->';
                });

                $('#prize').html(html);
                $( ".cardFull" ).after( htmlmodel);

                $.each(records, function(i, item) {
                    $('.openeditmodel' + i).click(function() {
                        $('#viewvouchermode' + i).modal('show');
                    });
                });
            }
        } // end success
    }); // end $.ajax
} // end function

function redeemHistory(token) {

    var member_id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/redeem-history?memberid=" + member_id, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {

            var records = data.records.data;
            var html = '';

            if(records.length === 0){

                html += '<div class="history-row">' +
                            '<div class="col-xs-12">' +
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                            '</div>' +
                        '</div>';

                $('#history').html(html);

            } else {

                $.each(records, function(i, item) {
                    var counter = i + 1;

                    html += '<div class="history-row">' +
                        '<div class="col-xs-2 column-4">' +
                            counter +
                        '</div>' +
                        '<div class="col-xs-7 column-5">' +
                            '<div class="description">'+ item.product_name + ' ' + item.pin_name + '</div>' +
                            '<div class="balance">兑换时间:'+ item.created_at +'</div>' +
                        '</div>';

                    if(item.pin_status == 4) { // Pending
                        html += '<div class="col-xs-3 column-6">' +
                                    '<div class="btn-pending">等待发放</div>' +
                                '</div>' + 
                            '</div>';

                    } else if (item.pin_status == 2) { // Confirmed
                        html += '<div class="col-xs-3 column-6">' +
                                    '<div class="btn-card" data-toggle="collapse" data-target="#content-' + item.id + '">查看卡号</div>' +
                                '</div>' + 
                            '</div>' +
                        '<div id="content-' + item.id + '" class="collapse">' +
                            '<div>卡号： <span class="numbers">'+ item.code +'</span> 密码：<span class="codes"></span></div>' +
                            '<div class="instruction">打开支付宝APP>[更多]>[话费卡转让]，输入卡密即可充值成功！' +
                            '</div>' +
                        '</div>';
                    } else {
                        html += '</div>';
                    }

                });

                $('#history').html(html);
            }
        }
    });
}

function redeem(token, product_id){

    var member_id = $('#hidUserId').val();
    
    $.ajax({
        type: 'POST',
        url: "/api/request-redeem",
        data: { 'memberid': member_id, 'productid': product_id },
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            if(data.success) {
                window.location.href = "/redeem/history";
            } else {
                $('#error-' + product_id).html(data.message);
            }
        }
    });
}
        