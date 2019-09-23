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
          getFromTabao(pageId);
        }
      
    });

});

  function goSearch(pageId) {
    var search = $('#search').val();
    if (pageId == 'undefined' || pageId == undefined) {
      pageId = 1;
    }

    console.log(search);
    console.log(pageSize);
    console.log(pageId);

      var html = '';

      if (search != "") {
        document.getElementById('loading').style.visibility="visible";
        $.ajax({
            type: 'GET',
            url: "/tabao/list-super-goods?search=" + search + "&pageSize=" + pageSize + "&pageId=" + pageId, 
            contentType: "application/json; charset=utf-8",
            dataType: "text",
            error: function (error) {
                console.log(error);
                alert(error.responseText);
                $(".reload").show();
            },
            success: function(data) {
                document.getElementById('loading').style.visibility="hidden";
                // alert(data == '');
                // alert(jQuery.isEmptyObject(JSON.parse(data)));
                 // console.log(data);
                // console.log(JSON.parse(data).data.list);
                if ((data == '') || (jQuery.isEmptyObject(JSON.parse(data))) || (JSON.parse(data).data.list == undefined) || (JSON.parse(data).data.list == '') || (typeof JSON.parse(data).data.list === 'undefined')){

                  html += '';

                } else {

                  var records = JSON.parse(data).data.list;
                  var newPrice = 0; 
                  var sales = 0;
                  totalNum = JSON.parse(data).data.totalNum;
                  // $('#hidPageId').val(JSON.parse(data).data.pageId);
                  // $('#hidPageId').val(Number(JSON.parse(data).data.pageId) + 1);

                  // pageId = $('#hidPageId').val();
                 
                    $.each(records, function(i, item) {

                      newPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice) - Number(12));
                      newPrice = (newPrice > 0) ? newPrice : 0;
                      sales = parseFloat(Number(item.couponTotalNum) / 10000).toFixed(1);
                      console.log(item.couponLink + 'dsad' + i);
                      // return item.couponLink;

                      html += '<div class="inBox">' +
                                '<div class="imgBox">' +
                                  '<a href="https://t.asczwa.com/taobao?backurl=' + item.itemLink + '">' + 
                                  '<img src="'+item.mainPic+'">' +
                                  '</a>'+
                                '</div>' +
                                '<div class="txtBox flex1">' +
                                  '<h2 class="name">'+item.title+'</h2>' +
                                  '<div class="typeBox">' +
                                    '<span class="type-red">'+item.couponPrice+'元</span>' +
                                    '<span class="type-sred">奖励100积分</span>' +
                                    '<span class="type-blue">抽奖补贴12元</span>' +
                                  '</div>' +
                                  '<div class="moneyBox">' +
                                    '<p class="icon">¥</p>' +
                                    '<p class="nowTxt">'+ newPrice +'</p>' +
                                    '<p class="oldTxt"><em class="fs">¥</em>'+item.originalPrice+'</p>' +
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
