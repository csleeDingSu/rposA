var totalNum = 0;
var pageId = 1;
var pageSize_init = 10;
var pageSize = 10;
var priceLowerLimit = 12;
var priceUpperLimit = 50;
var weChatVerificationStatus = '';
var isNewBie = true;
var life = 0;
var currentPageId = 1;

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
    console.log('pageId - ' + pageId);
    console.log('currentPageId - ' + currentPageId);
    // alert('页 - ' + pageId);
    if (Number(pageId) > Number(currentPageId)) {
      getFromTabao(pageId);  
    }
  }); 

});

function getFromTabao(pageId){
  var html = '';
  var highlight_list_html ='';
  var _pageSize = (pageId == 1) ? pageSize_init : pageSize;
  currentPageId = pageId;
  $.ajax({
      type: 'GET',
      // url: "/tabao/get-goods-list?pageSize=" + _pageSize + "&pageId=" + pageId + "&priceLowerLimit=" + priceLowerLimit+ "&priceUpperLimit=" + priceUpperLimit, 
      // url: "/tabao/get-collection-list-with-detail?pageSize=" + _pageSize + "&pageId=" + pageId,
      url: "/tabao/get-taobao-collection/" + pageId,
      contentType: "application/json; charset=utf-8",
      dataType: "text",
      error: function (error) {
          console.log(error);
          // alert(error.responseText);
          // $(".reload").show();
      },
      success: function(data) {
          // console.log(data);
          // console.log(_data.code);
          if ((typeof JSON.parse(data) == 'undefined') || data.length <= 0 || JSON.parse(data).code != 0) {
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
            _param = '?id=' + item.id + '&goodsId='+ item.goodsId +'&mainPic='+item.mainPic+'&title='+item.title+'&monthSales=' + item.monthSales +'&originalPrice=' +oldPrice+'&couponPrice=' +item.couponPrice + '&couponLink=' + encodeURIComponent(item.couponLink) + '&voucher_pass=&life=' + life;
            // _param = '?id=' + item.id + '&goodsId='+ item.goodsId;

              html += populateData(item);              

          });

          $('.listBox').append(html);

        totalNum = JSON.parse(data).data.totalNum;
        $('#hidPageId').val(JSON.parse(data).data.pageId);
        currentPageId = pageId; //keep current page
        pageId = $('#hidPageId').val(); //next page
        console.log(pageId);
        if (html == '') {
          $('.lastHint').html('');  
        }
        
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
  oldPrice = getNumeric(item.originalPrice);
  promoPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice));
  promoPrice = (promoPrice > 0) ? promoPrice : 0;
  newPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice) - Number(12));
  newPrice = (newPrice > 0) ? newPrice : 0;
  sales = (Number(item.monthSales) >= 1000) ? parseFloat(Number(item.monthSales) / 10000).toFixed(1) + '万' : Number(item.monthSales) + '件';
  commissionRate = item.commissionRate;
  commissionRate = (commissionRate <= 0) ? 0 : commissionRate;
  reward = parseInt(Number(newPrice) * Number(commissionRate));
  reward = (reward <= 0) ? '100' : reward;
  _param = '?id=' + item.id + '&goodsId='+ item.goodsId +'&mainPic='+item.mainPic+'&title='+item.title+'&monthSales=' + item.monthSales +'&originalPrice=' +oldPrice+'&couponPrice=' +item.couponPrice + '&couponLink=' + encodeURIComponent(item.couponLink) + '&commissionRate=' + commissionRate + '&voucher_pass=';
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
            '<span class="type-price">淘宝<em>¥</em>' + oldPrice + '</span>' +
            '<span class="type-red">'+item.couponPrice+'元券</span>' +
            '<span class="type-sred">奖励'+reward+'积分</span>' +
          '</div>' +
          '<p class="newTxt">券后价格<em>¥</em>' + promoPrice + '</p>' +
          '<div class="moneyBox">' +
          '<p class="txt-red">补贴价格<em>¥</em><span class="num-reward">' + newPrice + '</span></p>' +
          '<p class="num">热销'+ sales +'</p>' +
          '</div>' +
        '</div>' +
      '</div>';

  return html;

}
