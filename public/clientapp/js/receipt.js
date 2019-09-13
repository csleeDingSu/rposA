var wallet_point =0;
var gameid = 102;
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
            getWallet(data.access_token, id);
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
    var html = '';

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
            $.each(records, function(i, item) {          
            html += '<li>' +
                        '<h2><span>订单号&nbsp;'+item.receipt+'</span>';
                        if (item.status == 1) {
            html +=         '<font color="#a144ff">正在处理</font>';                
                        }else if (item.status == 2) {
            html +=         '<font color="#a144ff">奖励到账</font>';                
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

                      '</li>';
        
            });

            $('.data-list').html(html);
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
                       getReceiptList(token, memberid);
                        
                    } else {
                        alert(data.message);
                    }
                }
            });
        }
    });
}
