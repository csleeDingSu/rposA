
  $(document).ready(function () {
    if ($('#search').val() != "") {
      goSearch();       
    }
});

  function goSearch() {
    var search = $('#search').val();

      var html = '';

      if (search != "") {
        document.getElementById('loading').style.visibility="visible";
        $.ajax({
            type: 'GET',
            url: "/tabao/list-super-goods?search=" + search, 
            contentType: "application/json; charset=utf-8",
            dataType: "text",
            error: function (error) {
                console.log(error);
                alert(error.responseText);
                $(".reload").show();
            },
            success: function(data) {
                document.getElementById('loading').style.visibility="hidden";
                // console.log(data);
                // console.log(JSON.parse(data).data.list);
                if ((JSON.parse(data).data.list == '') || (typeof JSON.parse(data).data.list === 'undefined')){

                  html += '<div class="inBox">'+
                          '<div class="imgBox">'+
                            '<img src="/clientapp/images/demoImg.png">'+
                          '</div>'+
                          '<div class="txtBox flex1">'+
                            '<h2 class="name">【第二件0元】海底捞牛油火锅底料</h2>'+
                            '<div class="typeBox">'+
                              '<span class="type-red">20元</span>'+
                              '<span class="type-sred">奖励100积分</span>'+
                              '<span class="type-blue">抽奖补贴12元</span>'+
                            '</div>'+
                            '<div class="moneyBox">'+
                              '<p class="icon">¥</p>'+
                              '<p class="nowTxt">3.0</p>'+
                              '<p class="oldTxt">35.00</p>'+
                              '<a href="#" class="btn">'+
                                '<p>热销1.7万</p>'+
                                '<div class="inTxt">'+
                                  '<img src="/clientapp/images/shapeIcon.png">'+
                                  '<span>去领券</span>'+
                                '</div>'+
                              '</a>'+
                            '</div>'+
                          '</div>'+ 
                        '</div>';

                } else {

                  var records = JSON.parse(data).data.list;
                    $.each(records, function(i, item) {

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
                                    '<p class="nowTxt">'+ getNumeric(Number(item.originalPrice) - Number(item.couponPrice) - Number(12)) +'</p>' +
                                    '<p class="oldTxt">'+item.originalPrice+'</p>' +
                                    '<a href="'+item.couponLink+'" class="btn">' +
                                      '<p>热销'+ parseFloat(Number(item.couponTotalNum) / 10000).toFixed(1) +'万</p>' +
                                      '<div class="inTxt">' +
                                        '<img src="/clientapp/images/shapeIcon.png">' +
                                        '<span>去领券</span>' +
                                      '</div>' +
                                    '</a>' +
                                  '</div>' +
                                '</div>' +
                              '</div>';
                    });
                }                
            
              $('.listBox').html(html); 

            }
        });  
      
      } else {
        alert('请输入产品');
      }

    }

  function getNumeric(value) {
    return ((value % 1) > 0) ? Number(parseFloat(value).toFixed(2)) : Number(parseInt(value));
  }
