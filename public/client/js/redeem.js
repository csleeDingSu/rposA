var page = 1;
var page_count = 1;

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

    var clipboard_verify = new ClipboardJS('.cutBtn', {
        target: function () {
            return document.querySelector('#cutVerify');
        }
    });

    clipboard_verify.on('success', function (e) {
        $('.cutBtn').addClass('cutBtn-success').html('<i class="far fa-check-circle"></i>复制成功');
    });

    clipboard_verify.on('error', function (e) {
        $('.cutBtn').addClass('cutBtn-fail').html('<i class="far fa-times-circle"></i>复制失败');
    });

    $('.btn-close-verify').click(function() {
        $('#wechat-verification-modal').modal('hide');
    });
});

function getToken(){
    var username = $('#hidUsername', window.parent.document).val();
    var session = $('#hidSession', window.parent.document).val();
    var id = $('#hidUserId', window.parent.document).val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            getProductList(data.access_token);
            getPosts(page, data.access_token);
            scrollBottom(data.access_token);
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
            var current_point = parseInt(data.current_point);
            var previous_point = Cookies.get('previous_point');
            if(previous_point !== undefined){
                previous_point = parseInt(previous_point);

                $('.wabao-coin')
                  .prop('number', previous_point)
                  .animateNumber(
                    {
                      number: current_point
                    },
                    1000
                  );
                Cookies.remove('previous_point');
            } else {
                $('.wabao-coin').html(current_point);
            }            

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
                var current_life = parseInt($(".nTxt").html());

                $.each(packages, function(i, item) {
                    var available_quantity = item.available_quantity;
                    var used_quantity = item.used_quantity;
                    var reserved_quantity = item.reserved_quantity;
                    var cannot_redeem = false;
                    var cls_cannot_redeem = '';

                    if(available_quantity === null){
                        available_quantity = 0;
                    }

                    if(used_quantity === null){
                        used_quantity = 0;
                    }

                    if(reserved_quantity === null){
                        reserved_quantity = 0;
                    }

                    if (item.min_point > parseInt(data.current_point)){
                        cannot_redeem = true;
                        cls_cannot_redeem = 'btn-cannot-redeem';
                    }

                    if(available_quantity == 0){
                        cls_cannot_redeem = 'btn-cannot-redeem';
                    }

                    var total_used = parseInt(used_quantity) + parseInt(reserved_quantity) || 0;

                    //console.log(item);
                        html += '<div class="row">' +
                                    '<div class="col-xs-3 column-1">' +
                                        '<img class="img-voucher" src="'+ item.package_picurl +'" alt="'+item.package_name+'">' +
                                    '</div>' +
                                    '<div class="col-xs-6 column-2">' +                               
                                        '<div class="description">' + item.package_name + '</div>';
                                        html += '<div class="note"></div>';
                                        /*
                                         if (item.min_point > 0) {
                                            html += '<div class="note">VIP场，收益增10倍！</div>';
                                         } else {
                                            html += '<div class="note">积分不够，可用话费卡来兑换。</div>';
                                         }
                                         */                               
                                        //'<div class="note">可兑换支付宝红包' + parseInt(data.current_point) + '元</div>' +                                        
                                html +='<div class="icon-coin-wrapper">' +
                                            '<div class="icon-coin"></div>' +
                                        '</div>' +
                                        '<div class="w-coin">'+ item.min_point +'</div>' +
                                        '<div style="clear: both;"></div>' +
                                        '<div class="remaining">已兑换 '+ total_used +' 张</div>' +
                                    '</div>' +
                                    '<div class="col-xs-3 column-3">' +
                                        '<div class="btn-redeem openeditmodel_p'+ i + ' ' + cls_cannot_redeem + '">兑换</div>' +
                                    '</div>';

                            // if (cannot_redeem || current_life == 0) {
                            //     html +='<div class="horizontal"></div>' +
                            //         '<div class="col-xs-9 insufficient">不够积分兑换，邀请一个好友赚450积分！</div>' + 
                            //         '<div class="col-xs-3 btn-insufficient-wrapper">' +
                            //             '<a href="/share"><div class="btn-insufficient">马上邀请</div></a>' +
                            //         '</div>';
                            // }

                                html +='</div>';


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
                                                                '<div class="wabao-price">'+ item.min_point +'金币</div>' +
                                                        '</div>' +

                                                        '<div class="modal-card">' +
                                                            '<div class="wabao-balance">您当前拥有 '+ parseInt(data.current_point) +' 金币</div>' +
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
                                                '<div class="btn-close-wrapper">' +
                                                    '<img class="closeeditmodel_p'+ i +'" src="/client/images/btn-close-modal.png" width="22" height="22" />' +
                                                '</div>' +
                                                '<div class="modal-content vip-content">' +

                                                    '<div class="wrapper modal-full-height bg-vip-copy modal-body">' +
                                                        '<span class="vip-copy">复制淘口令，打开淘宝APP购买<br />' +
                                                        '每' + item.package_price + '元可兑换一次VIP入场卷</span>' +
                                                        '<div class="modal-card">' +
                                                            '<div id="cut" class="copyvoucher">¥ K8454DFGH45H</div>' +
                                                            '<div class="cutBtn">一键复制</div>' +
                                                        '</div>' +
                                                    '</div>' +
                                                    
                                                    '<div class="modal-body">' +
                                                        '<div class="modal-row">' +
                                                            '<ul class="nav nav-pills">' +
                                                              '<li class="active take-all-space-you-can"><a data-toggle="tab" href="#single-tab">单张提交</a></li>' +
                                                              '<li class="take-all-space-you-can"><a data-toggle="tab" href="#multiple">批量提交</a></li>' +
                                                            '</ul>' +
                                                            '<div class="tab-content">' +
                                                              '<div id="single-tab" class="tab-pane fade in active vip-tab-pane">' +
                                                                '卡号： <input id="txt_cardno" type="text" name="card_no" placeholder="请输入卡号" /><br /><hr>' +
                                                                '密码： <input id="txt_password" type="text" name="password" placeholder="请输入密码" /><br /><hr>' +
                                                                '<span class="modal-description">注意事项：请提交面值为100元的话费卷，如果提交多次错误花费卷，您的账号会被封号</span>' +
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
                                                                '<span class="modal-description">注意事项：请提交面值为100元的话费卷，如果提交多次错误花费卷，您的账号会被封号</span>' +
                                                                '<div class="modal-card">' +
                                                                    '<div id="request-'+ item.id +'" onClick="requestVip(\'' + token + '\', \''+ item.id +'\', \'multiple\', '+ i +');">' +
                                                                        '<a class="btn btn-submit-vip" >提交</a>' +
                                                                    '</div>' +
                                                                '</div>' +
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
                    var cannot_redeem = false;
                    var cls_cannot_redeem = '';

                    if(available_quantity === null){
                        available_quantity = 0;
                    }

                    if(used_quantity === null){
                        used_quantity = 0;
                    }

                    if(reserved_quantity === null){
                        reserved_quantity = 0;
                    }

                    if (item.min_point > parseInt(data.current_point)){
                        cannot_redeem = true;
                        cls_cannot_redeem = 'btn-cannot-redeem';
                    }

                    if(available_quantity == 0){
                        cls_cannot_redeem = 'btn-cannot-redeem';
                    }

                    var total_used = parseInt(used_quantity) + parseInt(reserved_quantity) || 0;

                    html += '<div class="row">' +
                                '<div class="col-xs-3 column-1">' +
                                    '<img class="img-voucher" src="'+ item.product_picurl +'" alt="'+item.product_name+'">' +
                                '</div>' +
                                '<div class="col-xs-6 column-2">' +
                                    '<div class="description">' + item.product_name + '</div>' +
                                    '<div class="note"></div>' +
                                    /*
                                    '<div class="note">兑换支付宝红包' + item.product_price + '元</div>' +
                                    */
                                    '<div class="icon-coin-wrapper">' +
                                        '<div class="icon-coin"></div>' +
                                    '</div>' +
                                    '<div class="w-coin">'+ item.min_point +'</div>' +
                                    '<div style="clear: both;"></div>' +
                                    '<div class="remaining">已兑换 '+ total_used +' 张</div>' +
                                '</div>' +
                                '<div class="col-xs-3 column-3">' +
                                    '<div class="btn-redeem openeditmodel'+ i + ' ' + cls_cannot_redeem +'">兑换</div>' +
                                '</div>';

                        // if (cannot_redeem || current_life == 0) {
                        //     html += '<div class="horizontal"></div>' +
                        //             '<div class="col-xs-9 insufficient">不够积分兑换，邀请一个好友赚450积分！</div>' + 
                        //             '<div class="col-xs-3 btn-insufficient-wrapper">' +
                        //                 '<a href="/share"><div class="btn-insufficient">马上邀请</div></a>' +
                        //             '</div>';
                        // }

                            html += '</div>';

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
                                                            '<div class="wabao-price">'+ item.min_point +'金币</div>' +
                                                    '</div>' +

                                                    '<div class="modal-card">' +
                                                        '<div class="wabao-balance">您当前拥有 '+ parseInt(data.current_point) +' 金币</div>' +
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

                var wechat_status = $('#hidWechatId').val();

                $.each(packages, function(i, item) {
                    $('.openeditmodel_p' + i).click(function() {
                        if(wechat_status > 0){
                            $('#wechat-verification-modal').modal('show');
                        } else {
                            $('#viewvouchermode_p' + i).modal('show');
                        }
                    });

                    $('.closeeditmodel_p' + i).click(function() {
                        $('#viewvouchermode_p' + i).modal('hide');
                    });
                });

                $.each(records, function(i, item) {
                    $('.openeditmodel' + i).click(function() {
                        if(wechat_status > 0){
                            $('#wechat-verification-modal').modal('show');
                        } else {
                            $('#viewvouchermode' + i).modal('show');
                        }
                    });
                });

                $('.open-card-no-modal').click(function() {
                    $('#card-no-modal').modal('show');
                });

                $('.btn-close-card').click(function() {
                    $('#card-no-modal').modal('hide');
                });
            }
        } // end success
    }); // end $.ajax
} // end function

