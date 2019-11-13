var token = null;
var page=1;
var _nextpg = page;
var url = '';
var bScroll = false;

$('#hidPg').val(page);
$('#hidNextPg').val(_nextpg);

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
        page = 1;
        getAll(token);

  });

  $('.redeem').click(function(){
        $('.all').removeClass('on');
        $('.redeem').addClass('on');
        $('.recharge').removeClass('on');
        $('.resell').removeClass('on');
        $('#filter').css('display', 'none');
        page = 1;
        getRedeem(token);
        // getSummary(token);
  });

  $('.recharge').click(function(){
        $('.all').removeClass('on');
        $('.redeem').removeClass('on');
        $('.recharge').addClass('on');
        $('.resell').removeClass('on');
        $('#filter').css('display', 'none');
        page = 1;
        getRecharge(token);
  });

  $('.resell').click(function(){
        $('.all').removeClass('on');
        $('.redeem').removeClass('on');
        $('.recharge').removeClass('on');
        $('.resell').addClass('on');
        $('#filter').css('display', 'none');
        page = 1;
        getResell(token);
  });

  //execute scroll pagination
  being.scrollBottom('.scrolly', '.scrollpg', () => {
    // console.log('new page ' + page);
    var current_page = parseInt($('#hidPg').val());
    console.log('current page ' + current_page);
    var next_page = parseInt($('#hidNextPg').val());
    console.log('next page ' + next_page);
    page = ($('#hidNextPg').val() == '') ? 1 : $('#hidNextPg').val();
    if (current_page != page) {
      getList(page);  
    }
    
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
            document.getElementById('loading2').style.visibility="hidden";
        } else {
          document.getElementById('loading2').style.visibility="hidden";
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
     //console.log(results);
    var length = results.length;
    var html = '';
    var _nodata = '暂无明细';

    if (page == 1) {
      $('#summary').html('');  
    }

    $.each(results, function(key, value){
        //console.log(value.created_at);
        var type = value.type;
        // console.log(type);

        //type => softpin,buyproduct,topup,merge,creditresell,buyer
        if (type == 'creditresell') {
          html += Resell_html(value);
          _nodata = '暂无转卖';
        } else if (type == 'buyer') {
          html += Recharge_html(value);
          _nodata = '暂无充值';
        } else {
          html += Summary_html(value);
          _nodata = '暂无兑换';
        }        
        
    });            

    if (html == '' || length === 0) {

        html =   '<div class="no-record">' +
                    '<img src="/clientapp/images/no-record/summary.png">' +
                    '<div>' + _nodata + '</div>' +
                  '</div>';

    }

    $('#summary').append(html);
    document.getElementById('loading2').style.visibility="hidden";

}

function Summary_html(value) {
  var html = '';
  var str_type = '';
  var str_points = '';

  var t = value.created_at.split(/[- :]/);
  var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
  var str_date =    d.getFullYear() + "-" + ("0"+(d.getMonth()+1)).slice(-2) + "-" + ("0" + d.getDate()).slice(-2) + " " + 
                      ("0" + d.getHours()).slice(-2) + ":" + ("0" + d.getMinutes()).slice(-2);
  
  var txt_amount = getNumeric(value.balance_before);
  var txt_reason = '';
  var _fontcolor = '#3d3d3d';

  switch(value.ledger_type){
      case 'CRPNT':
      break;
      case 'APMNT':
          str_type = '游戏收益结算';
          str_points = '+' + getNumeric(value.credit) + '挖宝币';   
          _fontcolor = '#3d3d3d';             
      break;

      case 'DPRPO':
          str_type = '兑换话费卡';
          str_points = '-' + getNumeric(value.debit) + '挖宝币';
          _fontcolor = '#12bf00';
      break;

      case 'DPBVP':
          str_type = '兑换VIP入场券';
          str_points = '-' + getNumeric(value.debit) + '挖宝币';
          _fontcolor = '#12bf00';                   
      break;

      case 'DPRBP': //redeem / buy product
          str_type = '兑奖-' + value.package_name; //value.title;
          str_points = '-' + getNumeric(value.debit) + '挖宝币';
          _fontcolor = '#3d3d3d';
      break

      case 'APACP': //top up
          str_type = '充值挖宝币';
          str_points = '+' + getNumeric(value.credit) + '挖宝币';
          _fontcolor = '#3d3d3d';
      break

      case 'APRBP': //refund
          str_type = '退还挖宝币-' + value.reject_notes;
          str_points = '+' + getNumeric(value.credit) + '挖宝币';
          _fontcolor = '#3d3d3d';
      break

      case 'APPAA': //refund
          _gameid = value.game_id;
          if (_gameid == '103') {//only show vip
            _gamelbl = ''; //(_gameid == '102') ? '(普通版)' : '(高级版)';
            if (Number(value.credit) >= 0) {
                str_type = '系统加款' + _gamelbl;
                str_points = '+' + getNumeric(value.credit) + '挖宝币';
                _fontcolor = '#3d3d3d';    
            } else {
                str_type = '系统扣款' + _gamelbl;
                str_points = '-' + getNumeric(value.debit) + '挖宝币';
                _fontcolor = '#3d3d3d';
            }  
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

  return html;

}

function Resell_html(item){
  var html ='';
  var txt_point = '';
  var txt_status = '';
  var txt_when = '';
  var txt_amount = '';
  var txt_reason = '';
  var _url = '';
  var _cls = '';
  var _fontcolor = '';

  txt_point = item.used_point;
  txt_when = item.created_at;
  txt_amount = item.amount;
  _url = '/coin/list/detail/' + item.id;

  if (item.status_id == 1) {
    txt_status = '已提交审核'; //'订单已提交';  
    _cls = 'payReady';
    _fontcolor = '#6ac2ff';                        
  } else if (item.status_id == 2 && item.is_locked != 1) {
    txt_status = '正在匹配买家';  
    _cls = 'payReady';
    _fontcolor = '#6ac2ff';
  } else if (item.status_id == 2 && item.is_locked == 1) {
    _buyer = item.buyer; 
    _phone = (_buyer != null) ? _buyer.phone : '';
    _phone = (_phone != '') ? (_phone.substring(0,3) + '*****' + _phone.slice(-4)) : '';
    txt_status = '买家正在付款'; //'已匹配到买家 ' + _phone;
    _cls = 'payIng';
    _fontcolor = '#ffa200';                        
  } else if (item.status_id == 3) {
    _buyer = item.buyer; 
    _phone = (_buyer != null) ? _buyer.phone : '';
    _phone = (_phone != '') ? (_phone.substring(0,3) + '*****' + _phone.slice(-4)) : '';
    txt_status = '买家已付款'; //'已匹配到买家 ' + _phone;
    _cls = 'payIng';
    _fontcolor = '#ffa200';
  } else if (item.status_id == 4) {
    txt_status = '交易成功'; //'买家付款完成';
    _cls = 'payOver';
    _fontcolor = '#51c000';
  } else if (item.status_id == 5) {
    return html = '';
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
            '<h2><span>转卖' +parseInt(txt_point)+ '挖宝币</span>' +
              '<font color="'+_fontcolor+'">' + txt_status + '</font>' +
            '</h2>' +
            '<p><span>' + txt_when +'</span>' +
              '<font color="#686868">售价&nbsp;'+parseInt(txt_amount)+'元</font>' +
            '</p>';
  //         if (txt_reason != '') {
  // html +=   '<h3>失败原因：' +txt_reason+ '</h3>';  
  //         }                                  
  html += '</a>';

  return html;
}

function Recharge_html(item){
  var html ='';
  var txt_point = '';
  var txt_status = '';
  var txt_when = '';
  var txt_amount = '';
  var txt_reason = '';
  var _url = '';
  var _cls = '';
  var _fontcolor = '';
  var countdown = '';

  txt_point = item.used_point;
  txt_when = item.created_at;
  txt_amount = item.amount;

  _url = '/recharge/list/detail/' + item.id;

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
    txt_status = '等待付款确认'; //'等待卖家发币';
    // _cls = 'payIng';
    _fontcolor = '#6ac2ff';
  } else if (item.status_id == 4) {
    txt_status = '交易成功'; //'卖家已发币';
    // _cls = 'payOver';
    _fontcolor = '#23ca27';
  } else if (item.status_id == 5) {
    txt_status = '交易失败'; //'发布失败';
    txt_reason = '付款超时';
    // _cls = 'payFail';
    _fontcolor = '#ff8282';
  } else if (item.status_id == 7) {
    txt_status = '交易失败'; //'拒绝退回';
    txt_reason = item.reason;
    // _cls = 'payFail';
    _fontcolor = '#ff8282';
  }

  if (_url != '') {
  html += '<a class="inBox '+_cls+'" href="'+_url+'">';  
  }else{
    html += '<a class="inBox '+_cls+'">';
  }
  
  // console.log(txt_point);
  // console.log((Number(txt_point) >= 100000) && (countdown != ''));
  if ((Number(txt_point) >= 100000) && (countdown != '')) {
    html += '<h2><span style="font-size: 14px !important;">充值' +parseInt(txt_point)+ '挖宝币</span>';
  } else {
    html += '<h2><span>充值' +parseInt(txt_point)+ '挖宝币</span>';
  }
  
  
  if (countdown != '') {
    html += '<span><span class="countdown">请在'+countdown+'内完成付款</span><span class="btn-go-recharge" id="btn-go-'+item.id+'">去付款</span></span>';  
  }  else {
    html += '<font color="'+_fontcolor+'">' + txt_status + '</font>';
  }
              
    html += '</h2>' +
            '<p><span>' + txt_when +'</span>' +
              '<font color="#686868">充值&nbsp;'+parseInt(txt_amount)+'元</font>' +
            '</p>';
  // if (txt_reason != '') {
  //   html += '<h3>失败原因：' +txt_reason+ '</h3>';  
  // }                           
  
  html += '</a>'; 

  return html;

}

function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) + 0 : Number(parseInt(value)) + 0;
  }

function getAll(token) {
  var user_id = $('#hidUserId').val();
  _url = "api/get-summary-new?memberid=" + user_id;
  url = _url;
    
    // if (page == 1) {
      document.getElementById('loading2').style.visibility="visible";
    // }

    $.ajax({
        type: 'GET',
        url: _url,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error);
            document.getElementById('loading2').style.visibility="hidden";
        },
        success: function(data) {
          console.log('dasdsad');
            document.getElementById('loading2').style.visibility="hidden";
            showSummary(data.records.data);
            _nextpg = (Number(data.records.last_page) > Number(page)) ? (Number(page) + 1) : ((Number(data.records.last_page) == Number(page)) ? page : 1) 
            console.log(_nextpg);
            $('#hidNextPg').val(_nextpg);
            
        }
    });
}

