var token = null;

$(document).ready(function () {
  $('.card-body').addClass('bgf3');
  $('#filter').css('display', 'none');
  $('.FilterBtn').click(function() {
    $('#filter').css('display', 'block');
  });
  
  $('.all').click(function(){
        $('.all').addClass('on');
        $('.redeem').removeClass('on');
        $('.recharge').removeClass('on');
        $('.resell').removeClass('on');
        $('#filter').css('display', 'none');
        getAll(token);

  });

  $('.redeem').click(function(){
        $('.all').removeClass('on');
        $('.redeem').addClass('on');
        $('.recharge').removeClass('on');
        $('.resell').removeClass('on');
        $('#filter').css('display', 'none');
        // getRedeem();
        getSummary(token);
  });

  $('.recharge').click(function(){
        $('.all').removeClass('on');
        $('.redeem').removeClass('on');
        $('.recharge').addClass('on');
        $('.resell').removeClass('on');
        $('#filter').css('display', 'none');
        getRecharge();
  });

  $('.resell').click(function(){
        $('.all').removeClass('on');
        $('.redeem').removeClass('on');
        $('.recharge').removeClass('on');
        $('.resell').addClass('on');
        $('#filter').css('display', 'none');
        getResell();
  });

    getToken();    

});

function getToken(){

    var id = $('#hidUserId').val();
    var session = $('#hidSession').val();
    $.getJSON( "/api/gettoken?id=" + id + "&token=" + session, function( data ) {
        //console.log(data);
        if(data.success) {
            token = data.access_token;
            $('#hidSession').val(session);
            getAll(data.access_token);
        } else {
        }
    });
}

function getSummary(token) {
    var user_id = $('#hidUserId').val();
    _url = "api/get-summary-new?memberid=" + user_id;
    
    $.ajax({
        type: 'GET',
        url: _url,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        success: function(data) {
            showSummary(data.records.data);
        }
    });
}

 function showSummary(results) {
    // console.log(results);
    var length = results.length;
    var html = '';
    $('#summary').html('');

    $.each(results, function(key, value){
        //console.log(value);
        var str_type = '';
        var str_points = '';

        var t = value.created_at.split(/[- :]/);
        var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
        var str_date =    d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + 
                            ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
        
        var txt_amount = getNumeric(value.balance_before);
        var txt_reason = '';
        var _fontcolor = '#3d3d3d';

        switch(value.credit_type){
            case 'CRPNT':
            break;
            case 'APMNT':
                str_type = '游戏收益结算';
                str_points = '+' + getNumeric(value.credit) + '元';   
                _fontcolor = '#3d3d3d';             
            break;

            case 'DPRPO':
                str_type = '兑换话费卡';
                str_points = '-' + getNumeric(value.debit) + '元';
                _fontcolor = '#12bf00';
            break;

            case 'DPBVP':
                str_type = '兑换VIP入场券';
                str_points = '-' + getNumeric(value.debit) + '元';
                _fontcolor = '#12bf00';                   
            break;

            case 'DPRBP': //redeem / buy product
                str_type = '兑奖-' + value.title;
                str_points = '-' + getNumeric(value.debit) + '元';
                _fontcolor = '#3d3d3d';
            break

            case 'APACP': //top up
                str_type = '充值挖宝币';
                str_points = '+' + getNumeric(value.credit) + '元';
                _fontcolor = '#3d3d3d';
            break

            case 'APRBP': //refund
                str_type = '退还挖宝币-' + value.reject_notes;
                str_points = '+' + getNumeric(value.credit) + '元';
                _fontcolor = '#3d3d3d';
            break

            case 'APPAA': //refund
                if (Number(value.credit) >= 0) {
                    str_type = '系统加款';
                    str_points = '+' + getNumeric(value.credit) + '元';
                    _fontcolor = '#3d3d3d';    
                } else {
                    str_type = '系统扣款';
                    str_points = '-' + getNumeric(value.debit) + '元';
                    _fontcolor = '#3d3d3d';
                }
                
            break

            
        }

        if (str_type != '') {                     

            html += '<a class="inBox">';                        
            html += '<h2><span>' +str_type+ '</span>';
            html += '<font color="'+_fontcolor+'">' + str_points + '</font>';                                    
            html += '</h2>' +
                      '<p><span>' + str_date +'</span>' +
                        '<font color="#686868">'+txt_amount+'</font>' +
                      '</p>';
            if (txt_reason != '') {
              html += '<h3>失败原因：' +txt_reason+ '</h3>';  
            }
            html += '</a>'; 

        }
        
    });            

    if (html == '' || length === 0) {

        html =   '<div class="no-record">' +
                    '<img src="/clientapp/images/no-record/summary.png">' +
                    '<div>暂无兑奖</div>' +
                  '</div>';

    }

    $('#summary').append(html);
    // document.getElementById('loading2').style.visibility="hidden";

}

