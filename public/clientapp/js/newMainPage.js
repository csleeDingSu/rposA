var totalNum = 0;
var pageId = 1;
var pageSize_init = 10;
var pageSize = 10;
var priceLowerLimit = 12;
var priceUpperLimit = 50;
var weChatVerificationStatus = '';
var isNewBie = true;
var life = 0;

$(document).ready(function () {

  pageId = ($('#hidPageId').val() == '') ? 1 : $('#hidPageId').val(); 
  weChatVerificationStatus = $('#hidweChatVerificationStatus').val(); 
  isNewBie = $('#hidgame102UsedPoint').val() > 0 ? false : true;
  life = $('#hidgame102Life').val();

  $('#btn-search').click(function() {
    goSearch();
  });

  $('#search').click(function() {
    goSearch();
  });

  //execute scroll pagination
  being.scrollBottom('.scrolly', '.box', () => {   
    pageId = ($('#hidPageId').val() == '') ? 1 : $('#hidPageId').val();
    console.log('dasdsa - ' + pageId)
    getFromTabao(pageId);
  }); 

});

function getFromTabao(pageId){
  var html = '';
  var highlight_list_html ='';
  var _pageSize = (pageId == 1) ? pageSize_init : pageSize;
  
  $.ajax({
      type: 'GET',
      // url: "/tabao/get-goods-list?pageSize=" + _pageSize + "&pageId=" + pageId + "&priceLowerLimit=" + priceLowerLimit+ "&priceUpperLimit=" + priceUpperLimit, 
      // url: "/tabao/get-collection-list-with-detail?pageSize=" + _pageSize + "&pageId=" + pageId,
      url: "/tabao/get-taobao-collection/" + pageId,
      contentType: "application/json; charset=utf-8",
      dataType: "text",
      error: function (error) {
          console.log(error);
          alert(error.responseText);
          $(".reload").show();
      },
      success: function(data) {
          // console.log(data);
          // console.log(_data.code);
          if (data.length <= 0 || JSON.parse(data).code != 0) {
            console.log(JSON.parse(data));
            getFromTabao(pageId);
          };

          var records = JSON.parse(data).data.list;
          var newPrice = 0; 
          var sales = 0;
         
          $.each(records, function(i, item) {
            oldPrice = parseFloat(item.originalPrice).toFixed(2);
            newPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice) - Number(12));
            newPrice = (newPrice > 0) ? newPrice : 0;
            sales = (Number(item.monthSales) >= 1000) ? parseFloat(Number(item.monthSales) / 10000).toFixed(1) + '万' : Number(item.monthSales) + '件';
            reward = parseInt(newPrice * 10);
            reward = (reward <= 0) ? '100' : reward;
            _param = '?id=' + item.id + '&goodsId='+ item.goodsId +'&mainPic='+item.mainPic+'&title='+item.title+'&monthSales=' + item.monthSales +'&originalPrice=' +oldPrice+'&couponPrice=' +item.couponPrice + '&couponLink=' + encodeURIComponent(item.couponLink) + '&voucher_pass=';
            // _param = '?id=' + item.id + '&goodsId='+ item.goodsId;

              html += populateData(item);              

          });

          $('.listBox').append(html);

        totalNum = JSON.parse(data).data.totalNum;
        $('#hidPageId').val(JSON.parse(data).data.pageId);
        pageId = $('#hidPageId').val();
        console.log(pageId);

          
      }
  });
}

function getNumeric(value) {
  return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
}

function goSearch() {
  
  var search = ''; //$('#search').val();
  
  window.location.href = "/main/search/" + search;      

}

function populateData(item) {
  oldPrice = parseFloat(item.originalPrice).toFixed(2);
  newPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice) - Number(12));
  newPrice = (newPrice > 0) ? newPrice : 0;
  sales = (Number(item.monthSales) >= 1000) ? parseFloat(Number(item.monthSales) / 10000).toFixed(1) + '万' : Number(item.monthSales) + '件';
  reward = parseInt(newPrice * 10);
  reward = (reward <= 0) ? '100' : reward;
  _param = '?id=' + item.id + '&goodsId='+ item.goodsId +'&mainPic='+item.mainPic+'&title='+item.title+'&monthSales=' + item.monthSales +'&originalPrice=' +oldPrice+'&couponPrice=' +item.couponPrice + '&couponLink=' + encodeURIComponent(item.couponLink) + '&voucher_pass=';
  // _param = '?id=' + item.id + '&goodsId='+ item.goodsId;

  html = '<div class="inBox">' +
        '<div class="imgBox">' +
          // '<a href="https://t.asczwa.com/taobao?backurl=' + item.couponLink + '" rel="external nofollow">' +
          '<a href="/main/product/detail' + _param +'">' + 
            '<img src="'+item.mainPic+'">' +
          '</a>' +
        '</div>' +
        '<div class="txtBox flex1">' +
          '<h2 class="name">'+item.title+'</h2>' +
          '<div class="typeBox">' +
            '<span class="type-red">'+item.couponPrice+'元券</span>' +
            '<span class="type-sred">奖励'+reward+'积分</span>';

            if (isNewBie) {
  html +=      '<span class="type-blue">新人补贴12元</span>';
            } else {
              if (life > 0) {
  html +=      '<span class="type-blue">抽奖补贴' + (Number(life) * 12) + '元</span>';
              } else {
  html +=      '<span class="type-blue">邀请补贴12元</span>';
              }  
            }
            
  html +=  '</div>' +
          '<div class="moneyBox">' +
            '<p class="icon">¥</p>' +
            '<p class="nowTxt">'+ newPrice +'</p>' +
            '<p class="oldTxt"><em class="fs">¥</em>'+oldPrice+'</p>' +
            '<p class="num">热销'+ sales +'</p>' +
          '</div>' +
        '</div>' +
      '</div>';

  return html;

}

function populateHighlightData(item) {
  oldPrice = parseFloat(item.originalPrice).toFixed(2);
  newPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice) - Number(12));
  newPrice = (newPrice > 0) ? newPrice : 0;
  sales = (Number(item.monthSales) >= 1000) ? parseFloat(Number(item.monthSales) / 10000).toFixed(1) + '万' : Number(item.monthSales) + '件';
  reward = parseInt(newPrice * 10);
  reward = (reward <= 0) ? '100' : reward;
  _param = '?id=' + item.id + '&goodsId='+ item.goodsId +'&mainPic='+item.mainPic+'&title='+item.title+'&monthSales=' + item.monthSales +'&originalPrice=' +oldPrice+'&couponPrice=' +item.couponPrice + '&couponLink=' + encodeURIComponent(item.couponLink) + '&voucher_pass=';
  // _param = '?id=' + item.id + '&goodsId='+ item.goodsId;
  html ='<a href="/main/product/detail' + _param +'">' +
          '<span><img src="'+item.mainPic+'"></span>' +
          '<h2><em>¥</em> '+ newPrice +'</h2>' +
          '<p>热销'+sales+'</p>' +
        '</a>';
  return html;
}