function getRedeem(token) {
  var user_id = $('#hidUserId').val();
  // _url = "api/get-summary-new?memberid=" + user_id + "&type=topup";
  // _url = "api/get-summary-new?memberid=" + user_id;
  _url = "api/get-summary-new?memberid=" + user_id + "&type="+encodeURIComponent("softpin,buyproduct");
  url = _url;

  // if (page == 1) {
      document.getElementById('loading2').style.visibility="visible";
    // }
    
    $.ajax({
        type: 'GET',
        url: _url,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
        },
        error: function (error) { 
            console.log(error);
            document.getElementById('loading2').style.visibility="hidden";
        },
        success: function(data) {
            showSummary(data.records.data);
            _nextpg = (Number(data.records.last_page) > Number(page)) ? (Number(page) + 1) : ((Number(data.records.last_page) == Number(page)) ? page : 1) 
            console.log(_nextpg);          
            $('#hidNextPg').val(_nextpg);
            document.getElementById('loading2').style.visibility="hidden";
        }
    });
}

function getRecharge(token) {
    document.getElementById('loading2').style.visibility="visible";
    var memberid = $('#hidUserId').val();   
    _url = "api/get-summary-new?memberid=" + memberid + "&type=buyer";
    url = _url;  

    $.ajax({
          type: 'GET',
          //url: "/api/buyer-list",          
          // data: { 'memberid': memberid },
          url: _url,
          dataType: "json",
          beforeSend: function( xhr ) {
              xhr.setRequestHeader ("Authorization", "Bearer " + token);
          },
          error: function (error) { 
              document.getElementById('loading2').style.visibility="hidden";
              console.log(error.responseText);
              alert('下载失败，重新刷新试试');
            },                  
          success: function(data) {
            document.getElementById('loading2').style.visibility="hidden";
            showSummary(data.records.data);
            _nextpg = (Number(data.records.last_page) > Number(page)) ? (Number(page) + 1) : ((Number(data.records.last_page) == Number(page)) ? page : 1) 
            console.log(_nextpg);
            $('#hidNextPg').val(_nextpg);
          }
      });      
}