function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) + 0 : Number(parseInt(value)) + 0;
  }

function getAll(token) {
  var user_id = $('#hidUserId').val();
  _url = "api/get-summary-new?memberid=" + user_id;
    // _url = "api/get-summary-new?memberid=" + user_id;
    
    $.ajax({
        type: 'GET',
        url: _url,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        success: function(data) {
            showSummary(data.records);
        }
    });
}

function getRedeem() {
    
}

function getRecharge() {
    // document.getElementById('loading2').style.visibility="visible";
    var memberid = $('#hidUserId').val();     

    $.ajax({
          type: 'GET',
          url: "/api/buyer-list",
          data: { 'memberid': memberid },
          dataType: "json",
          beforeSend: function( xhr ) {
              xhr.setRequestHeader ("Authorization", "Bearer " + token);
          },
          error: function (error) { 
              // document.getElementById('loading2').style.visibility="hidden";
              console.log(error.responseText);
              alert('下载失败，重新刷新试试');
            },                  
          success: function(data) {
              var html = '';
              var total = data.result.total;
              var current_page = data.result.current_page;
              console.log(data);

              if (current_page == 1) {
                $('#summary').html('');
              }
              
              if(data.success){
                  $.each(data.result.data, function(i, item) {
                    var txt_point = '';
                    var txt_status = '';
                    var txt_when = '';
                    var txt_amount = '';
                    var txt_reason = '';
                    var _url = '';
                    var _cls = '';
                    var _fontcolor = '';
                    var countdown = '';

                    txt_point = item.point;
                    txt_when = item.updated_at;
                    txt_amount = item.amount;

                    if (item.status_id == 1) {
                      txt_status = '等待付款';  
                      // _cls = 'payIng';
                      _fontcolor = '#6ac2ff'; 
                      getCoundown(item.locked_time, item.id);
                      countdown = '<span class="txt-red" id="'+item.id+'">00:00</span>';   
                      _url = '/recharge/type?credit_resell_id=' + item.id + '&coin=' + txt_point + '&cash=' + txt_amount;                    
                    } else if (item.status_id == 2 && item.is_locked == 1) {
                      txt_status = '等待付款';  
                      // _cls = 'payIng';
                      _fontcolor = '#6ac2ff'; 
                      getCoundown(item.locked_time, item.id);
                      countdown = '<span class="txt-red" id="'+item.id+'">00:00</span>';   
                      _url = '/recharge/type?credit_resell_id=' + item.id + '&coin=' + txt_point + '&cash=' + txt_amount;                    
                    } else if (item.status_id == 2  && item.is_locked != 1) {
                      txt_status = '等待卖家';
                      // _cls = 'payIng';
                      _fontcolor = '#ffa200';
                    } else if (item.status_id == 3) {
                      txt_status = '等待卖家发币';
                      // _cls = 'payIng';
                      _fontcolor = '#6ac2ff';
                    } else if (item.status_id == 4) {
                      txt_status = '卖家已发币';
                      // _cls = 'payOver';
                      _fontcolor = '#23ca27';
                    } else if (item.status_id == 5) {
                      txt_status = '付款超时';
                      txt_reason = '付款超时';
                      // _cls = 'payFail';
                      _fontcolor = '#ff8282';
                    } else if (item.status_id == 7) {
                      txt_status = '拒绝退回';
                      txt_reason = item.reason;
                      // _cls = 'payFail';
                      _fontcolor = '#ff8282';
                    }

                    if (_url != '') {
                    html += '<a class="inBox '+_cls+'" href="'+_url+'">';  
                    }else{
                      html += '<a class="inBox '+_cls+'">';
                    }
                    
                    html += '<h2><span>' +txt_point+ '挖宝币</span>';
                    
                    if (countdown != '') {
                      html += '<span><span class="countdown">请在'+countdown+'内完成付款</span><span class="btn-go-recharge" id="btn-go-'+item.id+'">去付款</span></span>';  
                    }  else {
                      html += '<font color="'+_fontcolor+'">' + txt_status + '</font>';
                    }
                                
                      html += '</h2>' +
                              '<p><span>' + txt_when +'</span>' +
                                '<font color="#686868">充值&nbsp;'+txt_amount+'元</font>' +
                              '</p>';
                    if (txt_reason != '') {
                      html += '<h3>失败原因：' +txt_reason+ '</h3>';  
                    }                           
                    
                    html += '</a>';                          
                  });

                  if ((html == '') && (total <= 0) ) {
                    html =  '<div class="no-record">' +
                              '<img src="/clientapp/images/no-record/redeem-vip.png">' +
                              '<div class="empty">你还没有充值记录<br><a href="/recharge" class="share-link">去充值></a></div>' +
                            '</div>';
                    }

                  $('#summary').append(html);
                  
                  // document.getElementById('loading2').style.visibility="hidden";
              }
          }
      });      
}

