var page = 1;
var page_count = 1;
var reload_pass = '￥EXpZYiJPcpg￥';
var this_vip_app = false;
var txt_coin = '元';

$(document).ready(function () {

    this_vip_app = $('#this_vip_app').val();

    if (this_vip_app == true) {
        txt_coin = "金币";
    }

    getToken();  

});

function getToken(){
    var username = $('#hidUsername', window.parent.document).val();
    var session = $('#hidSession', window.parent.document).val();
    var id = $('#hidUserId', window.parent.document).val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            getPosts(page, data.access_token);
            scrollBottom(data.access_token);
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

            if (item.type == '2' && this_vip_app == true && (item.redeem_state == 2 || item.redeem_state == 3)) { //new buy product - physical item
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
                                    '<a href="/blog/createform"><div class="btn-create-blog">我要晒单</div></a>' +
                                '</div>' +
                            '</div>';

                html += '</div>';
                
            }

        });

    }

    if(current_page == 1 && last_page == 1 && html === '') {
        html = '<div class="no-record">' +
                    '<img src="/clientapp/images/no-record/blog.png">' ;
                    if (this_vip_app) {
                        html += '<div class="empty">你还没兑换奖品，不能评价<br><a href="/shop" class="share-link">去换奖品></a></div>';
                    } else {
                        html += '<div class="empty">你还没兑换红包，不能评价<br><a href="/arcade" class="share-link">去拿红包></a></div>';
                    }
        html += '</div>';
    }

    return html;

}

function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
  }