function getResell() {

    document.getElementById('loading2').style.visibility="visible";
    
    var memberid = $('#hidUserId').val();   
    _url = "api/get-summary-new?memberid=" + memberid + "&type=creditresell"; 
    url = _url;  

    $.ajax({
          type: 'GET',
          // url: "/api/resell-list",
          // data: { 'memberid': memberid },
          url: _url,
          dataType: "json",
          beforeSend: function( xhr ) {
              xhr.setRequestHeader ("Authorization", "Bearer " + token);
          },
          error: function (error) { 
              document.getElementById('loading2').style.visibility="hidden";
              console.log(error.responseText);
              alert('下载失败，重新刷新试试');
            },                  
          success: function(data) {
            document.getElementById('loading2').style.visibility="hidden";
            showSummary(data.records.data);
            _nextpg = (Number(data.records.last_page) > Number(page)) ? (Number(page) + 1) : ((Number(data.records.last_page) == Number(page)) ? page : 1) 
            console.log(_nextpg);
            $('#hidNextPg').val(_nextpg);
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

function getList(page) {
  var user_id = $('#hidUserId').val();
  page = (page > 0 ? page : 1);
  url = (url == '') ? "api/get-summary-new?memberid=" + user_id : url;
  _url = url + "&page=" + page;
  
  if (bScroll) { //is searching in progress
      console.log('previous job in progress');
      return false;
    }

    bScroll = true;

    $.ajax({
        type: 'GET',
        url: _url,
        dataType: "json",
        beforeSend: function( xhr ) {
            xhr.setRequestHeader ("Authorization", "Bearer " + token);
            bScroll = false;
        },
        success: function(data) {
          bScroll = false;
          showSummary(data.records.data);
          $('#hidPg').val(page);
          _nextpg = (Number(data.records.last_page) > Number(page)) ? (Number(page) + 1) : ((Number(data.records.last_page) == Number(page)) ? page : 1) 
          console.log(_nextpg);
          $('#hidNextPg').val(_nextpg);
          // page++;
        }
    });
}