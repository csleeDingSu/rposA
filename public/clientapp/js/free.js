var totalNum = 0;
var pageId = 1;
var pageSize_init = 6;
var pageSize = 6;
var currentPageId = 1;
var life = 0;
var _url = '/tabao/get-taobao-collection-vouchers-less12/';

$(document).ready(function () {

  pageId = ($('#hidPageId').val() == '') ? 1 : $('#hidPageId').val(); 

  $('.scrolly').addClass('freeBg');
  $('.gzbtn').click(function() {
    $('#redeem-plan-modal').modal();
  });

  $('.btn-close-modal').click(function() {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
  })

  $('.returnBtn').click(function() {
    window.location.href = "/main";
  });

  //execute scroll pagination
  being.scrollBottom('.scrolly', '.box', () => {   
    pageId = ($('#hidPageId').val() == '') ? 1 : $('#hidPageId').val();
    console.log('pageId - ' + pageId);
    console.log('currentPageId - ' + currentPageId);
    // alert('页 - ' + pageId);
    if (Number(pageId) > Number(currentPageId)) {
      getTaobaoCollectionVouchersLess12(pageId);  
    }
  }); 

  getProduct(pageId, 1); 

   $('.one').click(function(){
        $('.one').addClass('on');
        $('.two').removeClass('on');
        $('.three').removeClass('on');
        _url = '/tabao/get-taobao-collection-vouchers-less12/';
        getProduct(pageId, 1);
  });

  $('.two').click(function(){
        $('.one').removeClass('on');
        $('.two').addClass('on');
        $('.three').removeClass('on');
        _url = '/tabao/get-taobao-collection-vouchers-greater12less24/';
        getProduct(pageId, 2);
  });

  $('.three').click(function(){
        $('.one').removeClass('on');
        $('.two').removeClass('on');
        $('.three').addClass('on');
        _url = '/tabao/get-taobao-collection-vouchers-greter24less36/';
        getProduct(pageId, 3);
  });

});

function getProduct(pageId, cat){
  var html = '';
  var highlight_list_html ='';
  var _pageSize = (pageId == 1) ? pageSize_init : pageSize;
  currentPageId = pageId;
  $.ajax({
      type: 'GET',
      url: _url + pageId + "?pgsize=" + pageSize,
      
      contentType: "application/json; charset=utf-8",
      dataType: "text",
      error: function (error) {
          console.log(error);
          // alert(error.responseText);
          // $(".reload").show();
      },
      success: function(data) {
        if (pageId == 1) {
          $('.dtList').html('');
        }

          // console.log(data);
          // console.log(_data.code);
          if ((typeof JSON.parse(data) == 'undefined') || data.length <= 0 || JSON.parse(data).code != 0) {
            console.log(JSON.parse(data));
            getProduct(pageId, cat);
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

              html += populateData(item, cat);              

          }); 
          // html += '<div class="isLastPage">下拉加载更多产品</div>';
          $('.dtList').append(html);

        totalNum = JSON.parse(data).data.totalNum;
        $('#hidPageId').val(JSON.parse(data).data.pageId);
        currentPageId = pageId; //keep current page
        pageId = $('#hidPageId').val(); //next page
        console.log(pageId);

        if (html == '') {
          $('.isLastPage').html('');
        }
        

                
      }
  });
}

function getNumeric(value) {
  return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
}

function populateData(item, cat) {
  oldPrice = getNumeric(item.originalPrice);
  promoPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice));
  promoPrice = (promoPrice > 0) ? promoPrice : 0;
  newPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice) - Number(12));
  newPrice = (newPrice > 0) ? newPrice : 0;
  sales = (Number(item.monthSales) >= 1000) ? parseFloat(Number(item.monthSales) / 10000).toFixed(1) + '万' : Number(item.monthSales) + '件';
  commissionRate = item.commissionRate;
  commissionRate = (commissionRate <= 0) ? 0 : parseInt(commissionRate);
  reward = parseInt(Number(promoPrice) * Number(commissionRate));
  reward = (reward <= 0) ? '100' : reward;
  hong = (Number(reward) / 100);
  _param = '?id=' + item.id + '&goodsId='+ item.goodsId +'&mainPic='+item.mainPic+'&title='+item.title+'&monthSales=' + item.monthSales +'&originalPrice=' +oldPrice+'&couponPrice=' +item.couponPrice + '&couponLink=' + encodeURIComponent(item.couponLink) + '&commissionRate=' + commissionRate + '&voucher_pass=&life=' + life;
  // _param = '?id=' + item.id + '&goodsId='+ item.goodsId;

  html = '<li>' +
          '<div class="imgBox">' +
            '<img src="'+item.mainPic+'_320x320.jpg">' +
          '</div>' +
          '<div class="txtBox">' +
            '<h2>'+item.title+'</h2>' +
            '<p><font>下单奖' + hong + '红包</font><i>原价' + oldPrice + '元</i></p>' +
            '<h3>'+ cat + '次抽奖 免费带走</h3>' +
          '</div>' +
          '<div class="btnBox">' +
            '<a href="/main/product/detail' + _param +'"><span>0元<br>到手</span></a>' +
          '</div>' +
        '</li>';

  return html;

}