function scrollBottom(token){
    being.scrollBottom('.cardBody', '.container', () => { 
        page = parseInt($('#page').val());
        var max_page = parseInt($('#max_page').val());
        if(page > max_page) {
            
        }else{
            getPosts(page, token);
        }   
    });
}

function getPosts(page, token){

    var member_id = $('#hidUserId').val();

    $.ajax({
        type: "GET",
        url: "/api/redeem-history?memberid=" + member_id + "&page=" + page, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            var current_page = parseInt(data.records.current_page);
            var last_page = parseInt(data.records.last_page);
            $('#max_page').val(last_page);
            var records = data.records;
            var html = populateHistoryData(records, token);

            if(current_page == 1){
                $('#redeem-history').html(html);
            } else {
                $('#redeem-history').append(html);
            }

            if(current_page == last_page){
                $(".isnext").html(end_of_result);
            }

            page++;
            $('#page').val(page);
        }
     });
}

function populateHistoryData(records, token) {
    var data = records.data;
    var current_page = parseInt(records.current_page);
    var limit = parseInt(records.per_page);

    var html = '';
    var htmlmodel = '';
    var counter = (current_page - 1) * limit;
    var str_date = '';

    if(page_count != page && current_page == page){
        return false;
    }

    console.log(page_count + ":" + current_page);
    page_count++;

    if(data.length === 0){

        html += '<div class="history-row">' +
                    '<div class="col-xs-12">' +
                        '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                    '</div>' +
                '</div>';
    } else {

        $.each(data, function(i, item) {
            counter += 1;

            if(item.request_at){
                var t = item.request_at.split(/[- :]/);
                var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                str_date =    d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + 
                            ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
            }

            if (item.type == 'vip') {
                html += '<div class="history-row">' +
                    '<div class="col-xs-2 column-4">' +
                        counter +
                    '</div>' +
                    '<div class="col-xs-7 column-5">' +
                        '<div class="description">'+ item.product_name + ' ' + (item.used_point || '') + '金币</div>' +
                        '<div class="balance">兑换时间:'+ str_date +'</div>' +
                    '</div>';

                if(item.redeem_state == 1) { // Pending
                    html += '<div class="col-xs-3 column-6">' +
                                '<div class="btn-pending-vip">等待发放</div>' +
                            '</div>' + 
                        '</div>';

                } else if (item.redeem_state == 2) { // Confirmed
                    html += '<div class="col-xs-3 column-6">' +
                                '<div class="btn-card-vip" data-toggle="collapse" data-target="#content-p-' + item.id + '">查看密码</div>' +
                            '</div>' + 
                        '</div>' +
                    '<div id="content-p-' + item.id + '" class="collapse">' +
                        '<div class="card-wrapper">挖宝密码：<span class="codes-vip">' + item.passcode + '</span>' +
                        '&nbsp;&nbsp;<button class="btn-vip" data-id="'+item.passcode+'" onClick="confirmredeemvip(\''+ token +'\', \''+ item.id +'\', \''+ item.passcode +'\')"  >进入VIP专场</button></div>' +
                        '<div class="instruction">进入VIP专场 > 打开挖宝页面VIP专场 > 粘帖密码 > 进入VIP专场</div>' +    
                    '</div>';

                    htmlmodel += '<!-- Modal starts -->' +
                                    '<div class="modal fade col-lg-12" id="enter-vip-modal-' + item.id + '" tabindex="-1" style="z-index: 9999">' +
                                        '<div class="modal-dialog" role="document">' +
                                            '<div class="modal-content enter-vip-content">' +
                                                '<div class="modal-body">' +
                                                    '<div class="modal-row">' +
                                                        '<div class="vip-label">' +
                                                            'VIP专场挖宝密码' +
                                                        '</div>' +
                                                        '<div class="vip-code">' +
                                                            item.passcode +
                                                        '</div>' +
                                                        '<a href="/vip">' +
                                                            '<div class="btn-enter-vip">' +
                                                                '进入专场' +
                                                            '</div>' +
                                                        '</a>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<!-- Modal Ends -->';

                } else if (item.redeem_state == 3) { // Redeemed
                    html += '<div class="col-xs-3 column-6">' +
                                '<a href="/vip"><div class="btn-pending">正在使用</div></a>' +
                            '</div>' + 
                        '</div>';
                } else if (item.redeem_state == 4) { // Used
                    html += '<div class="col-xs-3 column-6">' +
                                '<div class="btn-used-wrapper">' +
                                    '<div class="btn-used"><img src="/client/images/vip/vip-used.png" width="50" height="50" /></div>' +
                                '</div>' + 
                            '</div>' + 
                        '</div>';
                } else {
                    html += '</div>';
                }

            } else {
                html += '<div class="history-row">' +
                    '<div class="col-xs-2 column-4">' +
                        counter +
                    '</div>' +
                    '<div class="col-xs-7 column-5">' +
                        '<div class="description">'+ item.product_name + ' ' + (item.pin_name || '') + '</div>' +
                        '<div class="balance">兑换时间:'+ str_date +'</div>' +
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
                        '<div class="card-wrapper">卡号： <span id="number' + item.id + '" class="numbers">'+ item.code +'</span> <span id="copynumber' + item.id + '" class="copynumber">复制</span>' + 
                        '<br />密码：<span id="code' + item.id + '" class="numbers">' + item.passcode + '</span> <span id="copycode' + item.id + '" class="copycode">复制</span></div>' +
                        '<div class="instruction">打开支付宝APP>搜索“话费卡转让”>进入官方平台>选择面值输入卡号和卡密即可兑换成红包。' +
                        '</div>' +
                    '</div>';

                    // Copy card number
                    var clipboard_cardno = new ClipboardJS('#copynumber' + item.id, {
                        target: function () {
                            return document.querySelector('#number' + item.id);
                        }
                    });

                    clipboard_cardno.on('success', function (e) {
                        $('.copynumber').removeClass('copy-success').html('复制');
                        $('.copycode').removeClass('copy-success').html('复制');
                        $('#copynumber' + item.id).addClass('copy-success').html('成功');
                    });

                    clipboard_cardno.on('error', function (e) {
                        // $('#copynumber' + item.id).addClass('copy-fail').html('失败');
                        $('#copynumber' + item.id).addClass('copy-success').html('成功');
                    });

                    // Copy passcode
                    var clipboard_code = new ClipboardJS('#copycode' + item.id, {
                        target: function () {
                            return document.querySelector('#code' + item.id);
                        }
                    });

                    clipboard_code.on('success', function (e) {
                        $('.copynumber').removeClass('copy-success').html('复制');
                        $('.copycode').removeClass('copy-success').html('复制');
                        $('#copycode' + item.id).addClass('copy-success').html('成功');
                    });

                    clipboard_code.on('error', function (e) {
                        // $('#copycode' + item.id).addClass('copy-fail').html('失败');
                        $('#copycode' + item.id).addClass('copy-success').html('成功');
                    });

                } else {
                    html += '</div>';
                }
            }

        });

        $( ".cardFull" ).after( htmlmodel);
    }

    return html;

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
                window.location.href = "/redeem/history";
            }
        }
    });
}

function confirmredeemvip(token,id,code)
{
	var member_id = $('#hidUserId').val();
    
	$.ajax({
        type: 'POST',
        url: "/api/redeem-vip",
        data: { 'memberid': member_id, 'passcode': code },
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText);},
        success: function(data) {
            if(data.success){
                $('#enter-vip-modal-' + id).modal('show');
            } else {
                $('#using-vip-modal').modal('show');

                $('.btn-close-modal').click(function() {
                    $('#using-vip-modal').modal('hide');
                });
            }
        }
    });
	
	
}
        