function getResell() {

    var memberid = $('#hidUserId').val();    

    $.ajax({
          type: 'GET',
          url: "/api/resell-list",
          data: { 'memberid': memberid },
          dataType: "json",
          beforeSend: function( xhr ) {
              xhr.setRequestHeader ("Authorization", "Bearer " + token);
          },
          error: function (error) { 
              // document.getElementById('loading2').style.visibility="hidden";
              console.log(error.responseText);
              alert('下载失败，重新刷新试试');
            },                  
          success: function(data) {
              var html = '';
               var total = data.result.total;
              var current_page = data.result.current_page;
              console.log(data);

              if (current_page == 1) {
                $('#summary').html('');
              }

              // document.getElementById('loading2').style.visibility="hidden";
              if(data.success){
                  $.each(data.result.data, function(i, item) {
                    var txt_point = '';
                    var txt_status = '';
                    var txt_when = '';
                    var txt_amount = '';
                    var txt_reason = '';
                    var _url = '';
                    var _cls = '';
                    var _fontcolor = '';

                    txt_point = item.point;
                    txt_when = item.updated_at;
                    txt_amount = item.amount;
                    _url = '/coin/list/detail/' + item.id;

                    if (item.status_id == 1) {
                      txt_status = '订单已提交';  
                      _cls = 'payReady';
                      _fontcolor = '#6ac2ff';                        
                    } else if (item.status_id == 2) {
                      txt_status = '正在匹配买家';  
                      _cls = 'payReady';
                      _fontcolor = '#6ac2ff';                        
                    } else if (item.status_id == 3) {
                      _buyer = item.buyer; 
                      _phone = (_buyer != null) ? _buyer.phone : '';
                      _phone = (_phone != '') ? (_phone.substring(0,3) + '*****' + _phone.slice(-4)) : '';
                      txt_status = '已匹配到买家 ' + _phone;
                      _cls = 'payIng';
                      _fontcolor = '#ffa200';
                    } else if (item.status_id == 4) {
                      txt_status = '买家付款完成';
                      _cls = 'payOver';
                      _fontcolor = '#51c000';
                    } else if (item.status_id == 5) {
                      txt_status = '买家付款失败';
                      txt_reason = '付款超时';
                      _cls = 'payFail';
                      _fontcolor = '#ff8282';
                    } else if (item.status_id == 7) {
                      txt_status = '发布失败';
                      txt_reason = item.reason;
                      _cls = 'payFail';
                      _fontcolor = '#ff8282';
                    }

                    html += '<a href="'+_url+'" class="inBox '+_cls+'">' +
                              '<h2><span>' +txt_point+ '挖宝币</span>' +
                                '<font color="'+_fontcolor+'">' + txt_status + '</font>' +
                              '</h2>' +
                              '<p><span>' + txt_when +'</span>' +
                                '<font color="#686868">售价&nbsp;'+txt_amount+'元</font>' +
                              '</p>';
                            if (txt_reason != '') {
                    html +=   '<h3>失败原因：' +txt_reason+ '</h3>';  
                            }                                  
                    html += '</a>';
                  });

                  if ((html == '') && (total <= 0) ) {
                    html =  '<div class="no-record">' +
                              '<img src="/clientapp/images/no-record/redeem-vip.png">' +
                              '<div class="empty">你没有转卖记录<br><a href="/coin" class="share-link">去转卖></a></div>' +
                            '</div>';
                  }
                  
                  $('#summary').append(html);
                  
              }
          }
      });
         
      
}

function getCoundown(_time, id) {
        var t = _time.split(/[- :]/);
        var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
        var countDownDate = new Date(d).getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

          // Get today's date and time
          var now = new Date().getTime();

          // Find the distance between now and the count down date
          var distance = countDownDate - now;

          // Time calculations for days, hours, minutes and seconds
          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          var seconds = Math.floor((distance % (1000 * 60)) / 1000);

          // Display the result in the element with id="demo"
          minutes = minutes <= 9 ? "0" + minutes : minutes;
          seconds = seconds <= 9 ? "0" + seconds : seconds;
          document.getElementById(id).innerHTML = minutes + ":" + seconds;

          // If the count down is finished, write some text
          if (distance < 0) {
            clearInterval(x);
            document.getElementById(id).innerHTML = "00:00";
            $("#btn-go-" + id).off('click');
            $("#btn-go-" + id).css('display','none');
            
          }
        }, 1000);
      }
