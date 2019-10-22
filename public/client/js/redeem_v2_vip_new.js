var page = 1;
var page_count = 1;
var reload_pass = '￥EXpZYiJPcpg￥';
var this_vip_app = true;
var txt_coin = '挖宝币';
var wallet_point = 0;
var gameid = 103

$(document).ready(function () {

    reload_pass = $('#reload_pass').val();
    
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
            getWallet(data.access_token, id);
        }      
    });
}

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

    if (page == 1) {
        document.getElementById('loading2').style.visibility="visible";
    }

    $.ajax({
        type: "GET",
        url: "/api/redeem-history?memberid=" + member_id + "&page=" + page, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error);
        document.getElementById('loading2').style.visibility="hidden";
        },
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

            if ((records.data == '' || records.data == null) && current_page == 1) {
                $(".isnext").html('');
            } else {
                var empty = html.match("empty");
                if(current_page == last_page){
                    if (empty == '' || empty == null) {

                        $(".isnext").html(end_of_result); 

                    }else{
                       $(".isnext").html('');    
                    }
                    
                }
            }

            page++;
            $('#page').val(page);
            document.getElementById('loading2').style.visibility="hidden";
        }
     });
}

function populateHistoryData(records, token) {

    var data = records.data;
    var current_page = parseInt(records.current_page);
    var last_page = parseInt(records.last_page);
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

        // html += '<div class="history-row">' +
        //             '<div class="col-xs-12">' +
        //                 '<div class="empty">对不起 - 你现在还没有数据。</div>' +
        //             '</div>' +
        //         '</div>';
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

            } else if (item.type == '1' && this_vip_app == true) { //new buy product - card / virtual item
                /* close for basic game - only show on vip */

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


            } else if (item.type == '2' && this_vip_app == true) { //new buy product - physical item
                /* close for basic game - only show on vip*/

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
                                    '<div class="product-desc">'+item.used_point+' ' + txt_coin + '</div>' +
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
                
            } else if (item.type == 'product'  && this_vip_app == false){

                html += '<div class="row product-row">' +
                        '   <div class="product-bg"><div class="hbao"></div>' +
                        '       <div class="product-title">' + item.product_name + '<a href="/faq/4"><div class="gifhome"></div><div class="product-how-to-redeem">点击我<span class="highlight">看充值教程</span></div></a></div>';
                if (item.pin_status == 2) {
                html += '       <div class="product-content">' +
                        '           <div class="r"><div class="c1">卡号&nbsp;:</div><div id="number' + item.type + item.id + '" class="c2">' + item.code + '</div> <div id="copynumber' + item.type + item.id + '" class="copynumber c3">点击复制</div></div>' +
                        '           <div class="r"><div class="c1">密码&nbsp;:</div><div id="code' + item.type + item.id + '" class="c2">' + item.passcode + '</div> <div id="copycode' + item.type + item.id + '" class="copycode c3">点击复制</div></div>' +
                        '       </div>'+
                        '   </div>'+
                        '   <div class="product-redeem-time">发放时间:'+ str_date +'</div>' +
                        '</div>';

                    // Copy card number
                    var clipboard_cardno = new ClipboardJS('#copynumber' + item.type + item.id, {
                        target: function () {
                            return document.querySelector('#number' + item.type + item.id);
                        }
                    });

                    clipboard_cardno.on('success', function (e) {
                        $('.copycode').removeClass('copy-success-new').html('点击复制');
                        $('#copynumber' + item.type + item.id).addClass('copy-success-new').html('复制成功');                                                
                    });

                    clipboard_cardno.on('error', function (e) {
                        // $('#copynumber' + item.id).addClass('copy-fail').html('失败');
                        $('#copynumber' + item.type + item.id).addClass('copy-success-new').html('复制成功');
                    });

                    // Copy passcode
                    var clipboard_code = new ClipboardJS('#copycode' + item.type + item.id, {
                        target: function () {
                            return document.querySelector('#code' + item.type + item.id);
                        }
                    });

                    clipboard_code.on('success', function (e) {
                        $('.copynumber').removeClass('copy-success-new').html('点击复制');
                        $('.copycode').removeClass('copy-success-new').html('点击复制');
                        $('#copycode' + item.type + item.id).addClass('copy-success-new').html('复制成功');
                    });

                    clipboard_code.on('error', function (e) {
                        // $('#copycode' + item.id).addClass('copy-fail').html('失败');
                        $('#copycode' + item.type + item.id).addClass('copy-success-new').html('复制成功');
                    });

                } else {
                
                html += '   </div>' +
                        '</div>';
                }
            }

        });

    }

    if(current_page == 1 && last_page == 1 && html === '') {
        html = '<div class="no-record">' +
                    '<img src="/clientapp/images/no-record/redeem-vip.png">' ;
                    if (this_vip_app) {
                        html += '<div class="empty">你还没兑换奖品<br><a href="/shop" class="share-link">去换奖品></a></div>';
                    } else {
                        html += '<div class="empty">你还没兑换红包<br><a href="/arcade" class="share-link">去拿红包></a></div>';
                    }
        html += '</div>';
    }
   

    return html;

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

                if (item.card_pass == '#' || item.card_pass == '') {
                    html += '<div class="card-wrapper">卡号： <span id="number-buyproduct-v-' + item.order_id + '-' + item.id + '" class="numbers">' + item.card_num + '</span> <span id="copynumber-buyproduct-v-' + item.order_id + '-' + item.id + '" class="copynumber">复制</span>' +
                        '<br />淘口令: <span id="code-buyproduct-v-' + item.order_id + '-' + item.id + '" class="numbers">' + reload_pass + '</span> <span id="copycode-buyproduct-v-' + item.order_id + '-' + item.id + '" class="copycode">复制</span></div>' +
                        '<br/>';
                } else {
                    html += '<div class="card-wrapper">卡号： <span id="number-buyproduct-v-' + item.order_id + '-' + item.id + '" class="numbers">' + item.card_num + '</span> <span id="copynumber-buyproduct-v-' + item.order_id + '-' + item.id + '" class="copynumber">复制</span>' +
                        '<br />密码：<span id="code-buyproduct-v-' + item.order_id + '-' + item.id + '" class="numbers">' + item.card_pass + '</span> <span id="copycode-buyproduct-v-' + item.order_id + '-' + item.id + '" class="copycode">复制</span></div>' +
                        '<br/>';    
                }

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

                if (item.card_pass == '#' || item.card_pass == '') {
                    html += '<div class="instruction">兑换红包方法：复制上面淘口令›打开淘宝APP›进入后点立即回收›选电商卡›选京东E卡›选面额输入卡›等待回收</div>' +
                                    '</div>';
                }else{
                    html += '<div class="instruction">兑换红包方法：复制上面淘口令›打开淘宝APP›进入后点立即回收›选游戏卡›选骏网一卡通›选面额输入卡号和密码›3分钟红包到账。</div>' +
                                    '</div>';
                }
            });

            $('.redeem-card-detail-' + id).html(html);
        }
     });
}

function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
  }
  
function getWallet(token, id) {
    
    $.ajax({
        type: 'POST',
        url: "/api/wallet-detail?gameid=103&memberid=" + id, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) {
            console.log(error);
            alert(error.message);
            $(".reload").show();
        },
        success: function(data) {
            // console.log(data);
            wallet_point = data.record.gameledger[gameid].point;
            $('.wabao-coin').html(wallet_point);
            getPosts(page, token);
            scrollBottom(token);            
        }
    });
}