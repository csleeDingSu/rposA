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
            var current_point = getNumeric(data.current_point);
            var previous_point = Cookies.get('previous_point');
            if(previous_point !== undefined){
                previous_point = (getNumeric(previous_point));

                $('.wabao-coin')
                  .prop('number', previous_point)
                  .animateNumber(
                    {
                      number: (current_point)
                    },
                    1000
                  );
                Cookies.remove('previous_point');
            } else {
                $('.wabao-coin').html((current_point));
            }            

            var records = data.records.data;
            var packages = data.packages;
            var html = '';
            var htmlmodel = '';

            if(records.length === 0){

                // html += '<div class="history-row">' +
                //             '<div class="col-xs-12">' +
                //                 '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                //             '</div>' +
                //         '</div>';

                // $('#softpin').html(html);

            } else {
                var current_life = getNumeric($(".nTxt").html());

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

                    if (item.min_point > getNumeric(data.current_point)){
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
                                    '<div class="description">' + item.product_name + '<div class="description-info">可兑换支付宝现金</div></div>' +
                                    '<div class="remaining">已兑换 '+ total_used +' 张</div>' +
                                '</div>' +
                                '<div class="col-xs-3 column-3">' +
                                    '<div class="btn-redeem openeditmodel'+ i + ' ' + cls_cannot_redeem +'">兑换</div>' +
                                '</div>';

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
                                                            // '<div class="icon-coin-wrapper modal-icon">' +
                                                            //     '<div class="icon-coin"></div>' +
                                                            // '</div>' +
                                                            '<div class="wabao-price">'+ item.min_point +' 元</div>' +
                                                    '</div>' +

                                                    '<div class="modal-card">' +
                                                        '<div class="wabao-balance">您当前拥有 '+ getNumeric(data.current_point) +' 元</div>' +
                                                    '</div>' +

                                                    '<div id="error-'+ item.id + '" class="error"></div>';

                                                    if ((available_quantity > 0) && item.min_point <= getNumeric(data.current_point)) {

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

                $('#softpin').html(html);
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

            //new list of buy product
            getNewProductList(records.length, token);

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
            
            var txt_status = '等待发放';
            var cls_status = 'pending';
            var html_card_detail = null;

            if(item.request_at){
                var t = item.request_at.split(/[- :]/);
                var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                str_date =    d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + 
                            ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
            }

            if (item.type == 'vip') {
                /*html += '<div class="history-row">' +
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
                        '<div class="card-wrapper">游戏密码：<span class="codes-vip">' + item.passcode + '</span>' +
                        '&nbsp;&nbsp;<button class="btn-vip" data-id="'+item.passcode+'" onClick="confirmredeemvip(\''+ token +'\', \''+ item.id +'\', \''+ item.passcode +'\')"  >进入VIP专场</button></div>' +
                        '<div class="instruction">进入VIP专场 > 打开游戏页面VIP专场 > 粘帖密码 > 进入VIP专场</div>' +    
                    '</div>';

                    htmlmodel += '<!-- Modal starts -->' +
                                    '<div class="modal fade col-lg-12" id="enter-vip-modal-' + item.id + '" tabindex="-1" style="z-index: 9999">' +
                                        '<div class="modal-dialog" role="document">' +
                                            '<div class="modal-content enter-vip-content">' +
                                                '<div class="modal-body">' +
                                                    '<div class="modal-row">' +
                                                        '<div class="vip-label">' +
                                                            'VIP专场游戏密码' +
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
                }*/

            } else if (item.type == '1') { //new buy product - card / virtual item

                if(item.redeem_state == 1) { // Pending
                    txt_status = '等待发放';
                    cls_status = 'pending';
                } else if (item.redeem_state == 2 || item.redeem_state == 3) { // 2 = Confirmed, 3 redeemed
                    txt_status = '已发放';
                    cls_status = 'confirmed';
                    getVirtualCardDetails(item.id, token);
                } else {
                    txt_status = '被拒绝';
                    cls_status = 'rejected';
                }

                html += '<div class="row row-new">' +
                            '<div class="redeem-info">' +
                                '<div class="redeem-time">兑换时间: '+str_date+'</div>' +
                                '<div class="redeem-status '+cls_status+'">'+txt_status+'</div>' +
                            '</div>' +
                            '<div class="product-info">'+
                                '<div class="product-img"><img src="'+item.picurl+'" alt="'+item.product_name+'"></div>' +
                                '<div class="product-detail">' +
                                    '<div class="product-name">'+item.product_name+'</div>' +
                                    '<div class="product-desc">可兑换支付宝现金</div>' +
                                '</div>' +
                                '<div class="redeem-result">' +
                                    '<div class="redeem-quantity">X'+item.quantity+'</div>';                
                if (item.redeem_state == 2 || item.redeem_state == 3) {
                    html +=         '<div class="redeem-action"  data-toggle="collapse" data-target="#content-buyproduct-v-' + item.id + '">点击查看</div>' +                             
                                '</div>' +
                                '<div class="redeem-card-detail-' + item.id + '"></div>' +
                            '</div>' +
                        '</div>';
                    // html +=         '<div class="redeem-action"  data-toggle="collapse" data-target="#content-99">点击查看</div>' +
                    //             '</div>' +
                    //             '<div id="content-99" class="collapse">' +
                    //                 '<div class="card-wrapper">卡号： <span id="number99" class="numbers">code</span> <span id="copynumber99" class="copynumber">复制</span><br />密码：<span id="code99" class="numbers">passcode</span> <span id="copycode99" class="copycode">复制</span></div>' +
                    //                 '<div class="instruction">兑现方法：打开支付宝APP>搜索“闲鱼信用回收”并进入>选“卡券”>选骏网一卡通86>选面额并输入卡密>兑换现金成功。</div>' +
                    //             '</div>' +
                    //         '</div>' +
                    //     '</div>';
                } else {
                    html +=     '</div>' +
                            '</div>' +
                        '</div>';
                }

            } else if (item.type == '2') { //new buy product - physical item

                if(item.redeem_state == 1) { // Pending
                    txt_status = '等待发货';
                    cls_status = 'pending';
                } else if (item.redeem_state == 2 || item.redeem_state == 3) { // 2 = Confirmed, 3 redeemed
                    txt_status = '已发货';
                    cls_status = 'confirmed';
                } else {
                    txt_status = '被拒绝';
                    cls_status = 'rejected';
                }

                html += '<div class="row row-new">' +
                            '<div class="redeem-info">' +
                                '<div class="redeem-time">兑换时间: '+str_date+'</div>' +
                                '<div class="redeem-status '+cls_status+'">'+txt_status+'</div>' +
                            '</div>' +
                            '<div class="product-info">' +
                                '<div class="product-img"><img src="'+item.picurl+'" alt="'+item.product_name+'"></div>' +
                                '<div class="product-detail">' +
                                    '<div class="product-name">'+item.product_name+'</div>' +
                                    '<div class="product-desc">'+item.used_point+' 金币</div>' +
                                '</div>' +
                                '<div class="redeem-result">' +
                                    '<div class="redeem-quantity">X'+ item.quantity +'</div>' +
                                '</div>' +
                            '</div>';

                if (item.redeem_state == 2 || item.redeem_state == 3) {
                    html += '<div class="corrier-info">' +
                                '快递单号： <span class="tracking-num">'+ item.tracking_partner +'&nbsp;<span id="number-buyproduct-' + item.type + '-' + item.id + '" >'+ item.tracking_number +'</span>&nbsp;<span id="copynumber-buyproduct-' + item.type + '-' + item.id + '" class="copynumber">复制</span>' +
                            '</div>';

                    // Copy tracking number
                    var clipboard_trackingno = new ClipboardJS('#copynumber-buyproduct-' + item.type + '-' + item.id, {
                        target: function () {
                            return document.querySelector('#number-buyproduct-' + item.type + '-' + item.id);
                        }
                    });

                    clipboard_trackingno.on('success', function (e) {
                        $('.copynumber').removeClass('copy-success').html('复制');
                        $('#copynumber-buyproduct-' + item.type + '-' + item.id).addClass('copy-success').html('成功');
                    });

                    clipboard_trackingno.on('error', function (e) {
                        $('#copynumber-buyproduct-' + item.type + '-' + item.id).addClass('copy-success').html('成功');
                    });
                }

                html += '</div>';

            } else {

                if(item.pin_status == 4) { // Pending
                    txt_status = '等待发放';
                    cls_status = 'pending';
                } else if (item.pin_status == 2) { // Confirmed
                    txt_status = '已发放';
                    cls_status = 'confirmed';
                } else {
                    txt_status = '被拒绝';
                    cls_status = 'rejected';
                }

                html += '<div class="row row-new">' +
                            '<div class="redeem-info">' +
                                '<div class="redeem-time">兑换时间:'+ str_date +'</div>' +
                                '<div class="redeem-status '+cls_status+'">'+txt_status+'</div>' +
                            '</div>' +
                            '<div class="product-info"><div class="product-img"><img src="'+item.picurl+'" alt="'+item.product_name+'"></div>' +
                            '<div class="product-detail">' +
                                '<div class="product-name">'+item.product_name+'</div>' +
                                '<div class="product-desc">可兑换支付宝现金</div>' +
                            '</div>' +
                            '<div class="redeem-result">' +
                                '<div class="redeem-quantity">X1</div>';
                if (item.pin_status == 2) {
                    html += '     <div class="redeem-action"  data-toggle="collapse" data-target="#content-' + item.type + item.id + '">点击查看</div>' +
                            '</div>' +
                            '<div id="content-' + item.type + item.id + '" class="collapse">' +
                                '<div class="card-wrapper">卡号： <span id="number' + item.type + item.id + '" class="numbers">' + item.code + '</span> <span id="copynumber' + item.type + item.id + '" class="copynumber">复制</span><br />密码：<span id="code' + item.type + item.id + '" class="numbers">' + item.passcode + '</span> <span id="copycode' + item.type + item.id + '" class="copycode">复制</span></div>' +
                                '<div class="instruction">兑现方法：打开支付宝APP>搜索“闲鱼信用回收”并进入>选“卡券”>选骏网一卡通86>选面额并输入卡密>兑换现金成功。</div>' +
                            '</div></div>' +
                        '</div>';

                    // Copy card number
                    var clipboard_cardno = new ClipboardJS('#copynumber' + item.type + item.id, {
                        target: function () {
                            return document.querySelector('#number' + item.type + item.id);
                        }
                    });

                    clipboard_cardno.on('success', function (e) {
                        $('.copynumber').removeClass('copy-success').html('复制');
                        $('.copycode').removeClass('copy-success').html('复制');
                        $('#copynumber' + item.type + item.id).addClass('copy-success').html('成功');
                    });

                    clipboard_cardno.on('error', function (e) {
                        // $('#copynumber' + item.id).addClass('copy-fail').html('失败');
                        $('#copynumber' + item.type + item.id).addClass('copy-success').html('成功');
                    });

                    // Copy passcode
                    var clipboard_code = new ClipboardJS('#copycode' + item.type + item.id, {
                        target: function () {
                            return document.querySelector('#code' + item.type + item.id);
                        }
                    });

                    clipboard_code.on('success', function (e) {
                        $('.copynumber').removeClass('copy-success').html('复制');
                        $('.copycode').removeClass('copy-success').html('复制');
                        $('#copycode' + item.type + item.id).addClass('copy-success').html('成功');
                    });

                    clipboard_code.on('error', function (e) {
                        // $('#copycode' + item.id).addClass('copy-fail').html('失败');
                        $('#copycode' + item.type + item.id).addClass('copy-success').html('成功');
                    });

                } else {
                    html += '       </div>' +
                                '</div>' +
                            '</div>';
                }
            }

        });

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

function getNewProductList(softpinCount, token) {
    var member_id = $('#hidUserId').val();

    $.ajax({
        type: 'GET',
        url: "/api/get-product-list", 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            //console.log(data);
            var records = data.records;
            var packages = data.packages;
            var html = '';
            var htmlmodel = '';
            var current_point = $('.wabao-coin').text();

            if(records.length === 0 && softpinCount <= 0){
                html += '<div class="history-row">' +
                            '<div class="col-xs-12">' +
                                '<div class="empty">对不起 - 你现在还没有数据。</div>' +
                            '</div>' +
                        '</div>';

                $('#newProduct').html(html);
                
            } else {
                $.each(records, function(i, item) {
                    var available_quantity = item.available_quantity;
                    var used_quantity = 0;
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

                    if (item.point_to_redeem > getNumeric(current_point)){
                        cannot_redeem = true;
                        cls_cannot_redeem = 'btn-cannot-redeem';
                    }

                    if(available_quantity == 0){
                        cls_cannot_redeem = 'btn-cannot-redeem';
                    }

                    var total_used = parseInt(used_quantity) + parseInt(reserved_quantity) || 0;

                    html += '<div class="row">' +
                                '<div class="col-xs-3 column-1">' +
                                    '<img class="img-voucher" src="'+ item.picture_url +'" alt="'+item.name+'">' +
                                '</div>' +
                                '<div class="col-xs-6 column-2">' +
                                    '<div class="description">' + item.name + '<div class="description-info">' + item.description + '</div></div>' +
                                    '<div class="remaining">已兑换 '+ total_used +' 张</div>' +
                                '</div>' +
                                '<div class="col-xs-3 column-3">' +
                                    '<div class="btn-redeem openeditmodel_'+ i + ' ' + cls_cannot_redeem +'">兑换</div>' +
                                '</div>';

                            html += '</div>';

                    htmlmodel += '<!-- Modal starts -->' +
                            '<div class="modal fade col-lg-12" id="viewvouchermode_'+ i +'" tabindex="-1" >' +
                                '<div class="modal-dialog modal-sm" role="document">' +
                                    '<div class="modal-content">' +
                                        '<div class="modal-body">' +
                                            '<div class="modal-row">' +
                                                '<div class="modal-img-voucher">' +
                                                    '<img src="' + item.picture_url +'" alt=" ' + item.name + ' " class="img-voucher" />' +
                                                '</div>' +

                                                '<div class="wrapper modal-full-height">' +
                                                    '<div class="modal-card">' +
                                                        '<div class="modal-center">' +
                                                            '兑换本产品需要消耗:' +
                                                        '</div>' +
                                                    '</div>' +

                                                    '<div class="modal-card">' +
                                                            // '<div class="icon-coin-wrapper modal-icon">' +
                                                            //     '<div class="icon-coin"></div>' +
                                                            // '</div>' +
                                                            '<div class="wabao-price">'+ item.point_to_redeem +' 元</div>' +
                                                    '</div>' +

                                                    '<div class="modal-card">' +
                                                        '<div class="wabao-balance">您当前拥有 '+ getNumeric(current_point) +' 元</div>' +
                                                    '</div>' +

                                                    '<div id="error-'+ item.id + '" class="error"></div>';

                                                    if ((available_quantity > 0) && item.point_to_redeem <= getNumeric(current_point)) {

                                                        htmlmodel += '<div id="redeem-'+ item.id +'" onClick="redeemProduct(\''+ token +'\', \''+ item.id +'\');">' +
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

                $('#newProduct').html(html);
                $( ".cardFull" ).after(htmlmodel);

                $.each(records, function(i, item) {
                    $('.openeditmodel_' + i).click(function() {
                        $('#viewvouchermode_' + i).modal('show');
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
}

function redeemProduct(token, product_id){

    var member_id = $('#hidUserId').val();

    $.ajax({
        type: 'POST',
        url: "/buy",
        data: { 'memberid': member_id, 'hid_package_id': product_id },
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error.responseText) },
        success: function(data) {
            if(data.success) {
                // window.location.href = "/redeem/history";
                $("html").html(data);
            } else {
                $('#error-' + product_id).html(data.message);
            }
        }
    });
}

function getVirtualCardDetails(id, token){

    var member_id = $('#hidUserId').val();

    $.ajax({
        type: "GET",
        url: "/api/get-virtual-card-details?memberid=" + member_id + "&orderid=" + id, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            // console.log(data);
            var records = data.records;
            var html = '';

            html += '<div id="content-buyproduct-v-' + id + '" class="collapse">';

            $.each(records, function(i, item) {
                console.log(item.card_num);

                html += '<div class="card-wrapper">卡号： <span id="number-buyproduct-v-' + item.order_id + '-' + item.id + '" class="numbers">' + item.card_num + '</span> <span id="copynumber-buyproduct-v-' + item.order_id + '-' + item.id + '" class="copynumber">复制</span>' +
                        '<br />密码：<span id="code-buyproduct-v-' + item.order_id + '-' + item.id + '" class="numbers">' + item.card_pass + '</span> <span id="copycode-buyproduct-v-' + item.order_id + '-' + item.id + '" class="copycode">复制</span></div>' +
                        '<br/>';

                // Copy card number
                var _clipboard_cardno = new ClipboardJS('#copynumber-buyproduct-v-' + item.order_id + '-' + item.id, {
                    target: function () {
                        return document.querySelector('#number-buyproduct-v-' + item.order_id + '-' + item.id);
                    }
                });

                _clipboard_cardno.on('success', function (e) {
                    $('.copynumber').removeClass('copy-success').html('复制');
                    $('.copycode').removeClass('copy-success').html('复制');
                    $('#copynumber-buyproduct-v-' + item.order_id + '-' + item.id).addClass('copy-success').html('成功');
                });

                _clipboard_cardno.on('error', function (e) {
                    $('#copynumber-buyproduct-v-' + item.order_id + '-' + item.id).addClass('copy-success').html('成功');
                });

                // Copy passcode
                var _clipboard_code = new ClipboardJS('#copycode-buyproduct-v-' + item.order_id + '-' + item.id, {
                    target: function () {
                        return document.querySelector('#code-buyproduct-v-' + item.order_id + '-' + item.id);
                    }
                });

                _clipboard_code.on('success', function (e) {
                    $('.copynumber').removeClass('copy-success').html('复制');
                    $('.copycode').removeClass('copy-success').html('复制');
                    $('#copycode-buyproduct-v-' + item.order_id + '-' + item.id).addClass('copy-success').html('成功');
                });

                _clipboard_code.on('error', function (e) {
                    $('#copycode-buyproduct-v-' + item.order_id + '-' + item.id).addClass('copy-success').html('成功');
                });
            });

            html += '<div class="instruction">兑现方法：打开支付宝APP>搜索“闲鱼信用回收”并进入>选“卡券”>选骏网一卡通86>选面额并输入卡密>兑换现金成功。</div>' +
                                '</div>';

            $('.redeem-card-detail-' + id).html(html);
        }
     });
}

function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
  }