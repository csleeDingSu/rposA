
$(document).ready(function () {
    getFromTabao();     
});

function getFromTabao(){
    var html = '';
    $.ajax({
        type: 'GET',
        url: "/tabao/get-goods-list", 
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
            $.each(records, function(i, item) {
              newPrice = getNumeric(Number(item.originalPrice) - Number(item.couponPrice) - Number(12));
              newPrice = (newPrice > 0) ? newPrice : 0;
              sales = parseFloat(Number(item.couponTotalNum) / 10000).toFixed(1);

              html += '<div class="inBox">' +
              '<div class="imgBox">' +
                '<img src="'+item.mainPic+'">' +
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
                  '<p class="oldTxt">'+item.originalPrice+'</p>' +
                  '<a href="'+item.couponLink+'" class="btn">' +
                    '<p>热销'+ sales +'万</p>' +
                    '<div class="inTxt">' +
                      '<img src="/clientapp/images/shapeIcon.png">' +
                      '<span>去领券</span>' +
                    '</div>' +
                  '</a>' +
                '</div>' +
              '</div>' +
            '</div>';
          });

            $('.listBox').html(html);
            
        }
    });
}


function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
  }

  function goSearch() {
    var search = $('#search').val();
    if (search == '') {

      alert('请输入产品');

    }else{

      window.location.href = "/main/search/" + search;      

    }

  }
