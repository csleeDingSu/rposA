var totalNum = 0;
var pageId = 1;
var pageSize = 50;

document.onreadystatechange = function () {
  var state = document.readyState
  if (state == 'interactive') {
  } else if (state == 'complete') {
    setTimeout(function(){
        document.getElementById('interactive');
        document.getElementById('loading').style.visibility="hidden";
    },100);
  }
}

  $(document).ready(function () {
    if ($('#search').val() != "") {
      console.log('1');
      goSearch(pageId);       
    } else {
      //getFromTabao(pageId);
    }

    //execute scroll pagination
    being.scrollBottom('.scrolly', '.listBox', () => {   
      pageId = ($('#hidPageId').val() == '') ? 1 : $('#hidPageId').val();
      console.log('scrollBottom - ' + pageId)
        if ($('#search').val() != "") {
          console.log('2');
          goSearch(pageId);
        } else {
          // getFromTabao(pageId);
        }
      
    });

});

  function goSearch(pageId) {
    var search = $('#search').val();
    if (pageId == 'undefined' || pageId == undefined) {
      pageId = 1;
    }

    // console.log(search);
    // console.log(pageSize);
    // console.log(pageId);

      var html = '';

      if (search != "") {
        document.getElementById('loading').style.visibility="visible";
        $.ajax({
            type: 'GET',
            // url: "/tabao/list-super-goods?search=" + search + "&pageSize=" + pageSize + "&pageId=" + pageId, 
            // url: "/tabao/get-dtk-search-goods?search=" + search + "&pageSize=" + pageSize + "&pageId=" + pageId, 
            url: "/tabao/get-tb-service?search=" + search + "&pageSize=" + pageSize + "&pageId=" + pageId, 
            contentType: "application/json; charset=utf-8",
            dataType: "text",
            error: function (error) {
                console.log(error);
                // alert(error.responseText);
                // alert('请重新刷新');
                // $(".reload").show();
                html += '<ul class="no-connection-list">' +
                            '<li>' +
                              '<div class="no-connection-background">' +
                                '<img src="/clientapp/images/no-connection/no-internet.png" />' +
                              '</div>' +
                            '</li>' +
                            '<li class="line1">网络竟然崩溃了</li>' +
                            '<li class="line2">别紧张，重新刷新试试</li>' +
                            '<div class="btn-refresh">重新刷新</div>' +
                          '</ul>';
                  
                  $('.btn-refresh').click(function() {
                    goSearch(1);
                  });

                  $('.listBox').html(html);
                  $(".reload").show();
            },
            success: function(data) {

                document.getElementById('loading').style.visibility="hidden";
                // alert(data == '');
                // alert(jQuery.isEmptyObject(JSON.parse(data)));
                 // console.log(data);
                // console.log(JSON.parse(data));
                // console.log(JSON.parse(data).data);
                // console.log(JSON.parse(data).data === "undefined");
                // console.log(JSON.parse(data).data);
                // console.log(JSON.parse(data));
                if (data.length <= 0) {
                  console.log('124');

                  html += '<div class="no-record">' +
                            '<img src="/clientapp/images/no-record/search.png">' +
                            '<div>无搜索商品，请尝试其他关键字</div>' +
                          '</div>';

                  $('.listBox').html(html);
                  return false; 
                }

                _data = JSON.parse(data);
                // console.log(_data);
                console.log(_data.code);
                if (_data.code != 0){

                  html += '<div class="no-record">' +
                            '<img src="/clientapp/images/no-record/search.png">' +
                            '<div>无搜索商品，请尝试其他关键字</div>' +
                          '</div>';
                  // html += '<ul class="no-connection-list">' +
                  //           '<li>' +
                  //             '<div class="no-connection-background">' +
                  //               '<img src="/clientapp/images/no-connection/no-internet.png" />' +
                  //             '</div>' +
                  //           '</li>' +
                  //           '<li class="line1">网络竟然崩溃了</li>' +
                  //           '<li class="line2">别紧张，重新刷新试试</li>' +
                  //           '<div class="btn-refresh">重新刷新</div>' +
                  //         '</ul>';
                  // $('.btn-refresh').click(function() {
                  //   goSearch(1);
                  // });

                } else {

                  var records = (typeof _data.data.list == 'undefined') ? _data.data : _data.data.list;
                  // console.log(records);
                  var newPrice = 0; 
                  var sales = 0;
                  totalNum = JSON.parse(data).data.totalNum;
                  // $('#hidPageId').val(JSON.parse(data).data.pageId);
                  // $('#hidPageId').val(Number(JSON.parse(data).data.pageId) + 1);

                  // pageId = $('#hidPageId').val();
                 
                    $.each(records, function(i, item) {
                      originalPrice = (typeof item.originalPrice == 'undefined') ? item.reserve_price : item.originalPrice;
                      couponPrice = (typeof item.couponPrice == 'undefined') ? item.coupon_amount : item.couponPrice;
                      monthSales = (typeof item.monthSales == 'undefined') ? item.tk_total_sales : item.monthSales;
                      goodsId = (typeof item.goodsId == 'undefined') ? item.item_id : item.goodsId;
                      mainPic = (typeof item.mainPic == 'undefined') ? item.pict_url : item.mainPic;
                      title = item.title;
                      couponLink = (typeof item.couponLink == 'undefined') ? item.coupon_id : item.couponLink;
                      id = (typeof item.id == 'undefined') ? item.item_id : item.id;

                      newPrice = getNumeric(Number(originalPrice) - Number(couponPrice) - Number(12));
                      newPrice = (newPrice > 0) ? newPrice : 0;
                      sales = (Number(monthSales) >= 1000) ? parseFloat(Number(monthSales) / 10000).toFixed(1) + '万' : Number(monthSales) + '件';
                      reward = parseInt(newPrice * 10);
                      reward = (reward <= 0) ? '100' : reward;
                      _param = '?id=' + item.id + '&goodsId='+ goodsId +'&mainPic='+mainPic+'&title='+title+'&monthSales=' + monthSales +'&originalPrice=' +originalPrice+'&couponPrice=' +couponPrice + '&couponLink=' + encodeURIComponent(couponLink) + '&voucher_pass=';
            
                      // console.log(item.couponLink + 'dsad' + i);
                      // return item.couponLink;

                      html += '<div class="inBox">' +
                                '<div class="imgBox">' +
                                  // '<a href="https://t.asczwa.com/taobao?backurl=' + item.itemLink + '">' +
                                  '<a href="/main/product/detail' + _param +'">' +  
                                  '<img src="'+mainPic+'">' +
                                  '</a>'+
                                '</div>' +
                                '<div class="txtBox flex1">' +
                                  '<h2 class="name">'+title+'</h2>' +
                                  '<div class="typeBox">' +
                                    '<span class="type-red">'+couponPrice+'元</span>' +
                                    '<span class="type-sred">奖励'+reward+'积分</span>' +
                                    '<span class="type-blue">抽奖补贴12元</span>' +
                                  '</div>' +
                                  '<div class="moneyBox">' +
                                    '<p class="icon">¥</p>' +
                                    '<p class="nowTxt">'+ newPrice +'</p>' +
                                    '<p class="oldTxt"><em class="fs">¥</em>'+originalPrice+'</p>' +
                                    '<p class="num">热销'+ sales +'万</p>' +
                                  '</div>' +
                                '</div>' +
                              '</div>';
                    });
                }                
            
              if (pageId == 1) {

                $('.listBox').html(html); 
              } else {
                $('.listBox').append(html); 
              }

               pageId++;
              $('#hidPageId').val(pageId);
              console.log(pageId);
              // console.log($('#hidPageId').val());


            }
        });  
      
      } else {
        alert('请输入产品');
      }

    }

