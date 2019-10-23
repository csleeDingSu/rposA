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

            // console.log(html);

            if(current_page == 1){
                $('.prcieList').html(html);
            } else {
                $('.prcieList').append(html);
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
                //old vip... 
            } else if (item.type == '1' && this_vip_app == true) { //new buy product - card / virtual item
                /* close for basic game - only show on vip */

                if(item.redeem_state == 1) { // Pending
                    txt_status = '等待发放';
                    cls_status = '#ff5e1e';
                } else if (item.redeem_state == 2 || item.redeem_state == 3) { // 2 = Confirmed, 3 redeemed
                    txt_status = '已发放';
                    cls_status = '#1ea8ff';
                } else {
                    txt_status = '被拒绝';
                    cls_status = 'red';
                }

                html += '<div class="inBox">' +
                            '<div class="inHead">' +
                                '<h2>兑换时间：'+str_date+'</h2>' +
                                '<p>';
                                if (item.redeem_state == 2 || item.redeem_state == 3) {
                html +=             '<a href="/faq/5" class="helpBtn"><img src="/clientapp/images/courseHint.png"></a>';
                                }
                html +=             '<font color="'+cls_status+'">'+txt_status+'</font>' +
                                '</p>' +
                            '</div>' +
                            '<div class="inBody dFlex">' +
                                '<div class="imgBox">' +
                                    '<img src="'+item.picurl+'">' +
                                '</div>' +
                                '<div class="txtBox">' +
                                    '<h2>'+item.product_name+'</h2>' +
                                    '<p><span>'+item.used_point+'</span>' + txt_coin + '</p>' +
                                '</div>' +
                                '<div class="numBox">' +
                                    '<span>X'+item.quantity+'</span>';
                                if (item.redeem_state == 2 || item.redeem_state == 3) {                                   

                html +=             '<a class="courseBtn" id="courseBtn-' + item.id +'">点击查看</a>';
                                }

                html +=         '</div>' +
                            '</div>';

                if (item.redeem_state == 2 || item.redeem_state == 3) {
                    html += '<div class="inCourse dn" id="content-buyproduct-v-' + item.id + '"></div>';
                    getVirtualCardDetails(item.id, token);                    
                }
            
                html += '</div>';

            } else if (item.type == '2' && this_vip_app == true) { //new buy product - physical item
                /* close for basic game - only show on vip*/

                if(item.redeem_state == 1) { // Pending
                    txt_status = '等待发货';
                    cls_status = '#ff5e1e';
                } else if (item.redeem_state == 2 || item.redeem_state == 3) { // 2 = Confirmed, 3 redeemed
                    txt_status = '已发货';
                    cls_status = '#1ea8ff';
                } else {
                    txt_status = '被拒绝';
                    cls_status = 'red';
                }

                html += '<div class="inBox">' +
                            '<div class="inHead">' +
                                '<h2>兑换时间：'+str_date+'</h2>' +
                                '<p>' +
                                    '<font color="'+cls_status+'">'+txt_status+'</font>' +
                                '</p>' +
                            '</div>' +
                            '<div class="inBody dFlex">' +
                                '<div class="imgBox">' +
                                    '<img src="'+item.picurl+'">' +
                                '</div>' +
                                '<div class="txtBox">' +
                                    '<h2>'+item.product_name+'</h2>' +
                                    '<p><span>'+item.used_point+'</span>' + txt_coin + '</p>' +
                                '</div>' +
                                '<div class="numBox"><span>X'+ item.quantity +'</span></div>' +
                            '</div>';

                if (item.redeem_state == 2 || item.redeem_state == 3) {

                    html += '<div class="inExpress">' +
                              '<p>快递单号: <span>'+ item.tracking_partner +' <em><span id="number-buyproduct-' + item.type + '-' + item.id + '" >'+ item.tracking_number +'</span></em></span></p>' +

                              '<a><span id="copynumber-buyproduct-' + item.type + '-' + item.id + '" class="copynumber">复制单号</span></a>' +
                              '<span class="copyRight copyHint dn" id="copyRight-' + item.type + '-' + item.id + '">' +
                                '<font color="#54c700">复制成功</font>' +
                              '</span>' +
                              '<span class="copyWrong copyHint dn" id="copyWrong-' + item.type + '-' + item.id + '">' +
                                '<font color="#ff6f6f">复制失败</font>' +
                              '</span>' +
                            '</div>';

                    // html += '<div class="corrier-info">' +
                    //             '快递单号： <span class="tracking-num">'+ item.tracking_partner +'&nbsp;<span id="number-buyproduct-' + item.type + '-' + item.id + '" >'+ item.tracking_number +'</span>&nbsp;<span id="copynumber-buyproduct-' + item.type + '-' + item.id + '" class="copynumber">复制</span>' +
                    //         '</div>';

                    // Copy tracking number
                    var clipboard_trackingno = new ClipboardJS('#copynumber-buyproduct-' + item.type + '-' + item.id, {
                        target: function () {
                            return document.querySelector('#number-buyproduct-' + item.type + '-' + item.id);
                        }
                    });

                    clipboard_trackingno.on('success', function (e) {
                        // $('.copynumber').removeClass('copy-success').html('复制');
                        // $('#copynumber-buyproduct-' + item.type + '-' + item.id).addClass('copy-success').html('成功');
                        $('.copyRight').css('display','none');
                        $('.copyWrong').css('display','none');
                        $('#copyRight-' + item.type + '-' + item.id).css('display','inline');
                    });

                    clipboard_trackingno.on('error', function (e) {
                        // $('#copynumber-buyproduct-' + item.type + '-' + item.id).addClass('copy-success').html('成功');
                        $('.copyRight').css('display','none');
                        $('.copyWrong').css('display','none');
                        $('#copyWrong-' + item.type + '-' + item.id).css('display','inline');
                    });
                }

                html += '</div>';
                
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

            $.each(records, function(i, item) {
                // console.log(item.card_num);

                html += '<ul>' +
                            '<li>' +
                              '<span>卡号：<em><span id="number-buyproduct-v-' + item.order_id + '-' + item.id + '">' + item.card_num + '</span></em></span><a class="coruseCopyBtn"><span id="copynumber-buyproduct-v-' + item.order_id + '-' + item.id + '" class="copynumber">复制</span></a>' +
                            '</li>' +
                            '<li>' +
                              '<span>卡密：<em><span id="code-buyproduct-v-' + item.order_id + '-' + item.id + '">' + item.card_pass + '</span></em></span><a class="coruseCopyBtn"><span id="copycode-buyproduct-v-' + item.order_id + '-' + item.id + '" class="copycode">复制</span></a>' +
                            '</li>' +
                        '</ul>';
                          

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

            console.log('#courseBtn-' + id);

            $('#courseBtn-' + id).click(function () {
                console.log('#courseBtn-' + id);
                let em = $(this);
                em.parents('.inBody').next('.inCourse ').slideToggle(150);
              });

            html += '<h2>兑现方法：打开支付宝APP>搜索“闲鱼信用回收”并进入>选“卡券”>选骏网一卡通86>选面额并输入卡密>兑换现金成功。</h2>';

            $('#content-buyproduct-v-' + id).html(html);
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