var status = 'default';
var page = 1;
var page_count = 1;

$(function () {
    getToken();    
});

function getToken(){

    var id = $('#hidUserId').val();
    var session = $('#hidSession').val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            getPosts(page, data.access_token, status);
            scrollBottom(data.access_token);

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                page = 1;
                page_count = 1;
                status = $(e.target).attr('data-status');
                getPosts(page, data.access_token, status);
            });
        }     
    });
}

function scrollBottom(token){
    being.scrollBottom('.cardBody', '.container', () => { 
        page = parseInt($('#page').val());
        var max_page = parseInt($('#max_page').val());
        if(page > max_page) {
            
        }else{
            getPosts(page, token, status);
        }   
    });
}

function getPosts(page, token, status){
 
   var user_id = $('#hidUserId').val();

    $.ajax({
        type: "GET",
        url: "/api/basic-package-redeem-history?memberid=" + user_id + "&page=" + page + "&status=" + status,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            //console.log(data);
            var current_page = parseInt(data.records.current_page);
            var last_page = parseInt(data.records.last_page);
            $('#max_page').val(last_page);
            var records = data.records;
            var html = populateData(records, token);

            if(current_page == 1){
                $('#'+ status +'-tab').html(html);
            } else {
                $('#'+ status +'-tab').append(html);
            }

            if ((records.data == '' || records.data == null) && current_page == 1) {
                $(".isnext").html('');
            } else {
                if(current_page == last_page){
                    $(".isnext").html(end_of_result);
                }
            }

            page++;
            $('#page').val(page);
        }
    });
}

function populateData(records, token) {

            var current_page = parseInt(records.current_page);
            var last_page = parseInt(records.last_page);
            var limit = parseInt(records.per_page);
            var counter = (current_page - 1) * limit;
            var result = records.data;
            var html = '';

            if(page_count != page && current_page == page){
                return false;
            }

            console.log(page_count + ":" + current_page);
            page_count++;

            $.each(result, function(i, item) {
                counter += 1;

                var t = item.created_at.split(/[- :]/);
                var date = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                var str_date = date.getFullYear() + "-" + ("0"+(date.getMonth()+1)).slice(-2) + "-" + ("0" + date.getDate()).slice(-2) + " " + 
                                ("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2);
                
                if(item.redeem_state == 3){
                    var str_status = "开通成功";
                    var str_class = "successful";

                } else if (item.redeem_state == 1) {
                    var str_status = "等待开通";
                    var str_class = "pending";

                } else {
                    var str_status = "开通失败";
                    var str_class = "fail";
                }

                var bprice = Math.trunc((item.buy_price != null) ? item.buy_price : 0);
                
                html += '<div class="row">' +
                            '<div class="col-xs-8 column-1">' +
                                '<div class="item">购买' + item.package_name + '幸运转盘</div>' +
                                '<div class="date">购买时间：' + str_date + '</div>';
                                if(str_class == 'fail' && item.reject_notes != ''){
                                    html += '<div class="reason">原因：' + item.reject_notes + '</div>';
                                }
                            html += '</div>' +
                            '<div class="col-xs-4 column-2">' +
                                '<div class="right-wrapper">' +
                                    '<div class="status">' +
                                        '<span class="' + str_class + '">'+ str_status +'</span>' +
                                    '</div>' +
                                    '<div class="additional">'+ bprice +' 元</div>';
                                    if(str_class == 'fail'){
                                        html += '<a href="/purchase"><div class="btn-purchase">再次购买</div></a>';
                                    }
                                html += '</div>' +
                            '</div>' +
                        '</div>';
            });

            if(current_page == 1 && last_page == 1 && html === '') {
                html = '<div class="row-full">' + 
                            '<div class="col-xs-12">' + 
                                '<div class="empty">你还没开通幸运转盘场次<br><a href="/share" class="share-link">邀请好友送场次></a></div>' + 
                            '</div>' + 
                        '</div>';
            }

            return html;

}
