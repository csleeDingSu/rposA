var wallet_point =0;
var gameid = 102;
var earned_point = Number(0);
var earned_play_times = Number(0);
var default_exchange_point = Number(12);

$(document).ready(function () {
    getToken();     
});

function getToken(){
    var id = $('#hidUserId').val();
    var session = $('#hidSession').val();

    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            token = data.access_token;
            // getWallet(data.access_token, id);
            getReceiptList(data.access_token, id);
            AssignSubmitReceipt(data.access_token);            
        }      
    });
}

function getWallet(token, id) {
    $.ajax({
        type: 'POST',
        url: "/api/wallet-detail?gameid="+gameid+"&memberid=" + id, 
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
            $('.wallet_point').html(wallet_point);
        }
    });
}

function getReceiptList(token, id) {
    $.ajax({
        type: 'GET',
        url: "/api/list-receipt?memberid=" + id, 
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { console.log(error) },
        success: function(data) {
            console.log(data); 
            records = data.records;
            populateHtml(records);      
        } // end success
    }); // end $.ajax
}
  
function AssignSubmitReceipt(token) {
    $('.sendBtn').click(function() {
        var receipt = $('#receipt').val();
        var memberid = $('#hidUserId').val();

        if (receipt == '') {
            alert('请填写订单号');
        } else {

            $.ajax({
                type: 'POST',
                url: "/api/add-receipt",
                data: { 'memberid': memberid, 'receipt': receipt},
                dataType: "json",
                beforeSend: function( xhr ) {
                    xhr.setRequestHeader ("Authorization", "Bearer " + token);
                },
                error: function (error) { console.log(error.responseText) },
                success: function(data) {
                    if(data.success) {
                        
                        alert('提交成功');
                        $('#receipt').val('');
                       getReceiptList(token, memberid);
                        
                    } else {
                        alert(data.message);
                    }
                }
            });
        }
    });
}

function populateHtml(records) {
    var html = '';
    earned_point = 0;
    $.each(records, function(i, item) {          
    html += '<li id=r_"'+item.id+'">' +
                '<h2><span>订单号&nbsp;'+item.receipt+'</span>';
                if (item.status == 1) {
    html +=         '<font color="#a144ff">正在处理</font>';                
                }else if (item.status == 2) {
    html +=         '<font color="#a144ff">奖励到账</font>';
                    earned_point = Number(parseInt(earned_point)) + Number(parseInt(item.amount));

                }else if (item.status == 3) {
    html +=         '<font color="#ff6161">奖励失效</font>';                
                }else {
    html +=         '<font color="#ff6161">订单号无效</font>';                
                }            
    html +=     '</h2>';

                if (item.status == 2) {
    html +=         '<p><span>'+item.updated_at+'</span><font color="#ff6161">+'+parseInt(item.amount)+'</font></p>';           
                }else {
    html +=         '<p><span>'+item.updated_at+'</span></p>';              
                }

              '</li>';

    });

    if (html != '') {
        $('.data-list').html(html);
        $('.earned_point').html(earned_point);
        earned_play_times = parseInt(earned_point / default_exchange_point);
        earned_play_times = (earned_play_times > 1) ? earned_play_times : 0;
        $('.earned_play_times').html(earned_play_times);    
    }
}

function populateHtmlSocket (item) {
    console.log(item);
    var html = '';
    earned_point = parseInt($('.earned_point').html());

    html += '<h2><span>订单号&nbsp;'+item.receipt+'</span>';
                if (item.status == 1) {
    html +=         '<font color="#a144ff">正在处理</font>';                
                }else if (item.status == 2) {
    html +=         '<font color="#a144ff">奖励到账</font>';
                    earned_point = Number(parseInt(earned_point)) + Number(parseInt(item.amount));

                }else if (item.status == 3) {
    html +=         '<font color="#ff6161">奖励失效</font>';                
                }else {
    html +=         '<font color="#ff6161">订单号无效</font>';                
                }            
    html +=     '</h2>';

                if (item.status == 2) {
    html +=         '<p><span>'+item.updated_at+'</span><font color="#ff6161">+'+item.amount+'</font></p>';           
                }else {
    html +=         '<p><span>'+item.updated_at+'</span></p>';              
                }

    if (html != '') {
        $('#_'+data.id).html(html);
        $('.earned_point').html(earned_point);
        earned_play_times = parseInt(earned_point / default_exchange_point);
        earned_play_times = (earned_play_times > 1) ? earned_play_times : 0;
        $('.earned_play_times').html(earned_play_times);    
    }
}