function getFromTabao(pageId){
  var html = '';
  $.ajax({
      type: 'GET',
      url: "/tabao/get-goods-list?pageSize=" + pageSize + "&pageId=" + pageId, 
      contentType: "application/json; charset=utf-8",
      dataType: "text",
      error: function (error) {
          console.log(error);
          alert(error.responseText);
          $(".reload").show();
      },
      success: function(data) {
          // console.log(data);
          // console.log(JSON.parse(data).data.list);
          var records = JSON.parse(data).data.list;
          var newPrice = 0; 
          var sales = 0;
          totalNum = JSON.parse(data).data.totalNum;
          
          $.each(records, function(i, item) {
            oldPrice = parseFloat(item.originalPrice).toFixed(2);
            newPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice) - Number(12));
            newPrice = (newPrice > 0) ? newPrice : 0;
            sales = parseFloat(Number(item.couponTotalNum) / 10000).toFixed(1);

            html += '<div class="inBox">' +
            '<div class="imgBox">' +
              '<a href="https://t.asczwa.com/taobao?backurl=' + item.itemLink + '">' + 
                '<img src="'+item.mainPic+'">' +
              '</a>' +
            '</div>' +
            '<div class="txtBox flex1">' +
              '<h2 class="name">'+item.title+'</h2>' +
              '<div class="typeBox">' +
                '<span class="type-red">'+item.couponPrice+'元券</span>' +
                '<span class="type-sred">奖励100积分</span>' +
                '<span class="type-blue">抽奖补贴12元</span>' +
              '</div>' +
              '<div class="moneyBox">' +
                '<p class="icon">¥</p>' +
                '<p class="nowTxt">'+ newPrice +'</p>' +
                '<p class="oldTxt"><em class="fs">¥</em>'+oldPrice+'</p>' +
                '<p class="num">热销'+ sales +'万</p>' +
              '</div>' +
            '</div>' +
          '</div>';
        });

        if (pageId == 1) {
          $('.listBox').html(html); 
        } else {
          $('.listBox').append(html); 
        }

        $('#hidPageId').val(JSON.parse(data).data.pageId);
        pageId = $('#hidPageId').val();
        console.log(pageId);
          
      }
  });
}

  function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
  }
