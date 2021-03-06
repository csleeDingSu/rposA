var totalNum = 0;
var pageId = 1;
var pageSize_init = 10;
var pageSize = 10;
var priceLowerLimit = 12;
var priceUpperLimit = 50;
var currentPageId = 0;
var isMacDevices = false;
var DOWNLOAD_APP_IOS = '#';
var DOWNLOAD_APP_ANDROID = '#';
var download_url = '#';

$(document).ready(function () {

  pageId = ($('#hidPageId').val() == '') ? 1 : $('#hidPageId').val(); 
  isMacDevices = $('#hidisMacDevices').val(); 
  DOWNLOAD_APP_IOS = $('#hidDOWNLOAD_APP_IOS').val();
  DOWNLOAD_APP_ANDROID = $('#hidDOWNLOAD_APP_ANDROID').val();
  download_url = '/download-app'; //(isMacDevices == true) ? DOWNLOAD_APP_IOS : DOWNLOAD_APP_ANDROID;

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

  $('.rules').click(function() {
    $('#draw-rules').modal();
  });

  $('.modal-go-button').click(function() {
    window.location.href = "/arcade"; 
  });

});

function getFromTabao(pageId){
  var html = '';
  var highlight_list_html ='';
  var _pageSize = (pageId == 1) ? pageSize_init : pageSize;
  currentPageId = pageId;
  Downloading('show');

  $.ajax({
      type: 'GET',
      // url: "/tabao/get-goods-list?pageSize=" + _pageSize + "&pageId=" + pageId + "&priceLowerLimit=" + priceLowerLimit+ "&priceUpperLimit=" + priceUpperLimit, 
      // url: "/tabao/get-collection-list-with-detail?pageSize=" + _pageSize + "&pageId=" + pageId,
      url: "/tabao/get-taobao-collection-vouchers-less12/" + pageId+ "?pgsize=" + pageSize,
      contentType: "application/json; charset=utf-8",
      dataType: "text",
      error: function (error) {
          console.log(error);
          Downloading('hide');
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
            _param = '';

              html += populateData(item);              

          });

          $('.listBox').append(html);
          Downloading('hide');

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
  reward = parseInt(Number(promoPrice) * Number(commissionRate));
  reward = (reward <= 0) ? '100' : reward;
  hong = (Number(reward) / 100);
  _param = '';
  // _param = '?id=' + item.id + '&goodsId='+ item.goodsId;

  html = '<div class="inBox">' +
        '<div class="imgBox">' +
          // '<a href="https://t.asczwa.com/taobao?backurl=' + item.couponLink + '" rel="external nofollow">' +
          '<a class="go-url" href="'+gURL+'">' + 
            '<img class="lazy" src="'+item.mainPic+'_320x320.jpg">' +
          '</a>' +
        '</div>' +
        '<div class="txtBox flex1">' +
          '<h2 class="name">'+item.title+'</h2>' +
          '<div class="typeBox">' +
            '<span class="type-red">'+item.couponPrice+'元券</span>' +
            '<span class="type-price">淘宝<em>¥</em>' + oldPrice + ' | 销量' + sales + '</span>' +                                              
            // '<span class="type-sred">奖励'+reward+'积分</span>' +
          '</div>' +
          '<div class="moneyBox">' +
            '<div class="amount"><em>¥</em>0</div>' +
            '<div class="txt">APP专享补贴</div>' +
          '</div>' +
        '</div>' +
      '</div>';

  return html;

}

function Downloading(value) {
  console.log(value);
  if (value == 'hide') {
    $('.lastHint').html('下拉显示更多产品...');
  } else {
    $('.lastHint').html('<img class="loading2" id="loading2" src="/client/images/preloader.gif">&nbsp;正在加载产品...');
  }
}