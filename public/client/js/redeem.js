$(document).ready(function () {
    $('.tab').click(function(){
        var title = $(this).html();
        $('.navbar-brand').html(title); 
    });

    getToken();

    var clipboard = new ClipboardJS('.cutBtn', {
        target: function () {
            return document.querySelector('#cut');
        }
    });

    clipboard.on('success', function (e) {
        $('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
    });

    clipboard.on('error', function (e) {
        $('.cutBtn').addClass('cutBtn-fail').html('<i class="far fa-times-circle"></i>复制失败');
    });
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
            //console.log(data);
            $('.wabao-coin').html(data.current_point);

            var records = data.records.data;
            var packages = data.packages;
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
                $.each(packages, function(i, item) {
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

                    //console.log(item);
                        html += '<div class="row">' +
                                    '<div class="col-xs-3 column-1">' +
                                        '<img class="img-voucher" src="'+ item.package_picurl +'" alt="'+item.package_name+'">' +
                                    '</div>' +
                                    '<div class="col-xs-6 column-2">' +
                                        '<div class="description">' + item.package_name + '</div>' +
                                        '<div class="note">可兑换支付宝红包' + parseInt(data.current_point) + '元</div>' +
                                        '<div class="icon-coin-wrapper">' +
                                            '<div class="icon-coin"></div>' +
                                        '</div>' +
                                        '<div class="w-coin">'+ item.min_point +'</div>' +
                                        '<div style="clear: both;"></div>' +
                                        '<div class="remaining">剩余 '+ available_quantity +' 张 已兑换 '+ total_used +' 张</div>' +
                                    '</div>' +
                                    '<div class="col-xs-3 column-3">' +
                                        '<div class="btn-redeem openeditmodel_p'+ i +'">兑换</div>' +
                                    '</div>' +
                                '</div>';

                    if(item.package_type == 1){
                        htmlmodel += '<!-- Modal starts -->' +
                                '<div class="modal fade col-lg-12" id="viewvouchermode_p'+ i +'" tabindex="-1" >' +
                                    '<div class="modal-dialog modal-sm" role="document">' +
                                        '<div class="modal-content">' +
                                            '<div class="modal-body">' +
                                                '<div class="modal-row">' +
                                                    '<div class="modal-img-voucher">' +
                                                        '<img src="' + item.package_picurl +'" alt="' + item.package_name + '" class="img-voucher" />' +
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

                                                        if ((available_quantity > 0) && (item.min_point <= parseInt(data.current_point))) {

                                                            htmlmodel += '<div id="redeem-'+ item.id +'" onClick="redeemVip(\''+ token +'\', \''+ item.id +'\');">' +
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
                    } else if(item.package_type == 2){
                        htmlmodel += '<!-- Modal starts -->' +
                                        '<div class="modal fade col-lg-12" id="viewvouchermode_p'+ i +'" tabindex="-1" >' +
                                            '<div class="modal-dialog modal-sm-vip" role="document">' +
                                                '<div class="modal-content vip-content">' +
                                                    '<div class="modal-body">' +
                                                        '<div class="modal-row">' +
                                                            '<ul class="nav nav-pills">' +
                                                              '<li class="active take-all-space-you-can"><a data-toggle="tab" href="#single">单张提交</a></li>' +
                                                              '<li class="take-all-space-you-can"><a data-toggle="tab" href="#multiple">批量提交</a></li>' +
                                                            '</ul>' +

                                                            '<div class="tab-content">' +
                                                              '<div id="single" class="tab-pane fade in active vip-tab-pane">' +
                                                                '卡号： <input id="txt_cardno" type="text" name="card_no" placeholder="请输入卡号" /><br /><hr>' +
                                                                '密码： <input id="txt_password" type="text" name="password" placeholder="请输入密码" /><br /><hr>' +
                                                                '<span class="modal-description">提交面值为100元，【卡密规则】 卡号15位，密码19位<br />' +
                                                                '100元充值卡换VIP专场1次，200元充值卡换VIP专场2次<br />' +
                                                                '以此类推</span>' +
                                                                '<div class="modal-card">' +
                                                                    '<div id="request-'+ item.id +'" onClick="requestVip(\'' + token + '\', \''+ item.id +'\', \'single\', '+ i +');">' +
                                                                        '<a class="btn btn-submit-vip">提交</a>' +
                                                                    '</div>' +
                                                                '</div>' +
                                                              '</div>' +

                                                              '<div id="multiple" class="tab-pane fade vip-tab-pane">' +
                                                                '<textarea id="txa_card" placeholder="卡号与密码之间用空额隔开，每张一行用回车隔开"></textarea><br />' +
                                                                '<div class="textarea-link-wrapper">' +
                                                                '<div class="textarea-link open-card-no-modal">卡密示例</div>' +
                                                                '</div>' +
                                                                '<span class="modal-description">提交面值为100元，【卡密规则】 卡号15位，密码19位<br />' +
                                                                '100元充值卡换VIP专场1次，200元充值卡换VIP专场2次<br />' +
                                                                '以此类推</span>' +
                                                                '<div class="modal-card">' +
                                                                    '<div id="request-'+ item.id +'" onClick="requestVip(\'' + token + '\', \''+ item.id +'\', \'multiple\', '+ i +');">' +
                                                                        '<a class="btn btn-submit-vip" >提交</a>' +
                                                                    '</div>' +
                                                                '</div>' +
                                                              '</div>' +
                                                            '</div>' +

                                                            '<div class="wrapper modal-full-height">' +
                                                                '<span class="vip-copy">通过以下方式获得话费充值卡<br />' +
                                                                '复制话费卷淘宝口令，打开手机淘宝购买</span>' +
                                                                '<div class="modal-card">' +
                                                                    '<div id="cut" class="copyvoucher">¥ K8454DFGH45H</div>' +
                                                                    '<div class="cutBtn">一键复制</div>' +
                                                                '</div>' +
                                                            '</div>' +
                                                        '</div>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<!-- Modal Ends -->';
                
                    }
                });

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
                                    '<div class="note">可兑换支付宝红包' + parseInt(data.current_point) + '元</div>' +
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

                                                    if ((available_quantity > 0) && item.min_point <= parseInt(data.current_point)) {

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

                $.each(packages, function(i, item) {
                    $('.openeditmodel_p' + i).click(function() {
                        $('#viewvouchermode_p' + i).modal('show');
                    });
                });

                $.each(records, function(i, item) {
                    $('.openeditmodel' + i).click(function() {
                        $('#viewvouchermode' + i).modal('show');
                    });
                });

                $('.open-card-no-modal').click(function() {
                    $('#card-no-modal').modal('show');
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
            //console.log(data);
            var records = data.records.data;
            var package = data.package;
            var html = '';

            if(records.length === 0 && package.length === 0){

                html += '<div class="history-row">' +
                            '<div class="col-xs-12">' +
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                            '</div>' +
                        '</div>';

                $('#history').html(html);

            } else {

                $.each(package, function(i, item) {
                    var counter = i + 1;

                    html += '<div class="history-row">' +
                        '<div class="col-xs-2 column-4">' +
                            counter +
                        '</div>' +
                        '<div class="col-xs-7 column-5">' +
                            '<div class="description">'+ item.package_name + ' ' + item.package_price + '</div>' +
                            '<div class="balance">兑换时间:'+ item.created_at +'</div>' +
                        '</div>';

                    if(item.redeem_state == 1) { // Pending
                        html += '<div class="col-xs-3 column-6">' +
                                    '<div class="btn-pending">等待发放</div>' +
                                '</div>' + 
                            '</div>';

                    } else if (item.redeem_state == 2) { // Confirmed
                        html += '<div class="col-xs-3 column-6">' +
                                    '<div class="btn-card" data-toggle="collapse" data-target="#content-p-' + item.id + '">查看卡号</div>' +
                                '</div>' + 
                            '</div>' +
                        '<div id="content-p-' + item.id + '" class="collapse">' +
                            '<div>卡号： <span class="numbers"></span> 密码：<span class="codes">' + item.passcode + '</span></div>' +
                            '<div class="instruction">打开支付宝APP>[更多]>[话费卡转让]，输入卡密即可充值成功！' +
                            '</div>' +
                        '</div>';
                    } else {
                        html += '</div>';
                    }

                });

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
                            '<div>卡号： <span class="numbers">'+ item.code +'</span> 密码：<span class="codes">' + item.passcode + '</span></div>' +
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

function redeemVip(token, package_id){

    var member_id = $('#hidUserId').val();
    
    $.ajax({
        type: 'POST',
        url: "/api/request-vip-upgrade",
        data: { 'memberid': member_id, 'packageid': package_id },
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            if(data.success) {
                window.location.href = "/redeem/history";
            } else {
                $('#error-' + package_id).html(data.message);
            }
        }
    });
}

function requestVip(token, package_id, type, index){

    var member_id = $('#hidUserId').val();

    if(type == 'single') {
        var card_no = $('#txt_cardno').val();
        var password = $('#txt_password').val();
        var card = card_no + ' ' + password;
    } else {
        var card = $('#txa_card').val();
    }

    $.ajax({
        type: 'POST',
        url: "/api/request-vip-upgrade",
        data: { 'memberid': member_id, 'packageid': package_id, 'card': card },
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            if(data.success){
                $('#viewvouchermode_p' + index).modal('hide');
            }
        }
    });
}
        