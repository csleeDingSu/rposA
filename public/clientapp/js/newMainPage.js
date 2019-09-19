var totalNum = 0;
var pageId = 1;
var pageSize = 50;

$(document).ready(function () {

  $('#btn-search').click(function() {
    goSearch();
  });

  $('#search').click(function() {
    goSearch();
  });
  
  getFromTabao(pageId);

  //execute scroll pagination
  being.scrollBottom('.scrolly', '.box', () => {   
    pageId = ($('#hidPageId').val() == '') ? 1 : $('#hidPageId').val();
    console.log('dasdsa - ' + pageId)
    getFromTabao(pageId);
  }); 

});

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
          $('#hidPageId').val(JSON.parse(data).data.pageId);
          pageId = $('#hidPageId').val();
          console.log(pageId);

          $.each(records, function(i, item) {
            oldPrice = parseFloat(item.originalPrice).toFixed(2);
            newPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice) - Number(12));
            newPrice = (newPrice > 0) ? newPrice : 0;
            sales = parseFloat(Number(item.couponTotalNum) / 10000).toFixed(1);
            
            html += '<div class="inBox">' +
            '<div class="imgBox">' +
              '<a href="https://t.asczwa.com/taobao?backurl=https://uland.taobao.com/coupon/edetail?e=Sl7CZu%2BjTD8GQASttHIRqddlmysF55yxMBcpyuLai3Nhpq6VrhAdaLv8aC%2Flmph0AlMIspZpkdMYCQC%2FUZXJ8DEhJpUUrcnYK95Rc8uqBd5wO9XRdFenWHY9x3IctcCWLspxGy3zBjY8IeN8lvhRA2lzrR4%2BfrcbDkTV1xxm6pfAfTZczEC3a%2Bib2QyKSVw%2F417roa%2FvOLA%3D&traceId=0bb049c515688810151592733e&union_lens=lensId:0b013a8d_0b4f_16d4898798b_3f51&xId=R5DAtHFdLpPmGGwuyxqTTIElWkqByrzzd4szbjCP7fAEc064ho1JBumLnWixHQGwE4zCJZ6kswSrmPWOhWEefu&activityId=760755084e3c4617b40694749f5e5acb">' + 
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
                '<p class="oldTxt">'+oldPrice+'</p>' +
                '<p class="num">热销'+ sales +'万</p>' +
              '</div>' +
            '</div>' +
          '</div>';
        });

          $('.listBox').append(html);
          
      }
  });
}

function getNumeric(value) {
  return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
}

function goSearch() {
  
  var search = $('#search').val();
  
  window.location.href = "/main/search/" + search;      

}

